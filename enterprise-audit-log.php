<?php
/**
 * Plugin Name: Enterprise Audit Logger
 * Description: High-performance activity tracker using custom SQL tables for compliance and security auditing.
 * Version:     1.1.0
 * Author:      Vamsi Bodapati
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

class RT_Audit_Logger {

    private $table_name;

    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'rt_audit_logs';

        // 1. Hook into plugin activation to create/update the DB Table
        register_activation_hook( __FILE__, array( $this, 'create_custom_table' ) );

        // 2. Event Hooks: Logins and Content Updates
        add_action( 'wp_login', array( $this, 'log_user_login' ), 10, 2 );
        add_action( 'save_post', array( $this, 'log_post_updates' ), 10, 3 );

        // 3. UI Hooks: Dashboard Widget and Sidebar Menu
        add_action( 'wp_dashboard_setup', array( $this, 'add_dashboard_widget' ) );
        add_action( 'admin_menu', array( $this, 'add_security_logs_menu' ) );
    }

    /**
     * Creates a custom SQL table optimized for logging.
     * Uses dbDelta() for safe database schema migrations.
     */
    public function create_custom_table() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $this->table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            user_id mediumint(9) NOT NULL,
            user_login varchar(60) NOT NULL,
            activity_type varchar(100) NOT NULL,
            ip_address varchar(100) NOT NULL,
            time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

    /**
     * Captures Login Events.
     */
    public function log_user_login( $user_login, $user ) {
        global $wpdb;
        $wpdb->insert( 
            $this->table_name, 
            array( 
                'user_id'       => $user->ID,
                'user_login'    => $user_login,
                'activity_type' => 'User Login',
                'ip_address'    => $_SERVER['REMOTE_ADDR'],
                'time'          => current_time( 'mysql' )
            ) 
        );
    }

    /**
     * Captures Content Updates (Posts/Pages).
     * Bypasses revisions and auto-saves to maintain database performance.
     */
    public function log_post_updates( $post_ID, $post, $update ) {
        if ( ! $update || wp_is_post_revision( $post_ID ) ) {
            return;
        }

        global $wpdb;
        $wpdb->insert( 
            $this->table_name, 
            array( 
                'user_id'       => get_current_user_id(),
                'user_login'    => wp_get_current_user()->user_login,
                'activity_type' => 'Post Updated: ' . get_the_title( $post_ID ),
                'ip_address'    => $_SERVER['REMOTE_ADDR'],
                'time'          => current_time( 'mysql' )
            ) 
        );
    }

    /**
     * Registers a dedicated sidebar menu for the logs.
     */
    public function add_security_logs_menu() {
        add_menu_page(
            'Security Logs',
            'Security Logs',
            'manage_options',
            'security-logs',
            array( $this, 'render_audit_page' ),
            'dashicons-shield',
            80
        );
    }

    public function add_dashboard_widget() {
        wp_add_dashboard_widget(
            'rt_audit_log_widget',
            '🔒 Enterprise Security Logs',
            array( $this, 'render_audit_page' )
        );
    }

    /**
     * Shared render function for both the Widget and the Menu Page.
     */
    public function render_audit_page() {
        global $wpdb;
        $logs = $wpdb->get_results( "SELECT * FROM $this->table_name ORDER BY time DESC LIMIT 10" );

        echo '<div class="wrap"><h2>Audit Logs</h2>';
        if ( empty( $logs ) ) {
            echo '<p>No activity recorded yet.</p>';
        } else {
            echo '<table class="wp-list-table widefat fixed striped">';
            echo '<thead><tr><th>User</th><th>Action</th><th>IP Address</th><th>Time</th></tr></thead>';
            echo '<tbody>';
            foreach ( $logs as $log ) {
                echo '<tr>';
                echo '<td><strong>' . esc_html( $log->user_login ) . '</strong></td>';
                echo '<td>' . esc_html( $log->activity_type ) . '</td>';
                echo '<td>' . esc_html( $log->ip_address ) . '</td>';
                echo '<td>' . esc_html( $log->time ) . '</td>';
                echo '</tr>';
            }
            echo '</tbody></table>';
        }
        echo '</div>';
    }
}

new RT_Audit_Logger();
