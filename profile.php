<?php
    
require_once("includes/initialize.php");
ensure_login($session);

require ('layout/header.php');

$customer = Customer::find_by_id($session->user_id);

//$orders = Purchase::find_all_orders_by_customer($customer->id);

//$order_items = new OrderItems();

?>



 <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <h3><?php echo $customer->fullname(); ?></h3>
            <div class="well" style="width: 500px;">
                <table class="table table-bordered" style="width: 450px; ">

                    <tr>
                        <th>First Name</th>
                        <td><?php echo $customer->firstname; ?></td>
                    </tr>

                    <tr>
                        <th>Last Name</th>
                        <td><?php echo $customer->lastname; ?></td>
                    </tr>

                    <tr>
                        <th>Gender</th>
                        <td><?php echo $customer->gender; ?></td>
                    </tr>

                    <tr>
                        <th>Email</th>
                        <td><?php echo $customer->email; ?></td>
                    </tr>

                    <tr>
                        <th>State</th>
                        <td><?php echo $customer->state; ?></td>
                    </tr>

                    <tr>
                        <th>Customer Address</th>
                        <td><?php echo $customer->address; ?></td>
                    </tr>

                    <tr>
                        <th>Mobile Number</th>
                        <td><?php echo $customer->mobile; ?></td>
                    </tr>



                </table>
            </div>

        </div>
        <div class="col-sm-3"></div>
    </div>





<?php
require ('layout/footer.php');


