<?php
/**
 * GBT_Plugin_setup
 *
 * Handles installation / activation of required and recommended plugins, via TGMPA
 *
 * @class       GBT_Plugin_setup
 * @version     2.0
 * @category    Class
 * @author      GetBowtied
 */

if ( ! class_exists( 'GBT_Plugin_setup' ) ) {
	class GBT_Plugin_setup {

			/**
			 * TGMPA Menu url
			 *
			 * @var string
			 */
		private $tgmpa_url = 'themes.php?page=tgmpa-install-plugins';

			/**
			 * Record of types of plugins for use in frontend
			 *
			 * @var array
			 */
		private $counter = array(
			'recommended' => 0,
			'internal' => 0,
			'3rdparty' => 0,
		);

		/**
		 * Store remote plugins
		 *
		 * @var array
		 */
		private $cached_plugins = array();


			/**
			 * Init
			 */
		public function __construct() {
			$this->includes();
			$this->cached_plugins = get_transient( GBTHELPERS::theme_slug() . "_remote_plugins");
			add_action( 'tgmpa_register', array( $this, 'register_required_plugins' ) );
			add_filter( 'tgmpa_load', array( $this, 'tgmpa_load' ), 10, 1 );
			add_action( 'wp_ajax_gbt_get_plugins', array( $this, 'ajax_plugins' ) );
			add_action( 'wp_ajax_gbt_get_wizard_plugins', array( $this, 'ajax_wizard_plugins' ) );
		}

			/**
			 * Include TGMPA class
			 */
		public function includes() {
			require_once 'class-tgm-plugin-activation.php';
		}

		public function tgmpa_load() {
			return is_admin() || current_user_can( 'install_themes' );
		}

		public function get_remote_plugins() {

			/**
			 * If the info is cached return that
			 */
			if ( $this->cached_plugins != false ) {
				return $this->cached_plugins;
			}

			$plugins = false;

			$api_url = 'https://api.getbowtied.com/v2/update-plugins-new.json';

			$args = array(
				'method' => 'POST',
				'timeout' => 5,
				'body' => array(
					't' => GBTHELPERS::theme_name(),
					'k' => get_option( 'getbowtied_' . GBTHELPERS::theme_slug() . '_license' ),
					'd' => get_site_url(),
				),
			);

			$response = wp_remote_post( $api_url, $args );

			if ( is_wp_error( $response ) ) {
				return false;
			} else {
				$rsp = $response['body'];
				$rsp = json_decode( $rsp, true );
			}

			if ( is_array( $rsp ) ) {

				$plugins = array();

				foreach ( $rsp as $plugin ) {
					$plugins[ $plugin['slug'] ] = array(
						'name'                  => $plugin['name'],
						'slug'                  => $plugin['slug'],
						'source'                => $plugin['source'],
						'required'              => $plugin['required'],
						'version'               => $plugin['version'],
						'force_activation'      => $plugin['force_activation'],
						'force_deactivation'    => $plugin['force_deactivation'],
						'external_url'          => '',
						'external_image'        => $plugin['image_url'],
					);
				}
			}

			/**
			 * Set a 1 day transient with plugin information
			 */
			set_transient(GBTHELPERS::theme_slug() . "_remote_plugins", $plugins, 60*60*24);
			return $plugins;
		}

			/**
			 * Loads the required and recommended plugins into TGM
			 */
		public function register_required_plugins() {
			$plugins = array(
			'js_composer' =>
			array(
				'name'               => 'WPBakery Visual Composer',
				'slug'               => 'js_composer',
				'source'             => get_template_directory() . '/inc/plugins/js_composer.zip',
				'required'           => true,
				'external_url'       => '',
				'description'		 => 'Premium Page Builder',
				'external_image'	 => plugins_url( '/assets/images/thumb-visual-composer.png', GBTHELPERS::path() ),
				'gbt-type'			 => '',
			),
			'woocommerce' => array(
				'name'               => 'WooCommerce',
				'slug'               => 'woocommerce',
				'required'           => true,
				'description'		 => 'The eCommerce engine',
				'external_image'	 => plugins_url( '/assets/images/thumb-woocommerce.png', GBTHELPERS::path() ),
				'gbt-type'			 => '',
			),
			);

			$remote_plugins = $this->get_remote_plugins();
			if ( $remote_plugins && is_array( $remote_plugins ) ) {
				foreach ( $remote_plugins as $key => $value ) {
					if ( isset( $plugins[ $key ] ) ) :
						$plugins[ $key ] = array_merge( $plugins[ $key ], $value );
		        		else :
		        			$plugins[ $key ] = $value;
		        		endif;
				}
			}

			$config = array(
			'id'                => 'getbowtied',
			'default_path'      => '',
			'parent_slug'       => 'themes.php',
			'menu'              => 'tgmpa-install-plugins',
			'has_notices'       => true,
			'is_automatic'      => true,
			);

			tgmpa( $plugins, $config );
		}

			/**
			 * Get all required plugins as defined by the theme
			 */
		public function _get_plugins() {
			$instance = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );

			$installed_plugins = get_plugins();
			$plugins  = array();

			foreach ( $instance->plugins as $slug => $plugin ) {
				if ( $slug == 'getbowtied-tools' ) { continue;
				}
				$plugins[ $slug ] = $plugin;

				if ( isset( $plugin['gbt-type'] ) && ($plugin['gbt-type'] == 'internal') ) {
					$this->counter['internal']++;
				}

				if ( isset( $plugin['gbt-type'] ) && ($plugin['gbt-type'] == '3rdparty') ) {
					$this->counter['3rdparty']++;
				}

				if ( $plugin['required'] == false ) {
					$this->counter['recommended']++;
				}

				if ( isset( $installed_plugins[ $plugin['file_path'] ]['Version'] ) ) :
					$plugins[ $slug ]['version'] = $installed_plugins[ $plugin['file_path'] ]['Version'];
					endif;

				if ( ! $instance->is_plugin_installed( $slug ) ) {
					$plugins[ $slug ]['status'] = 'install';
				} else {
					if ( false !== $instance->does_plugin_have_update( $slug ) ) {
						$plugins[ $slug ]['status'] = 'update';
					} elseif ( $instance->can_plugin_activate( $slug ) ) {
						$plugins[ $slug ]['status'] = 'activate';
					} else {
						$plugins[ $slug ]['status'] = 'no-action';
					}
				}
			}

			return $plugins;
		}

		public function ajax_plugins() {
			$plugins = $this->_get_plugins();
			wp_send_json( $plugins[ $_POST['gbt_plugin'] ]['status'] === 'no-action' );
		}

		public function ajax_wizard_plugins() {
			$plugins = $this->_get_plugins();
			wp_send_json( ($plugins[ $_POST['gbt_plugin'] ]['status'] === 'no-action') || ($plugins[ $_POST['gbt_plugin'] ]['status'] === 'update') );
		}

		public function get_tgmpa_url() {
			return $this->tgmpa_url;
		}

		public function _count_plugins( $type = 'recommended' ) {
			return $this->counter[ $type ];
		}
	}
}// End if().

