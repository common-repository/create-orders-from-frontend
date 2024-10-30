<?php


if (is_user_logged_in()) {



$order_form = "<form action='" .  esc_url( admin_url('admin-post.php')) . "' method='POST'>";


// Get Users

$order_form .= "<div class='form-section'><h5>Select User</h5>
<select name='user'>";

global $wpdb;
 $tablename = $wpdb->prefix . "users";
 $results = $wpdb->get_results("SELECT * FROM $tablename", "OBJECT");
 
 foreach ($results as $item)  {
     $password = $item->user_pass;
     
     $order_form .= "<option value='" . $item->ID . "'>" . $item->user_login . "</option>";
     
 }

 $order_form .= "</select></div>";
 
 
 
 // Get Products  
 
 
 
 $order_form .= "<div class='form-section'><h5>Select Products</h5>
 <div class='product-selection'>
 ";


 $all_ids = get_posts( array(
        'post_type' => 'product',
        'numberposts' => -1,
        'post_status' => 'publish',
        'fields' => 'ids',
   ) );
   
   $i = 1;
   
   foreach ( $all_ids as $id ) {
        $productid = $id;
        $product_image = get_the_post_thumbnail_url($productid);
        
        if( empty($product_image)){
            $product_image = plugin_dir_url( __FILE__ ) . "../images/woocommerce-placeholder.png";
        }
        
        $product = wc_get_product( $productid );
        $order_form .= "<div class='product-item'>
        <img src='" . $product_image . "'>
        <span class='wcfront_product_id'>" . $productid . "</span>";
        $order_form .= "<div class='form-check'><input type='checkbox' name='products[]' value='" . $productid . "' class='form-check-input' id='flexCheckDefault" . $i . "'><label class='form-check-label' for='flexCheckDefault" . $i . "'>" . $product->get_name() . "</label>
        </div></div>";
        
        $i++;
        
   }
   
   $order_form .= "</div></div>";
 
 
 // Enter Billing and Shipping Address
 
 
$order_form .= "<h4 class='mb-3'>Enter Billing Address</h4><div class='form-input'>";

$order_form .= "<div class='form-billing-section mb-3'><div class='address-details'>"; 
$order_form .= "<h5 class='mt-3 mb-3'>Add Address</h5>";
$order_form .= "<input type='text' placeholder='address1' name='address1'><br>";
$order_form .= "<input type='text' placeholder='address2' name='address2'><br>";
$order_form .= "<input type='text' placeholder='city' name='city'><br>";
$order_form .= "<input type='text' placeholder='state' name='state'><br>";
$order_form .= "<input type='text' placeholder='postcode' name='postcode'><br>";
$order_form .= "<input type='text' placeholder='country' name='country'><br>";

$order_form .= "</div><div class='contact-details'>";

$order_form .= "<h5 class='mt-3 mb-3'>Contact Details</h5>";
$order_form .= "<input type='text' placeholder='First Name' name='firstname'><br>";
$order_form .= "<input type='text' placeholder='Last Name' name='lastname'><br>";
$order_form .= "<input type='text' placeholder='Company' name='company'><br>";
$order_form .= "<input type='email' placeholder='email' name='email'><br>";
$order_form .= "<input type='text' placeholder='phone' name='phone'><br>";

$order_form .= "</div></div>";

    
     
$order_form .= "<input type='hidden' name='action' value='create_form'>";
$order_form .= "<button class='btn button btn-primary'>Creat Order</button>";
$order_form .= "</form>";

} else {
    echo "Restricted Page";
}

?>
