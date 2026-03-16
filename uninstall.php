<?php
defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

delete_option('clickfunnels_api_email');
delete_option('clickfunnels_api_auth');
delete_option('clickfunnels_display_method');
delete_option('clickfunnels_favicon_method');
delete_option('clickfunnels_additional_snippet');
delete_option('clickfunnels_homepage_post_id');
delete_option('clickfunnels_404_post_id');
delete_option('clickfunnels_posts_schema_version');
?>
