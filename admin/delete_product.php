<?php
    
    require_once("../includes/initialize.php");

    $product = Product::find_by_id($_GET['id']);
//    $category = Category::find_by_id($product->category_id);
    $category = $product->fetch_category();

?>



 <img class="pull-right" src="../<?php echo $product->image_path();?>" width="50" />
<input type="hidden" value="<?php echo $product->id; ?>"  id="productId"/>
<div>
    <h4>Are you sure you want to delete this product?</h4>
    <dl class="dl-horizontal">
        <dt>
            Product
        </dt>
        <dd>
            <?php echo $product->title;  ?>
        </dd>            
        <dt>
            Category
        </dt>
        <dd>
            <?php echo $category->name; ?>
        </dd>
        <dt>
            Price
        </dt>
        <dd>
            <?php echo "₦$product->price"; ?>
        </dd>
        <dt>
            Created
        </dt>
        <dd>
            <?php echo $product->created; ?>
        </dd>

    </dl>
</div>