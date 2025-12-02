<?php if (!defined('FW')) die('Forbidden');
/**
 * @var string $archives_html
 */
?>

<?php
$backups = fw_ext( 'backups' ); /** @var FW_Extension_Backups $backups */
$page_url = $backups->get_page_url();
?>
<h2><?php esc_html_e('Backup', 'fw') ?> <span id="fw-ext-backups-status"></span></h2>

<div>
	<?php if ( !class_exists('ZipArchive') ): ?>
		<div class="error below-h2">
			<p>
				<strong><?php _e( 'Important', 'fw' ); ?></strong>:
				<?php printf(
					__( 'You need to activate %s.', 'fw' ),
					'<a href="http://php.net/manual/en/book.zip.php" target="_blank">'. __('zip extension', 'fw') .'</a>'
				); ?>
			</p>
		</div>
	<?php endif; ?>
<!--
	<div>
		<a href="#" onclick="return false;" id="fw-ext-backups-edit-schedule"
		   class="button button-primary"><?php esc_html_e( 'Edit Backup Schedule', 'fw' ) ?></a>
		&nbsp;
		<?php if (fw_ext_backups_current_user_can_full()): ?>
		<a href="#" onclick="return false;" id="fw-ext-backups-full-backup-now"
		   class="button fw-ext-backups-backup-now" data-full="1"><?php esc_html_e('Create Full Backup Now', 'fw') ?></a>
		&nbsp;
		<?php endif; ?>
		<a href="#" onclick="return false;" id="fw-ext-backups-content-backup-now"
		   class="button fw-ext-backups-backup-now" data-full=""><?php esc_html_e('Create Content Backup Now', 'fw'); ?></a>
	</div>
-->
</div>

<br>
<h3><?php _e( 'Archives', 'fw' ) ?></h3>

	<div id="lte-backups-loader" style="display: none;"><img src="<?php echo esc_attr(get_admin_url() . 'images/loading.gif'); ?>"></div>

	<div>
		<p><a href="#" onclick="return false;" id="fw-ext-backups-content-backup-now"
		   class="button fw-ext-backups-backup-now" data-full=""><?php esc_html_e('Create Content Backup Now', 'fw'); ?></a></p>
	</div>

<div id="fw-ext-backups-archives"><?php echo $archives_html; ?></div>

<br>
<?php do_action('fw_ext_backups_page_footer'); ?>