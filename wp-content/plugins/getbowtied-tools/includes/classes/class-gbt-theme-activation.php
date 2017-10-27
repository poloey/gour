<?php
/**
 * GBT_Activaton
 *
 * The GetBowtied Activation class handles remote theme activation
 *
 * @class       GBT_Activation
 * @version         2.0
 * @category    Class
 * @author      GetBowtied
 */

if ( ! class_exists( 'GBT_Activation' ) ) {
	class GBT_Activation {

		/**
		 * Do not instance
		 */
		private function __construct() {
		}

		/**
		 * Listen for activation requests; validate and save them
		 *
		 * @return bool | NULL
		 */
		public static function activation_listener() {
			if ( isset( $_GET['l'] ) ) {
				$license = $_GET['l'];
				if ( preg_match( '/^[a-f0-9]{32}$/', $license ) ) {
					return self::validate_license( $license );
				}
			}

			return null;
		}

		public static function deactivation_listener() {
			if ( isset( $_POST['deactivate_getbowtied_license'] ) && ($_POST['deactivate_getbowtied_license'] == 1) ) {
				delete_option( 'getbowtied_' . GBTHELPERS::theme_slug() . '_license' );
			}
		}

		/**
		 * Checks if the license received is valid
		 *
		 * @param  string $license
		 *
		 * @return bool
		 */
		private static function validate_license( $license ) {
			$api_url = 'https://api.getbowtied.com/v2/validate-license.json';
			$args = array(
						'method' => 'POST',
						'timeout' => 5,
						'body' => array(
							'l' => $license,
							'd' => get_site_url(),
							't' => GBTHELPERS::theme_name(),
						),
					);

			$response = wp_remote_post( $api_url, $args );

			if ( is_wp_error( $response ) ) {
				return false;
			} else {
				$rsp = json_decode( $response['body'] );

				if ( $rsp->status == 1 ) {
					update_option( 'getbowtied_' . GBTHELPERS::theme_slug() . '_license', $license );
					return true;
				}

				return false;
			}
		}

		/**
		 * Returns the active license
		 *
		 * @return string | false
		 */
		public static function get_license() {
			return get_option( 'getbowtied_' . GBTHELPERS::theme_slug() . '_license' );
		}

		/**
		 * Frontend for this function
		 *
		 * @return bool
		 */
		public static function is_active() {
			return (self::get_license() !== false && trim( self::get_license() != false ));
		}

		/**
		 * Gets the connected user info from remote server
		 *
		 * @return bool|array
		 */
		public static function user_info() {
			if ( self::is_active() === true ) {
				/**
				 * If we have a cached transient, return that
				 */
				$uinfo = get_transient(GBTHELPERS::theme_slug() . "_uinfo");
				if ( $uinfo != false) {
					return $uinfo;
				}
				$api_url = 'https://api.getbowtied.com/v2/user-info.json';
				$args = array(
					'method' => 'POST',
					'timeout' => 5,
					'body' => array(
						'k' => self::get_license(),
						'd' => get_site_url(),
						't' => GBTHELPERS::theme_name(),
					),
				);

				$response = wp_remote_post( $api_url, $args );
				if ( is_wp_error( $response ) ) {
					return false;
				} else {
					$rsp = json_decode( $response['body'], true );
					if ( isset( $rsp['username'] ) && isset( $rsp['purchased'] ) && isset( $rsp['supported'] ) ) {
						/**
						 * Set a 1 week transient with user info
						 */
						set_transient( GBTHELPERS::theme_slug() . "_uinfo", $rsp, 60*60*24*7 );
						return $rsp;
					}
				}
			}

			return false;
		}

		public static function refresh_uinfo() {
			if ( isset( $_POST['refresh_uinfo'] ) && ($_POST['refresh_uinfo'] == 1) ) {
				delete_transient( GBTHELPERS::theme_slug() . "_uinfo" );
			}

			return null;
		}
	}
}// End if().


GBT_Activation::activation_listener();
GBT_Activation::deactivation_listener();
GBT_Activation::refresh_uinfo();
