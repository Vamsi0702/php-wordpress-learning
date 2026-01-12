<?php
/**
 * Plugin Name: Cricket Pace Calculator
 * Plugin URI:  https://github.com/Vamsi0702/php-wordpress-learning
 * Description: A custom plugin to calculate cricket bowling speeds based on distance and time. Built to demonstrate PHP & JS skills.
 * Version:     1.1.0
 * Author:      Vamsi Bodapati
 * Author URI:  https://github.com/Vamsi0702
 * License:     GPL-2.0+
 * Text Domain: cricket-pace-calc
 */

// Security: Prevent direct access to this file
if ( ! defined( 'ABSPATH' ) ) {
    exit; 
}

/**
 * Main Function: Renders the calculator form and handles the math.
 * Usage: Place [cricket_calculator] on any page.
 */
function cpc_render_calculator_shortcode() {
    
    // Initialize variables
    $speed_kph = 0;
    $speed_mph = 0;
    $result_html = '';

    // Check if the form was submitted (Backend Logic)
    if ( isset( $_POST['cpc_submit_speed'] ) ) {
        
        // 1. Sanitize Inputs (Security Best Practice)
        $distance_yards = floatval( $_POST['cpc_distance'] ); // usually 22 yards
        $time_seconds   = floatval( $_POST['cpc_time'] );

        // 2. Perform Calculation (The Math)
        // Formula: Speed = Distance / Time
        if ( $distance_yards > 0 && $time_seconds > 0 ) {
            
            // Convert yards to meters (1 yard = 0.9144 meters)
            $distance_meters = $distance_yards * 0.9144;
            
            // Speed in Meters per Second
            $mps = $distance_meters / $time_seconds;
            
            // Convert to KPH (MPS * 3.6) and MPH (KPH * 0.621371)
            $speed_kph = round( $mps * 3.6, 2 );
            $speed_mph = round( $speed_kph * 0.621371, 2 );

            // Create the Success Message
            $result_html = "<div class='cpc-result' style='background: #e7f5e6; padding: 15px; margin-bottom: 20px; border-left: 5px solid #28a745;'>
                                <strong>🚀 Delivery Speed:</strong> <br>
                                <span style='font-size: 24px;'>{$speed_kph} KPH</span> / {$speed_mph} MPH
                            </div>";
        }
    }

    // 3. Render the HTML Form
    // We use output buffering (ob_start) to return the HTML cleanly to WordPress
    ob_start();
    ?>
    
    <div class="cpc-calculator-wrapper" style="border: 1px solid #ddd; padding: 20px; border-radius: 8px; max-width: 400px;">
        <h3>🏏 Bowling Speed Calculator</h3>
        
        <?php echo $result_html; ?>
        
        <form method="post" action="">
            <div style="margin-bottom: 15px;">
                <label for="cpc_distance">Pitch Length (Yards):</label><br>
                <input type="number" step="0.01" name="cpc_distance" id="cpc_distance" value="22" required style="width: 100%; padding: 8px;">
                <small style="color: #666;">Standard pitch is 22 yards.</small>
            </div>
            
            <div style="margin-bottom: 15px;">
                <label for="cpc_time">Time (Seconds):</label><br>
                <input type="number" step="0.001" name="cpc_time" id="cpc_time" placeholder="e.g. 0.45" required style="width: 100%; padding: 8px;">
                <small style="color: #666;">Time from release to stumps.</small>
            </div>
            
            <input type="submit" name="cpc_submit_speed" value="Calculate Speed" style="background: #0073aa; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 4px;">
        </form>
    </div>

    <?php
    return ob_get_clean();
}

// Register the Shortcode with WordPress
add_shortcode( 'cricket_calculator', 'cpc_render_calculator_shortcode' );
