<?php namespace BEA\Beautiful_Flexible;

class Main {
	use Singleton;

	protected function init() {
		add_action( 'init', [ $this, 'init_translations' ] );

		// Assets
		add_action( 'acf/input/admin_head', [ $this, 'admin_register_assets' ] );
		add_action( 'acf/input/admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );
		add_action( 'acf/input/admin_footer', [ $this, 'admin_enqueue_styles' ] );

		// Images
		add_action( 'acf/input/admin_footer', [ $this, 'layouts_images' ], 20 );
	}

	public function layouts_images() {
		$images = $this->get_layouts_images();
		if ( empty( $images ) ) {
			return;
		}

		$css = '/** BEA - Beautiful Flexible : dynamic images */';
		foreach ( $images as $layout_key => $image_url ) {
			$css .= sprintf( "\n.acf-fc-popup ul li a[data-layout=%s]{ background-image: url(%s);", $layout_key, $image_url );
		}

		echo $css;
	}

	private function get_layouts_images() {
		$layouts_images = [];

		// get flexible

		// foreach flexible, get keys


		// generate keys => url (filtred)

		/**
		 * Allow to add/remove/change a flexible layout key
		 *
		 * @params array $layouts_images : Array of flexible layout's keys with associated image url
		 *
		 * @author Maxime CULEA
		 * @since  0.0.1
		 *
		 * @return array
		 */
		return apply_filters( 'bea.beautiful_flexible.images', $layouts_images );
	}

	/**
	 * Locate template in the theme or plugin if needed
	 *
	 * @param string $tpl : the tpl name, add automatically .png at the end of the file
	 *
	 * @return bool|string
	 */
	private function locate_image( $tpl ) {
		if ( empty( $tpl ) ) {
			return false;
		}

		/**
		 * Allow to add/remove/change the path to images
		 *
		 * @params array $path : Path to check
		 *
		 * @author Maxime CULEA
		 * @since  0.0.1
		 *
		 * @return array
		 */
		$path = apply_filters( 'bea.beautiful_flexible.images_path', 'assets/bea-beautiful-flexible' );

		if ( is_file( sprintf( '%s/%s.png', $path, $tpl ) ) ) {
			return sprintf( '%s/%s.png', $path, $tpl );
		}

		if ( file_exists( sprintf( '%s/%s/%s.png', get_stylesheet_directory(), $path, $tpl ) ) ) {
			return sprintf( '%s/%s/%s.png', get_stylesheet_directory_uri(), $path, $tpl );
		}

		if ( file_exists( sprintf( '%s/%s/%s.png', get_template_directory(), $path, $tpl ) ) ) {
			return sprintf( '%s/%s/%s.png', get_template_directory_uri(), $path, $tpl );
		}

		return sprintf( '%s/assets/default.png', BEA_BEAUTIFUL_FLEXIBLE_URL );
	}

	private function admin_register_assets() {
		wp_register_script( 'bea-beautiful-flexible', BEA_BEAUTIFUL_FLEXIBLE_URL . 'assets/js/bea-beautiful-flexible.min.js', [ 'jquery' ], BEA_BEAUTIFUL_FLEXIBLE_VERSION );
		wp_register_style( 'bea-beautiful-flexible', BEA_BEAUTIFUL_FLEXIBLE_URL . 'assets/css/bea-beautiful-flexible.min.css', [], BEA_BEAUTIFUL_FLEXIBLE_VERSION );
	}

	private function admin_enqueue_scripts() {
		wp_enqueue_script( 'bea-beautiful-flexible' );
	}

	private function admin_enqueue_styles() {
		wp_enqueue_style( 'bea-beautiful-flexible' );
	}

	private function init_translations() {
		load_plugin_textdomain( 'bea-beautiful-flexible', false, BEA_BEAUTIFUL_FLEXIBLE_PLUGIN_DIRNAME . '/languages' );
	}
}