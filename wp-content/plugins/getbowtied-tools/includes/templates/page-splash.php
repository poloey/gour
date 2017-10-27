<?php

include 'header.php';

?>

<div class="gbt-wrapper splash-page">
	<div class="welcome-icon">
		<img src="<?php echo esc_url( plugins_url( '/assets/images/icon-checkmark.png', GBTHELPERS::path() ) ); ?>">
	</div>
		<p class="welcome-text"><?php esc_html_e( 'Congratulations for your excellent taste in WordPress themes. Welcome to ' . GBTHELPERS::theme_name() . '!', 'getbowtied' ); ?></p>
	<div class="setup">
		<a href="<?php echo esc_url( admin_url( 'index.php?page=gbt-setup' ) ); ?>" class="setup-wizard-btn button"><?php esc_html_e( 'Run the Setup Wizard', 'getbowtied' ); ?></a>
	</div>
</div>
