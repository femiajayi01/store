<?php
    
require_once("../includes/initialize.php");

if (!$session->is_logged_in()) {
    redirect_to("login.php");
}

$done = FALSE;
$errorMessage = "";
$errorName = "";
$name = "";

if (isset($_POST['submit'])) {
    if ($_POST['name']) {
        if (empty($_POST['name'])) {
            $errorName= "Category Name is Required";
            $errorMessage .= $errorName . "<br/>";
        } else {
            $name = test_input($_POST['name']);
            if (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
                $errorName = "Only letters and white space are allowed for Category Name";
                $errorMessage .= $errorName . "<br/>";
            }
        }
    }

    if ((!$errorMessage) and empty($errorMessage)){
        $category = new Category();
        $category->name = $name;
        $category->created = strftime("%Y-%m-%d %H:%M:%S", time());
        if ($category->create()){
            $done = TRUE;
            $session->message("A new category has been created.");
            redirect_to('view_category.php');
        } else {
   $done = FALSE;
            $session->message("Could not create a new category.");

        }
    }         
}

require ('layout/admin_header.php');
?>


   <div class="container">
       <a href="view_category.php">&laquo; Back</a><br/><br/>
        <form method="post" action="new_category.php" class="form-horizontal">
            <?php if ($done == TRUE) { ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    A new category has been created.
                </div>
            <?php } else if (empty($errorMessage) == FALSE and isset($errorMessage)) {
                ?>
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <?php echo $errorMessage; ?>
                </div>
                <?php
            } ?>
            <br/>
        <div class="form-group">
            <label for="name" class="control-label col-md-2">Category Name</label>
            <div class="col-md-10" style="width: 300px">
                <input class="form-control" id="name" name="name" placeholder="Category Name" required
                       value="<?php echo $name; ?>" maxlength="30">
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <input type="submit" name="submit" value="Create Category" class="btn btn-danger"/>
            </div>
        </div>
        
        
        </form>
   
   
   </div>






<?php
    
require ('layout/admin_footer.php');