<?php
// If uninstall.php is not called by WordPress, exit
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit();
}

// Delete all options created by the plugin
delete_option('wqf_admin_receiver_mail');
delete_option('wqf_email_notification_status');
delete_option('wqf_myaccount_action_button_text');
delete_option('wqf_myaccount_action_button_bg');
delete_option('wqf_myaccount_action_button_color');
delete_option('wqf_query_modal_bg');
delete_option('wqf_query_modal_heading');
delete_option('wqf_query_modal_heading_color');
delete_option('wqf_query_modal_close_btn_color');
delete_option('wqf_left_side_message_box_bg');
delete_option('wqf_left_side_message_box_color');
delete_option('wqf_right_side_message_box_bg');
delete_option('wqf_right_side_message_box_color');
delete_option('wqf_send_button_text');
delete_option('wqf_send_button_bg');
delete_option('wqf_send_button_text_color');

$post_ids = get_posts(array(
    'post_type' => 'any',
    'meta_key' => 'wqf_query_message',
    'fields' => 'ids',
    'posts_per_page' => -1,
));

foreach ($post_ids as $post_id) {
    delete_post_meta($post_id, 'wqf_query_message');
}

wp_cache_flush();