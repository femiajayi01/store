<?php
    
require_once("../includes/initialize.php");

if(!$session->is_logged_in()){
    redirect_to("login.php");
}

$orders = Order::find_all_orders();

$order_items = new OrderItems();

$count = Order::count_all();

require ('layout/admin_header.php');


?>


<a href="index.php">&laquo; Back</a><br/>
<div class="panel-group">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4 class="panel-title">All Orders</h4>
            </div>
            <div id="business">
                <div class="panel-body">
                    <table class="table table-bordered table-responsive">
                        <thead>
                        <tr>
                            <th>Order Number</th>
                            <th>Customer Name</th>
                            <th>Order Items</th>
                            <th>Quantity</th>
                            <th>Price(₦)</th>
                            <th>Order Date</th>
                            <th>Delivery Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($orders as $order) { ?>
                            <tr>
                                
                                <td><?php echo $order->order_number; ?></td>      
                                <td><?php $customer = Customer::find_by_id($order->customer_id); echo $customer->fullname();  ?></td>
                                <td><?php 
                                            $items = $order_items->find_by_order_id($order->id); 
                                           foreach ($items as $item){
                                               echo $item->product_title . "<br/>";
                                           }
                                 ?></td>
                                <td><?php echo $order->order_quantity; ?></td>
                                <td><?php echo $order->total_price; ?></td>
                                <td><?php echo $order->order_date ?></td>
                                <td><?php echo $order->delivery_date ?></td>                               
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="panel-footer"><?php echo $count ? "$count Orders(s)": "No Order"; ?></div>
            </div>
        </div>
    </div>






<?php
require ('layout/admin_footer.php');
