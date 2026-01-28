<?php
/**
 * Plugin Name: Enterprise Audit Logger
 * Description: High-performance activity tracker using custom SQL for compliance and security auditing.
 * Version:     1.1.0
 * Author:      Vamsi Bodapati
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

class RT_Audit_Logger {

    private $table_name;

    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'rt_audit_logs';

        register_activation_hook( __FILE__, array( $this, 'create_custom_table' ) );

        // Hooks for tracking
        add_action( 'wp_login', array( $this, 'log_user_login' ), 10, 2 );
        add_action( 'save_post', array( $this, 'log_post_updates' ), 10, 3 );

        // UI Hooks
        add_action( 'wp_dashboard_setup', array( $this, 'add_dashboard_widget' ) );
    }

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

    public function log_user_login( $user_login, $user ) {
        global $wpdb;
        $wpdb->insert( $this->table_name, array( 
            'user_id' => $user->ID, 'user_login' => $user_login, 'activity_type' => 'User Login',
            'ip_address' => $_SERVER['REMOTE_ADDR'], 'time' => current_time( 'mysql' )
        ) );
    }

    public function log_post_updates( $post_ID, $post, $update ) {
        // Skip auto-saves and revisions to keep the DB clean (Performance Win)
        if ( ! $update || wp_is_post_revision( $post_ID ) ) { return; }

        global $wpdb;
        $wpdb->insert( $this->table_name, array( 
            'user_id' => get_current_user_id(),
            'user_login' => wp_get_current_user()->user_login,
            'activity_type' => 'Updated Post: ' . get_the_title( $post_ID ),
            'ip_address' => $_SERVER['REMOTE_ADDR'], 'time' => current_time( 'mysql' )
        ) );
    }

    public function add_dashboard_widget() {
        wp_add_dashboard_widget( 'rt_audit_log_widget', '🔒 Enterprise Security Logs', array( $this, 'render_widget' ) );
    }

    public function render_widget() {
        global $wpdb;
        $logs = $wpdb->get_results( "SELECT * FROM $this->table_name ORDER BY time DESC LIMIT 5" );
        if ( empty( $logs ) ) { echo '<p>No activity recorded yet.</p>'; return; }
        echo '<table style="width:100%; text-align:left;"><thead><tr><th>User</th><th>Action</th><th>Time</th></tr></thead><tbody>';
        foreach ( $logs as $log ) {
            echo '<tr><td>' . esc_html( $log->user_login ) . '</td><td>' . esc_html( $log->activity_type ) . '</td><td>' . esc_html( $log->time ) . '</td></tr>';
        }
        echo '</tbody></table>';
    }
}
new RT_Audit_Logger();
