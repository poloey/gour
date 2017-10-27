<div class="wrap gbt-wrap">
	<h1 class="transparent"><?php echo esc_html( get_admin_page_title() ); ?></h1>

	<div class="gbt-container">
		<div class="gbt-header">
			
			<div class="gbt-logo">
				<a href=""><img src="<?php echo esc_url( plugins_url( '/assets/images/' . GBTHELPERS::theme_slug() . '-logo.png', GBTHELPERS::path() ) ); ?>" alt="Logo"></a>
			</div>
			<div class="gbt-info">
				<span class="gbt-plugin-title"><?php esc_html_e( 'Get Bowtied Tools', 'getbowtied' ); ?></span>
				<span class="gbt-theme-name"><?php _e( GBTHELPERS::theme_name() ); ?></span>
			</div>
			<div class="gbt-navigation">
				<ul class="gbt-menu">
					<li>
						<a href="<?php echo esc_url( admin_url( 'admin.php?page=getbowtied-tools' ) ); ?>" class="<?php echo ($_GET['page'] === 'getbowtied-tools')? 'current' : ''; ?>"><?php esc_html_e( 'Welcome', 'getbowtied' ); ?></a>
					</li>
					<li>
						<a href="<?php echo esc_url( admin_url( 'admin.php?page=getbowtied-plugin-setup' ) ); ?>" class="<?php echo ($_GET['page'] === 'getbowtied-plugin-setup')? 'current' : ''; ?>"><?php esc_html_e( 'Plugins', 'getbowtied' ); ?></a>
					</li>
					<li>
						<a href="<?php echo esc_url( admin_url( 'admin.php?page=getbowtied-demo-import' ) ); ?>" class="<?php echo ($_GET['page'] === 'getbowtied-demo-import')? 'current' : ''; ?>"><?php esc_html_e( 'Demo', 'getbowtied' ); ?></a>
					</li>
					<li><a href="<?php echo esc_url( admin_url( 'admin.php?page=getbowtied-theme-activation' ) ); ?>" class="<?php echo ($_GET['page'] === 'getbowtied-theme-activation')? 'current' : ''; ?>"><?php esc_html_e( 'Updates', 'getbowtied' ); ?></a></li>
					<li><a href="<?php echo GBTHELPERS::customizer_link(); ?>"><?php esc_html_e( 'Customize', 'getbowtied' ); ?></a></li>
					<li><a target="_blank" href="<?php echo esc_url( GBTHELPERS::support_link() ); ?>"><?php esc_html_e( 'Help Center', 'getbowtied' ); ?></a></li>

				</ul>
			</div>
		</div>
