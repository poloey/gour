<?php
/**
 * GBT_InstallWizard
 *
 * Install wizard for the theme
 *
 * @class 		GBT_InstallWizard
 * @version		2.0
 * @category	Class
 * @author 		GetBowtied
 */

class GBT_InstallWizard {

	private $steps;
	private $step;

	public function __construct() {

		add_action( 'admin_menu', array( $this, 'initWizard' ) );
		add_action( 'admin_init', array( $this, 'setupWizard' ) );

	}

	public function initWizard() {
		add_dashboard_page( '', '', 'manage_options', 'gbt-setup', '' );
	}

	public function setupWizard() {
		global $GBT;

		if ( empty( $_GET['page'] ) || 'gbt-setup' !== $_GET['page'] ) {
			return;
		}

		$default_steps = array(
			'introduction' => array(
				'name'    => __( 'Introduction', 'getbowtied' ),
				'view'    => array( $this, 'gbt_setup_introduction' ),
				'handler' => '',
			),
			'plugins' => array(
				'name'    => __( 'Plugins', 'woocommerce' ),
				'view'    => array( $this, 'gbt_setup_plugins' ),
				'handler' => '',
			),
			'demo' => array(
				'name'    => __( 'Demo Import', 'woocommerce' ),
				'view'    => array( $this, 'gbt_setup_demo' ),
				'handler' => '',
			),
			'final' => array(
				'name'    => __( 'Ready!', 'woocommerce' ),
				'view'    => array( $this, 'gbt_setup_final' ),
				'handler' => '',
			),
			// 'next_steps' => array(
			// 'name'    => __( 'Ready!', 'woocommerce' ),
			// 'view'    => array( $this, 'gbt_setup_ready' ),
			// 'handler' => '',
			// ),
		);

		$this->steps = $default_steps;
		$this->step = isset( $_GET['step'] ) ? sanitize_key( $_GET['step'] ) : current( array_keys( $this->steps ) );

		wp_enqueue_style( 'gbt-wizard-css', $GBT->plugin_urL() . '/assets/css/wizard.css', array(), $GBT->version );
		wp_register_script( 'gbt-wizard-js', $GBT->plugin_urL() . '/assets/js/wizard.js', array( 'jquery' ), $GBT->version );
		$this->setup_wizard_steps();
		$this->setup_wizard_header();
		$this->content();
		$this->setup_wizard_footer();
		exit;
	}

	/**
	 * Get the URL for the next step's screen.
	 *
	 * @param string step   slug (default: current step)
	 * @return string       URL for next step if a next step exists.
	 *                      Admin URL if it's the last step.
	 *                      Empty string on failure.
	 */
	public function get_next_step_link( $step = '' ) {
		if ( ! $step ) {
			$step = $this->step;
		}

		$keys = array_keys( $this->steps );
		if ( end( $keys ) === $step ) {
			return admin_url();
		}

		$step_index = array_search( $step, $keys );
		if ( false === $step_index ) {
			return '';
		}

		return add_query_arg( 'step', $keys[ $step_index + 1 ] );
	}

	public function get_prev_step_link( $step = '' ) {
		if ( ! $step ) {
			$step = $this->step;
		}

		$keys = array_keys( $this->steps );
		if ( end( $keys ) === $step ) {
			return admin_url();
		}

		$step_index = array_search( $step, $keys );
		if ( false === $step_index ) {
			return '';
		}

		return add_query_arg( 'step', $keys[ $step_index - 1 ] );
	}

	/**
	 * Output the steps.
	 */
	public function setup_wizard_steps() {
		$ouput_steps = $this->steps;
		array_shift( $ouput_steps );
		?>

		<div class="gbt-wizard-logo">
			<a href="#"><img src="<?php echo esc_attr( plugins_url( '/assets/images/' . GBTHELPERS::theme_slug() . '-logo.png', GBTHELPERS::path() ) ); ?>" alt="Logo"></a>
		</div>

		<ol class="gtb-wizard-menu">
			<?php foreach ( $ouput_steps as $step_key => $step ) : ?>
				<li class="<?php
				if ( $step_key === $this->step ) {
					echo 'active';
				} elseif ( array_search( $this->step, array_keys( $this->steps ) ) > array_search( $step_key, array_keys( $this->steps ) ) ) {
					echo 'done';
				}
				?>"><span><?php echo esc_html( $step['name'] ); ?></span></li>
			<?php endforeach; ?>
		</ol>
		<?php
	}

