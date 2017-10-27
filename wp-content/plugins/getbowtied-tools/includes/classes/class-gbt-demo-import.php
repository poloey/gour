<?php
/**
 * GBT_Importer
 *
 * The GetBowtied Tools importer class is a wrapper class that uses the WXR_Importer to import .xml files, and provides a frontend interface for doing so.
 *
 * @class 		GBT_Importer
 * @version		2.0
 * @category	Class
 * @author 		GetBowtied
 */

class GBT_Importer {

	/**
	 * Attempts to load the theme specific configuration file;
	 * If the file does not exist the importer class will terminate
	 *
	 * @var object | NULL
	 */
	public static $theme_config;

	/**
	 * Do not instance
	 */
	private function __construct() {
	}

	/**
	 * Configure the class
	 */
	public static function configure() {
		self::demo_config();
		self::add_ajax_events();
	}

	/**
	 * Get the theme specific import settings
	 *
	 * @uses $theme_config
	 * @return JSON object or NULL
	 */
	private static function demo_config() {
		$json = null;

		if ( is_file( get_template_directory() . '/inc/demo/demo-config.json' ) ) :
			$rsp = file_get_contents( get_template_directory() . '/inc/demo/demo-config.json' );
			$json = json_decode( $rsp, true );
		endif;

		self::$theme_config = $json;
	}

	/**
	 * Loads required dependencies for the importer
	 */
	private static function includes() {
		if ( ! class_exists( 'WP_Importer' ) ) {
			defined( 'WP_LOAD_IMPORTERS' ) || define( 'WP_LOAD_IMPORTERS', true );
			require ABSPATH . '/wp-admin/includes/class-wp-importer.php';
		}

		if ( ! class_exists( 'WXR_Importer' ) ) {
			require dirname( __FILE__ ) . '/class-wxr-importer.php';
		}
	}

	/**
	 * Adds class specific ajax event listeners
	 */
	private static function add_ajax_events() {
		// woocommerce_EVENT => nopriv
		$ajax_events = array(
			'demo_importer',
			'after_import',
		);

		foreach ( $ajax_events as $ajax_event ) {
			add_action( 'wp_ajax_gbt_' . $ajax_event, array( __CLASS__, $ajax_event ) );
		}
	}

	/**
	 * Do we have a configuration file for the importer
	 *
	 * @uses $theme_config
	 * @return bool
	 */
	public static function is_config() {
		return ( self::$theme_config !== null );
	}

	/**
	 * Main importer static function
	 * Imports an .xml file
	 * Runs post import operations on success
	 *
	 * @uses $theme_config
	 * @param string $file_path
	 */
	public static function demo_importer() {

		self::includes();

		$options = array(
			'fetch_attachments' => true,
		);

		$wxr_importer = new WXR_Importer( $options );

		$demo_type = ! empty( $_POST['demo_type'] ) ? $_POST['demo_type'] : '';

		$file_path = '';

		foreach ( self::$theme_config as $demo ) {
			if ( $demo['demo_name'] == $demo_type ) {
				$file_path = $demo['file_path'];
			}
		}

		if ( ! empty( $file_path ) ) {
			$file_path = get_template_directory() . '/inc/demo/' . $file_path;
		}

		try {

			$result = $wxr_importer->import( $file_path );

			if ( is_wp_error( $result ) ) {
				wp_send_json( $result->get_error_message() );
			} else {
				wp_send_json( array(
					'success' => 1,
				) );
			}
		} catch ( Exception $e ) {
			wp_send_json( $e->get_error_message() );
		}
	}

	/**
	 * Runs after import operations
	 * Should only be called after a successful import
	 */
	public static function after_import() {

		$demo_type = ! empty( $_POST['demo_type'] ) ? $_POST['demo_type'] : '';
		$settings = '';

		foreach ( self::$theme_config as $demo ) {
			if ( $demo['demo_name'] == $demo_type ) {
				$settings = $demo['settings'];
			}
		}

		$status = array(
			'reading_options'	=> self::set_reading_options( $settings ),
			'woo_pages'			=> self::set_woocommerce_pages( $settings ),
			'theme_options'		=> self::theme_options(),
			'nav_menus'			=> self::set_nav_menus( $settings )
		);

		flush_rewrite_rules();

		wp_send_json( json_encode( $status ) );
	}

