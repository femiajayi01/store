<?php

require_once("../includes/initialize.php");


require('layout/admin_header.php');

if (!$session->is_logged_in()) {
    redirect_to("login.php");
}

$finds = Category::find_all();

?>


 <h2>Product Category</h2>


<?php echo output_message($message); ?>

   
<?php
foreach ($finds as $find) {
    echo "<ul>";
    echo "<li>" . $find->name . "</li>";
    echo "</ul>";
}
?>

    <br/>
    <a href="index.php">&laquo; Back</a>
    | <a href="new_category.php">New Category</a><br/><br/>


<?php

require('layout/admin_footer.php');