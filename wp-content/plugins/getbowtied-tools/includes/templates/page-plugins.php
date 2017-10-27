<?php

	global $GBT_Plugins;
	$plugins = $GBT_Plugins->_get_plugins();

	include 'header.php';

function loop_plugins( $GBT_Plugins, $plugins ) {
	foreach ( $plugins as $slug => $plugin ) {
		?>
		<div class="gbt-plugin <?php echo ! empty( $plugin['status'] )? 'action-' . $plugin['status'] : ''; ?>" data-slug="<?php echo esc_attr( $slug ); ?>">
		
			<div class="plugin-image <?php echo esc_html( $plugin['slug'] ); ?>">
				
				<?php if ( $plugin['status'] == 'update' ) : ?>
					<p class="update-tag"><?php esc_html_e( 'Update Available', 'getbowtied' ); ?></p>	
					<?php endif; ?>

				<?php if ( isset( $plugin['external_image'] ) ) : ?>
						<div class="plugin-featured-icon" style="background-image: url('<?php echo esc_url( $plugin['external_image'] ); ?>');"></div>
					<?php endif; ?>

			</div>  

			<div class="plugin-body">

				<?php if ( $plugin['required'] === true ) : ?>
					<p class="required-tag"><?php esc_html_e( 'Required', 'getbowtied' ); ?></p>	
					<?php endif; ?>
					
				<h3><a class="plugin-name"><?php echo esc_html_e( $plugin['name'] ); ?></a></h3>
					
				<div class="action-links">
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
							<a  class="button ajax-request <?php echo $plugin['status']; ?>-now" 
								href="<?php echo esc_url( $url ); ?>" 
								data-plugin="<?php echo $slug; ?>" 
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
					</div> <!-- end plugin body -->
				</div>
				
			</div>

		<?php }// End foreach().

	if ( ! GBT_Activation::is_active() ) : ?>
			
			<div class="gbt-plugin placeholder"></div>	
			<div class="gbt-plugin placeholder last"></div>	
			<p><a href="<?php echo admin_url( 'admin.php?page=getbowtied-theme-activation' ); ?>"><?php esc_html_e( 'Activate updates','getbowtied' );?></a> <?php esc_html_e( 'to get the latest versions as well as the full list of recommended plugins.', 'getbowtied' ); ?></p>

		<?php endif;

}

	?>

	<div class="gbt-wrapper gbt-plugins <?php echo ( ! GBT_Activation::is_active()) ? esc_html_e( 'theme-inactive', 'getbowtied' ) : ''; ?>">
		<?php
		/**
		 *  Required Plugins
		 */
		?>

		<?php loop_plugins( $GBT_Plugins, $plugins ); ?>

	</div>


