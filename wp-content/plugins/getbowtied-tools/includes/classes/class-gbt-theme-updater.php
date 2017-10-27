<?php
/**
 * GBT_Theme_updater
 *
 * The theme updater adds update transients for the active GetBowtied theme and premium plugins provided with the theme
 *
 * @class       GBT_Theme_updater
 * @version     2.0
 * @category    Class
 * @author      GetBowtied
 */

if ( ! class_exists( 'GBT_Theme_updater' ) ) {
	class GBT_Theme_updater {

		/**
		 * Theme updater endpoint
		 *
		 * @var string
		 */
		var $api_url = 'http://api.getbowtied.com/v2/update-theme.json';

		/**
		 * Set filters and init key
		 */
		public function __construct() {

			$this->license_key = get_option( 'getbowtied_' . GBTHELPERS::theme_slug() . '_license' );

			add_filter( 'pre_set_site_transient_update_themes', array( &$this, 'check_for_update' ) );

			add_filter( 'upgrader_pre_download', array( $this, 'upgradeFilter' ), 10, 4 );
		}


		/**
		 * Hook into the update transient and add the themes version and update info
		 *
		 * @param  $transient
		 *
		 * @return $transient
		 */
		public function check_for_update( $transient ) {

			if ( empty( $transient->checked ) ) {
				return $transient;
			}

			$curr_theme = wp_get_theme();
			$curr_ver = GBTHELPERS::theme_version();

			$url = $this->api_url;

			$args = array(
						'method' => 'POST',
						'timeout' => 7,
						'body' => array(
							'k' => GBT_Activation::get_license(),
							't' => GBTHELPERS::theme_name(),
							'd' => get_site_url(),
						),
			);

			$request = wp_remote_post( $url, $args );

			if ( is_wp_error( $request ) ) {
		    	return $transient;
		    }

		    if ( $request['response']['code'] == 200 ) {
		    	$data = json_decode( $request['body'] );

		    	if ( ! empty( $data->error ) && $data->error == 1 ) {
		    		update_option( 'getbowtied_' . GBTHELPERS::theme_slug() . '_license', '' );
		    	}

				if ( isset( $data->version ) && version_compare( $curr_ver, $data->version, '<' ) ) {
					$transient->response[ $curr_theme->get_template() ] = array(
						'new_version'	=> $data->version,
						'package'		=> $data->download_url,
						'url'			=> GBTHELPERS::support_link(),
					);
					update_option( 'getbowtied_' . GBTHELPERS::theme_slug() . '_remote_ver', $data->version );

				}
			}

			return $transient;
		}

		/**
		 * Hook into upgrade filter and include our theme / premium plugins
		 *
		 * @param  $reply
		 * @param  $package
		 * @param  $updater
		 *
		 * @return $reply
		 */
		public function upgradeFilter( $reply, $package, $updater ) {

			// Theme updater
			$theme = wp_get_theme();
			$condition = isset( $updater->skin->theme_info ) && $updater->skin->theme_info['Name'] === $theme['Name'];
			if ( $condition ) {
				if ( ! get_option( 'getbowtied_' . GBTHELPERS::theme_slug() . '_license' ) || (get_option( 'getbowtied_' . GBTHELPERS::theme_slug() . '_license_expired' ) == 1) ) {
					return new WP_Error( 'no_credentials', sprintf( __( 'Please <a href="%1$s" target="_blank">activate your license</a> to enable theme updates.', 'getbowtied' ), admin_url( 'admin.php?page=getbowtied-theme-activation' ) ) );
				}
			}

			// VC Updater
			$condition = isset( $updater->skin->plugin ) && $updater->skin->plugin === 'js_composer/js_composer.php';
			if ( (isset( $updater->skin->plugin )) && ( $updater->skin->plugin === 'js_composer/js_composer.php') ) {}
			{
				$updater->strings['dummy_string'] = __( 'Getting the package...', 'js_composer' );
				$updater->skin->feedback( 'dummy_string' );
				$updater->strings['downloading_package_url'] = __( '', 'js_composer' );
				$updater->skin->feedback( 'downloading_package_url' );
				$updater->strings['downloading_package'] = __( '', 'js_composer' );
				$updater->skin->feedback( 'downloading_package_url' );
			}

			return $reply;
		}

	}
}// End if().