	/**
	 * Setup Wizard Header.
	 */
	public function setup_wizard_header() {
		?>
		<!DOCTYPE html>
		<html <?php language_attributes(); ?>>
		<head>
			<meta name="viewport" content="width=device-width" />
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<title><?php esc_html_e( 'GetBowtied &rsaquo; Setup Wizard', 'getbowtied' ); ?></title>
			<?php wp_print_scripts( 'gbt-wizard-js' ); ?>
			<?php do_action( 'admin_print_styles' ); ?>
			<?php do_action( 'admin_head' ); ?>
		</head>
		<body class="gbt-setup-wizard wp-core-ui">
			

		<?php
		        update_option( 'gbt_' . GBTHELPERS::theme_name() . '_wizard_redirect', 0 );
	}

	/**
	 * Setup Wizard Footer.
	 */
	public function setup_wizard_footer() {
		?>
				
				<a class="wc-return-to-dashboard" href="<?php echo esc_url( admin_url() ); ?>"><?php esc_html_e( 'Return to the WordPress Dashboard', 'woocommerce' ); ?></a>

			</body>
		</html>
		<?php
	}

	/**
	 * Load the view for the current step
	 */
	public function content() {
		if ( array_key_exists( $this->step, $this->steps ) ) :
			call_user_func( $this->steps[ $this->step ]['view'], $this );
		endif;
	}

	/**
	 * Step Introduction view
	 */
	public function gbt_setup_introduction() {
		?>
			<div class="wrapper wizard-introduction">
				<img src="<?php echo esc_attr( plugins_url( '/assets/images/page_setup.jpg', GBTHELPERS::path() ) ); ?>" alt="Page Setup Introduction">
				<h1><?php esc_html_e( GBTHELPERS::theme_name() . '\'s');?> <br/> <?php esc_html_e('Theme Setup Wizard', 'getbowtied' ); ?></h1>
				<p><?php esc_html_e( 'The quickest way to setup the theme', 'getbowtied'); ?> <br /> <?php esc_html_e('and start working on your site.', 'getbowtied' );?></p>
				<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button-primary button button-large button-next"><?php esc_html_e( 'Let\'s go!', 'woocommerce' ); ?></a>
			</div>

		<?php
	}

	/**
	 * Step Plugins View
	 */
	public function gbt_setup_plugins() {
		?>
			<div class="wrapper wizard-plugins">

				<div class="content-info">
					<h1><?php esc_html_e( 'Plugin Installation', 'getbowtied' ); ?></h1>
					<p><?php _e( 'Install <strong>WooCommerce</strong> and <strong>Visual Composer</strong> and <br> proceed with the demo content import.', 'getbowtied' ); ?></p>
				</div>
				<div class="plugins">

				<?php
					global $GBT_Plugins;

					$plugins = $GBT_Plugins->_get_plugins();

				foreach ( $plugins as $slug => $plugin ) {
					if ( $plugin['required'] === true ) : ?>
						<div class="plugin <?php echo esc_attr( $slug ); ?>">
							<p class="required-tag"><?php esc_html_e( 'Required', 'getbowtied' ); ?></p>
							<div class="plugin-image" style="background-image: url('<?php echo esc_url( $plugin['external_image'] ); ?>');"></div>
							<div class="plugin-install">
								<div class="plugin-status">
									<!-- <span class="dashicons dashicons-editor-help"></span> -->
									<span class="dashicons dashicons-yes grey"></span>
									<!-- <span class="dashicons dashicons-no"></span> -->
								</div>
								<label for="woocommerce"><strong><?php echo esc_html( $plugin['name'] );?></strong></label>
								<span class="plugin-description"><?php echo isset( $plugin['description'] )? esc_html_e( $plugin['description'] ) : '';?></span>
								<div class="action-links" style="display:none">
									<?php
									$url = wp_nonce_url(
										add_query_arg(
											array(
												'plugin'   		   			 => urlencode( $slug ),
												'tgmpa-' . $plugin['status'] => $plugin['status'] . '-plugin',
											),
											admin_url( $GBT_Plugins->get_tgmpa_url() )
										),
										'tgmpa-' . $plugin['status'],
										'tgmpa-nonce'
									);
								?>

								<?php if ( ! empty( $plugin['status'] ) && ($plugin['status'] != 'no-action') ) : ?>
										<a  class="button ajax-request <?php echo esc_html( $plugin['status'] ); ?>-now" 
											href="<?php echo esc_url( $url ); ?>" 
											data-plugin="<?php echo esc_attr( $slug ); ?>" 
											data-verify="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>"
											data-action="<?php echo esc_attr( $plugin['status'] ); ?>">
											<?php echo ($plugin['status'] == 'install') ? esc_html_e( 'Install Now', 'getbowtied' ) : ''; ?>
											<?php echo ($plugin['status'] == 'update') ? esc_html_e( 'Update Now', 'getbowtied' ) : ''; ?>
											<?php echo ($plugin['status'] == 'activate') ? esc_html_e( 'Activate', 'getbowtied' ) : ''; ?>
										</a>

									<?php else : ?>
										<a class="button button-disabled">
											<?php  esc_html_e( 'Active', 'getbowtied' ); ?>
										</a>
									<?php endif; ?>
								</div>
							</div>
						</div>
					<?php
					endif;
				}// End foreach().
				?>
				</div>

				<div class="buttons">
					<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button skip"><?php esc_html_e( 'Skip', 'getbowtied' ); ?></a>
					<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button install "><?php esc_html_e( 'Install', 'getbowtied' ); ?></a>
				</div>
			</div>

		<?php
	}

