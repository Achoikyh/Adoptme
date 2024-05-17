<?php
session_start(); // Start session if not already started
include 'config.php'; 

$error = array(); 

if(isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']);

    $select = "SELECT * FROM member WHERE user_name='$username' AND user_password='$password'";
    $result = mysqli_query($conn, $select);

    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
       
            $_SESSION['user_id'] = $row['user_id'];
            header('location:index.php');
    } else {
        
        $error[] = 'Incorrect email or password!'; 
     
    }
    
   
}

if(isset($_POST['submit_signup'])) { // Changed 'submit' to 'submit_signup' to distinguish from login form
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = md5($_POST['password']); 
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $address= mysqli_real_escape_string($conn, $_POST['address']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    $select = "SELECT * FROM member WHERE user_name='$username' OR user_email='$email'";
    $result = mysqli_query($conn, $select);

    if(mysqli_num_rows($result) > 0) {
      
        $error[] = 'User already exists!'; 
       
    } else {
        $insert = "INSERT INTO member (user_name, user_email, user_password, user_phone , user_city, user_gender, user_address) VALUES ('$username', '$email', '$password', '$phone', '$city', '$gender', '$address')";
        mysqli_query($conn, $insert);
        $row = mysqli_fetch_array($result);
        $_SESSION['user_id'] = $row['user_id'];
        header('location:signin-signup.php');
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="styles.css">
    <link rel="shortcut icon" type="image/x-icon" href="image/logoh.png"  />
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic" rel="stylesheet" />
    <title>signin-signup</title>
</head>

<body>
    <div class="container">
    <div class="imagehead">
            <img src="image\owner.png" alt="" class="">
            </div>
        <div class="signin-signup">
       
            <form action="" method="post" class="sign-in-form">
                <h2 class="title">Sign in</h2>
                <?php
                if(!empty($error)) {
                    foreach($error as $error_message) {
                        echo '<span id="error">' . $error_message . '</span>';
                    }
                }
                ?>
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" id="password" placeholder="Password" required>
                 

                </div>
                <input type="submit" value="Login" name="submit" class="btn">
                <p class="social-text">Or Sign in with social platform</p>
                <div class="social-media">
                    <a href="#" class="social-icon">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="" class="social-icon">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="" class="social-icon">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
                <p class="account-text">Don't have an account? <a href="#" id="sign-up-btn2">Sign up</a></p>
            
            </form>
           
            <form action="" method="post" class="sign-up-form">
                <h2 class="title">Sign up</h2>
                <?php
                if(!empty($error)) {
                    foreach($error as $error_message) {
                        echo '<span id="error">' . $error_message . '</span>';
                    }
                
                  
                }
                ?>
                <div class="list">
                <div class="gauche">
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" placeholder="Username">
                </div>
                <div class="input-field">
                    <i class="fas fa-envelope"></i>
                    <input type="text" name="email" placeholder="Email">
                </div>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Password">
                </div>
                </div>
             
               
                <div class="droit">
                <div class="" class="none">
               
                    <select class="input-field" name="gender">

<option id="option1" value="male">Male</option>
<option id="option2" value="female">Female</option>


</select>
                </div>
                <div class="input-field">
                <ion-icon name="earth"></ion-icon>
                    <input type="text" name="city" placeholder="City">
                </div>
                <div class="input-field">
                <ion-icon name="location"></ion-icon>
                    <input type="text" name="address" placeholder="full address">
                </div>
                </div>
            </div>
            <div class="input-field" class="move">
                <i class="fas fa-phone"></i>
                <input type="tel" name="phone" placeholder="Phone number">
            </div>
                <input type="submit" value="Sign up" name="submit_signup" class="btn">
                <p class="social-text">Or Sign up with social platform</p>
                               <div class="social-media">
                    <a href="#" class="social-icon">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="" class="social-icon">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="" class="social-icon">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
                <p class="account-text">Already have an account? <a href="#" id="sign-in-btn2">Sign in</a></p>

            </form>
        </div>
        <!-- Panels container -->
        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>New here?</h3>
                    <p>Join And Discover The Best <br> In Your Location</p>
                    <button class="btn" id="sign-in-btn">Sign in</button>
                </div>
                <img src="image\owner.png" alt="" class="image">
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>New here?</h3>
                    <p>Join And Discover The Best <br> In Your Location</p>
                    <button class="btn" id="sign-up-btn">Sign up</button>
                </div>
                <img src="image\owner.png" alt="" class="image">
            </div>
        </div>
    </div>
    <script src="signin-signup.js"></script>
</body>

</html>
