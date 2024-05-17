
<?php
session_start();
include 'config.php'; // Assuming this file contains your database connection

$error = array(); // Initialize $error array

if(isset($_POST['publish'])) {
    // Get form data
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    
    // Fetch user data from database
    $query = "SELECT * FROM Member WHERE user_id='$user_id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    
    $user_phone = mysqli_real_escape_string($conn, $row['user_phone']);
    $user_name = mysqli_real_escape_string($conn, $row['user_name']);
    $email = mysqli_real_escape_string($conn, $row['user_email']);
    $user_address = mysqli_real_escape_string($conn, $row['user_address']);
    $anim_name = mysqli_real_escape_string($conn, $_POST['anim_name']);
    $anim_type = mysqli_real_escape_string($conn, $_POST['anim_type']);
    $anim_race = mysqli_real_escape_string($conn, $_POST['anim_race']);
    $anim_gender = mysqli_real_escape_string($conn, $_POST['anim_gender']);
    $anim_description = mysqli_real_escape_string($conn, $_POST['anim_description']);
    $anim_age = mysqli_real_escape_string($conn, $_POST['anim_age']);
    $anim_medication = mysqli_real_escape_string($conn, $_POST['anim_medication']);
  
    // Upload animal images
    $target_dir = "uploads/";
    $anim_images = array();
    $i = 0;
    for ($i = 0; $i < 3; $i++) {
     
        $anim_image = isset($_FILES["anim_image{$i}"]["name"]) ? $_FILES["anim_image{$i}"]["name"] : '';
        $anim_image_tmp = isset($_FILES["anim_image{$i}"]["tmp_name"]) ? $_FILES["anim_image{$i}"]["tmp_name"] : '';
    // Handle each image upload
    if (!empty($anim_image) && is_uploaded_file($anim_image_tmp)) {
        $target_file = $target_dir . basename($anim_image);
        if (move_uploaded_file($anim_image_tmp, $target_file)) {
            $anim_images[] = $target_file;
        } else {
            echo "Failed to upload image {$i}.";
            exit; // Stop execution if any image fails to upload
        }
    } else {
        echo "Please select image {$i}.";
        exit; // Stop execution if any image is not selected
    }

}

    // Insert pub_adoption into database
    $insert_query = "INSERT INTO pub_adoption (user_phone, user_name,user_address, anim_name, anim_type, anim_race,anim_gender, user_email, anim_description, anim_medication, anim_image1, anim_image2, anim_image3, anim_age, user_id_pub) 
                    VALUES ('$user_phone', '$user_name','$user_address', '$anim_name', '$anim_type', '$anim_race','$anim_gender', '$email', '$anim_description', '$anim_medication', '{$anim_images[0]}', '{$anim_images[1]}', '{$anim_images[2]}', '$anim_age', '$user_id')";
      
    if(mysqli_query($conn, $insert_query)) {
        $_SESSION['pub_message'] = "Publication published successfully.";
       
        
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
$pub_message = isset($_SESSION['pub_message']) ? $_SESSION['pub_message'] : null;
unset($_SESSION['pub_message']); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="animal-card.css">
    <link rel="stylesheet" href="pub-adoption.css">
    <link rel="shortcut icon" type="image/x-icon" href="image/logoh.png"  />
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic" rel="stylesheet" />
    <title>Adopt Me</title>
</head>
<body>
    <header>
        <div class="header-main">
        <div class="header1">
                <a href="#" class="header-logo">
                    <img src="image/logo.png" alt="" width="170px" height="45px">
                </a>
                <div>
                <button class="nav-open-btn" >
                        <ion-icon name="menu-outline"></ion-icon>
                    </button>
                <form class="header-search-container" method="POST" action="index.php">
               
                    <input type="search" name="search" class="search-field" placeholder="Enter Animal name or type...">
                    <button class="search-btn" name="submit">
                        <ion-icon name="search-outline"></ion-icon>
                    </button>
                    </div>
                </form>
                <?php 
           
            if(!isset($_SESSION['user_id'])) {
                // User is not logged in, show login button
                echo '<div>
                        <button class="login-btn" onclick="window.location.href=\'signin-signup.php\';">log in</button>
                    </div>';
            }else{
              echo '<div>
              <button class="login-btn"  onclick="window.location.href=\'profile.php\';">profile</button>
          </div>';
            }
            ?>
            </div>
            <div class="header2">
               
                <div>
                 
                    <button class="nav-close-btn" aria-label="Close Menu" data-nav-close-btn>
                        <ion-icon name="close-outline"></ion-icon>
                    </button>
                </div>
                <div>
                    <ul id="navbar">
                        <li><a  class="active" href="#index.php" onclick="window.location.href='index.php';">HOME</a></li>
                        <li><a  href="#adopt.php" onclick="window.location.href='adopt.php';" >ADOPT</a></li>
                        <li class="name-list"><a >PUBLISH</a>
                        <div class="pub-list">
                        <?php 
           
           if(!isset($_SESSION['user_id'])) {
            
            echo ' <ul>' ;
            echo ' <a  href="#signin-signup.php" onclick="window.location.href=\'signin-signup.php\';"><li>ADOPTION</li></a>' ;
            echo ' <a  href="#signin-signup.php" onclick="window.location.href=\'signin-signup.php\';"><li>HOSTING</li></a>' ;
            echo ' <a  href="#signin-signup.php" onclick="window.location.href=\'signin-signup.php\';"><li>MISSING</li></a>' ;
            echo ' </ul> ' ;
          }else{
            echo ' <ul>' ;
            echo ' <a  href="#pub-adoption.php" onclick="window.location.href=\'pub-adoption.php\';"><li>ADOPTION</li></a>' ;
            echo ' <a  href="#pub-hosting.php" onclick="window.location.href=\'pub-hosting.php\';"><li>HOSTING</li></a>' ;
            echo ' <a  href="#pub-missing.php" onclick="window.location.href=\'pub-missing.php\';"><li>MISSING</li></a>' ;
            echo ' </ul> ' ;
          }
          ?>
        </div>
                      </li>
                        <li><a  href="#missing.php" onclick="window.location.href='missing.php';">MISSING</a></li>
                        <li><a  href="#hosting.php" onclick="window.location.href='hosting.php';">HOSTING</a></li>
                    </ul>
                </div> 
                <div class="header-user-actions">
                <?php 
           
           if(!isset($_SESSION['user_id'])) {
               // User is not logged in, show login button
               echo '<button class="action-btn" onclick="window.location.href=\'signin-signup.php\';">
               <ion-icon name="person-outline"></ion-icon>
           </button>';
           echo '<button class="action-btn" onclick="window.location.href=\'signin-signup.php\';">
           <ion-icon name="heart-outline"></ion-icon>
           <span class="count">0</span>
       </button>';
       echo '
       <button class="action-btn"  onclick="window.location.href=\'signin-signup.php\';">
          <ion-icon name="megaphone-outline"></ion-icon>
           <span class="count">0</span>
       </button>';
           }else{
             echo '<button class="action-btn" onclick="window.location.href=\'profile.php\';">
             <ion-icon name="person-outline"></ion-icon>
         </button>';
         echo '<button class="action-btn" onclick="window.location.href=\'wishlist.php\';">
           <ion-icon name="heart-outline"></ion-icon>
           <span class="count">0</span>
       </button>';
       echo '
       <button class="action-btn"  onclick="window.location.href=\'myannonce.php\';">
          <ion-icon name="megaphone-outline"></ion-icon>
           <span class="count">0</span>
       </button>';
           }
           ?>
                </div>
            </div> 
        </div>
     
    </header>
    <main>
<section class="container-form">
    <h3 class="title-info">Annonce Request Adoption Form</h3>
        <form method="post" class="annonce-form" enctype="multipart/form-data" >
        <?php if ($pub_message) {
    echo '<span id="massg">' . $pub_message . '</span>';
}
?>
          <div class="partition">
            <div class="parrtion-info">
                <h5>please enter your pet information </h5>
            <input type="text" placeholder="enter your pet name " name="anim_name" class="anim-init" required>
          
            <input type="text" placeholder="enter your pet race " name="anim_race" class="anim-init" required>
            <input type="text" placeholder="enter your pet age" name="anim_age" class="anim-init" class="animage"  required>
          </div>
      
            <div class="options">
            <h5>enter your pet type </h5>
                <div class="check">
            
                
        <select class="animals" name="anim_type">
      
    <option id="option1" value="cat">Cat</option>
    <option id="option2" value="bird">Bird</option>
    <option id="option3" value="rabbit">Rabbit</option>
    <option id="option4" value="others">Others</option>
</select>
<div>
<h5>enter your pet gender </h5>
<select class="animals" name="anim_gender">

    <option id="option1" value="male">Male</option>
    <option id="option2" value="female">Female</option>
   
    
</select>
</div>
<div>
<h5>Medication</h5>
<select class="animals" name="anim_medication">

    <option id="option1" value="yes">Yes</option>
    <option id="option2" value="no">No</option>
   
    
</select>
</div>
</div>
    </div>
          </div>
          
            <textarea name="anim_description" class="description" cols="80" rows="10" placeholder="enter your animal medication and needs here . "></textarea>
            <h5>please select 3 pet images </h5>
            <div class="imgsection">
       <div class="imagebtn">
    
<input type="file" id="fileInput1" name="anim_image0" class="imageanim" style="display: none;" accept="image/*" onchange="displayFileName('fileInput1', 'fileInputLabel1')"  required>

<button type="button" id="fileInputLabel1" onclick="document.getElementById('fileInput1').click()">Choose first pet image</button>
</div>
<div class="imagebtn">
<input type="file" id="fileInput2" name="anim_image1" class="imageanim" style="display: none;" accept="image/*" onchange="displayFileName('fileInput2', 'fileInputLabel2')" required>


<button type="button" id="fileInputLabel2" onclick="document.getElementById('fileInput2').click()">Choose second pet image</button>
</div>
<div class="imagebtn">
<input type="file"  id="fileInput3" name="anim_image2" class="imageanim" style="display: none;" accept="image/*" onchange="displayFileName('fileInput3', 'fileInputLabel3')" required>


<button type="button" id="fileInputLabel3" onclick="document.getElementById('fileInput3').click()">Choose third pet image</button>
</div>
</div>
<input type="submit" class="publish" name="publish" value="publish">


        </form>
    </section>
    </main>
    <footer class="p1">
      <div class="col">
          <img src="image/logo.png"  class="logo"alt="" width="190px" height="60px">
          <h4>ABOUT</h4>
          <p><strong>Adress: </strong>médéa city , ouazera 2600</p>
          <p><strong>Phone: </strong>+213 00 00 00 00 / 025 00 00 00</p>
          <p><strong>Hours: </strong> 10:00 - 18:00, Mon - sat</p>
      
      <div class="follow ">
          <h4>Follow us </h4>
          <div class="icon">
              <ion-icon name="logo-facebook"></ion-icon>
              <ion-icon name="logo-twitter"></ion-icon>
              <ion-icon name="logo-instagram"></ion-icon>
              <ion-icon name="logo-pinterest"></ion-icon>
              <ion-icon name="logo-youtube"></ion-icon>

          </div>
      </div >
      </div>
      <div class="col">
          <h4>LOST</h4>
          <a href="#">LOST Us</a>
          <a href="#">Delivery Information</a>
          <a href="#">Privacy Policy</a>
          <a href="#">Terms & Conditions</a>
          <a href="#">ABOUT Us</a>
      </div>
      <div class="col">
          <h4>My Account </h4>
          <a href="#">Sign In</a>
          <a href="#">View profile</a>
          <a href="#">My wishlist</a>
          <a href="#">blog</a>
          <a href="#">Help</a>
      </div>
      <div class="col install">
          <h4>Install App</h4>
          <p>From App Store or Google Play</p>
          <div class="row">
              <img src="image/app.jpg" alt="">
              <img src="image/play.jpg" alt="">
          </div>
         
      </div>
  </footer>
    <script>
        function displayFileName(inputId, buttonId) {
            const input = document.getElementById(inputId);
            const button = document.getElementById(buttonId);
            if (input.files.length > 0) {
                button.textContent = input.files[0].name;
            } else {
                button.textContent = "Choose your image";
            }
       
       
   
};
const openBtn = document.querySelector('.nav-open-btn');
const nav = document.querySelector('.header2');
const closeBtn = document.querySelector('.nav-close-btn'); // Assuming you have a separate close button

if (openBtn) {
    openBtn.addEventListener('click', () => {
        nav.classList.add('active');
    });
}

if (closeBtn) {
    closeBtn.addEventListener('click', () => {
        nav.classList.remove('active');
    });
}
    </script>
   
</body>

</html>