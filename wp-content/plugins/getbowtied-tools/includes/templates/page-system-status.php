<?php

include 'header.php'; ?>

<div class="gtb-system-status">
	<ul class="gbt-sub-menu">
		<li class="back-to"><a href="<?php echo esc_url( admin_url( 'admin.php?page=getbowtied-demo-import' ) ); ?>"><span class="dashicons dashicons-arrow-left-alt2"></span><?php esc_html_e( 'Back to Demo Import', 'getbowtied' );?></a></li>
		
	</ul>
	
</div>

<div class="gtb-system-status">
	<table class="required_plugins">
		<thead>
			<th colspan="2"><?php esc_html_e( 'Required Plugins', 'getbowtied' ); ?></th>
		</thead>
		<tbody>
			<tr>
				<td><?php esc_html_e( 'WPBakery Visual Composer', 'getbowtied' ); ?></td>
				<td>
					<?php if ( true === GBT_SysStatus::pluginActive( 'js_composer/js_composer.php' ) ) : ?>
						<mark class="yes"><span class="dashicons dashicons-yes"></span> </mark>
					<?php else : ?>
						<mark class="error"><span class="dashicons dashicons-warning"></span> </mark>
					<?php endif; ?>
				</td>
			</tr>
			<tr>
				<td><?php esc_html_e( 'Woocommerce', 'getbowtied' ); ?></td>
				<td>
					<?php if ( true === GBT_SysStatus::pluginActive( 'woocommerce/woocommerce.php' ) ) : ?>
						<mark class="yes"><span class="dashicons dashicons-yes"></span> </mark>
					<?php else : ?>
						<mark class="error"><span class="dashicons dashicons-warning"></span> </mark>
					<?php endif; ?>
				</td>
			</tr>
		</tbody>
	</table>



	<table class="server_environment">
		<thead>
			<th colspan="2"><?php esc_html_e( 'Server Environment:', 'getbowtied' ); ?></th>
		</thead>
		<tbody>
			<tr>
				<td><?php esc_html_e( 'Server Memory Limit:', 'getbowtied' ); ?></td>
				<td>
					<?php if ( true === GBT_SysStatus::memLimit() ) : ?>
						<mark class="yes"><span class="dashicons dashicons-yes"></span><?php echo GBT_SysStatus::memLimit( true ); ?>MB</mark>
					<?php else : ?>
						<mark class="error"><span class="dashicons dashicons-warning tooltip" title="<?php esc_html_e( 'We recommend at least 256MB of memory.','getbowtied' ); ?>"></span><?php echo GBT_SysStatus::memLimit( true ); ?>MB</mark>
					<?php endif; ?>
				</td>
			</tr>
			<tr>
				<td><?php esc_html_e( 'PHP Time Limit:', 'getbowtied' ); ?></td>
				<td>
					<?php if ( true === GBT_SysStatus::execTime() ) : ?>
						<mark class="yes"><span class="dashicons dashicons-yes"></span><?php echo esc_html( GBT_SysStatus::execTime( true ) ); ?></mark>
					<?php else : ?>
						<mark class="error"><span class="dashicons dashicons-warning tooltip" title="<?php esc_html_e( 'We recommend at least 60s of execution time.','getbowtied' ); ?>"></span><?php echo esc_html( GBT_SysStatus::execTime( true ) ); ?></mark>
					<?php endif; ?>
				</td>
			</tr>
			<tr>
				<td><?php esc_html_e( 'Max Upload Size', 'getbowtied' ); ?></td>
				<td>
					<?php if ( true === GBT_SysStatus::uploadLimit() ) : ?>
						<mark class="yes"><span class="dashicons dashicons-yes"></span><?php echo esc_html( GBT_SysStatus::uploadLimit( true ) ); ?>MB</mark>
					<?php else : ?>
						<mark class="error"><span class="dashicons dashicons-warning tooltip" title="<?php esc_html_e( 'We recommend at least 12MB of upload limit.','getbowtied' ); ?>"></span><?php echo esc_html( GBT_SysStatus::uploadLimit( true ) ); ?>MB</mark>
					<?php endif; ?>
				</td>
			</tr>
			<tr>
				<td><?php esc_html_e( 'Gzip:', 'getbowtied' ); ?></td>
				<td>
					<?php if ( true === GBT_SysStatus::isGzip() ) : ?>
						<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>
					<?php else : ?>
						<mark class="error"><span class="dashicons dashicons-warning tooltip" title="<?php esc_html_e( 'Gzip is required for importing archived demo content','getbowtied' ); ?>"></span></mark>
					<?php endif; ?>
				</td>
			</tr>
			<tr>
				<td><?php esc_html_e( 'Remote Get:', 'getbowtied' ); ?></td>
				<td>
					<?php if ( true === GBT_SysStatus::isGet() ) : ?>
						<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>
					<?php else : ?>
						<mark class="error"><span class="dashicons dashicons-warning tooltip" title="<?php esc_html_e( 'Remote Get is required for fetching theme & plugin updates.','getbowtied' ); ?>"></span></mark>
					<?php endif; ?>
				</td>
			</tr>
		</tbody>
	</table>



</div>
