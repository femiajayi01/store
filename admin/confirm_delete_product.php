<?php
    
    require_once("../includes/initialize.php");

    $product = Product::find_by_id($_POST['id']);
    $product->destroy();