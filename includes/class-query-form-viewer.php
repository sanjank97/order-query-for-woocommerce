<?php

class Query_Form_Viewer {

    private $message_html_generator;
    /**
     * Constructor for the PHP class.
     *
     * @param datatype $message_html_generator description
     */
    public function __construct( $message_html_generator) {
       $this->message_html_generator = $message_html_generator;
        add_action('wp_ajax_view_queryform', array($this, 'view_queryform'));
        add_action('wp_ajax_nopriv_view_queryform', array($this, 'view_queryform'));
    }

    /**
     * View query form function
     *
     * @param null
     * @throws null
     * @return null
     */
    public function view_queryform() {
        $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
        $side = (isset($_POST['side']) && $_POST['side'] == "admin") ? 'admin' : '';

        if (!$post_id) {
            wp_send_json_error('Invalid data');
        }
        $this->update_query_status($side, $post_id);
        $messages = get_post_meta($post_id, 'wqf_query_message', true);
        $html = $this->message_html_generator->generateMessageHtml($side, $messages);
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
