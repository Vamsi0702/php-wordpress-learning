<?php
/**
 * Plugin Name: GitHub Portfolio Fetcher (Enterprise Edition)
 * Description: Fetches and caches GitHub repositories with advanced error handling and rate-limit protection.
 * Version: 2.0.0
 * Author: Vamsi Bodapati
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class GitHub_Portfolio_Fetcher {

    private $username = 'Vamsi0702'; // Your verified username
    private $transient_key = 'vamsi_github_repos';

    public function __construct() {
        add_shortcode( 'my_github_repos', [ $this, 'render_github_repos' ] );
    }

    public function fetch_repositories() {
        $cached_data = get_transient( $this->transient_key );

        if ( false !== $cached_data ) {
            return $cached_data;
        }

        $url = "https://api.github.com/users/{$this->username}/repos?sort=updated&per_page=5";
        
        // Advanced HTTP Request with User-Agent (Required by GitHub API)
        $response = wp_remote_get( $url, [
            'timeout'    => 15,
            'user-agent' => 'WordPress-Portfolio-Fetcher'
        ]);

        // FIX: Missing HTTP header validation
        $response_code = wp_remote_retrieve_response_code( $response );
        if ( 200 !== $response_code ) {
            // Cache a "failure" for 10 minutes to prevent hitting rate limits repeatedly
            set_transient( $this->transient_key, [], 10 * MINUTE_IN_SECONDS );
            return [];
        }

        $body = wp_remote_retrieve_body( $response );
        $data = json_decode( $body );

        // FIX: Silent failure on JSON decode
        if ( ! is_array( $data ) ) {
            set_transient( $this->transient_key, [], 10 * MINUTE_IN_SECONDS );
            return [];
        }

        // Cache successful response for 1 hour as per ADR standards
        set_transient( $this->transient_key, $data, HOUR_IN_SECONDS );

        return $data;
    }

    public function render_github_repos() {
        $repos = $this->fetch_repositories();

        if ( empty( $repos ) ) {
            return '<p>Could not load GitHub repositories at this time.</p>';
        }

        $output = '<ul class="github-repos">';
        foreach ( $repos as $repo ) {
            // FIX: No language fallback
            $language = ! empty( $repo->language ) ? esc_html( $repo->language ) : 'Not specified';
            
            $output .= sprintf(
                '<li><strong><a href="%s" target="_blank">%s</a></strong> - %s <em>(%s)</em></li>',
                esc_url( $repo->html_url ),
                esc_html( $repo->name ),
                esc_html( $repo->description ),
                $language
            );
        }
        $output .= '</ul>';

        return $output;
    }
}

new GitHub_Portfolio_Fetcher();
