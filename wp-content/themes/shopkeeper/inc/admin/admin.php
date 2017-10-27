<?php 
if( ! class_exists( 'Getbowtied_Admin_Pages' ) ) {

	class Getbowtied_Admin_Pages {		
	
		// =============================================================================
		// Construct
		// =============================================================================

		function __construct() {	

			add_action( 'admin_menu', 				array( $this, 'getbowtied_theme_admin_menu' ) );
			add_action( 'admin_menu', 				array( $this, 'getbowtied_customizer_menu' ) );

		}

		function getbowtied_theme_admin_menu() {			
			$getbowtied_menu_welcome = add_menu_page(
				getbowtied_parent_theme_name(),
				getbowtied_parent_theme_name(),
				'administrator',
				'getbowtied_theme',
				array( $this, 'getbowtied_theme_welcome_page' ),
				'',
				3
			);
		}

		function getbowtied_customizer_menu() {		
			$customize_url = add_query_arg(
		        'return',
		        urlencode( wp_unslash( $_SERVER['REQUEST_URI'] ) ),
		        'customize.php'
		    );	

			add_submenu_page(
				'getbowtied_theme',
		        __( 'Customize' ),
		        __( 'Customize' ),
		        'customize',
		        esc_url( $customize_url ),
		        ''
		    );

		}

		function getbowtied_admin_menu() {						
			$getbowtied_welcome = add_submenu_page(
				'getbowtied_theme',
				__( 'Get Bowtied', 'getbowtied' ),
				__( 'Get Bowtied', 'getbowtied' ),
				'administrator',
				'getbowtied',
				array( $this, 'getbowtied_welcome_page' )
			);
		}

		function getbowtied_theme_welcome_page() 
		{
			require_once 'welcome_theme.php';
		}
	}
	
	new Getbowtied_Admin_Pages;

}