<?php

include 'header.php'; ?>

<?php
$is_required_plugins = GBT_Importer::is_required_plugins();
?>

<div class="gbt-demo-import">	
	
	<ul class="gbt-sub-menu">
		<li><a class="button <?php echo ( GBT_SysStatus::systemsCheck() === false) ? 'required' : ''; ?>" href="<?php echo esc_url( admin_url( 'admin.php?page=getbowtied-system-status' ) ); ?>"><span class="dashicons dashicons-info"></span><?php esc_html_e( 'System Status', 'getbowtied' );?></a></li>
	</ul>

	<?php if ( GBT_Importer::is_config() ) : ?>

		<?php foreach ( GBT_Importer::$theme_config as $demo ) { ?>
			<?php if ( GBT_Importer::is_required_plugins() ) : ?>
				<div class="demo-object">
					<img class="demo-import-icon" src="<?php echo esc_attr( plugins_url( '/assets/images/install-demo-import.png', GBTHELPERS::path() ) );?>">
					<a href="javascript:void(0)" class="getbowtied-install-demo-button import-demo-content button" 
						data-demo="<?php echo $demo['demo_name'];?>"> 
						<?php esc_html_e( 'Import Demo Content', 'getbowtied' ); ?>
					 </a>
				</div>
			<?php else : ?>
				<div class="demo-object install-required-plugins">
					<img class="demo-import-icon" src="<?php echo esc_attr( plugins_url( '/assets/images/demo-required-plugins.png', GBTHELPERS::path() ) );?>"></a>
						<p><?php _e( 'Please make sure <a href="#">Visual Composer</a> and <a href="#">WooCommerce</a> are installed and activated before importing the demo content.' ); ?></p>
						<a href="<?php echo esc_url( admin_url( 'admin.php?page=getbowtied-plugin-setup' ) ); ?>" class="button install-required-plugins-btn"><?php esc_html_e( 'Install Required Plugins', 'getbowtied' ); ?></a>
				</div>
			<?php endif; ?>
		<?php } ?>
		
		<div class="importer-log">
			<div class="status-log status-importer"></div>
			<div class="status-log status-settings"></div>
			<div class="status-log status-final"></div>
		</div>

	<?php else : ?>
		<?php esc_html_e( "Sorry, we couldn't find a theme config file.", 'getbowtied' ); ?>
	<?php endif;?>
</div>	
