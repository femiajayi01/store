<?php
/**
 * Created by PhpStorm.
 * User: FEMI
 * Date: 6/11/16
 * Time: 10:27 AM
 */
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="lib/jquery-ui/jquery-ui.min.css">
        <link rel="stylesheet" href="lib/jquery-ui/jquery-ui.theme.min.css">
        <link rel="stylesheet" href="lib/style.css">
        <title></title>
    </head>
    <body>
        <br/>
         <div class="container" >
            <div class="row">
              <div class="col-lg-3">

              </div><!-- /.col-lg-4 -->
              <div class="col-lg-6">
                <div class="input-group input-group-lg" class="ui-widget">
                  <input type="text" class="form-control" name="product" id="product" placeholder="Search for a product, brand or category">
                  <span class="input-group-btn">
                    <button class="btn btn-warning " type="button">Search</button>
                  </span>
                </div><!-- /input-group -->
                <div id="productList"></div>
              </div><!-- /.col-lg-4 -->
              <div class="col-lg-3 cart" id="dropdown">
                <p class="pull-right" id="dropbtn">
                    Cart
                    <span style="font-size: xx-large; " class="glyphicon glyphicon-shopping-cart"><span style="background-color: orange" class="badge" id="cart_count"><?php echo count(UserCart::get_cart()); ?></span>
                    </span></p>
                  <div class="dropdown-content" id="user_cart">
                    <?php echo UserCart::render_cart(); ?>
                  </div>
              </div>
            </div>

            <nav class="navbar navbar-default" style="padding-top: initial;">
              <div class="container">
                <div class="navbar-header">
                  <a style="font-size: x-large; color: orange; font-family: 'Book Antiqua'" class="navbar-brand" href="/">Algorism</a>
                </div>
        <div class="collapse navbar-collapse " id="bs-example-navbar-collapse-1">

                      <?php if ($session->is_logged_in()) {
                      $customer = Customer::find_by_id($session->user_id); ?>




                      <ul class="nav navbar-nav navbar-right">
                          <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                 aria-haspopup="true" aria-expanded="false">Hello, <?php echo $customer->firstname; ?> <span class="caret"></span></a>
                              <ul class="dropdown-menu">
                                  <li><a href="profile.php">View Profile</a></li>
                                  <li><a href="my_orders.php">View Orders</a></li>
                                  <li role="separator" class="divider"></li>
                                  <li><a href="logout.php">Log off</a></li>
                              </ul>
                          </li>
                      </ul>
                     <?php  } else { ?>
                    <ul class="nav navbar-nav pull-right">
                        <li><a href="register.php">Sign Up</a></li>
                        <li><a href="login.php">Login</a></li>
                   </ul>
                    <?php  } ?>  



             </div>
             </div>
           </div>


        </div></a></li>
                </ul>
              </div>
            </nav>

        <div class="container"  >


                      