<?php
/**
 * Plugin Name: GitHub Portfolio Fetcher
 * Description: Connects to the GitHub API, fetches your top repositories, and caches them for performance.
 * Version:     1.0.0
 * Author:      Vamsi Bodapati
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

class WP_Github_Fetcher {

    public function __construct() {
        add_shortcode( 'my_github_repos', array( $this, 'render_repos' ) );
    }

    /**
     * Fetch data from GitHub API with Caching (Transient API)
     */
    private function get_repos() {
        // 1. Check if we have the data cached (saved in database) for 1 hour
        $cached_repos = get_transient( 'vamsi_github_repos' );
        if ( false !== $cached_repos ) {
            return $cached_repos;
        }

        // 2. If not cached, connect to GitHub API
        $response = wp_remote_get( 'https://api.github.com/users/Vamsi0702/repos?sort=updated&per_page=5', array(
            'user-agent' => 'WordPress-Portfolio-Site'
        ));

        // 3. Error Handling (If GitHub is down)
        if ( is_wp_error( $response ) ) {
            return [];
        }

        $body = wp_remote_retrieve_body( $response );
        $data = json_decode( $body );

        // 4. Save to Cache for 1 hour (3600 seconds) - Performance Boost!
        set_transient( 'vamsi_github_repos', $data, 3600 );

        return $data;
    }

    /**
     * Render the HTML
     */
    public function render_repos() {
        $repos = $this->get_repos();

        if ( empty( $repos ) ) {
            return '<p>Could not load GitHub repositories.</p>';
        }

        ob_start();
        ?>
        <div class="github-showcase" style="display: grid; gap: 15px; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));">
            <?php foreach ( $repos as $repo ) : ?>
                <div style="border: 1px solid #ddd; padding: 15px; border-radius: 8px; background: #fff;">
                    <h3 style="margin: 0 0 10px 0;"><a href="<?php echo esc_url( $repo->html_url ); ?>" target="_blank" style="text-decoration:none; color:#0073aa;"><?php echo esc_html( $repo->name ); ?></a></h3>
                    <p style="color: #666; font-size: 14px;"><?php echo esc_html( $repo->description ? $repo->description : 'No description.' ); ?></p>
                    <div style="font-size: 12px; font-weight: bold; color: #333;">
                        Stars: <?php echo intval( $repo->stargazers_count ); ?> | 
                        Language: <?php echo esc_html( $repo->language ); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
        return ob_get_clean();
    }
}

new WP_Github_Fetcher();
