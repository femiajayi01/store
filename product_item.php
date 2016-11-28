<?php

require_once("includes/initialize.php");

//$product = Product::find_by_id($_GET['id']);

//$customer = Customer::find_by_id($session->user_id);

require('layout/header.php');

 if(empty($_GET['id'])){
     $session->message("No product ID was provided.");
     redirect_to('index.php');
 }


     $product = Product::find_by_id($_GET['id']);

    if(!$product){
        $session->message("The product could not be located");
        redirect_to('index.php');
    }


    $reviews = Review::find_by_product_id($product->id);

     $count = Review::count_by_product_id($product->id);
    //echo $count;
  

  //  foreach($reviews as $r){
  //      echo ($r->comment);
 //   } 


if ($_SERVER["REQUEST_METHOD"] == "POST" && $product) {
    
        $comment = trim($_POST['comment']);

        $new_review = Review::write_review($product->id, $customer->firstname, $comment);
        if ($new_review && $new_review->save()){
           
            redirect_to("product_item.php?id={$product->id}");
        } else {
            $message = "There was an error that prevented the comment from being saved.";
        }
    } else {
        $comment = "";
    }

    $reviews = Review::find_reviews_on($product->id);



?>


    <div class="row">
        <div class="col-sm-1"></div>

        <div class="col-sm-4">
            <img class="pull-right" src="<?php echo $product->image_path(); ?>" style="height: 300px; "/>
        </div>

        <div class="col-sm-6">
            <h2><?php echo $product->title; ?></h2>
            <hr/>
            <h3>Quantity Available</h3>
            <p><?php echo $product->quantity; ?></p>
            <h3>Price </h3>
            <p> <?php echo "₦$product->price"; ?></p>
            <h3>Product Description </h3>
            <p><?php echo $product->description; ?></p>
            <br/>

            <?php echo $count ? "$count Review(s)": "No Review";  ?> <br/>

              <?php if ($session->is_logged_in()) {
                      $customer = Customer::find_by_id($session->user_id); ?>


         
         <small id="review"><a href="#" data-toggle="modal" data-target ="#writeRev">write review</a></small> |
         <small id="review"><a href="#" data-toggle="modal" data-target ="#viewRev">view review</a></small>


             <?php  } ?>  


         <div class="modal fade" id="writeRev" tabindex="-1" role="dialog">
          <div class=" modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Your Review</h4>
              </div>
              <div class="modal-body">
                <div id="form">
                 <form action="product_item.php?id=<?php echo $product->id; ?>" method="post">
                    <table>
                        <tr>
                            <td><textarea style="font-size: small" name="comment" cols="20" rows="4" required></textarea></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td><input type="submit" value="Submit review" class="btn btn-info"/> </td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                </form>
            </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>               
              </div>
            </div>
          </div>
        </div>


         <div class="modal fade" id="viewRev" tabindex="-1" role="dialog">
          <div class=" modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Reviews</h4>
              </div>
              <div class="modal-body">
                <div id="form">

<div id="reviews">
<?php  $reviews = Review::find_by_product_id($product->id); foreach($reviews as $review) { ?>
    <div class="reviews" style="margin-bottom: 2em;">
        <div >
            <?php echo $review->reviewer; ?> wrote:
        </div>
        <div class="body">
            <?php echo strip_tags($review->comment, '<strong><em><p>'); ?>
        </div>
        <div class="meta-info" style="font-size: 0.8em;">
            <?php echo datetime_to_text($review->created) ; ?>
        </div>
    </div>
    <?php } ?>
    <?php if(empty($reviews)) {echo "No Reviews.";} ?>
</div>



            </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>               
              </div>
            </div>
          </div>
        </div>

            <br/> 
            <hr/>

            <form action="index.php">  
                <button type="button" class="btn btn-warning" data-id="<?php echo $product->id; ?>" id="add_to_cart">ADD TO CART              
                </button>
                <button type="submit" class="btn btn-info">CONTINUE SHOPPING</button>
            </form>

            <br/> 
            <hr/>

            
        </div>

        <div class="col-sm-1"></div>
    </div>







<?php
require('layout/footer.php');


