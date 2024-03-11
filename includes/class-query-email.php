<?php 

class Query_Email {

    /**
     * send_query_form_mail function sends a query form mail.
     *
     * @param datatype $side description
     * @param datatype $post_id description
     * @param datatype $user_id description
     */
    public function send_query_form_mail($side, $post_id, $user_id) {

        $order_id = $post_id ;
        $messages = get_post_meta($order_id, 'wqf_query_message', true);
        if($messages && count($messages) > 5) {
            $messages = array_slice($messages, -5);
        }
        $this->send_mail_template($side, $order_id, $messages );
    }

    /**
     * Sends a mail template based on the provided parameters.
     *
     * @param string $side The side of the message (e.g. 'admin' or 'customer')
     * @param int $order_id The ID of the order
     * @param array $messages An array of messages to be included in the mail template
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    private function send_mail_template($side, $order_id, $messages) {
        
    
            $site_title = get_bloginfo('name');
            $site_email = get_option('wqf_admin_receiver_mail');
            $site_url = get_bloginfo('url');
    
            $order = wc_get_order( $order_id );
            $customer = $order->get_user();
            $customer_name = ($customer->display_name) ? $customer->display_name : $customer->user_login;
            $customer_email = $customer->user_email;
            
            // Determine message alignment based on side
            $right_msg = ($side != "") ? "left-msg" : "right-msg";
            $left_msg = ($side != "") ? "right-msg" : "left-msg";

            $query_modal_heading = get_option('wqf_query_modal_heading');
    
            // Initialize email HTML
            $smsHtml = '<html>
            <head>
                <title>'.$site_title.'</title>
            </head>
            <style>
                @media (max-width: 480px) {
                    .wqf-query-form-container .msg-body {
                        width: 265px;
                    }
                }
            </style>
            <body style="font-family: "Open Sans", sans-serif;background-color: #ffffff;">';
    
            $smsHtml .= '<div class="wqf-query-form-container" style="padding: 4px; max-height: 375px; overflow-y: scroll; max-width:600px;">';
            $smsHtml .= '<h3>'. $query_modal_heading .'</h3>';
    
            // Loop through messages
            $messages = array_reverse($messages);
            foreach ($messages as $message) {
                $user = get_userdata($message['sender']);
                $user_role = $user->roles[0];
                $datetime = $message['datetime'];
                $formatted_date = date('d/m h:i A', strtotime($datetime));
    
                // Determine message alignment based on user role
                $msg_alignment = ($user_role == "administrator" || $user_role == "shop_manager") ? $right_msg : $left_msg;

            
                // Generate HTML for each message
                $responser = ($user->display_name) ? $user->display_name : $user->user_login;
                $msg_background = ($user_role == "administrator" || $user_role == "shop_manager") ? "#579ffb" : "#ececec";
                $msg_color = ($user_role == "administrator" || $user_role == "shop_manager") ? "#fff" : "#000";
                
                if($msg_alignment =="left-msg"){
                    $smsHtml .= '<div  style="justify-content: flex-end; align-self:end;">';
                }else{
                    $smsHtml .= '<div  style="display:flex;">';
                }
             
                $smsHtml .= '<div class="msg-body" style="width: 300px; padding: 12px; border-radius: 15px; background: '.$msg_background.'; border-bottom-left-radius: 0; margin-bottom: 12px; color: '.$msg_color.';">';
                $smsHtml .= '<div class="msg-info" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">';
                $smsHtml .= '<div class="msg-info-name" style="font-size: 14px; font-weight: 700; line-height: 20px; text-transform: uppercase;">'.$responser.'</div>';
                $smsHtml .= '<div class="msg-info-time" style="font-size: 13px; font-weight: 400; line-height: 20px; text-transform: lowercase; margin-left: 10px;">'.$formatted_date.'</div>';
                $smsHtml .= '</div>';
                $smsHtml .= '<div class="msg-text" style="font-size: 14px; font-weight: 400; line-height: 20px;">'.$message['content'].'</div>';
                $smsHtml .= '</div>';
                $smsHtml .= '</div>';
            }
            $smsHtml .= '</div>';
    
            if($side == 'admin') {
                $link = site_url().'/my-account/view-order/'.$order_id;
                $smsHtml .= '<p>Please visit the provided <a href="'.$link.'">link</a> and review the previous inquiry and response. If you have any questions or concerns regarding this order, feel free to ask.</p>';
            } else {
                $link = site_url().'/wp-admin/post.php?post='.$order_id.'&action=edit';
                $smsHtml .= '<p>Please visit the <a href="'.$link.'">Admin Dashboard</a> WooCommerce order query form section and review the previous inquiry and response for the customer order.</p>';
            }

            $smsHtml .= '</body></html>';
    
            $headers = array(
                'Content-Type: text/html; charset=UTF-8'
            ); 
    
            if($side == 'admin') {
                $to = $customer_email;
                $subject = $site_title . 'Query About Order Id #'.$order_id;
            } else {
                $to = $site_email;
                $subject =  $site_title . 'Query About Order Id #'.$order_id;
            }
            return wp_mail($to, $subject, $smsHtml, $headers);
    }
}
