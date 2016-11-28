<?php
require_once("includes/initialize.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product = Product::find_by_id($_GET['id']);
    $result = new ServiceResult();
    $quantity = $_GET['quantity'] || 1;

    if (!$product)
        $result->message = "Product not found";
    else {
        $count = $_GET['action'] == 'delete' ?
            UserCart::delete_from_cart($product->id) :
            $_GET['action'] == 'put' ?
                UserCart::decrease_cart_quantity($product, $quantity) :
                UserCart::add_to_cart($product, $quantity);

        $result->message = "Successfully delete the product to the cart";
        $result->success = true;
        $result->cart = UserCart::render_cart();
        $result->items_count = $count;
        $result->checkout_cart = UserCart::checkout_page();
    }

    header('Content-Type:application/json');
    echo json_encode($result);
    exit;
}

echo UserCart::render_cart();