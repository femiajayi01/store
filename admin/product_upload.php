<?php
    
require_once("../includes/initialize.php");


if (!$session->is_logged_in()) {
    redirect_to("login.php");
}

$message = "";
$done = FALSE;
$errorMessage = "";
$product->title = $product->category_id = $product->price = $product->quantity = $product->description = $product->created = "";
$errorTitle = $errorCategory = $errorPrice = $errorQuantity = $errorDescription = $errorCreated = "";


if (isset($_POST['submit'])) {
    if ($_POST['title']) {
        if (empty($_POST['title'])) {
            $errorTitle = "Product Title is Required";
            $errorMessage .= $errorTitle . "<br/>";
        } else {
            $product->title = test_input($_POST['title']);
        }
    }

      if (empty($_POST['category_id'])) {
            $errorCategory = "Category is Required";
            $errorMessage .= $errorCategory . "<br/>";
         } else {
            $product->category_id = test_input($_POST['category_id']);
         } 

    if ($_POST['price']) {
        if (empty($_POST['price'])) {
            $errorPrice = "Price of Product is Required";
            $errorMessage .= $errorPrice . "<br/>";
        } else {
            $product->price = test_input($_POST['price']);
            if (!is_numeric($product->price)) {
                $errorPrice = "Only Numbers are allowed for Price";
                $errorMessage .= $errorPrice . "<br/>";
            }
        }
    }

    if ($_POST['quantity']) {
        if (empty($_POST['quantity'])) {
            $errorQuantity = "Quantity is Required";
            $errorMessage .= $errorQuantity . "<br/>";
        } else {
            $product->quantity = test_input($_POST['quantity']);
            if (!is_numeric($product->quantity)) {
                $errorQuantity = "Only Numbers are allowed for Quantity";
                $errorMessage .= $errorQuantity . "<br/>";
            }

        }
    }


    if ($_POST['description']) {
        if (empty($_POST['description'])) {
            $errorDescription = "Product description is Required";
            $errorMessage .= $errorDescription . "<br/>";
        } else {
            $product->description = test_input($_POST['description']);
        }
    }


    if (!$errorMessage) {
        $product->created = strftime("%Y-%m-%d %H:%M:%S", time());
        $product = new Product();
        $product->attach_file($_FILES['file_upload']);
        if ($product->save()) {
            $done = TRUE;
            $session->message("Product uploaded successfully.");
            redirect_to('product_listing.php');
        } else {
            $errorMessage = join("<br/>", $product->errors);
        }
    }


    if ($errorMessage) {
        $panelClass = 'panel-danger';
        $panelHeader = '<div class="panel-heading"><h3 class="panel-title">Please correct the errors in the form<br></h3> class=
                          "panel-title alert alert-danger">' . $errorMessage . '</h3> </div>';
    }
}

require ('layout/admin_header.php');

?>


   <a href="index.php">&laquo; Back</a><br/>


        <div class="row">
        

             <div class="col-sm-2">  </div>                        
                 
                 <div class="col-sm-8">
                     <h3>Product Upload</h3>
                     <br/>
                   <form id="userForm" method="post" action="product_upload.php" class="form-horizontal" enctype="multipart/form-data">

        <?php if ($done == TRUE) { ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                Product uploaded successfully.
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
        
        <div class="form-group">
            <label for="title" class="control-label col-md-2">Product Title</label>
            <div class="col-md-10" style="width: 300px">
                <input class="form-control" id="title" name="title" placeholder="Product Title" required
                       value="<?php echo $product->title; ?>" maxlength="30">
            </div>
        </div>

        <div class="form-group">
            <label for="category" class="control-label col-md-2">Category</label>
            <div class="col-md-10" style="width: 300px">
                <select class="form-control" id="category_id" name="category_id">
                    <?php
                    $finds = Category::find_all();
                    foreach ($finds as $find){
                    ?>
                        <option
                            value="<?php echo $find->id;?>"><?php echo $find->name; ?></option>
                    <?php
                        }
                        ?>
                </select>
            </div>
        </div>


        <div class="form-group">
            <label for="price" class="control-label col-md-2">Price</label>
            <div class="col-md-10" style="width: 300px">
                <input class="form-control" id="price" name="price" placeholder="Price" required
                       value="<?php echo $product->price; ?>" maxlength="30">
            </div>
        </div>

        <div class="form-group">
            <label for="quantity" class="control-label col-md-2">Quantity</label>
            <div class="col-md-10" style="width: 300px">
                <input class="form-control" id="quantity" name="quantity" placeholder="Quantity" required
                       value="<?php echo $product->quantity; ?>" maxlength="30">
            </div>
        </div>

        <div class="form-group">
            <label for="descrption" class="control-label col-md-2">Description</label>
            <div class="col-md-10" style="width: 400px">
                <textarea class="form-control" cols="40" rows="8" id="description" name="description"
                          placeholder="Product Description" required
                          maxlength="1000"><?php echo $product->description; ?></textarea>
            </div>
        </div>


        <div class="form-group">
            <label for="fileUpload" class="control-label col-md-2">File Upload</label>
            <div class="col-md-10" style="width: 300px">
                <input type="file" id="file_upload" name="file_upload" required>
            </div>
        </div>


        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <input type="submit" name="submit" value="Upload Product" class="btn btn-warning"/>
            </div>
        </div>

    </form>
                </div> 
                                      
            <div class="col-sm-2">  </div>

        </div>







<?php
    
require ('layout/admin_footer.php');