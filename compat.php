<?php namespace BEA\Beautiful_Flexible;

class Compatibility {
	/**
	 * admin_init hook callback
	 *
	 * @since 0.1
	 */
	public static function admin_init() {
		// Not on ajax
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return;
		}

		// Check activation
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		// Load the textdomain
		load_plugin_textdomain( 'bea-beautiful-flexible', false, BEA_BEAUTIFUL_FLEXIBLE_PLUGIN_DIRNAME . '/languages' );

		 /* translators: %s: Minimal PHP Version */
		trigger_error( sprintf( esc_html__( 'BEA - Beautiful Flexible requires PHP version %s or greater to be activated.', 'bea-beautiful-flexible' ), BEA_BEAUTIFUL_FLEXIBLE_MIN_PHP_VERSION ) ); // phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped

		// Deactive self
		deactivate_plugins( BEA_BEAUTIFUL_FLEXIBLE_DIR . 'bea-beautiful-flexible.php' );

		unset( $_GET['activate'] );

		add_action( 'admin_notices', array( __CLASS__, 'admin_notices' ) );
	}

	/**
	 * Notify the user about the incompatibility issue.
	 */
	public static function admin_notices() {
		echo '<div class="notice error is-dismissible">';

		 /* translators: %1$s: Minimal PHP Version required, %2$s: Current PHP Version */
		echo '<p>' . sprintf( esc_html__( 'BEA - Beautiful Flexible require PHP version %1$s or greater to be activated. Your server is currently running PHP version %2$s.', 'bea-beautiful-flexible' ), BEA_BEAUTIFUL_FLEXIBLE_MIN_PHP_VERSION, PHP_VERSION ) . '</p>'; // phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '</div>';
	}
}
