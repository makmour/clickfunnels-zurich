<style>.hndle {display: none !important}</style>
<?php
	// Security: Capability check
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'sudowp-clickfunnels-zurich' ) );
	}

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		// --- SECURITY PATCH START: CSRF Protection (CVE-2022-47152) ---
		// Verify the nonce to ensure the request is genuine
		// UPDATED: Prefixed nonce for SudoWP standardization
		check_admin_referer( 'sudowp_cf_zurich_save_settings', 'sudowp_cf_zurich_nonce_field' );
		// --- SECURITY PATCH END ---

		if ( empty( $_POST['clickfunnels_api_email'] ) ) {
			echo '<div id="message" class="error notice is-dismissible" style="width: 733px;padding: 10px 12px;font-weight: bold"><i class="fa fa-times" style="margin-right: 5px;"></i> Please add an email address. <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
		}
		else if ( empty( $_POST['clickfunnels_api_auth'] ) ) {
			echo '<div id="message" class="updated notice is-dismissible" style="width: 733px;padding: 10px 12px;font-weight: bold"><i class="fa fa-times" style="margin-right: 5px;"></i> Please add Authorization Key. <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
		}
		else {
			echo '<div id="message" class="updated notice is-dismissible" style="width: 733px;padding: 10px 12px;font-weight: bold"><i class="fa fa-check" style="margin-right: 5px;"></i> Successfully updated ClickFunnels plugin settings. <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
			
			// Improved Sanitization
			update_option( 'clickfunnels_api_email', sanitize_email( trim( wp_unslash( $_POST['clickfunnels_api_email'] ) ) ) );
			update_option( 'clickfunnels_api_auth', sanitize_text_field( trim( wp_unslash( $_POST['clickfunnels_api_auth'] ) ) ) );
			update_option( 'clickfunnels_display_method', sanitize_text_field( wp_unslash( $_POST['clickfunnels_display_method'] ) ) );
			update_option( 'clickfunnels_favicon_method', sanitize_text_field( wp_unslash( $_POST['clickfunnels_favicon_method'] ) ) );
			// Keep htmlentities for snippet as it might contain code, but ensure we don't break existing logic
			update_option( 'clickfunnels_additional_snippet', htmlentities( stripslashes( wp_unslash( $_POST['clickfunnels_additional_snippet'] ) ) ) );
		}
	}
?>
<link href="<?php echo esc_url( plugins_url( '../css/admin.css', __FILE__ ) ); ?>" rel="stylesheet">
<link href="<?php echo esc_url( plugins_url( '../css/font-awesome.css', __FILE__ ) ); ?>" rel="stylesheet">
<script>
	jQuery(document).ready(function() {
		// Console Warning
		jQuery('.draft').hide();
		console.log("%cClickFunnels WordPress Plugin", "background: #0166AE; color: white;");
		console.log("%cEditing anything inside the console is for developers only. Do not paste in any code given to you by anyone. Use with caution. Visit for support: https://support.clickfunnels.com/", "color: #888;");
		// Tabs
		jQuery('.cftablink').click(function() {
      jQuery('.cftabs').hide();
      jQuery('.cftablink').removeClass('active');
      jQuery(this).addClass('active');
      var tab = jQuery(this).attr('data-tab');
      jQuery('#'+tab).show();
		});
		// Note: API credentials are exposed to admin users only for AJAX calls
		// This is a known limitation - ideally should use wp_ajax hooks
		var funnelURL = <?php echo wp_json_encode( CF_API_URL . 'funnels/list?email=' . urlencode( get_option( 'clickfunnels_api_email' ) ) . '&auth_token=' . urlencode( get_option( 'clickfunnels_api_auth' ) ) ); ?>;
		jQuery.getJSON(funnelURL, function(data) {
		  jQuery('.checkSuccess').html('<i class="fa fa-check successGreen"></i>');
		  jQuery('.checkSuccessDev').html('<i class="fa fa-check"> Connected</i>');
		  jQuery('#api_check').addClass('compatenabled');
	  }).fail(function(jqXHR) {
	  	jQuery('#api_check').removeClass('compatenabled');
	  	jQuery('#api_check').addClass('compatdisabled');
     	jQuery('.checkSuccess').html('<i class="fa fa-times errorRed"></i>');
     	jQuery('.checkSuccessDev').html('<i class="fa fa-times"> Not Connected</i>');
     	jQuery('.badAPI').show();
	  });
	});
