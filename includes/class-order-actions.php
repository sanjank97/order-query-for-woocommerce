<?php

class Order_Actions {
    
    private $message_html_generator;
    /**
     * Constructor for the class.
     *
     * @param $message_html_generator
     */
    public function __construct($message_html_generator) {
        $this->message_html_generator = $message_html_generator;
        add_filter('woocommerce_my_account_my_orders_actions', array($this, 'query_form_button'), 9999, 2);
        add_action('woocommerce_order_details_before_order_table', array($this, 'query_button_woocommerce_order_details_before_table_action'));
    }

    /**
     * A function to handle the query form button.
     *
     * @param datatype $actions description of the actions parameter
     * @param datatype $order description of the order parameter
     * @return datatype
     */
    public function query_form_button($actions, $order) {

        if( is_user_logged_in() ) {

            $myaccount_action_button_text = get_option('wqf_myaccount_action_button_text');
 
            $query_modal_heading = get_option('wqf_query_modal_heading');
     
            $send_button_text = get_option('wqf_send_button_text');  
    
            $order_id = method_exists($order, 'get_id') ? $order->get_id() : $order->ID;

             $actions['wqf-order-query-form'] = array(
                 'url' =>'#'.$order_id ,
                 'name' => $myaccount_action_button_text,
             );
     
             echo '<div id="wqf-resond_popup'.  $order_id .'" class="wqf-query-overlay">
                     <div class="wqf-respond_popup">
                         <h2>' . $query_modal_heading . '</h2>
                         <a class="wqf-close"  href="#'.  $order_id .'">&times;</a>';
        
                         $messages = get_post_meta( $order_id , 'wqf_query_message', true);
                         echo '<div class="wqf-query-form-container">';
                         echo $this->message_html_generator->generateMessageHtml("", $messages); 
                         echo "</div>";
     
                          echo '<div class="wqf-respond_content">
                             <form id="wqf-query_form'.  $order_id .'" class="wqf-customer_query_form">
                                 <input type="text" class="wqf-query_message" name="query_message" placeholder="' . esc_attr__('Message', 'wooqueryform') . '" />
                                 <input type="hidden" name="post_id" class="wqf-query_post_id" value="' .  $order_id  . '" />
                                 <input name="user_id" type="hidden" class="wqf-query_user_id" value="' .get_current_user_id(). '" />
                                 <button  type="button" name="submit_query" class="wqf-customer_query_form_button" id="wqf-query_form_button'.  $order_id .'">
                                 '. $send_button_text . '<i class="fa fa-spinner fa-spin"></i>
                                </button>
                             </form>
                         </div>
                     </div>
                 </div>';
        }
      
 
     
     return $actions;
    }

    /**
     * A function to handle the action before displaying the WooCommerce order details table.
     *
     * @param datatype $order The WooCommerce order object
     */
    public function query_button_woocommerce_order_details_before_table_action($order) {
       if( is_user_logged_in() ) {
            $myaccount_action_button_text = get_option('wqf_myaccount_action_button_text');
            $query_modal_heading = get_option('wqf_query_modal_heading');
            $send_button_text = get_option('wqf_send_button_text');
            $order_id = method_exists($order, 'get_id') ? $order->get_id() : $order->ID;
        
            echo "<a  href='#".  $order_id ."' class ='wqf-order-query-form'>". $myaccount_action_button_text ."</a>";
        
        
            echo '<div id="wqf-resond_popup'.  $order_id .'" class="wqf-query-overlay">
            <div class="wqf-respond_popup">
                <h2>' .$query_modal_heading. '</h2>
                <a class="wqf-close"  href="#'.  $order_id .'">&times;</a>';
        
                $messages = get_post_meta(  $order_id , 'wqf_query_message', true);
            
                echo '<div class="wqf-query-form-container">';
                echo $this->message_html_generator->generateMessageHtml("", $messages); 
                
                echo "</div>";
                echo '<div class="wqf-respond_content">
                    <form id="wqf-query_form'.  $order_id .'" class="wqf-customer_query_form">
                        <input type="text" class="wqf-query_message" name="query_message" placeholder="' . esc_attr__('Message', 'wooqueryform') . '" />
                        <input type="hidden" name="post_id" class="wqf-query_post_id" value="' .  $order_id  . '" />
                        <input name="user_id" type="hidden" class="wqf-query_user_id" value="' .get_current_user_id(). '" />
                        <button  type="button" name="submit_query" class="wqf-customer_query_form_button" id="wqf-query_form_button'.  $order_id .'">
                        '. $send_button_text . '<i class="fa fa-spinner fa-spin"></i>
                    </button>
                    </form>
                </div>
            </div>
        </div>';
       }
    }
}


