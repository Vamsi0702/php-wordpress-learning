<?php
/**
 * Plugin Name: Cricket Pace Calculator
 * Plugin URI:  https://github.com/Vamsi0702/php-wordpress-learning
 * Description: An OOP-based WordPress plugin to calculate bowling velocity. Demonstrates Class architecture, Sanitation, and Shortcode API.
 * Version:     1.2.0 (Enterprise Edition)
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
 * Class Cricket_Pace_Calculator
 * * Handles the logic, rendering, and processing of the bowling speed calculator.
 * Built using Object-Oriented Programming (OOP) principles.
 */
class Cricket_Pace_Calculator {

	/**
	 * Constructor: Hooks into WordPress.
	 */
	public function __construct() {
		// Register the shortcode [cricket_calculator]
		add_shortcode( 'cricket_calculator', array( $this, 'render_calculator' ) );
	}

	/**
	 * Renders the Calculator Form and Results.
	 */
	public function render_calculator() {
		
		// Initialize variables
		$result_html = '';

		// Check if form is submitted via POST
		if ( isset( $_POST['cpc_submit_speed'] ) ) {
			$result_html = $this->process_calculation();
		}

		// Output Buffering to ensure HTML loads in the correct place
		ob_start();
		?>
		
		<div class="cpc-wrapper" style="border: 1px solid #e0e0e0; padding: 25px; border-radius: 8px; max-width: 450px; background: #fff; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
			<h3 style="margin-top:0; border-bottom: 2px solid #0073aa; padding-bottom: 10px; color: #333;">🏏 Pace Calculator</h3>
			
			<?php echo $result_html; ?>

			<form method="post" action="">
				
				<div style="margin-bottom: 20px;">
					<label style="font-weight:bold; display:block; margin-bottom:5px;">Pitch Length (Yards)</label>
					<input type="number" step="0.01" name="cpc_distance" value="22" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
					<small style="color: #666; display:block; margin-top:5px;">Standard test pitch is 22 yards.</small>
				</div>

				<div style="margin-bottom: 20px;">
					<label style="font-weight:bold; display:block; margin-bottom:5px;">Time (Seconds)</label>
					<input type="number" step="0.001" name="cpc_time" placeholder="e.g. 0.45" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
				</div>

				<button type="submit" name="cpc_submit_speed" style="background: #0073aa; color: white; border: none; padding: 12px 25px; cursor: pointer; border-radius: 4px; font-weight: bold; width: 100%;">
					Calculate Speed 🚀
				</button>

			</form>
		</div>

		<?php
		return ob_get_clean();
	}

	/**
	 * Handles the Math Logic.
	 * * @return string HTML formatted result.
	 */
	private function process_calculation() {
		
		// 1. Sanitize Inputs (Security)
		$yards = isset( $_POST['cpc_distance'] ) ? floatval( $_POST['cpc_distance'] ) : 0;
		$time  = isset( $_POST['cpc_time'] ) ? floatval( $_POST['cpc_time'] ) : 0;

		// 2. Validation
		if ( $yards <= 0 || $time <= 0 ) {
			return '<p style="color: red;">Please enter valid numbers greater than 0.</p>';
		}

		// 3. The Physics Logic
		$meters    = $yards * 0.9144;
		$mps       = $meters / $time;       // Meters per second
		$kph       = round( $mps * 3.6, 1 );
		$mph       = round( $kph * 0.621371, 1 );

		// 4. Return Formatted Success Message
		return "<div style='background: #e3f2fd; color: #0d47a1; padding: 15px; margin-bottom: 20px; border-left: 5px solid #0073aa; border-radius: 4px;'>
					<strong style='font-size: 1.2em;'>Speed Result:</strong><br>
					<span style='font-size: 2em; font-weight: bold;'>{$kph}</span> <span style='font-size:0.9em'>KPH</span>
					<span style='color:#999; margin: 0 10px;'>|</span>
					<span style='font-size: 1.5em; color: #555;'>{$mph}</span> <span style='font-size:0.8em'>MPH</span>
				</div>";
	}

}

// Initialize the Plugin Class
new Cricket_Pace_Calculator();
