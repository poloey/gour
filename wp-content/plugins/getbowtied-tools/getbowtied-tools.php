<?php
	/**
	 * Plugin Name: GetBowtied Tools
	 * Plugin URI: https://getbowtied.com/
	 * Description: A suite of tools to help you kickstart your GetBowtied theme.
	 * Version: 2.3
	 * Author: GetBowtied
	 * Author URI: https://getbowtied.com
	 * Requires at least: 4.7
	 * Tested up to: 4.8.2
	 *
	 * @package  GetBowtied Tools
	 * @author GetBowtied
	 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


if ( ! class_exists( 'GetBowtied_Tools' ) ) :

	/**
	 * GetBowtied Tools class.
	 *
	 * @class GetBowtiedTools
	 * @version    2.3
	 */
	class GetBowtied_Tools {


		/**
		 * The plugin version
		 *
		 * @var string
		 */
		public $version = '2.3';

		/**
		 * The plugin url
		 *
		 * @var string
		 */
		public $slug = 'getbowtied-tools';

		/**
		 * The plugin path
		 *
		 * @var string
		 */
		public $path = 'getbowtied-tools/getbowtied-tools.php';

		/**
		 * The plugin logo path
		 *
		 * @var string
		 */
		public $logo = ''; // plugins_url( '/assets/images/get-bowtied-logo.jpg' , __FILE__ )

		/**
		 * The plugin modules
		 *
		 * @var array
		 */
		public $modules;


		/**
		 * GetBowtied Tools constructor
		 */
		function __construct() {

			$this->load_helpers();
			$this->load_sysstatus();

			/**
			 * Die if not a GetBowtied theme
			 *
			 * @var array
			 */
			$getbowtiedThemes = array( 'theretailer', 'mrtailor', 'shopkeeper', 'merchandiser' );
			if ( ! in_array( GBTHELPERS::theme_slug(), $getbowtiedThemes ) ) {
				return;
			}

			add_action( 'admin_menu', array( $this, 'removeOldMenu' ), 99 );
			add_action( 'admin_menu', array( $this, 'adminMenu' ) );
			add_action( 'admin_menu', array( $this, 'adminSubmenu' ) );

			add_action( 'admin_enqueue_scripts', array( $this, 'loadScripts' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'loadStyles' ) );

			$this->modules = $this->modules();
			$this->includes();
			$this->self_updater();
			$this->theme_updater();

			add_action( 'vc_activation_hook', array( $this, 'vc_page_welcome_redirect' ), 99 );

			add_action( 'admin_bar_menu', array( $this, 'adminBarNotification' ), 999 );
			add_action( 'admin_bar_menu', array( $this, 'updateNotification' ), 999 );

			$this->load_wizard();
			new GBT_InstallWizard();

			register_activation_hook( __FILE__, array( $this, 'activationRedirect' ) );
			add_action( 'admin_init', array( $this, 'redirectWizard' ) );
			add_action( 'admin_init', array( $this, 'disallowed_admin_pages' ) );

			add_filter('woocommerce_enable_setup_wizard', array($this, 'wc_install_wizard_redirect'), 10, 1);
		}

		/*
		 * Disable WC activation redirect
		 */
		public function wc_install_wizard_redirect( $bool) {
			if (is_plugin_active('woocommerce/woocommerce.php'))
				return true;
			return false;
		}

		/**
		 * Disable VC activation redirect
		 */
		public function vc_page_welcome_redirect() {
			delete_transient( '_vc_page_welcome_redirect' );
		}

		/**
		 * Queue a redirect to install wizard
		 */
		public function activationRedirect() {
			update_option( 'gbt_' . GBTHELPERS::theme_name() . '_wizard_redirect', 1 );
		}

		/**
		 * Redirect to install wizard if a redirect request is queued
		 */
		public function redirectWizard() {
			if ( get_option( 'gbt_' . GBTHELPERS::theme_name() . '_wizard_redirect' ) == 1 ) {
				wp_redirect( admin_url( 'index.php?page=gbt-setup' ) );
			}
		}

		/**
		 * Catch the old plugin splash page redirect and redirect it to the new one
		 */
		public function disallowed_admin_pages() {
			global $pagenow;
			/* Check current admin page. */
			if ( $pagenow == 'admin.php' && isset( $_GET['page'] ) && $_GET['page'] == 'getbowtied_theme' ) {
				wp_redirect( admin_url( 'admin.php?page=getbowtied-tools' ) );
				return;
			}
		}

		/**
		 * Helpers
		 */
		private function load_helpers() {
			if ( ! class_exists( 'GBTHELPERS' ) ) {
				if ( file_exists( dirname( __FILE__ ) . '/includes/classes/class-gbt-helpers.php' ) ) {
					include dirname( __FILE__ ) . '/includes/classes/class-gbt-helpers.php';
				}
			}
		}

		/**
		 * Load the install wizard
		 */
		private function load_wizard() {
			if ( ! class_exists( 'GBT_InstallWizard' ) ) {
				if ( file_exists( dirname( __FILE__ ) . '/includes/classes/class-gbt-install-wizard.php' ) ) {
					include dirname( __FILE__ ) . '/includes/classes/class-gbt-install-wizard.php';
				}
			}
		}

		/**
		 * System status
		 */
		private function load_sysstatus() {
			if ( ! class_exists( 'GBT_SysStatus' ) ) {
				if ( file_exists( dirname( __FILE__ ) . '/includes/classes/class-system-status.php' ) ) {
					include dirname( __FILE__ ) . '/includes/classes/class-system-status.php';
				}
			}
		}

		/**
		 * The plugin self updater
		 */
		private function self_updater() {
			if ( ! class_exists( 'GBT_Self_updater' ) ) {
				if ( file_exists( dirname( __FILE__ ) . '/includes/classes/class-gbt-self-updater.php' ) ) {
					include dirname( __FILE__ ) . '/includes/classes/class-gbt-self-updater.php';
				}
			}
			new GBT_Self_updater( $this->version, 'https://api.getbowtied.com/v2/getbowtied-tools/update.php', 'getbowtied-tools/getbowtied-tools.php' );
		}

		/**
		 * Initializes the theme updater
		 */
		private function theme_updater() {
			if ( ! class_exists( 'GBT_Theme_updater' ) ) {
				if ( file_exists( dirname( __FILE__ ) . '/includes/classes/class-gbt-theme-updater.php' ) ) {
					include dirname( __FILE__ ) . '/includes/classes/class-gbt-theme-updater.php';
				}
			}
			new GBT_Theme_updater;
		}

		/**
		 * Defines the plugin modules
		 *
		 * @return Array of plugin modules
		 */
		private function modules() {
			return
			array(
				array(
					'name' => 'Plugins',
					'slug' => 'plugin-setup',
					'callback' => 'callback_plugin_setup',
				),

				array(
					'name' => 'Demo',
					'slug' => 'demo-import',
					'callback' => 'callback_demo_import',
				),

				array(
					'name' => 'Updates',
					'slug' => 'theme-activation',
					'callback' => 'callback_theme_activation',
				),

				array(
					'name' => 'System Status',
					'slug' => 'system-status',
					'callback' => 'callback_system_status',
				),
			);
		}

		/**
		 * Include section dependencies
		 *
		 * @uses $this->modules
		 */
		public function includes() {
			foreach ( $this->modules as $section ) {
				if ( file_exists( dirname( __FILE__ ) . '/includes/classes/' . 'class-gbt-' . $section['slug'] . '.php' ) ) {
					include dirname( __FILE__ ) . '/includes/classes/' . 'class-gbt-' . $section['slug'] . '.php';
				}
			}
		}

		/**
		 * Enqueue common javascript files
		 */
		public function loadScripts() {
			wp_enqueue_script( 'tooltipster-js', plugins_url( 'assets/external/tooltipster/tooltipster.bundle.min.js', __FILE__ ), array(), $this->version, null );
			wp_register_script( 'getbowtied-tools-js', plugins_url( 'assets/js/scripts-dist.js', __FILE__ ), array(), $this->version, null );
			wp_localize_script( 'getbowtied-tools-js', 'gbtAjaxurl', admin_url( 'admin-ajax.php' ) );
			wp_localize_script('getbowtied-tools-js', 'gbtStrings', array(
					'start_import'          => __( 'Running Import', 'getbowtied' ),
					'start_settings'        => __( 'Configuring your settings', 'getbowtied' ),
					'view_site'             => sprintf( __( "<a href='%s'>View site</a>", 'getbowtied' ), site_url() ),
					'import_error'          => __( "Whoa, something stopped the process. Please <a class='import-try-again'>Try Again</a>. The importer will try to continue where it left off.", 'getbowtied' ),
					'plugin'                => array(
													'activate'  => array(
														'doing' => __( 'Activating', 'getbowtied' ),
														'done'  => __( 'Active!', 'getbowtied' ),
													),
													'update'    => array(
														'doing' => __( 'Updating', 'getbowtied' ),
														'done'  => __( 'Updated!', 'getbowtied' ),
													),
													'install'   => array(
														'doing' => __( 'Installing', 'getbowtied' ),
														'done'  => __( 'Installed!', 'getbowtied' ),
													),
													'error'     => __( 'Failed.Try again?', 'getbowtied' ),

												),

			));
			wp_enqueue_script( 'getbowtied-tools-js' );
		}

		/**
		 * Enqueue common css files
		 */
		public function loadStyles() {

			wp_enqueue_style( 'getbowtied-tools-css', plugins_url( 'assets/css/styles.css', __FILE__ ), array(), $this->version );
			wp_enqueue_style( 'tooltipster-css', plugins_url( 'assets/external/tooltipster/tooltipster.bundle.min.css', __FILE__ ), array(), $this->version );
		}

		/**
		 * Setup plugin main menu
		 */
		public function adminMenu() {

			add_menu_page(
				GBTHELPERS::theme_name(),
				GBTHELPERS::theme_name(),
				'administrator',
				$this->slug,
				array(
				$this,
				'callbackSplashPage',
				),
				'',
				'2.1'
			);

			add_submenu_page(
				'getbowtied-tools',
				'Welcome',
				'Welcome',
				'administrator',
				'getbowtied-tools',
				array(
				$this,
				'callbackSplashPage',
				)
			);
		}

		/**
		 * Remove the old plugin menu / default theme menu
		 */
		public function removeOldMenu() {
			remove_menu_page( 'getbowtied_theme' );
		}

		/**
		 * Setup plugin submenu
		 *
		 * @uses GetBowtiedTools::$modules
		 */
		public function adminSubmenu() {

			foreach ( $this->modules as $section ) {
				add_submenu_page(
					$this->slug,
					$section['name'],
					$section['name'],
					'administrator',
					'getbowtied-' . $section['slug'],
					array(
					$this,
					$section['callback'],
					)
				);
			}

			$customize_url = GBTHELPERS::customizer_menu_link();

			add_submenu_page(
				$this->slug,
		        __( 'Customize' ),
		        __( 'Customize' ),
		        'customize',
		       $customize_url,
		        ''
		    );
		}

		/**
		 * Adds a notification/link to the wordpress admin bar
		 * if the theme is not activated
		 *
		 * @param  array $wp_admin_bar
		 */
		public function adminBarNotification( $wp_admin_bar ) {
			if ( class_exists( 'GBT_Activation' ) ) {
				if ( false === GBT_Activation::is_active() ) {
					$args = array(
					'id'    => 'getbowtied_theme_updates',
					'title' => __( 'Activate Theme Updates', 'getbowtied' ),
					'href'  => admin_url( 'admin.php?page=getbowtied-theme-activation' ),
					'meta'  => array(
						'class' => 'getbowtied_theme_activation',
					),
					);
					$wp_admin_bar->add_node( $args );
				}
			}
		}

		/**
		 * Admin Bar Update notification
		 * If the theme has a remote update
		 *
		 * @param  array $wp_admin_bar
		 */
		public function updateNotification( $wp_admin_bar ) {
			if ( version_compare( GBTHELPERS::theme_version(), get_option( 'getbowtied_' . GBTHELPERS::theme_slug() . '_remote_ver' ), '<' ) ) {
				$args = array(
					'id'    => 'getbowtied_theme_update_available',
					'title' => __( 'Theme Update Available', 'getbowtied' ),
					'href'  => admin_url( 'update-core.php' ),
					'meta'  => array(
						'class' => 'getbowtied_theme_update_available',
					),
					);
				$wp_admin_bar->add_node( $args );
			}
		}

		/**
		 * Splash page callback function
		 */
		public function callbackSplashPage() {
			require_once( 'includes/templates/page-splash.php' );
		}

		/**
		 * Demo Import callback function
		 */
		public function callback_demo_import() {
			if ( class_exists( 'GBT_Importer' ) ) {
				require_once( 'includes/templates/page-demo-import.php' );
			}
		}

		/**
		 * Plugin Setup callback function
		 */
		public function callback_plugin_setup() {
			if ( class_exists( 'GBT_Plugin_setup' ) ) {
				require_once( 'includes/templates/page-plugins.php' );
			}
		}

		/**
		 * Activation callback function
		 */
		public function callback_theme_activation() {
			if ( class_exists( 'GBT_Activation' ) ) {
				require_once( 'includes/templates/page-theme-activation.php' );
			}
		}

		/**
		 * System status page callback function
		 */
		public function callback_system_status() {
			if ( class_exists( 'GBT_Importer' ) ) {
				require_once( 'includes/templates/page-system-status.php' );
			}
		}

		/**
		 * Get the plugin url.
		 *
		 * @return string
		 */
		public function plugin_url() {
			return untrailingslashit( plugins_url( '/', __FILE__ ) );
		}
	}
	endif;


	$GBT = new GetBowtied_Tools;

	/**
 * Plugins module
 */
if ( class_exists( 'GBT_Plugin_setup' ) ) :
	if (is_admin()):
		$GBT_Plugins = new GBT_Plugin_setup();
	endif;
endif;
