<?php
/**
 * GBT_SysStatus
 *
 * A helper class for the plugin
 *
 * @class 		GBT_SysStatus
 * @version		2.0
 * @category	Class
 * @author 		GetBowtied
 */

if ( ! class_exists( 'GBT_SysStatus' ) ) {
	class GBT_SysStatus {

		/**
		 * Do not instance
		 */
		private function __construct(){}

		public static function pluginActive( $plugin ) {
			return is_plugin_active( $plugin );
		}

		public static function memLimit( $print = false ) {
			$mem = intval( substr( ini_get( 'memory_limit' ), 0, -1 ) );
			if ( $print === false ) {
				return ($mem >= 256);
			}
			return $mem;
		}

		public static function execTime( $print = false ) {
			$exec = intval( ini_get( 'max_execution_time' ) );
			if ( $print === false ) {
				return ( ($exec >= 60) || ($exec === 0) );
			}
			return $exec;
		}

		public static function uploadLimit( $print = false ) {
			$upl = intval( substr( size_format( wp_max_upload_size() ), 0, -1 ) );
			if ( $print === false ) {
				return ($upl >= 12);
			}
			return $upl;
		}

		public static function isCurl() {
			return ((function_exists( 'fsockopen' )) && (function_exists( 'curl_init' )));
		}

		public static function isGzip() {
			return (is_callable( 'gzopen' ));
		}

		public static function isGet() {
			$response = wp_safe_remote_get( 'http://www.woothemes.com/wc-api/product-key-api?request=ping&network=' . ( is_multisite() ? '1' : '0' ) );
			return ( ( ! is_wp_error( $response ) && $response['response']['code'] >= 200 && $response['response']['code'] < 300 ) );
		}

		public static function systemsCheck() {
			return ( 	self::pluginActive( 'js_composer/js_composer.php' ) &&
						self::pluginActive( 'woocommerce/woocommerce.php' ) &&
						self::memLimit() &&
						self::execTime() &&
						self::uploadLimit() &&
						// self::isCurl() &&
						self::isGzip() &&
						self::isGet()
				);
		}
	}
}// End if().
