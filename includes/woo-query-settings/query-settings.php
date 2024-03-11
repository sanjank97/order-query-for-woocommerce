<?php

    include(WOO_QUERY_DIR_PATH. 'includes/woo-query-settings/settings-controller.php');

    // Instantiate the class
     $settings_controller = new SettingsController();
     $settings_controller->settings_controller();
        

     $wqf_admin_receiver_mail            = get_option('wqf_admin_receiver_mail');
     $wqf_email_notification_status      = get_option('wqf_email_notification_status');
 
     $wqf_myaccount_action_button_text   = get_option('wqf_myaccount_action_button_text');
     $wqf_myaccount_action_button_bg     = get_option('wqf_myaccount_action_button_bg');
     $wqf_myaccount_action_button_color  = get_option('wqf_myaccount_action_button_color');
 
     $wqf_query_modal_heading            = get_option('wqf_query_modal_heading');
     $wqf_query_modal_bg                 = get_option('wqf_query_modal_bg','#fff');
     $wqf_query_modal_heading_color      = get_option('wqf_query_modal_heading_color');
     $wqf_query_modal_close_btn_color    = get_option('wqf_query_modal_close_btn_color');
 
     $wqf_left_side_message_box_bg       = get_option('wqf_left_side_message_box_bg');
     $wqf_left_side_message_box_color    = get_option('wqf_left_side_message_box_color');
     $wqf_right_side_message_box_bg      = get_option('wqf_right_side_message_box_bg');
     $wqf_right_side_message_box_color   = get_option('wqf_right_side_message_box_color');
 
     $wqf_send_button_text               = get_option('wqf_send_button_text');
     $wqf_send_button_bg                 = get_option('wqf_send_button_bg');
     $wqf_send_button_color              = get_option('wqf_send_button_color');
  
?>
<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

    <p class="notice" style="padding:10px;"><strong>Important:- unchecked the Guest Checkout options and Checked the Account Creation options in <a href="?page=wc-settings&tab=account"> Woocommerce Accounts and Privacy </a> settings.</strong></p>

    <form method="post" action="">
        <input type="hidden" name="wqf-query-setting" />
        <div class="wqf-mail">
            <h3>For Email</h3>
            <label><strong>Admin Receiver Email :</strong></label>
            <input type="email" name="wqf_admin_receiver_mail" value="<?php echo esc_attr($wqf_admin_receiver_mail); ?>" /><br /><br />

            <label><strong>Email Notification Status :</strong></label>
            <select name="wqf_email_notification_status">
                <option value="1" <?php echo ($wqf_email_notification_status) ? 'selected' : ''; ?>>Activate</option>
                <option value="0" <?php echo ($wqf_email_notification_status) ? '' : 'selected'; ?>>Deactivate</option>
            </select>
        </div>

        <div class="wqf-myaccount">
            <h3>Woocommerce MyAccount </h3>
            <label><strong>Action Button Text :</strong></label>
            <input type="text" name="wqf_myaccount_action_button_text" value="<?php echo esc_attr($wqf_myaccount_action_button_text); ?>" /><br /><br />

            <label><strong>Action Button Background color :</strong></label>
            <input type="text" class="wqf-color-picker" name="wqf_myaccount_action_button_bg" value="<?php echo esc_attr($wqf_myaccount_action_button_bg); ?>" /><br /><br />

            <label><strong> Action Button color :</strong></label>
            <input type="text" class="wqf-color-picker" name="wqf_myaccount_action_button_color" value="<?php echo esc_attr($wqf_myaccount_action_button_color); ?>" />
        </div>
      
        <div class="wqf-modal">
            <h3>Query Modal</h3>
            <label><strong> Heading :</strong></label>
            <input type="text" name="wqf_query_modal_heading" value="<?php echo esc_attr($wqf_query_modal_heading); ?>" /><br /><br />

            <label><strong>Heading color:</strong></label>
            <input type="text" class="wqf-color-picker" name="wqf_query_modal_heading_color" value="<?php echo esc_attr($wqf_query_modal_heading_color); ?>" /><br /><br />

            <label><strong>Background color:</strong></label>
            <input type="text" class="wqf-color-picker" name="wqf_query_modal_bg" value="<?php echo esc_attr( $wqf_query_modal_bg); ?>" /><br /><br />

            <label><strong>Close Button color:</strong></label>
            <input type="text" class="wqf-color-picker" name="wqf_query_modal_close_btn_color" value="<?php echo esc_attr( $wqf_query_modal_close_btn_color); ?>" />
        </div>
        
        <div class="wqf-msg" >
            <h3>Message History Box</h3>
            <label><strong>Left Side Background :</strong></label>
            <input type="text" class="wqf-color-picker" name="wqf_left_side_message_box_bg" value="<?php echo esc_attr( $wqf_left_side_message_box_bg); ?>" /><br /><br />

            <label><strong>Left Side Color :</strong></label>
            <input type="text" class="wqf-color-picker" name="wqf_left_side_message_box_color" value="<?php echo esc_attr( $wqf_left_side_message_box_color); ?>" /><br /><br />

            <label><strong>Right Side Background :</strong></label>
            <input type="text" class="wqf-color-picker" name="wqf_right_side_message_box_bg" value="<?php echo esc_attr( $wqf_right_side_message_box_bg); ?>" /><br /><br />

            <label><strong>Right Side  Color :</strong></label>
            <input type="text" class="wqf-color-picker" name="wqf_right_side_message_box_color" value="<?php echo esc_attr( $wqf_right_side_message_box_color); ?>" />
        </div>

        
        <div class="wqf-sendbtn">
            <h3>Send Query Button</h3>
            <label><strong> Text :</strong></label>
            <input type="text" name="wqf_send_button_text" value="<?php echo esc_attr($wqf_send_button_text); ?>" /><br /><br />

            <label><strong> Background Color :</strong></label>
            <input type="text" class="wqf-color-picker" name="wqf_send_button_bg" value="<?php echo esc_attr( $wqf_send_button_bg); ?>" /><br /><br />

            <label><strong> Color :</strong></label>
            <input type="text" class="wqf-color-picker" name="wqf_send_button_color" value="<?php echo esc_attr( $wqf_send_button_color); ?>" />
         </div>
   
         <div class="wqf-savebtn">
            <?php submit_button('Save Changes'); ?>
         </div>
    </form>
</div>
