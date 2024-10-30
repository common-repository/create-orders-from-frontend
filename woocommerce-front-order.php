<?php


/*

 Plugin Name:       Create Orders from Frontend for WooCommerce
 Plugin URI:        http://ramagirimahesh.xyz/plugins/create-orders-from-frontend/
 Description:       Aministrator can place orders for any user from frontend
 Version:           1.0.0
 Requires at least: 5.4
 Requires PHP:      7.2
 Author:            Mahesh Ramagiri
 Author URI:        http://ramagirimahesh.xyz/
 Text Domain:       create-orders-from-frontend
 
*/

class woocommercefrontendorders {
    
    function __construct() {
        
        add_action( 'admin_menu', array($this, 'add_new_menu') );
        add_action('wp_enqueue_scripts', array($this, 'add_script_style') );
        add_shortcode( 'woocommerce_create_order_form', array($this, 'create_order_form') );
        add_shortcode( 'woocommerce_order_details', array($this, 'woocommerce_order_details') );
        add_action('admin_post_create_form', array($this, 'create_form') );
        add_action('admin_post_nopriv_create_form', array($this, 'create_form') );
 
    }
    
    
    // Plugin Menu 
    
     function add_new_menu() {
            add_menu_page(
              'WC Orders',
              'WC Orders',
              'manage_options',
              'wc_orders',
               array($this, 'wc_orders'),
              'dashicons-format-aside',
              20
          );
       }
       
       function wc_orders() {
         echo "<h3>All Order List will be listed on next version</h3>";
       }
    
    
    // Add Script & Style
    
     
     function add_script_style() {
        wp_enqueue_style( 'woocommerce-front-order-add-style', plugin_dir_url( __FILE__ ) . 'css/style.css', array(), '1.1', 'all');
     }
     
    
    // Woocommerce Short code

     function create_order_form() {

        require_once('inc/create-order-form.php');
        return $order_form;

     } 
     
    
    
     function woocommerce_order_details() {

        require_once('inc/order-details.php');
        return $order_details;

     }
     
     
     function create_form() {

$user_id = sanitize_text_field($_POST['user']);
$args = array(
    'status'        => 'pending payment',
    'customer_id'   => $user_id,
    'customer_note' => 'The Order has been Place by Administrator',
);

$address = array(
   'first_name' => sanitize_text_field($_POST['firstname']),
   'last_name'  => sanitize_text_field($_POST['lastname']),
   'company'    => sanitize_text_field($_POST['company']),
   'email'      => sanitize_email($_POST['email']),
   'phone'      => sanitize_text_field($_POST['phone']),
   'address_1'  => sanitize_text_field($_POST['address_1']),
   'address_2'  => sanitize_text_field($_POST['address_2']),
   'city'       => sanitize_text_field($_POST['city']),
   'state'      => sanitize_text_field($_POST['state']),
   'postcode'   => sanitize_text_field($_POST['postcode']),
   'country'    => sanitize_text_field($_POST['country'])
	);


$order = wc_create_order($args); 

$products = sanitize_text_field($_POST['products']);

if(is_array($products)) {
    foreach($products as $product) {
        $productid = $product;
        $order->add_product(get_product($productid), 1);
    }
}

$order->set_address($address, 'shipping');
$order->set_address($address, 'billing');
$order->calculate_totals();

wp_safe_redirect(site_url('/thank-you/'));


}

     

    
}

$woocommercefrontendorders = new woocommercefrontendorders();




?>