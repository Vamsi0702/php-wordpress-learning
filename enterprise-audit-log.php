<?php
/**
 * Plugin Name: Enterprise Audit Logger
 * Description: Creates a custom database table to track user activity (Logins, Post Updates) for compliance and security auditing.
 * Version:     1.0.0
 * Author:      Vamsi Bodapati
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

class RT_Audit_Logger {

    private $table_name;

    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'rt_audit_logs';

        // 1. Hook into plugin activation to create the DB Table
        register_activation_hook( __FILE__, array( $this, 'create_custom_table' ) );

        // 2. Log when a user logs in
        add_action( 'wp_login', array( $this, 'log_user_login' ), 10, 2 );

        // 3. Add a Dashboard Widget to view logs
        add_action( 'wp_dashboard_setup', array( $this, 'add_dashboard_widget' ) );
    }

    /**
     * Creates a custom SQL table optimized for logging.
     * Uses dbDelta() which is the WordPress standard for database migrations.
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
     * Captures the Login Event and inserts into our custom table.
     */
    public function log_user_login( $user_login, $user ) {
        global $wpdb;
        
        $wpdb->insert( 
            $this->table_name, 
            array( 
                'user_id'       => $user->ID,
                'user_login'    => $user_login,
                'activity_type' => 'User Login',
                'ip_address'    => $_SERVER['REMOTE_ADDR'], // Basic IP capture
                'time'          => current_time( 'mysql' )
            ) 
        );
    }

    /**
     * Adds a widget to the WP Admin Dashboard to visualize the data.
     */
    public function add_dashboard_widget() {
        wp_add_dashboard_widget(
            'rt_audit_log_widget',
            '🔒 Enterprise Security Logs',
            array( $this, 'render_dashboard_widget' )
        );
    }

    public function render_dashboard_widget() {
        global $wpdb;
        $logs = $wpdb->get_results( "SELECT * FROM $this->table_name ORDER BY time DESC LIMIT 5" );

        if ( empty( $logs ) ) {
            echo '<p>No activity recorded yet.</p>';
            return;
        }

        echo '<table style="width:100%; text-align:left;">';
        echo '<thead><tr><th>User</th><th>Action</th><th>Time</th></tr></thead>';
        echo '<tbody>';
        foreach ( $logs as $log ) {
            echo '<tr>';
            echo '<td>' . esc_html( $log->user_login ) . '</td>';
            echo '<td>' . esc_html( $log->activity_type ) . '</td>';
            echo '<td>' . esc_html( $log->time ) . '</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    }
}

new RT_Audit_Logger();
