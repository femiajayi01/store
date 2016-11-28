<?php
    
require_once("../includes/initialize.php");

if(!$session->is_logged_in()){
    redirect_to("login.php");
}

require ('layout/admin_header.php');

$user = User::find_by_id($session->user_id);



?>


            <ul>   
                <li><a href="product_upload.php">Upload Product</a></li>
                <li><a href="product_listing.php">View Products</a></li>
                <li><a href="product_order.php">View Orders</a></li>
                <li><a href="view_category.php">View Categories</a></li>                
                <li><a href="logout.php">Log out</a></li>
                  
            </ul>






<?php
    
require ('layout/admin_footer.php');