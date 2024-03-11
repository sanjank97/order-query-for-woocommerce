<?php

class Custom_Woo_Query_CSS {
    /**
     * Constructor for the class.
     */
    public function __construct() {
        add_action('wp_head', array($this, 'add_custom_woo_query_css'));
    }

    public function add_custom_woo_query_css() {
        ?>
        <style type="text/css">
            a.wqf-order-query-form {
                background-color: <?php echo get_option('wqf_myaccount_action_button_bg'); ?> !important;
                color: <?php echo get_option('wqf_myaccount_action_button_color'); ?> !important;
            }
            .wqf-respond_popup {
                background-color: <?php echo get_option('wqf_query_modal_bg'); ?> !important;
            }
            .wqf-respond_popup h2 {
                color: <?php echo get_option('wqf_query_modal_heading_color'); ?> !important;
            }
            .wqf-query-form-container .left-msg .msg-body {
                background-color: <?php echo get_option('wqf_left_side_message_box_bg'); ?> !important;
                color: <?php echo get_option('wqf_left_side_message_box_color'); ?> !important;
            }
            .wqf-query-form-container .right-msg .msg-body {
                background-color: <?php echo get_option('wqf_right_side_message_box_bg'); ?> !important;
                color: <?php echo get_option('wqf_right_side_message_box_color'); ?> !important;
            }
            .wqf-respond_content .customer_query_form .customer_query_form_button {
                background-color: <?php echo get_option('wqf_send_button_bg'); ?> !important;
                color: <?php echo get_option('wqf_send_button_text_color'); ?> !important;
            }
            .wqf-respond_popup .wqf-close {
                color: <?php echo get_option('wqf_query_modal_close_btn_color'); ?> !important;
            }
        </style>
        <?php
    }
}


