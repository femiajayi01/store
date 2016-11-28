<?php
    
require_once("includes/initialize.php");

require ('layout/header.php');

define("nl", "<br>");
$errMessage = '';
$firstName = $lastName = $email = $gender = $mobile = $state = $address = $password = $confirmPassword = $dateRegistered = '';
$errFirstName = $errLastName = $errEmail = $errGender = $errMobile = $errState = $errAddress = $errPassword = $errConfirmPassword = '';
$done = FALSE;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
         if ($_POST['firstName']) {
             if (empty($_POST['firstName'])) {
                    $errFirstName = "First Name is Required";
                    $errMessage .= $errFirstName . nl;
                } else {
                    $firstName = test_input($_POST['firstName']);
                    if (!preg_match("/^[a-zA-Z]*$/", $firstName)) {
                        $errFirstName = "Only letters and white space are allowed for First Name";
                        $errMessage .= $errFirstName . nl;
                    }
                }
              }
              
         if ($_POST['lastName']) {
             if (empty($_POST['lastName'])) {
                    $errLastName = "Last Name is Required";
                    $errMessage .= $errLastName . nl;
                } else {
                    $lastName = test_input($_POST['lastName']);
                    if (!preg_match("/^[a-zA-Z]*$/", $lastName)) {
                        $errLastName = "Only letters and white space are allowed for Last Name";
                        $errMessage .= $errLastName . nl;
                    }
                }
              }

        if (empty($_POST['email'])) {
            $errEmail = "Email is Required";
            $errMessage .= $errEmail . nl;
        } else {
            $email = test_input($_POST['email']);
            $cus = Customer::find_by_email($email);

            if (isset($cus) && !empty($cus)) {
                $errEmail = "Username already exists";
                $errMessage .= $errEmail . nl;
            } else {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errEmail = "Invalid Email Format";
                    $errMessage .= $errEmail . nl;
                }
            }
        }//die("$email");    

        if (empty($_POST['gender'])) {
            $errGender = "Gender is Required";
            $errMessage .= $errGender . nl;
        } else {
            $gender = test_input($_POST['gender']);
        }

        if (empty($_POST['mobile'])) {
            $errMobile = "Mobile Number is Required";
            $errMessage .= $errMobile . nl;
        } else {
            $mobile = test_input($_POST['mobile']);
        }

        if (empty($_POST["state"])) {
            $errState = "State is Required";
            $errMessage .= $errState . nl;
        } else {
            $state = test_input($_POST['state']);
        }

        if (empty($_POST["address"])) {
            $errAddress = "Address is Required";
            $errMessage .= $errAddress . nl;
        } else {
            $address = test_input($_POST['address']);
        }

        if (empty($_POST['password'])) {
            $errPassword = "Password is Required";
            $errMessage .= $errPassword . nl;
        }

        if (strlen($_POST['password']) < 6)  {
            $errPassword = "Password must have a minimum of 6 characters!";
            $errMessage .= $errPassword . nl;
                }
         else {
                $password = $_POST['password'];
            }
                   

        if (empty($_POST['confirmPassword'])) {
            $errConfirmPassword = "Confirm password";
            $errMessage .= $errConfirmPassword . nl;
        } else {
            if ($_POST['password'] != $_POST['confirmPassword']) {
                $errConfirmPassword = "Password did not match!";
                $errMessage .= $errConfirmPassword . nl;  
            } else {

                $password = $_POST['password'];
            }
        }

        if (empty($errMessage)) {
            $dateRegistered = strftime("%Y-%m-%d %H:%M:%S", time());
            $password_hash = hash('md5',$password);
            $customer = new Customer();
            $customer->firstname = $firstName;
            $customer->lastname  = $lastName;
            $customer->email     = $email;
            $customer->gender    = $gender;
            $customer->mobile    = $mobile;
            $customer->state     = $state;
            $customer->address   = $address;
            $customer->password  = $password_hash;
            $customer->dateRegistered = $dateRegistered;
            if ($customer->save()) {
                $done = TRUE;
            } else {
                
            }
        }
        else {
            $panelClass = 'panel-danger';
            $panelHeader = '<div class="panel-heading"><h3 class="panel-title">Please correct the errors in the form<br></h3> class=
                              "panel-title alert alert-danger">' . $errMessage . '</h3> </div>';
        }
    


}


