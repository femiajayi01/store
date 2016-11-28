<?php
require_once("includes/initialize.php");
ensure_login($session);
require('layout/header.php');

$items = UserCart::get_cart();
if(count($items) == 0)
    redirect_to('/');


?>
    <div class="row">
        <div class="col-sm-9" id="checkout_page">
            <?php echo UserCart::checkout_page(); ?>
        </div>
        <div class="col-sm-3">
        </div>
    </div>
<?php require('layout/footer.php');