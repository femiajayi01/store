<?php
require_once("includes/initialize.php");
ensure_login($session);
$items = UserCart::get_cart();
if (count($items) == 0)
    redirect_to('checkout.php');

//$item = $items[0];
//print_r($items);


$customer = Customer::find_by_id($session->user_id);
//$product = Product::find_by_id($item->id);


if ($_SERVER["REQUEST_METHOD"] == 'POST') {


    $order = new Order();
    $order->order_number   = rand(100000, 999999);
    $order->customer_id    = $customer->id;
    $order->order_quantity = UserCart::total_quantity();
    $order->order_date     = strftime("%Y-%m-%d %H:%M:%S", time());
    $order->delivery_date  = "";
    $order->total_price    = UserCart::total_price();
    
    if ($order->save()) {
        
         foreach ($items as $item){
            $product = Product::find_by_id($item->id);

            $orderItem                = new OrderItems();
            $orderItem->order_id      = $order->id;
            $orderItem->product_title = $product->title;
            $orderItem->quantity      = $item->quantity;
            $orderItem->unit_price    = $product->price;
            $orderItem->order_date    = $order->order_date;
            $orderItem->save();

             if ($item->id == $product->id) {       
             $product->quantity = $product->quantity - $item->quantity;
             }
             $product->save();
         }
         
         $cart = new UserCart();
         $cart->clear_cart();         
         redirect_to("my_orders.php");
    }
    

} else {

}

require('layout/header.php');
?>
    <div class="row">
        <div class="col-sm-9">
            <table class="table table-responsive">
                <tr>
                    <th>Your Email</th>
                    <td><?php echo $customer->email . "<br/>"; ?><br/></td>
                </tr>
                <br/>
                <tr>
                    <th>Your Address</th>
                    <td><?php echo $customer->fullname() . "<br/>" . $customer->address; ?></td>
                </tr>
                <tr>
                    <th>Order Summary</th>
                    <td><?php echo "<b>Items:</b> " . UserCart::total_quantity() . "<br/>"   . "<b>Total:</b> " . "₦" . UserCart::total_price(); ?></td>
                </tr>
            </table>
            <form action="" method="post">
                <button type="submit" class="btn btn-warning">CONFIRM ORDER</button>
            </form>

        </div>
        <div class="col-sm-3">

        </div>
    </div>
<?php require('layout/footer.php');