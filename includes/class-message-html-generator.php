<?php

class Message_Html_Generator {

    /**
     * Generate HTML for displaying messages.
     *
     * @param datatype $side description
     * @param datatype $messages description
     * @return Some_Return_Value
     */
    public function generateMessageHtml($side, $messages) {
        $right_msg = ($side != "") ? "left-msg" : "right-msg";
        $left_msg = ($side != "") ? "right-msg" : "left-msg";
      
        $smsHtml = '';

        if ($messages) {
            foreach ($messages as $message) {
                $user = get_userdata($message['sender']);
                $user_role = $user->roles[0];
                $datetime = $message['datetime'];
                $formatted_date = date('d/m h:i A', strtotime($datetime));
                

                $responser = ($user->display_name) ? $user->display_name : $user->user_login;

                // Determine message alignment based on user role
                if ($user_role == "administrator" || $user_role == "shop_manager") {
                    $msg_alignment = $right_msg;

                } else {
                    $msg_alignment = $left_msg;
                
                }
          
               // Determine status based on alignment
               $status = ($msg_alignment == "left-msg") ? $message['status'].'<i class="fa fa-check" aria-hidden="true"></i>' : "";
    
                // Generate HTML for each message
                $smsHtml .= '<div class="' . $msg_alignment . '">
                                <div class="msg-body">
                                    <div class="msg-info">
                                        <div class="msg-info-name">' . $responser . '</div>
                                        <div class="msg-info-time">' . $formatted_date . '</div>
                                    </div>
                                    <div class="msg-text">
                                        ' . $message['content'] . '
                                    </div>
                                    <div class="msg-status">'. $status . '</div>
                                </div>
                            </div>';
            }
        }

        return $smsHtml;
    }
}
