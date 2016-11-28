<?php
    
require_once("includes/initialize.php");

$products;
$catId = $_GET["category"];

if(isset($catId) && intval($catId) > 0){
    $products = Category::get_products_for_category($catId);
 }  else $products = Product::find_all_by_date();
 $categories = Category::find_all();

require ('layout/header.php');

//$count = Review::count_all();


?>


            <div class="row">
              <div class="col-md-3">

                 <div class="list-group">
                     <?php foreach($categories as $category) { ?>
                         <a href="?category=<?php echo $category->id; ?> " class="list-group-item"><?php echo $category->name; ?></a>                  
                     <?php } ?>  
                         </div>               
               </div>


              <div class="col-md-9">
                      
                        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="item active">
                                    <img class="slide-image" src="carousel/one.jpg" alt="http://placehold.it/800x300">
                                </div>
                                <div class="item">
                                    <img class="slide-image" src="carousel/two.jpg" alt="http://placehold.it/800x300">
                                </div>
                                <div class="item">
                                    <img class="slide-image" src="carousel/three.jpg" alt="http://placehold.it/800x300">
                                </div>
                                <div class="item">
                                    <img class="slide-image" src="carousel/four.jpg" alt="http://placehold.it/800x300">
                                </div>
                            </div>
                            <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                            </a>
                            <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                            </a>
                       
                    </div>               
                  </div>
            </div>
        
        
        </div>
        <br/>

        <div class="container">

            <?php foreach($products as $product) { ?>
                <div class="col-sm-3 col-lg-3 col-md-3">
                    <div class="thumbnail">
 <!--             <a href="<?php //echo $product->productName; ?>">      --> 
               <a href="product_item.php?id=<?php echo $product->id; $count = Review::count_by_product_id($product->id); ?>">  
       	        <img class="" src="<?php echo $product->image_path();?>" style="height: 200px;" />
               </a>
                   <div class="caption">
            
                        <h4 class="pull-right" style="color: green"><?php echo "₦$product->price"; ?></h4>
           
                        <h4><a href="#"> <?php echo $product->title; ?> </a> </h4>
   
                                                        		         
                   </div>   
                                            
                     <div class="ratings">                         
                       <p class="pull-right"> <?php echo $count ? "$count Review(s)": "No Review"; ?></p>                          
                          <p>                          
 		            <span class="glyphicon glyphicon-star"></span>               
                            <span class="glyphicon glyphicon-star"></span>               
                            <span class="glyphicon glyphicon-star"></span>                                   
		            <span class="glyphicon glyphicon-star"></span>        
                            <span class="glyphicon glyphicon-star-empty"></span>                
                         </p>                        
   	                 </div>
                      
              </div>
                </div>
                 <?php } ?>
                   
        </div>







<?php
require ('layout/footer.php');



