<?php

class Query_Options {
    /**
     * A description of the entire PHP function.
     *
     */
    public function woo_query_activation() {
        $this->wp_query_options();
    }

    /**
     * Updates various options related to the WP Query.
     *
     * @throws Some_Exception_Class description of exception
     */
    private function wp_query_options() {
        update_option('wqf_admin_receiver_mail', get_bloginfo('admin_email'));
        update_option('wqf_email_notification_status', 0);
        update_option('wqf_myaccount_action_button_text', __('Ask Query', 'wooqueryform'));
        update_option('wqf_myaccount_action_button_bg', '#1058c9');
        update_option('wqf_myaccount_action_button_color', '#fff');
        update_option('wqf_query_modal_bg', '#fff');
        update_option('wqf_query_modal_heading', __('Query History', 'wooqueryform'));
        update_option('wqf_query_modal_heading_color', '#004866');
        update_option('wqf_query_modal_close_btn_color', '#333');
        update_option('wqf_left_side_message_box_bg', '#1058c9');
        update_option('wqf_left_side_message_box_color', '#fff');
        update_option('wqf_right_side_message_box_bg', '#ececec');
        update_option('wqf_right_side_message_box_color', '#000');
        update_option('wqf_send_button_text', __('Send', 'wooqueryform'));
        update_option('wqf_send_button_bg', '#1058c9');
        update_option('wqf_send_button_text_color', '#fff');
    }
}
