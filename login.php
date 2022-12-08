<?php 
ob_start();
session_start();
include'conn.php';
$showerror=false;
$showalert=false;
$showpassword_wrong=false;
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Suruchi - Account Page</title>
  <meta name="description" content="Morden Bootstrap HTML5 Template">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
    
  <!-- ======= All CSS Plugins here ======== -->
  <link rel="stylesheet" href="assets/css/plugins/swiper-bundle.min.css">
  <link rel="stylesheet" href="assets/css/plugins/glightbox.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">

  <!-- Plugin css -->
  <!-- <link rel="stylesheet" href="assets/css/vendor/bootstrap.min.css"> -->

  <!-- Custom Style CSS -->
  <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

   <!-- Start header area -->
   <?php include('header.php'); ?>
    <!-- End header area -->

    <main class="main__content_wrapper">
        
        <!-- Start breadcrumb section -->
        <section class="breadcrumb__section breadcrumb__bg">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title text-white mb-25">Account Page</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items"><a class="text-white" href="index.html">Home</a></li>
                                <li class="breadcrumb__content--menu__items"><span class="text-white">Account Page</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End breadcrumb section -->

        <!-- Start login & register section  -->
        <div class="login__section section--padding">
            <div class="container">
                <div class="login__section--inner">
                    <div class="row row-cols-md-2 row-cols-1">
                        <!-- login section start here -->
                        <form method="post">
                            <?php if(isset($_REQUEST['login'])){
                                    $email=$_REQUEST['useremail'];
                                    $password=$_REQUEST['password'];
                                    $select_login=$conn->query("SELECT Username,Password,Status,Name FROM admin_user WHERE Username='$email'AND Password='$password' OR Mobile='$email' AND Password='$password'");
                                        $fetch=mysqli_fetch_array($select_login);
                                        if(mysqli_num_rows($select_login)>0){
                                            $_SESSION['useremail']=$email;
                                            $_SESSION['username']=$fetch['Name'];
                                            $_SESSION['login_message']="You have successfully login";
                                            header('location:my-account.php');
                                        }else{
                                            $showerror="You have entered wrong details..";
                                        }
                                }
                            ?>
                            <div class="col">
                                <div class="account__login">
                                    <div class="account__login--header mb-25">
                                        <h2 class="account__login--header__title h3 mb-10">Login</h2>
                                        <h2><?php echo $showerror;?></h2>
                                        <p class="account__login--header__desc">Login if you area a returning customer.</p>
                                    </div>
                                    <div class="account__login--inner">
                                        <input class="account__login--input" placeholder="Email Addres" type="text" name="useremail">
                                        <input class="account__login--input" placeholder="Password" type="password" name="password">
                                        <div class="account__login--remember__forgot mb-15 d-flex justify-content-between align-items-center">
                                            <div class="account__login--remember position__relative">
                                                <input class="checkout__checkbox--input" id="check1" type="checkbox">
                                                <span class="checkout__checkbox--checkmark"></span>
                                                <label class="checkout__checkbox--label login__remember--label" for="check1">
                                                    Remember me</label>
                                            </div>
                                            <button class="account__login--forgot" type="submit">Forgot Your Password?</button>
                                        </div>
                                        <button class="account__login--btn primary__btn" name="login" type="submit">Login</button>
                                        <div class="account__login--divide">
                                            <span class="account__login--divide__text">OR</span>
                                        </div>
                                        <div class="account__social d-flex justify-content-center mb-15">
                                            <a class="account__social--link facebook" target="_blank" href="https://www.facebook.com/">Facebook</a>
                                            <a class="account__social--link google" target="_blank" href="https://www.google.com/">Google</a>
                                            <a class="account__social--link twitter" target="_blank" href="https://twitter.com/">Twitter</a>
                                        </div>
                                        <p class="account__login--signup__text">Don,t Have an Account? <button type="submit">Sign up now</button></p>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- login section end here -->
                        <!-- registration section start here -->
                        <form method="post">
                            <?php
                                if(isset($_POST['register'])){
                                    $name=$_POST['name'];
                                    $email=$_POST['email'];
                                    $mobile=$_POST['mobile'];
                                    $password=$_POST['password'];
                                    $cpassword=$_POST['cpassword'];
                                    $already_registered=mysqli_query($conn,"SELECT *FROM admin_user WHERE Username='$email' OR Mobile='$mobile'");
                                        if (mysqli_num_rows($already_registered)>0) {
                                            $showalert="Your are existing customer";
                                        }elseif ($password==$cpassword AND !empty($password)) {
                                            $insert=$conn->query("INSERT INTO admin_user(Name,Username,Mobile,Password)VALUES('$name','$email','$mobile','$password')");
                                        }else{
                                            $showpassword_wrong="Your password doesn't match please try agian.";
                                        }
                                }    
                            ?>    
                            <div class="col">
                                <div class="account__login register">
                                    <div class="account__login--header mb-25">
                                        <h2 class="account__login--header__title h3 mb-10">Create an Account</h2>
                                        <h3>
                                        <?php 
                                            if($showalert){
                                                echo $showalert;
                                            }else{
                                                echo $showpassword_wrong;
                                            }
                                        ?> 
                                        </h3>
                                        <p class="account__login--header__desc">Register here if you are a new customer</p>
                                    </div>
                                    <div class="account__login--inner">
                                        <input class="account__login--input" placeholder="Username" type="text" name="name">
                                        <input class="account__login--input" placeholder="Email Addres" type="email" name="email">
                                        <input class="account__login--input" placeholder="Mobile No." type="number" name="mobile">
                                        <input class="account__login--input" placeholder="Password" type="password" name="password">
                                        <input class="account__login--input" placeholder="Confirm Password" type="password" name="cpassword">
                                        <button class="account__login--btn primary__btn mb-10" type="submit" name="register">Submit & Register</button>
                                        <div class="account__login--remember position__relative">
                                            <input class="checkout__checkbox--input" id="check2" type="checkbox">
                                            <span class="checkout__checkbox--checkmark"></span>
                                            <label class="checkout__checkbox--label login__remember--label" for="check2">
                                                I have read and agree to the terms & conditions</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- registration section start here -->
                    </div>
                </div>
            </div>     
        </div>
        <!-- End login and registration section  -->

        <!-- Start shipping section -->
        <section class="shipping__section2 shipping__style3 section--padding pt-0">
            <div class="container">
                <div class="shipping__section2--inner shipping__style3--inner d-flex justify-content-between">
                    <div class="shipping__items2 d-flex align-items-center">
                        <div class="shipping__items2--icon">
                            <img src="assets/img/other/shipping1.png" alt="">
                        </div>
                        <div class="shipping__items2--content">
                            <h2 class="shipping__items2--content__title h3">Shipping</h2>
                            <p class="shipping__items2--content__desc">From handpicked sellers</p>
                        </div>
                    </div>
                    <div class="shipping__items2 d-flex align-items-center">
                        <div class="shipping__items2--icon">
                            <img src="assets/img/other/shipping2.png" alt="">
                        </div>
                        <div class="shipping__items2--content">
                            <h2 class="shipping__items2--content__title h3">Payment</h2>
                            <p class="shipping__items2--content__desc">From handpicked sellers</p>
                        </div>
                    </div>
                    <div class="shipping__items2 d-flex align-items-center">
                        <div class="shipping__items2--icon">
                            <img src="assets/img/other/shipping3.png" alt="">
                        </div>
                        <div class="shipping__items2--content">
                            <h2 class="shipping__items2--content__title h3">Return</h2>
                            <p class="shipping__items2--content__desc">From handpicked sellers</p>
                        </div>
                    </div>
                    <div class="shipping__items2 d-flex align-items-center">
                        <div class="shipping__items2--icon">
                            <img src="assets/img/other/shipping4.png" alt="">
                        </div>
                        <div class="shipping__items2--content">
                            <h2 class="shipping__items2--content__title h3">Support</h2>
                            <p class="shipping__items2--content__desc">From handpicked sellers</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End shipping section -->

    </main>

    <!-- Start footer section -->
    <?php include('footer.php');?>
    <!-- End footer section -->

    <!-- Scroll top bar -->
    <button id="scroll__top"><svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M112 244l144-144 144 144M256 120v292"/></svg></button>

    
  <!-- All Script JS Plugins here  -->
  <!-- <script src="assets/js/vendor/popper.js" defer="defer"></script> -->
  <!-- <script src="assets/js/vendor/bootstrap.min.js" defer="defer"></script> -->
  
  <script src="assets/js/plugins/swiper-bundle.min.js"></script>
  <script src="assets/js/plugins/glightbox.min.js"></script>

  <!-- Customscript js -->
  <script src="assets/js/script.js"></script>
  
</body>

<!-- Mirrored from risingtheme.com/html/suruchi-demo/suruchi/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 31 Jul 2022 04:41:07 GMT -->
</html>