?>


          <div class="row">      
               <div class="col-md-2"></div>   
                    <div class="col-md-7">                     
                        <div class="well" style="width: 800px" >
                            <h3 style="font-size: x-large; text-align: center; color: orange; font-family: 'Book Antiqua'">Sign Up</h3>
                            <br/>
                          <form id="userForm" method="post" action="" class="form-horizontal">
                                <?php if ($done == TRUE) { ?>
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                        You have successfully registered
                                    </div>
                                <?php } else if (empty($errMessage) == FALSE and isset($errMessage)) {
                                    ?>
                                    <div class="alert alert-warning alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                        <?php echo $errMessage; ?>
                                    </div>
                                    <?php
                                } ?>

                                <div class="form-group">
                                    <label style="font-size: large"  for="firstName" class="control-label col-md-2">First Name</label>
                                    <div class="col-md-10" style="width: 300px">
                                        <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name" required
                                               value="<?php echo $firstName; ?>" maxlength="30">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="font-size: large"  for="lastName" class="control-label col-md-2">Last Name</label>
                                    <div class="col-md-10" style="width: 300px">
                                        <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name" required
                                               value="<?php echo $lastName; ?>" maxlength="30">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="font-size: large"  for="email" class="control-label col-md-2">Email (Username) </label>
                                    <div class="col-md-10" style="width: 300px">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required
                                               value="<?php echo $email; ?>" maxlength="30">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="font-size: large" for="password" class="control-label col-md-2">Password </label><small id="passLength" style="color: red"></small>
                                    <div class="col-md-10" style="width: 300px">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                                             required>
                                    </div>
                                    </div>

                               
                               
                                <div class="form-group">
                                    <label style="font-size: large" for="password" class="control-label col-md-2">Confirm Password </label>
                                    <div class="col-md-10" style="width: 300px">
                                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"
                                               placeholder="Confirm Password"   required>
                                    </div>
                                    <small id="divCheckPasswordMatch" style="color: red"></small>
                                </div>
                              

                                <div class="form-group">
                                    <label style="font-size: large" for="gender" class="control-label col-md-2">Gender</label>
                                    <div class="col-md-10" style="width: 300px">
                                        <select class="form-control" id="gender" name="gender" required>
                                            <option <?php echo ($gender == 'Female') ? 'selected ="TRUE"' : ''; ?> value="Female">Female
                                            </option>
                                            <option <?php echo ($gender == 'Male') ? 'selected ="TRUE"' : ''; ?> value="Male">Male</option>
                                        </select>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label style="font-size: large"  for="mobile" class="control-label col-md-2">Mobile Number</label>
                                    <div class="col-md-10" style="width: 300px">
                                        <input type="tel" class="form-control" id="mobile" name="mobile"
                                               placeholder="Mobile Number" required
                                               value="<?php echo $mobile; ?>" maxlength="30">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="font-size: large"  for="State" class="control-label col-md-2">State</label>
                                    <div class="col-md-10" style="width: 300px">
                                        <input type="text" class="form-control" id="state" name="state" placeholder="State" required
                                               value="<?php echo $state; ?>" maxlength="30">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="font-size: large" for="address" class="control-label col-md-2">Contact Address</label>
                                    <div class="col-md-10" style="width: 300px">
                                        <input type="text" class="form-control" id="address" name="address" placeholder="Contact Address" required
                                               value="<?php echo $address; ?>" maxlength="30">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-10">
                                        <input type="submit" value="Submit" class="btn btn-warning"/>
                                    </div>
                                </div>


                            </form>  
                            <br/><br/>
                            <p>Already have an account? <a href="login.php">Sign In</a></p>            
                
                       </div>                
                      </div>      
                 <div class="col-md-3"></div>     
                 </div>    









<?php
require ('layout/footer.php');


