<?php<?php
    
require_once("../includes/initialize.php");

if($session->is_logged_in()){
    redirect_to("index.php");
}
$done = FALSE;

if (isset($_POST['submit'])){
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $found_user = User::authenticate($username, $password);

    if($found_user){
        $done = TRUE;
        $session->login($found_user);
        redirect_to("index.php");
    } else {
        $message = "Username/Password combination incorrect";
    }
} else {
    $username = "";
    $password = "";
}

require ('layout/admin_header.php');


?>


        
        <div class="row">
        

             <div class="col-sm-3"></div>  
            
               <div class="col-sm-6">  
                    
                 
                          <h4 style="text-align: center">admin Login</h4>

              <?php echo $message; ?>
         

                        <div class="container-fluid">
            
            <br/>
            <form id="userForm" method="post" action="" class="form-horizontal">
                <div class="form-group">
                     <label for="name" class="control-label col-md-2">Username </label>
                     <div class="col-md-10" style="width: 300px">
                     <input type="text" class="form-control" id="username" name="username" placeholder="Username" required maxlength="30">
                     </div>
                 </div>

                 <div class="form-group">
                     <label for="password" class="control-label col-md-2">Password </label>
                     <div class="col-md-10" style="width: 300px">
                     <input type="password" class="form-control" id="password" name="password" placeholder="Password" required >
                     </div>
                 </div>

                 <div class="form-group">
                     <div class="col-md-offset-2 col-md-10">
                     <input type="submit" name="submit" value="submit" class="btn btn-default"/>
                     </div>
                 </div>
        
        </form>   
        
        </div>
                  

              
                   
                 </div> 

             <div class="col-sm-3"></div> 
            
          </div>

<?php
require ('layout/admin_footer.php');