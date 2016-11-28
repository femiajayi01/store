<?php

require_once("../includes/initialize.php");

require('layout/admin_header.php');

if (!$session->is_logged_in()) {
    redirect_to("login.php");
}

$products = Product::find_all_by_date();

$category = new Category();

$count = Product::count_all();

?>
    <a href="index.php">&laquo; Back</a>
    <br/><br/>
<?php echo output_message($message); ?>
    <div class="panel-group">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4 class="panel-title">Products</h4>
            </div>
            <div id="business">
                <div class="panel-body">
                    <table class="table table-bordered table-responsive">
                        <thead>
                        <tr>
                            <th>Product Image</th>
                            <th>Product Title</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Description</th>
                            <th>Date Uploaded</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($products as $product) {
                            $category = $product->fetch_category(); ?>
                            <tr>
                                <td><img src="../<?php echo $product->image_path(); ?>" width="50"/></td>
                                <td><?php echo $product->title; ?></td>
                                <td><?php echo $product->category->name; ?></td>
                                <td><?php echo "₦$product->price"; ?></td>
                                <td><?php echo $product->quantity; ?></td>
                                <td><?php echo $product->description; ?></td>
                                <td><?php echo $product->created; ?></td>
                                <td><a class="editItem" href="#" data-product-id="<?php echo $product->id ?>">Edit</a>
                                </td>
                                <td><a class="deleteItem" href="#"
                                       data-product-id="<?php echo $product->id ?>">Delete</a></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="panel-footer"><?php echo $count ? "$count Product(s)" : "No Product"; ?></div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="product_delete_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <!-- <h4 class="modal-title">Modal title</h4> -->
                    <h4 class="modal-title" id="deleteProduct"></h4>
                </div>
                <div class="modal-body">
                    <div id="deleteBody"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="deleteAction">Delete</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" tabindex="-1" role="dialog" id="product_edit_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <!-- <h4 class="modal-title">Modal title</h4> -->
                    <h4 class="modal-title" id="editProduct"></h4>
                </div>
                <div class="modal-body">
                    <div id="editBody"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <!--          <button type="button" class="btn btn-primary" id="editAction">Edit</button>     -->
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


<?php

require('layout/admin_footer.php');