</script>
<div id="message" class="badAPI error notice" style="display: none; width: 733px;padding: 10px 12px;font-weight: bold"><i class="fa fa-times" style="margin-right: 5px;"></i> Failed API Connection with ClickFunnels. Check <a href="edit.php?post_type=clickfunnels&page=cf_api&error=compatibility">Settings > Compatibility Check</a> for details.</div>
<div class="api postbox" style="width: 780px;margin-top: 20px;">
	<?php include('_header.php'); ?>
	<div class="apiSubHeader" style="padding: 18px 16px;">
		<h2 style="font-size: 1.5em"><i class="fa fa-cog" style="margin-right: 5px"></i> Plugin Settings</h2>
	</div>
	<form method="post" action="<?php echo esc_url( admin_url( 'edit.php?post_type=clickfunnels&page=cf_api' ) ); ?>">
		
		<?php wp_nonce_field( 'sudowp_cf_zurich_save_settings', 'sudowp_cf_zurich_nonce_field' ); ?>

		<div class="bootstrap-wp">
			<div id="app_sidebar">
				<a href="#" data-tab="tab1" class="cftablink <?php if ( ! isset( $_GET['error'] ) ) { echo 'active';} ?>">API Connection</a>
				<a href="#" data-tab="tab2" class="cftablink <?php if ( isset( $_GET['error'] ) ) { echo 'active';} ?>">Compatibility Check</a>
				<a href="#" data-tab="tab3" class="cftablink <?php if ( isset( $_GET['error'] ) ) { echo 'active';} ?>">General Settings</a>
				<a href="#" data-tab="tab5" class="cftablink <?php if ( isset( $_GET['error'] ) ) { echo 'active';} ?>">Reset Plugin Data</a>
			</div>
			<div id="app_main">
				<div id="tab3" class="cftabs" style="display: none;">
					<h2>General Settings</h2>
					<div class="control-group clearfix" >
						<label class="control-label" for="clickfunnels_display_method">Page Display Method:</span> </label>
						<div class="controls" style="padding-left: 24px;margin-bottom: 16px;">
							<select name="clickfunnels_display_method" id="clickfunnels_display_method" class="input-xlarge" style="height: 30px;">
								<option value="download" <?php if (get_option('clickfunnels_display_method') == 'iframe') { echo "selected";}?>>Download &amp; Display</option>
								<option value="iframe" <?php if (get_option('clickfunnels_display_method') == 'iframe') { echo "selected";}?>>Embed Full Page iFrame</option>
								<option value="redirect" <?php if (get_option('clickfunnels_display_method') == 'redirect') { echo "selected";}?>>Redirect to Clickfunnels</option>
							</select>
						</div>
					</div>
					<div class="control-group clearfix" >
						<label class="control-label" for="clickfunnels_favicon_method">Favicon:</span> </label>
						<div class="controls" style="padding-left: 24px;margin-bottom: 16px;">
							<select name="clickfunnels_favicon_method" id="clickfunnels_favicon_method" class="input-xlarge" style="height: 30px;">
								<option value="funnel" <?php if (get_option('clickfunnels_favicon_method') == 'funnel') { echo "selected";}?>>Use Funnel Favicon</option>
								<option value="wordpress" <?php if (get_option('clickfunnels_favicon_method') == 'wordpress') { echo "selected";}?>>Use Wordpress Favicon</option>
							</select>
						</div>
					</div>
					<div class="control-group clearfix">
						<label class="control-label" for="clickfunnels_additional_snippet">Additional Tracking Snippet:</label>
						<div class="controls" style="padding-left: 24px;margin-bottom: 16px;">
							<textarea class="input-xlarge" name="clickfunnels_additional_snippet"><?php echo esc_textarea( html_entity_decode( stripslashes( get_option( 'clickfunnels_additional_snippet' ) ) ) ); ?></textarea>
						</div>
						<p class="infoHelp"><i class="fa fa-question-circle" style="margin-right: 3px"></i>Additional tracking code to be put on full page iFrame embeds only</p>
					</div>
					<button class="action-button shadow animate green" id="publish" style="float: right;margin-top: 10px;"><i class="fa fa-check-circle"></i> Save Settings</button>
				</div>
				<div id="tab5" class="cftabs" style="display: none;">
					<h2>Reset Plugin Data</h2>
					<p class="infoHelp"><i class="fa fa-question-circle" style="margin-right: 3px"></i> Delete all your ClickFunnels pages inside your WordPress blog and remove your API details to clean up the database if you are starting fresh.</p>
					<a href="<?php echo esc_url( wp_nonce_url( 'edit.php?post_type=clickfunnels&page=reset_data', 'reset_clickfunnels_data' ) ); ?>" class="button" style="margin-left: 51px" onclick="return confirm('Are you sure?')">Delete All Pages and API Settings</a>
					<p class="infoHelp" style="font-style: italic;font-weight: bold;margin-right: 3px;"><i class="fa fa-exclamation-triangle" style="font-weight: bold;margin-right: 3px;color: #E54F3F;"></i> Use with caution.</p>
				</div>
				<div id="tab2" class="cftabs" style="display: none;">
					<h2>Compatibility Check</h2>
					<span class="compatCheck" id="api_check">API Authorization:  <strong class='checkSuccessDev'><i class="fa fa-spinner"></i> Connecting...</strong></span>
					<?php
						if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
						echo '<span class="compatCheck compatwarning">CloudFlare:  <strong><a target="_blank" href="https://support.clickfunnels.com/support/solutions/5000164139">If you have blank pages, turn off minify for JavaScript.</a></strong></span>';
						}
					?>
					<?php if ( get_option( 'permalink_structure' ) == '' ) {
							echo '<span class="compatCheck compatdisabled">Permalinks:  <strong>ClickFunnels needs <a href="options-permalink.php">custom permalinks</a> enabled!</strong></span>';
					}
					else {
						echo '<span class="compatCheck compatenabled">Permalinks:  <strong><i class="fa fa-check"> Enabled</i></strong></span>';
					} ?>
					<?php echo function_exists('curl_version') ? '<span class="compatCheck compatenabled">CURL:  <strong><i class="fa fa-check"> Enabled</i></strong></span>' : '<span class="compatCheck"><i class="fa fa-times">Disabled</i></strong></span>'  ?>
					<?php echo file_get_contents(__FILE__) ? '<span class="compatCheck compatenabled">File Get Contents:  <strong><i class="fa fa-check"> Enabled</i></strong></span>' : '<span class="compatCheck">File Get Contents:  <strong><i class="fa fa-times">Disabled</i></strong></span>' ; ?>
					<?php echo ini_get('allow_url_fopen') ? '<span class="compatCheck compatenabled">Allow URL fopen:  <strong><i class="fa fa-check"> Enabled</i></strong></span>' : '<span class="compatCheck">Allow URL fopen:  <strong><i class="fa fa-times">Disabled</i></strong></span>' ; ?>
					<?php
						if (version_compare(phpversion(), "5.3.0", ">=")) {
							echo '<span class="compatCheck compatenabled">PHP Version:  <strong>'.PHP_VERSION.'</strong></span>';
						} else {
							// you're not PHP enough
							echo '<span class="compatCheck compatdisabled">PHP Version:  <strong><a href="https://support.clickfunnels.com/support/home" target="_blank">This plugin requires PHP 5.3.0 or above.</a></strong></span>';
						}
					?>
				</div>
				<div id="tab1" class="cftabs">
					<h2>API Connection</h2>
					<div>
						<div class="control-group clearfix">
							<label class="control-label" for="clickfunnels_api_email">Account Email:<span class="checkSuccess"></span> </label>
							<div class="controls" style="padding-left: 24px;margin-bottom: 16px;">
								<input type="text" class="input-xlarge" style="height: 30px;" value="<?php echo esc_attr( get_option( 'clickfunnels_api_email' ) ); ?>" name="clickfunnels_api_email" />
							</div>
						</div>
						<div class="control-group clearfix">
							<label class="control-label" for="clickfunnels_api_auth">Authentication Token:<span class="checkSuccess"></span> </label>
							<div class="controls" style="padding-left: 24px;margin-bottom: 16px;">
								<input type="text" class="input-xlarge" style="height: 30px;" value="<?php echo esc_attr( get_option( 'clickfunnels_api_auth' ) ); ?>" name="clickfunnels_api_auth" />
							</div>
						</div>
						<p class="infoHelp"><i class="fa fa-question-circle" style="margin-right: 3px"></i> To access your Authentication Token go to your ClickFunnels Members area and choose <a href="https://app.clickfunnels.com/users/edit" target="_blank">My Account > Settings</a> and you will find your API information.</p>
					</div>
					<button class="action-button shadow animate green" id="publish" style="float: right;margin-top: 10px;"><i class="fa fa-check-circle"></i>Save Settings</button>
				</div>

				<br clear="both" />
			</div>
		</div>
	</form>
	<?php include('_footer.php'); ?>
</div>