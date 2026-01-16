<?php
/**
 * Plugin Name: Enterprise CLI Bulk Importer
 * Description: A WP-CLI tool to ingest CSV data and create posts programmatically. Demonstrates Backend Engineering & Data Migration skills.
 * Version:     1.0.0
 * Author:      Vamsi Bodapati
 */

// If WP-CLI is not running, do not load this file.
if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
    return;
}

/**
 * Implements the "vamsi_import" command.
 */
class Vamsi_Bulk_Importer extends WP_CLI_Command {

    /**
     * Imports posts from a CSV file.
     *
     * ## OPTIONS
     *
     * <file>
     * : The path to the CSV file to import.
     *
     * ## EXAMPLES
     *
     * wp vamsi_import run mock-data.csv
     *
     * @when before_wp_load
     */
    public function run( $args, $assoc_args ) {
        
        // 1. Get the filename from the command line argument
        list( $filename ) = $args;

        // 2. Validation: Does the file exist?
        if ( ! file_exists( $filename ) ) {
            WP_CLI::error( "File not found: " . $filename );
        }

        WP_CLI::success( "Found file: " . $filename . ". Starting Import Process..." );

        // 3. Open the file
        $file_handle = fopen( $filename, 'r' );
        
        // Skip the Header Row (Title, Content, etc.)
        fgetcsv( $file_handle );

        // Initialize counters
        $count = 0;
        $errors = 0;

        // 4. Progress Bar (Visual Feedback for long tasks)
        // We count lines first to set up the progress bar
        $total_lines = count( file( $filename ) ) - 1; 
        $progress = \WP_CLI\Utils\make_progress_bar( 'Importing Posts', $total_lines );

        // 5. Loop through the rows
        while ( ( $row = fgetcsv( $file_handle ) ) !== FALSE ) {
            
            // Map CSV columns to Variables
            $title      = $row[0];
            $content    = $row[1];
            $category   = $row[2]; // We will treat this as a tag for now
            $author_id  = $row[3];

            // create the post array
            $post_data = array(
                'post_title'    => wp_strip_all_tags( $title ),
                'post_content'  => $content,
                'post_status'   => 'publish',
                'post_author'   => intval( $author_id ),
                'post_type'     => 'post'
            );

            // Insert into Database
            $post_id = wp_insert_post( $post_data );

            if ( is_wp_error( $post_id ) ) {
                WP_CLI::warning( "Failed to import: $title" );
                $errors++;
            } else {
                $count++;
            }

            // Tick the progress bar
            $progress->tick();
        }

        fclose( $file_handle );
        $progress->finish();

        // 6. Final Report
        WP_CLI::success( "Migration Complete! Created $count posts. Failed: $errors." );
    }
}

// Register the command with WP-CLI
WP_CLI::add_command( 'vamsi_import', 'Vamsi_Bulk_Importer' );
