<?php include 'header.php'; ?> 
<div class="gbt-wrapper gbt-activation">
	<?php if ( GBT_Activation::is_active() ) : ?>
		<div class="theme-activation theme-is-active">
			<img src="<?php echo esc_url( plugins_url( '/assets/images/gbt-theme-activated.png', GBTHELPERS::path() ) ); ?>">
			<?php if ( ! GBTHELPERS::hasUpdate() ) : ?>
			<p><?php esc_html_e( 'Updates are enabled for this site.', 'getbowtied' );?><br/><?php esc_html_e( 'You’re using the latest version of the theme', 'getbowtied' ); ?> (V. <?php echo esc_html( GBTHELPERS::theme_version() ); ?>).</p>
			<a class="button check-for-updates" href="<?php echo esc_url( admin_url( 'update-core.php?force-check=1' ) ); ?>"><?php esc_html_e( 'Check for Updates', 'getbowtied' ); ?></a>
			<?php else : ?>
			<p><?php esc_html_e( "There's a new theme update available", 'getbowtied' ); ?>, V. <?php echo esc_html( GBTHELPERS::remoteVersion() );?><br/>
			<?php esc_html_e( "You're using", 'getbowtied' ); ?> V. <?php echo esc_html( GBTHELPERS::theme_version() );?>
			</p>
			<a class="button check-for-updates" href="<?php echo esc_url( admin_url( 'update-core.php?force-check=1' ) ); ?>"><span class="dashicons dashicons-update"></span><?php esc_html_e( 'Update Now', 'getbowtied' ); ?></a>
			<?php endif;?>

			<form action="" method="post" class="refresh-info" >
				<input type="hidden" name="refresh_uinfo" value="1" />
				<button type="submit" 
						class="button disconnect">
						<?php esc_html_e( 'Refresh License Info', 'getbowtied' ); ?>
				</button>
			</form>

			<form action="" method="post" class="disconnect-form" >
				<input type="hidden" name="deactivate_getbowtied_license" value="1" />
				<button type="submit" 
						class="button disconnect" 
						onclick="return confirm('<?php esc_html_e( 'This will deactivate automatic updates for your GetBowtied theme and included plugins. Are you sure?', 'getbowtied' ); ?>')">
						<?php esc_html_e( 'Disconnect', 'getbowtied' ); ?>
				</button>
			</form>

			<?php
			$uinfo = GBT_Activation::user_info();
			if ( false !== $uinfo ) : ?>
			<table class="username-info">
				<tr>
					<td class="col-left"><?php esc_html_e( 'Envato Username:', 'getbowtied' );?></td>
					<td class="col-right"><?php echo esc_html( $uinfo['username'] );?></td>
				</tr>
				<tr>
					<td class="col-left"><?php esc_html_e( 'Purchase Date:', 'getbowtied' );?></td>
					<td class="col-right"><?php echo is_numeric( $uinfo['purchased'] ) ? date( 'F jS, Y', $uinfo['purchased'] ) : $uinfo['purchased'];?></td>
				</tr>
				<tr>
					<td class="col-left"><?php esc_html_e( 'Support Subscription:', 'getbowtied' );?></td>
					<td class="col-right">
						<?php if ( is_numeric( $uinfo['supported'] ) && (time() > $uinfo['supported']) ) : ?>
	                    	<span class="expired"><?php esc_html_e( 'Expired', 'getbowtied' ); ?></span> <?php esc_html_e( 'on', 'getbowtied' ); ?>
	                    	<?php
	                    		echo is_numeric( $uinfo['supported'] )? date( 'F jS, Y', $uinfo['supported'] ) : $uinfo['supported'];
	                    	?>
	                    	<span class="extend"><a href="<?php echo GBTHELPERS::envato_link(); ?>" target="_blank"><?php esc_html_e( 'Extend', 'getbowtied' );?></a></span>
						<?php else : ?>
							<span class="supported"><?php esc_html_e( 'Supported', 'getbowtied' ); ?></span> <?php esc_html_e( 'until','getbowtied' ); ?>
	                    	<?php echo is_numeric( $uinfo['supported'] )? date( 'F jS, Y', $uinfo['supported'] ) : $uinfo['supported']; ?>
	                    <?php endif; ?>
					</td>
				</tr>
			</table>
			<?php endif; ?>

			<p class="your-purchase-enable theme-active">
				<?php printf( __( 'Your purchase enables updates and support for one WordPress site.<br> Please <a target="_blank" href="%s">purchase a new license</a> to use this theme on another website.', 'getbowtied' ), GBTHELPERS::envato_link() );
				?>
			</p>
		</div>
	<?php else : ?>
		<div class="theme-activation">
			<img src="<?php echo esc_url( plugins_url( '/assets/images/gbt-connect-icon.png', GBTHELPERS::path() ) ); ?>">
			<p><?php esc_html_e( 'Connect your Envato Market account to validate your purchase and enable theme updates for this WordPress Site.', 'getbowtied' ); ?></p>

			<?php
				$url = get_site_url();
				$theme_name = GBTHELPERS::theme_name();

				printf(
					'<a class="activation-required gbt-btn" href="https://api.getbowtied.com/one-click-registration/?theme=%s&uri=%s&admin=%s">',
					urlencode( $theme_name ),
					urlencode( $url ),
					urlencode( admin_url() )
				);

				esc_html_e( 'Connect Envato Account', 'getbowtied' );

				echo '</a>';
			?>
			<p class="your-purchase-enable"> 
				<?php _e( 'A license is valid for one WordPress site only. Using this <br> theme on a new site?', 'getbowtied' ); ?>
				<a href="<?php echo GBTHELPERS::envato_link(); ?>" target="_blank"><?php esc_html_e( 'Purchase a new license.', 'getbowtied' );?></a>
				</a>
			</p>
		</div>
	<?php endif; ?>
</div>
