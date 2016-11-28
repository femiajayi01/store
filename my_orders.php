<?php
    
require_once("includes/initialize.php");
ensure_login($session);

require ('layout/header.php');

$customer = Customer::find_by_id($session->user_id);

$orders = Order::find_all_orders_by_customer($customer->id);

$order_items = new OrderItems();


?>



<div class="panel-group">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">Orders</h4>
            </div>
            <div id="business">
                <div class="panel-body">
                    <table class="table table-bordered table-responsive">
                        <thead>
                        <tr>
                            <th>Order Number</th>
                            <th>Order Items</th>
                            <th>Order Price(₦)</th>
                            <th>Order Date</th>
                            <th>Delivery Date</th>
                        </tr>
                        </thead>
                        <tbody>
                       <?php foreach($orders as $order) { ?>
                            <tr>
                                <td><?php echo $order->order_number; ?></td>
                                <td>
                                    <?php  
                                           $items = $order_items->find_by_order_id($order->id); 
                                           foreach ($items as $item){
                                               echo $item->product_title  ." (". $item->quantity . " X " . "₦$item->unit_price" . ")"."<br/>";
                                           }
                            
                                    ?>
                                </td>
                                <td><?php echo $order->total_price;  ?></td>
                                <td><?php echo $order->order_date; ?></td>
                                <td><?php echo $order->delivery_date; ?></td>                            
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
    </div>






<?php
require ('layout/footer.php');


