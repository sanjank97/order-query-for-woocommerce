<?php

class SettingsController {
   
    /**
     * settings_controller function
     */
    public function settings_controller() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['wqf-query-setting'])) {
            $this->process_form_data();
        }
    }

    /**
     * Process form data and update options in the database.
     */
    private function process_form_data() {
        $wqf_admin_receiver_mail = sanitize_email($_POST["wqf_admin_receiver_mail"]);
        $wqf_email_notification_status = (isset($_POST["wqf_email_notification_status"]) && $_POST["wqf_email_notification_status"] == "1") ? 1 : 0;
        $wqf_myaccount_action_button_text = sanitize_text_field($_POST["wqf_myaccount_action_button_text"]);
        $wqf_myaccount_action_button_bg = sanitize_text_field($_POST["wqf_myaccount_action_button_bg"]);
        $wqf_myaccount_action_button_color = sanitize_text_field($_POST["wqf_myaccount_action_button_color"]);
        $wqf_query_modal_heading = sanitize_text_field($_POST["wqf_query_modal_heading"]);
        $wqf_query_modal_bg = sanitize_text_field($_POST["wqf_query_modal_bg"]);
        $wqf_query_modal_heading_color = sanitize_text_field($_POST["wqf_query_modal_heading_color"]);
        $wqf_query_modal_close_btn_color = sanitize_text_field($_POST["wqf_query_modal_close_btn_color"]);
        $wqf_left_side_message_box_bg = sanitize_text_field($_POST["wqf_left_side_message_box_bg"]);
        $wqf_left_side_message_box_color = sanitize_text_field($_POST["wqf_left_side_message_box_color"]);
        $wqf_right_side_message_box_bg = sanitize_text_field($_POST["wqf_right_side_message_box_bg"]);
        $wqf_right_side_message_box_color = sanitize_text_field($_POST["wqf_right_side_message_box_color"]);
        $wqf_send_button_text = sanitize_text_field($_POST["wqf_send_button_text"]);
        $wqf_send_button_bg = sanitize_text_field($_POST["wqf_send_button_bg"]);
        $wqf_send_button_color = sanitize_text_field($_POST["wqf_send_button_color"]);

        update_option('wqf_admin_receiver_mail', $wqf_admin_receiver_mail);
        update_option('wqf_email_notification_status', $wqf_email_notification_status);
        update_option('wqf_myaccount_action_button_text', $wqf_myaccount_action_button_text);
        update_option('wqf_myaccount_action_button_bg', $wqf_myaccount_action_button_bg);
        update_option('wqf_myaccount_action_button_color', $wqf_myaccount_action_button_color);
        update_option('wqf_query_modal_heading', $wqf_query_modal_heading);
        update_option('wqf_query_modal_bg', $wqf_query_modal_bg);
        update_option('wqf_query_modal_heading_color', $wqf_query_modal_heading_color);
        update_option('wqf_query_modal_close_btn_color', $wqf_query_modal_close_btn_color);
        update_option('wqf_left_side_message_box_bg', $wqf_left_side_message_box_bg);
        update_option('wqf_left_side_message_box_color', $wqf_left_side_message_box_color);
        update_option('wqf_right_side_message_box_bg', $wqf_right_side_message_box_bg);
        update_option('wqf_right_side_message_box_color', $wqf_right_side_message_box_color);
        update_option('wqf_send_button_text', $wqf_send_button_text);
        update_option('wqf_send_button_bg', $wqf_send_button_bg);
        update_option('wqf_send_button_text', $wqf_send_button_text);
    }
}

