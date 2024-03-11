<?php 

class Woo_Query_Form_Submission {
      
    private $query_email;
    private $message_html_generator;

    /**
     * Constructor for initializing the message HTML generator and query email.
     *
     * @param datatype $message_html_generator description
     * @param datatype $query_email description
     */
    public function __construct($message_html_generator, $query_email) {

        $this->query_email = $query_email;
        $this->message_html_generator = $message_html_generator;

        add_action('wp_ajax_submit_woo_query_form', array($this, 'submit_woo_query_form'));
        add_action('wp_ajax_nopriv_submit_woo_query_form', array($this, 'submit_woo_query_form'));
        
    }

    /**
     * A function to submit a query form to the database.
     *
     * @param none
     * @throws none
     * @return none
     */
    public function submit_woo_query_form() {

        $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
        $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
        $query_message = isset($_POST['query_message']) ? sanitize_text_field($_POST['query_message']) : '';
    
        $side = (isset($_POST['side']) &&  $_POST['side']=="admin") ? 'admin' : ''; 
    
        if (!$post_id || !$user_id || empty($query_message)) {
            wp_send_json_error('Invalid data');
        }
    
        $messages = get_post_meta($post_id, 'wqf_query_message', true);
        $new_message = array(
            'id' => uniqid() . '-' . $user_id,
            'content' => $query_message,
            'sender' => $user_id,
            'datetime' => current_time('mysql'),
            'post_id'=>  $post_id,
            'side' => $side ,
            'status' => 'Delivered'
        );
    
        if (!is_array($messages)) {
            $messages = array();
        }
        $messages[] = $new_message;
        update_post_meta($post_id, 'wqf_query_message', $messages);

        $this->update_query_status($side,  $post_id);
      
       $messages = get_post_meta($post_id, 'wqf_query_message', true);

       $html = $this->message_html_generator->generateMessageHtml($side, $messages);

       $email_notification_status = get_option('wqf_email_notification_status');

       if($email_notification_status) {
          $this->query_email->send_query_form_mail($side, $post_id, $user_id);         
       }
       wp_send_json($html);
       wp_die();
    }

    private function update_query_status($side, $post_id) {
        $messages = get_post_meta($post_id, 'wqf_query_message', true);
        if ($messages && $side === 'admin') {
            foreach ($messages as &$message) {
                if ($message['side'] === '') {
                    $message['status'] = 'Read';
                }
            }
        update_post_meta($post_id, 'wqf_query_message', $messages);
        }
        
        if($messages && $side === ''){
            foreach ($messages as &$message) {
                if ($message['side'] === 'admin') {
                    $message['status'] = 'Read';
                }
            }
        update_post_meta($post_id, 'wqf_query_message', $messages);
        }

    }
}