	/**
	 * Step Demo View
	 */
	public function gbt_setup_demo() {
		?>
		
		<div class="wrapper wizard-demo-import">

			<?php $is_required_plugins = GBT_Importer::is_required_plugins(); ?>

			<div class="content-info">
				<h1><?php esc_html_e( 'Demo Content Import', 'getbowtied' ); ?></h1>
				<p><?php esc_html_e( 'Start with pre-built page layouts, dummy product pages,', 'getbowted');?><br/> <?php esc_html_e('blog posts and portfolio items.', 'getbowtied' ); ?></p>
			</div>

			<div class="demo-icon <?php echo ( ! $is_required_plugins === true) ? 'error' : '' ?>">
				<?php if ( $is_required_plugins === true ) : ?>
					<img src="<?php echo esc_url( plugins_url( '/assets/images/install-demo-import-white.png', GBTHELPERS::path() ) ); ?>" alt="Demo Import">
				<?php else : ?>
					<img src="<?php echo esc_url( plugins_url( '/assets/images/install-demo-import-error.png', GBTHELPERS::path() ) ); ?>" alt="Demo Import">
					<p class="error-info"><?php esc_html_e( 'Please make sure Visual Composer and WooCommerce are installed and activated before importing the demo content.', 'getbowtied' ); ?></p>
				<?php endif; ?>
			</div>

	        <?php foreach ( GBT_Importer::$theme_config as $demo ) { ?>
				<div class="wizard-demo-object">
					<span class="getbowtied-install-demo-wizard" 
						data-demo="<?php echo esc_attr( $demo['demo_name'] );?>"
						data-ajaxurl="<?php echo esc_attr( admin_url( 'admin-ajax.php' ) ); ?>"> 
					 </span>
				</div>
			<?php } ?>

			<div class="buttons">
				<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button skip"><?php esc_html_e( 'Skip', 'getbowtied' ); ?></a>
				<?php if ( $is_required_plugins === true ) : ?>
					<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button install"><?php esc_html_e( 'Install', 'getbowtied' ); ?></a>
				<?php else : ?>
					<a href="<?php echo esc_url( $this->get_prev_step_link() ); ?>" class="button "><?php esc_html_e( 'Go back', 'getbowtied' ); ?></a>
				<?php endif; ?>
			</div>

		</div>


		<?php
	}

	/**
	 * Step Final View
	 */
	public function gbt_setup_final() {
		?>
		
		<div class="wrapper wizard-ready">
			<img src="<?php echo esc_url( plugins_url( '/assets/images/page_setup.jpg', GBTHELPERS::path() ) ); ?>" alt="Page Setup Ready">
			<div class="content-info">
				<h1><?php esc_html_e( 'Setup has completed successfully!', 'getbowtied' ); ?></h1>
				<p><?php esc_html_e('You should be able to start working on your site now.','getbowtied');?> <br/>
					<?php esc_html_e('Best of luck with your project!', 'getbowtied'); ?></p>
			</div>

			<div class="further-info">
				<div class="column">
					<h2><?php esc_html_e( 'What now?', 'getbowtied' ); ?></h2>
					<a href="<?php echo esc_url( site_url() ); ?>" class="button button-primary"><?php esc_html_e( 'View Site', 'getbowtied' );?></a>
				</div>
				<div class="column last">
					<h2><?php esc_html_e( 'What\'s next?', 'getbowtied' );?></h2>
					<ul>
						<li><a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>"><span class="dashicons dashicons-admin-appearance"></span><?php esc_html_e( 'Customize the theme', 'getbowtied' ); ?></a>
						</li>

						<li><a href="<?php echo esc_url( admin_url( 'admin.php?page=getbowtied-theme-activation' ) );?>"><span class="dashicons dashicons-update"></span><?php esc_html_e( 'Activate Theme Updates', 'getbowtied' ); ?></a></li>
						<li><a href="<?php echo esc_url( admin_url( 'index.php?page=wc-setup' ) );?>"><span class="dashicons dashicons-admin-settings"></span><?php esc_html_e( 'WooCommerce Setup Wizard', 'getbowtied' ); ?></a></li>
						<li><a href="<?php echo esc_url( GBTHELPERS::support_link() ); ?>"><span class="dashicons dashicons-editor-help"></span><?php esc_html_e( 'Theme User Guide &amp; Support', 'getbowtied' ); ?></a></li>
					</ul>
				</div>
			</div>

		</div>

		<?php
	}


}
