<?php
    
    require_once("../includes/initialize.php");

    $product = Product::find_by_id($_GET['id']);
//    $category = Category::find_by_id($product->category_id);
    $category = $product->fetch_category();


$message = "";
$done = FALSE;
$errorMessage = "";
$title = $category_id = $price = $description = $created = "";
$errorTitle = $errorCategory = $errorPrice = $errorDescription = $errorCreated = "";

$product = Product::find_by_id($_GET['id']);

if ($_SERVER["REQUEST_METHOD"] == "POST" && $product) {
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
            $price = test_input($_POST['price']);
            if (!is_numeric($product->price)) {
                $errorPrice = "Only Numbers are allowed for Price";
                $errorMessage .= $errorPrice . "<br/>";
            }else $product->price = $price;
        }
    }

    if ($_POST['quantity']) {
        if (empty($_POST['quantity'])) {
            $errorQuantity = "Quantity is Required";
            $errorMessage .= $errorQuantity . "<br/>";
        } else {
            $quantity = test_input($_POST['quantity']);
            if (!is_numeric($product->quantity)) {
                $errorQuantity = "Only Numbers are allowed for Quantity";
                $errorMessage .= $errorQuantity . "<br/>";
            }else $product->quantity = $quantity;

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
        $product->save();
        redirect_to("product_listing.php");
    }


    if ($errorMessage) {
        $panelClass = 'panel-danger';
        $panelHeader = '<div class="panel-heading"><h3 class="panel-title">Please correct the errors in the form<br></h3> class=
                          "panel-title alert alert-danger">' . $errorMessage . '</h3> </div>';
    }
}




?>

<img class="pull-right" src="../<?php echo $product->image_path();?>" width="50" />
<input type="hidden" value="<?php echo $product->id; ?>"  id="productId"/>
<div>
    <h4>Edit  <i><?php echo $product->title; ?></i></h4>

    <form id="userForm" method="post" action="edit_product.php?id=<?php echo $product->id; ?>" >
        <?php if ($done == TRUE) { ?>
           <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                 aria-hidden="true">&times;</span></button>
                 Your information was successfully updated
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

    <dl class="dl-horizontal">
        <dt>
            Product
        </dt>
        <dd>
            <input class="form-control" style="width: 200px;" name="title" value="<?php echo $product->title;  ?>" />
        </dd> <br/>      
    
        <dt>
            Category
        </dt>
        <dd>

            <select class="form-control" style="width: 200px;" id="category_id" name="category_id">
                <?php
                $finds = Category::find_all();
                foreach ($finds as $find){ ?>
                    <option <?php echo $find->id == $category->id ? 'selected' : ''; ?>
                        value="<?php echo $find->id;?>"><?php echo $find->name ; ?></option>
                    <?php } ?>
                                       
            </select>
        </dd><br/>  
        <dt>
            Price(₦)
        </dt>
        <dd>
            <input class="form-control" style="width: 200px;" name="price" value="<?php echo "$product->price"; ?>" />
        </dd><br/> 

        <dt>
            Quantity
        </dt>
        <dd>
            <input class="form-control" style="width: 200px;" name="quantity" value="<?php echo $product->quantity; ?>" />
        </dd><br/> 

        <dt>
            Description
        </dt>
        <dd>
            <textarea class="form-control" cols="4" rows="5" name="description"><?php echo $product->description; ?></textarea> 
        </dd><br/>
        <dt>
            
        </dt>
        <dd>
            <input type="submit" value="Save" class="btn btn-info"/> 
        </dd>

    </dl>
    </form>
</div>