	/**
	 * Sets the home page and blog pages after import
	 *
	 * @param array $settings
	 * @uses $theme_config
	 * @return bool
	 */
	public static function set_reading_options( $settings ) {

		$reading_settings = $settings['reading_settings'];

		if ( ! empty( $reading_settings ) ) {

			$homepage 	= get_page_by_title( html_entity_decode( $reading_settings['homepage'] ) );
			$blog 		= get_page_by_title( html_entity_decode( $reading_settings['blog'] ) );

			if ( ( isset( $homepage ) && $homepage->ID ) && ( isset( $blog ) && $blog->ID) ) {
					update_option( 'show_on_front', 	'page' );
					update_option( 'page_on_front', 	$homepage->ID );
					update_option( 'page_for_posts', 	$blog->ID );
				return true;
			}
		}

		return false;
	}
	/**
	 * Sets the woocommerce pages
	 *
	 * @param array $settings
	 * @uses $theme_config
	 * @return bool
	 */
	public static function set_woocommerce_pages( $settings ) {
		if ( class_exists( 'Woocommerce' ) && ! empty( $settings['woocommerce_pages'] ) ) {
			foreach ( $settings['woocommerce_pages'] as $woo_name => $woo_title ) {
				$woopage = get_page_by_title( $woo_title );
				if ( isset( $woopage ) && property_exists( $woopage, 'ID' ) ) {
					update_option( $woo_name, $woopage->ID );
				}
			}
			return true;
		}
		return false;
	}

	/**
	 * Sets the navigation menu locations
	 *
	 * @param array $settings
	 * @uses $theme_config
	 * @return bool
	 */
	public static function set_nav_menus( $settings ) {

		if ( is_array( $settings['navigation'] ) ) {
			$locations = get_theme_mod( 'nav_menu_locations' );
			$menus = wp_get_nav_menus();

			foreach ( (array) $menus as $theme_menu ) {
				foreach ( (array) $settings['navigation'] as $import_menu ) {
					if ( $theme_menu->name == $import_menu['name'] ) {
						$locations[ $import_menu['location'] ] = $theme_menu->term_id;
					}
				}
			}

			set_theme_mod( 'nav_menu_locations', $locations );
			return true;
		}
		return false;
	}

	/**
	 * Looks for a theme options file and imports the settings
	 * Does nothing if a file isn't present
	 */
	public static function theme_options() {
		if ( is_file( get_template_directory() . '/inc/demo/theme_options.json' ) ) :
			$rsp = file_get_contents( get_template_directory() . '/inc/demo/theme_options.json' );
			$options = json_decode( $rsp, true );

			if ( class_exists( 'ReduxFrameworkInstances' ) ) :

				if ( GBTHELPERS::theme_slug() == 'mrtailor' ) :
	            	$redux = ReduxFrameworkInstances::get_instance( 'mr_tailor_theme_options' );
	        	else :
	        		$redux = ReduxFrameworkInstances::get_instance( GBTHELPERS::theme_slug() . '_theme_options' );
	        	endif;

				$redux->set_options( $options );

				return true;
			endif;
		endif;

		if ( is_file( get_template_directory() . '/inc/demo/theme_options.txt' ) ) :
			$theme_options_txt = file_get_contents( get_template_directory() . '/inc/demo/theme_options.txt' );
			$imported_smof_data = unserialize( base64_decode( $theme_options_txt ) );
			if ( function_exists( 'of_save_options' ) ) :
				of_save_options( $imported_smof_data );
			endif;

			return true;
		endif;

		return false;
	}

	/**
	 * Checks if VC & WooCommerce is active
	 *
	 * @return boolean
	 */
	public static function is_required_plugins() {
		return (is_plugin_active( 'js_composer/js_composer.php' ) && is_plugin_active( 'woocommerce/woocommerce.php' ));
	}



}

GBT_Importer::configure();

