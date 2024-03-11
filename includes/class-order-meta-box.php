<?php
class Order_Meta_Box {
    private $message_html_generator;
    public $wc_version;

    /**
     * Constructor for the class.
     *
     * @param $message_html_generator
     */
    public function __construct($message_html_generator) {
        $this->message_html_generator = $message_html_generator;
        $this->wc_version = get_option('woocommerce_version');

        add_action('add_meta_boxes', array($this, 'add_custom_meta_box_for_orders_page'));

        add_filter('manage_woocommerce_page_wc-orders_columns', array($this, 'wqf_add_order_new_column_header'), 20);
        add_action('manage_woocommerce_page_wc-orders_custom_column', array($this, 'wqf_add_wc_order_admin_list_column_content'), 10, 2);
        add_filter('manage_edit-shop_order_columns', array($this, 'wqf_add_order_new_column_header'), 20);
        add_action('manage_shop_order_custom_column', array($this, 'wqf_add_wc_order_admin_list_column_content'), 10, 2);

    }

    /**
     * Adds a custom meta box for the WooCommerce orders page.
     */
    public function add_custom_meta_box_for_orders_page() {
        $screen = array('woocommerce_page_wc-orders', 'shop_order');

        add_meta_box(
            'order_query_form_for_woocommerce',
            __('Orders Query Form For WooCommerce', 'wooqueryform'),
            array($this, 'render_custom_order_meta_box_content'),
            $screen,
            'normal',
            'default'
        );
    }

    /**
     * Renders the custom order meta box content.
     *
     * @param object $order The order object.
     */
    public function render_custom_order_meta_box_content($order) {
   
        $order_id = method_exists($order, 'get_id') ? $order->get_id() : $order->ID;

        $send_button_text = get_option('wqf_send_button_text');
        $messages = get_post_meta($order_id, 'wqf_query_message', true);

        $order = wc_get_order($order_id);
        $customer_id = $order->get_customer_id();


        if ($customer_id == 0) {
            echo '<p class="notice notice-error" style="padding:10px;"><strong>Important:- unchecked the Guest Checkout options and the Checked Account Creation options in <a href="?page=wc-settings&tab=account"> WooCommerce Accounts and Privacy</a> settings.</strong></p>';
        }
        ?>
        <div class="wqf-query-form-container">
            <?php echo $this->message_html_generator->generateMessageHtml("admin", $messages); ?>
        </div>

        <div id="wqf-admin_query_form">
            <textarea id="wqf-query_message" name="query_message" placeholder="<?php echo esc_attr__('Message', 'wooqueryform'); ?>" rows="4" style="width:100%" cols="50"></textarea><br>
            <input type="hidden" name="post_id" id="wqf-query_post_id" value="<?php echo $order_id; ?>" />
            <input name="user_id" type="hidden" id="wqf-query_user_id" value="<?php echo get_current_user_id(); ?>" />
            <button type="button" name="submit_query" id="wqf-query_form_button_id">
                <?php echo $send_button_text; ?><i class="fa fa-spinner fa-spin"></i>
            </button>
            <span class="wqf-refresh-query" data-id="<?php echo $order_id; ?>"><i class="fa fa-refresh wqf-refresh-without-loader" aria-hidden="true"></i> <i class="fa fa-refresh fa-spin wqf-refresh-with-loader"></i></span>
        </div>
        <?php
    }

    /**
     * Adds content to the custom column on the WooCommerce orders page.
     *
     * @param string $column The column ID.
     * @param int $order The order ID.
     */
    public function wqf_add_wc_order_admin_list_column_content($column, $order) {
   
      
        if(is_object($order)) {
            $order_id = (method_exists($order, 'get_id'))? $order->get_id() : $order->ID;
        }else{
        $order_id = $order;
        }

        if ($column === 'wqf_query_message_column') {
            $messages = get_post_meta($order_id, 'wqf_query_message', true);

            if ($messages) {
                $count = 0;
                foreach ($messages as &$message) {
                    if ($message['side'] === '' && $message['status'] === "Delivered") {
                        $count++;
                    }
                }
                echo "<span style='background:red; color:#fff; padding:5px; border-radius:2px'>";
                echo ($count == 0 || $count == 1) ? $count . ' unread query' : $count . ' unread queries';
                echo "</span>";
            } else {
                echo "Not Query";
            }
        }
    }

    public function wqf_add_order_new_column_header($columns) {
        $columns['wqf_query_message_column'] = __('Query', 'wooqueryform');
        return $columns;
     }


}