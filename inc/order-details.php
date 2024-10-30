


<?php


$args = array(
    'limit' => 1,
);
$orders = wc_get_orders( $args );
$order_details = "<div class='mb-3'>Your Order Information </div>";

foreach($orders as $results) {

$order_details .= "<ul class='woocommerce-order-overview woocommerce-thankyou-order-details order_details'>

    <li class='woocommerce-order-overview__order order'>
        Order number: <br><strong>" . $results->id . "</strong>
    </li>

    <li class='woocommerce-order-overview__date date'>
        Date: <br><strong>" . $results->get_date_created() . "</strong>
    </li>

    <li class='woocommerce-order-overview__email email'>
        Email: <br><strong>" . $results->get_billing_email() . "</strong>
    </li>

    <li class='woocommerce-order-overview__total total'>
        Total: <br><strong><span class='woocommerce-Price-amount amount'>" . $results->total . "</strong>

    </li>

    <li class='woocommerce-order-overview__payment-method method'>
        Payment method: <br><strong>" . $results->status . "</strong>
    </li>

</ul>";

} 

?>