<?php
 /*
Plugin Name: Orders Query For WooCommerce
Description: This plugin enables a chat system for orders, facilitating communication between admin and users via chat and email. Admins access the chat in the order section, while users access it in their "My Account" section. Admins also receive notifications for new chat messages within orders.
Author: sanjan.k97 (Contact via Instagram)
Version: 1.0
Text Domain: wooqueryform
Domain Path: /languages
*/


class Order_Query_For_Woocommerce {

    /**
     * Constructor for initializing various objects and performing necessary actions.
     */
    public function __construct() {



        define('WOO_QUERY_DIR_PATH', plugin_dir_path(__FILE__));
        define('WOO_QUERY_PLUGIN_URL', plugin_dir_url(__FILE__));

        spl_autoload_register(array($this, 'autoload_classes'));
  
        $query_options = new Query_Options();
        $custom_woo_query_css = new Custom_Woo_Query_CSS();
        $message_html_generator = new Message_Html_Generator();
        $query_email = new Query_Email();
        $query_submission = new Woo_Query_Form_Submission($message_html_generator, $query_email);
        $order_actions = new Order_Actions($message_html_generator);
        $order_meta_box = new Order_Meta_Box($message_html_generator);
        $query_form_viewer = new Query_Form_Viewer($message_html_generator);

        register_activation_hook(__FILE__, array($query_options , 'woo_query_activation'));
        add_action('init', array($this, 'add_plugin_script'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_color_picker'));
        add_action('admin_menu', array($this, 'register_my_custom_menu_page'));


        // Check if WooCommerce is activated
        if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            add_action('admin_notices', array($this, 'wqf_admin_notice__error'));
        }
      
        
    }

      /**
     * Autoload classes when referenced but not yet loaded.
     *
     * @param string $class_name The name of the class to load.
     */
    public function autoload_classes($class_name) {
       
        $class_directory = WOO_QUERY_DIR_PATH . 'includes/';
        $file_extension = '.php';
        $file_path = $class_directory . 'class-' . strtolower(str_replace('_', '-', $class_name)) . $file_extension;
        if (file_exists($file_path)) {
            require_once $file_path;
        }
    }

    /**
     * Add plugin script.
     */
    public function add_plugin_script() {
        wp_enqueue_style('WOO_QUERY_CSS', WOO_QUERY_PLUGIN_URL . 'assets/css/style.css', '', time());
        wp_enqueue_style('WOO_QUERY_FONTAWESOME', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', '', time());
        wp_enqueue_script('WOO_QUERY_AJAX_JS', WOO_QUERY_PLUGIN_URL . 'assets/js/query-form-ajax.js', array('jquery'), time());
        wp_localize_script('WOO_QUERY_AJAX_JS', 'woo_query_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
    }

    /**
     * Enqueues the color picker styles and script.
     */
    public function enqueue_color_picker() {
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('woo-query-color-picker', WOO_QUERY_PLUGIN_URL . 'assets/js/color-picker.js', array('wp-color-picker'), false, true);
    }

    /**
     * Register a custom menu page.
     */
    public function register_my_custom_menu_page() {
        add_menu_page(
            __('Orders Query Settings', 'wooqueryform'),
            __('Orders Query For Woocommerce', 'wooqueryform'),
            'manage_options',
            'wooqueryform-menu',
            array($this, 'wooqueryform_settings'),
            WOO_QUERY_PLUGIN_URL . '/assets/images/query-icon.png',
            6
        );
    }

    /**
     * A function to handle wooqueryform settings.
     */
    public function wooqueryform_settings() {
        include_once(WOO_QUERY_DIR_PATH . 'includes/woo-query-settings/query-settings.php');
    }

    public function wqf_admin_notice__error() {
        echo "<div class='notice notice-error'><p>The <strong>Orders Query For Woocommerce plugin</strong> requires the <a href='https://wordpress.org/plugins/woocommerce/'>WooCommerce plugin</a> to be activated.</p></div>";
    }
}

$order_query_for_woocommerce = new Order_Query_For_Woocommerce();
