<?php namespace BEA\Beautiful_Flexible;

class Main {
	use Singleton;

	protected function init() {
		add_action( 'init', [ $this, 'init_translations' ] );

		// Assets
		add_action( 'acf/input/admin_footer', [ $this, 'register_assets' ], 1 );
		add_action( 'acf/input/admin_footer', [ $this, 'enqueue_assets' ] );

		// Images
		add_action( 'acf/input/admin_footer', [ $this, 'layouts_images_style' ], 20 );

		add_action( 'acf/input/admin_head', [ $this, 'retrieve_flexible_keys' ], 1 );
	}

	/**
	 * Display the flexible layouts images related css for backgrounds
	 *
	 * @author Maxime CULEA
	 * @since  0.0.1
	 */
	public function layouts_images_style() {
		$images = $this->get_layouts_images();
		if ( empty( $images ) ) {
			return;
		}

		$css = "\n<style>";
		$css .= "\n\t /** BEA - Beautiful Flexible : dynamic images */";
		foreach ( $images as $layout_key => $image_url ) {
			$css .= sprintf( "\n\t .acf-fc-popup ul li a[data-layout=%s]{ background-image: url(\"%s\"); }", $layout_key, $image_url );
		}
		$css .= "\n</style>\n";

		echo $css;
	}

	/**
	 * Manage to get ACF Flexible keys
	 *
	 * @author Maxime CULEA
	 * @since  0.0.1
	 *
	 * TODO : maybe add cache
	 *
	 * @return array
	 */
	public function retrieve_flexible_keys() {
		$keys   = [];
		$groups = acf_get_field_groups();
		if ( empty( $groups ) ) {
			return $keys;
		}

		foreach ( $groups as $group ) {
			$fields = (array) acf_get_fields( $group );
			if ( empty( $fields ) ) {
				continue;
			}

			foreach ( $fields as $field ) {
				if ( 'flexible_content' === $field['type'] ) {
					// Flexible is recursive structure with sub_fields into layouts
					foreach ( $field['layouts'] as $layout_field ) {
						if ( ! empty( $keys [ $layout_field['key'] ] ) ) {
							continue;
						}
						$keys[ $layout_field['key'] ] = $layout_field['name'];
					}
				}
			}
		}

		return $keys;
	}

	/**
	 * Get for all flexible the associated images
	 *
	 * @author Maxime CULEA
	 * @since  0.0.1
	 *
	 * @return mixed
	 */
	public function get_layouts_images() {
		$flexibles = $this->retrieve_flexible_keys();
		if ( empty( $flexibles ) ) {
			return [];
		}

		foreach ( $flexibles as $flexible ) {
			$layouts_images[ $flexible ] = $this->locate_image( $flexible );
		}

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
	 * @author Maxime CULEA | Nicolas Lemoine
	 *
	 * @return false|string
	 */
	public function locate_image( $tpl ) {
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

		// Rework the tpl
		$tpl = str_replace( '_', '-', $tpl );

		foreach ( [ 'jpg', 'jpeg', 'png', 'gif' ] as $extension ) {
			$image = sprintf( '%s/%s.%s', $path, $tpl, $extension );
			// Direct path to custom folder
			if ( is_file( $image ) ) {
				return $image;
			}
			// Partial path to check into themes
			if ( is_file( get_theme_file_path( $image ) ) ) {
				return get_theme_file_uri( $image );
			}
		}

		return sprintf( '%sassets/default.png', BEA_BEAUTIFUL_FLEXIBLE_URL );
	}

	/**
	 * Use default JS or for 5.7.0+ the 57 one
	 * @since 1.0.3
	 */
	public function register_assets() {
		$version = version_compare( acf()->version, '5.7.O', '>=' ) ? '-57' : '';
		wp_register_script( 'bea-beautiful-flexible', sprintf( '%sassets/js/bea-beautiful-flexible%s.min.js', BEA_BEAUTIFUL_FLEXIBLE_URL, $version ), [ 'jquery' ], BEA_BEAUTIFUL_FLEXIBLE_VERSION );
		wp_register_style( 'bea-beautiful-flexible', BEA_BEAUTIFUL_FLEXIBLE_URL . 'assets/css/bea-beautiful-flexible.min.css', [], BEA_BEAUTIFUL_FLEXIBLE_VERSION );
	}

	public function enqueue_assets() {
		wp_enqueue_script( 'bea-beautiful-flexible' );
		wp_enqueue_style( 'bea-beautiful-flexible' );
	}

	public function init_translations() {
		load_plugin_textdomain( 'bea-beautiful-flexible', false, BEA_BEAUTIFUL_FLEXIBLE_PLUGIN_DIRNAME . '/languages' );
	}
}