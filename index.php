<?php
session_start(); // Start session
include 'config.php';
if (isset($_POST['found'])) {
  $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
  $miss_id = isset($_POST['miss_id']) ? $_POST['miss_id'] : null;


  if ($user_id) {
      // Check if the item is already in the wishlist
      $check_query = "SELECT * FROM formulaire WHERE user_id_form = $user_id AND miss_id = $miss_id";
      $result = mysqli_query($conn, $check_query);

      if (mysqli_num_rows($result) > 0) {
          // If it's in the wishlist, remove it
          $_SESSION['error_message'] = "we already sent your form to the pet owner.";
      } else {
          $insert_query = "INSERT INTO formulaire (user_id_form, miss_id) VALUES ($user_id, $miss_id)";
          mysqli_query($conn, $insert_query);
          $_SESSION['miss_message'] = "we sent your information to the owner.";
      }
  }

  header("Location: {$_SERVER['REQUEST_URI']}");
  exit();
  
}

// Check if there's any wishlist message to display
$miss_message = isset($_SESSION['miss_message']) ? $_SESSION['miss_message'] : null;
unset($_SESSION['miss_message']);

// Check if there's any adopt message to display
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : null;
unset($_SESSION['error_message']);

if(isset($_POST['submit'])){
  // Retrieve the search term from the form and sanitize it
  $search = mysqli_real_escape_string($conn, $_POST['search']);

  // Perform a query based on the search term for both tables
  $sql = "SELECT * FROM pub_adoption WHERE anim_name ='$search' OR anim_type ='$search' OR anim_race ='$search'";
  $result = mysqli_query($conn, $sql);
  // Check for errors
  if(!$result) {
      // Handle the error, for example:
      die('Error: ' . mysqli_error($conn));
  }

  // Check if there are any results
  $num = mysqli_num_rows($result);

  // Initialize an array to store search results
  $search_results = array();

  // Loop through the results and store them in the array
  while($row = mysqli_fetch_assoc($result)){
      $search_results[] = $row;
  }

  // Store the search results in a session variable
  $_SESSION['search_results'] = $search_results;

  // Check if there are search results
  if ($num > 0) {
      // Redirect to the new page to display the results
      header('location: reserch.php');
      exit(); // Terminate script execution after redirection
  } else {
      // No results found
      $_SESSION['no_results'] = true;
      header('location: reserch.php');
  }
}

 // Terminate script execution after redirection
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="missing.css">
    <link rel="stylesheet" href="index.css">
    
    <link rel="shortcut icon" type="image/x-icon" href="image/logoh.png"  />
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic" rel="stylesheet" />
    <title>Adopt Me</title>
</head>
<body>
    <div class="overlay" data-overlay></div>
    <div class="modal" data-modal>
        <div class="modal-close-overlay" data-modal-overlay></div>
        <div class="modal-content">
            <button class="modal-close-btn" data-modal-close>
                <ion-icon name="close-outline"></ion-icon>
            </button>
            <div class="newsletter-img">
                <img src="image/login.png" alt="subscribe newsletter" width="420" height="500">
            </div>
            <div class="newsletter">
                <div class="newsletter-header">
                    <h3 class="newsletter-title">Subscribe Newsletter.</h3>
                    <p class="newsletter-desc">
                        Subscribe the <b>Adopt Me </b> to get latest Adoption animals and updates.
                    </p>
                </div>
                <div action="POST">
                    <input type="email" name="email" class="email-field" placeholder="Email Address" required>
                    <button type="submit" class="btn-newsletter">Subscribe</button>
                </div>
            </div>
        </div>
    </div>
    <div class="notification-toast" data-toast>
        <button class="toast-close-btn" data-toast-close>
            <ion-icon name="close-outline"></ion-icon>
        </button>
        <div class="toast-banner">
            <img src="image/notification.png" alt="Rose Gold Earrings" width="80" height="70">
        </div>
        <div class="toast-detail">
            <p class="toast-message">Someone in new just adopt</p>
            <p class="toast-title">Female White Siamois</p>
            <p class="toast-meta">
                <time datetime="PT2M">2 Minutes</time> ago
            </p>
        </div>
    </div>
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
               
               <button class="nav-close-btn" >
                  <ion-icon name="close-outline"></ion-icon>
                </button>
                <div>
                    <ul id="navbar">
                                            <li><a  class="active" href="#index.php" onclick="window.location.href='index.php';" >HOME</a></li>
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
      
        <div class="container">
            <div class="filter"></div>
            <video class="banner-video" autoplay muted loop width="1500px">
                <source src="image/catvd.mp4" type="video/mp4" >
            </video>
            <div class="banner-content">
                <h2 class="banner-title">Your happiness is closer <br> than you think</h2>
                <div class="contact">
                    <ion-icon name="call-outline"></ion-icon>
                    <a href="tel" class="number">+213550510563</a>
                    <a href="#" class="banner-btn">Adopt now</a>
                </div>
            </div>
        </div>
    </header>


    <main>
       <!-- catalogue -->
       <section class="section service" id="service">
        <div class="container">

          <p class="section-subtitle">
            

            <span>CATALOGUE :</span>
          </p>

          <h2 class="h2 section-title">
            We Work Differently to <br><span>keep The World Safe</span>
          </h2>



          <ul class="service-list">

            <li>
              <div class="service-card">

                <div class="card-icon">
              <img src="image/caticon.png" alt="">
                </div>

                <h3 class="h3 card-title">Our Cats</h3>

                <p class="card-text">
                  Tempor incididunt ut labores
                  dolore magna suspene
                </p>

                <a href="#" class="btn-link">
                  <span>Show More</span>

                  <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
                </a>

              </div>
            </li>

            <li>
              <div class="service-card">

                <div class="card-icon">
                  <img src="image/birdicon.png" alt="">
                </div>

                <h3 class="h3 card-title">Our Birds</h3>

                <p class="card-text">
                  Tempor incididunt ut labores
                  dolore magna suspene
                </p>

                <a href="#" class="btn-link">
                  <span>Show More</span>

                  <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
                </a>

              </div>
            </li>

            <li>
              <div class="service-card">

                <div class="card-icon">
<img src="image/hamstericon.png" alt="">                </div>

                <h3 class="h3 card-title">Our hamsters</h3>

                <p class="card-text">
                  Tempor incididunt ut labores
                  dolore magna suspene
                </p>

                <a href="#" class="btn-link">
                  <span>Show More</span>

                  <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
                </a>

              </div>
            </li>

            <li>
              <div class="service-card">

                <div class="card-icon">
                 <img src="image/pawprintsicon.png" alt="">
                </div>

                <h3 class="h3 card-title">Other Animals</h3>

                <p class="card-text">
                  Tempor incididunt ut labores
                  dolore magna suspene
                </p>

                <a href="#" class="btn-link">
                  <span>Show More</span>

                  <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
                </a>

              </div>
            </li>

          </ul>

        </div>
      </section>
     <!-- animal minimal -->
  <div class="animal-minimal">

      <div class="animal-showcase">

        <h2 class="title">New Cats</h2>

        <div class="showcase-wrapper has-scrollbar">

          <div class="showcase-container">

            <div class="showcase">

              <a href="#" class="showcase-img-box">
                <img src="image/Ragdoll.png" alt="" width="70" class="showcase-img">
              </a>

              <div class="showcase-content">

                <a href="#">
                  <h4 class="showcase-title">Female Ragdoll</h4>
                </a>

            

                <div class="age-box">
                  <p class="age">3 Years old</p>
              
                </div>

              </div>

            </div>

            <div class="showcase">
            
              <a href="#" class="showcase-img-box">
                <img src="image/Black&White.png" width="70">
              </a>
            
              <div class="showcase-content">
            
                <a href="#">
                  <h4 class="showcase-title">Female Black&White</h4>
                </a>
            
           
            
                <div class="age-box">
                  <p class="age">1 Year and 5 Months old</p>
           
                </div>
            
              </div>
            
            </div>

            <div class="showcase">
            
              <a href="#" class="showcase-img-box">
                <img src="image/scottish Fold.png" class="showcase-img"
                  width="70">
              </a>
            
              <div class="showcase-content">
            
                <a href="#">
                  <h4 class="showcase-title">Male Scottish Fold</h4>
                </a>
            
          
            
                <div class="age-box">
                  <p class="age">4 Years old</p>
                  
                </div>
            
              </div>
            
            </div>

          

          </div>

          <div class="showcase-container">

            <div class="showcase">

              <a href="#" class="showcase-img-box">
                <img src="image/Ragdoll-Birman.png" alt="relaxed short full sleeve t-shirt" width="70" class="showcase-img">
              </a>

              <div class="showcase-content">

                <a href="#">
                  <h4 class="showcase-title">Male Ragdoll Birman</h4>
                </a>

            

                <div class="age-box">
                  <p class="age">2 Years old </p>
              
                </div>

              </div>

            </div>

            <div class="showcase">
            
              <a href="#" class="showcase-img-box">
                <img src="image/scottish fold (2).png" class="showcase-img" width="70">
              </a>
            
              <div class="showcase-content">
            
                <a href="#">
                  <h4 class="showcase-title">Female Scottish Fold</h4>
                </a>
            
           
            
                <div class="age-box">
                  <p class="age">4 Years Old</p>
           
                </div>
            
              </div>
            
            </div>

            <div class="showcase">
            
              <a href="#" class="showcase-img-box">
                <img src="image/tabby.jpeg" alt="black floral wrap midi skirt" class="showcase-img"
                  width="70">
              </a>
            
              <div class="showcase-content">
            
                <a href="#">
                  <h4 class="showcase-title">Female Tabby </h4>
                </a>
            
          
            
                <div class="age-box">
                  <p class="age">2 Months</p>
                  
                </div>
            
              </div>
            
            </div>

          

          </div>

        </div>

      </div>

      <div class="animal-showcase">

        <h2 class="title">New Rabbits</h2>

        <div class="showcase-wrapper has-scrollbar">

          <div class="showcase-container">

            <div class="showcase">

              <a href="#" class="showcase-img-box">
                <img src="image/female rex.jpg" alt="" width="70" class="showcase-img">
              </a>

              <div class="showcase-content">

                <a href="#">
                  <h4 class="showcase-title">Female Rex bunny</h4>
                </a>

            

                <div class="age-box">
                  <p class="age">2 Years old </p>
              
                </div>

              </div>

            </div>

            <div class="showcase">
            
              <a href="#" class="showcase-img-box">
                <img src="image/flemish giant.jpg" alt="" class="showcase-img" width="70">
              </a>
            
              <div class="showcase-content">
            
                <a href="#">
                  <h4 class="showcase-title">Male Flemish Giant bunny </h4>
                </a>
            
           
            
                <div class="age-box">
                  <p class="age">3 Years old </p>
           
                </div>
            
              </div>
            
            </div>

            <div class="showcase">
            
              <a href="#" class="showcase-img-box">
                <img src="image/fluffy bunny.jpeg" alt="black floral wrap midi skirt" class="showcase-img"
                  width="70">
              </a>
            
              <div class="showcase-content">
            
                <a href="#">
                  <h4 class="showcase-title">Pair of Female Fluffy bunny</h4>
                </a>
            
          
            
                <div class="age-box">
                  <p class="age">1 Years </p>
                  
                </div>
            
              </div>
            
            </div>

          

          </div>

          <div class="showcase-container">

            <div class="showcase">

              <a href="#" class="showcase-img-box">
                <img src="image/lop eared bunny.jpg" width="70" class="showcase-img">
              </a>

              <div class="showcase-content">

                <a href="#">
                  <h4 class="showcase-title">Male Lop Eared Bunny </h4>
                </a>

            

                <div class="age-box">
                  <p class="age">5 Years old </p>
              
                </div>

              </div>

            </div>

            <div class="showcase">
            
              <a href="#" class="showcase-img-box">
                <img src="image/male dutch.jpg" alt="" class="showcase-img" width="70">
              </a>
            
              <div class="showcase-content">
            
                <a href="#">
                  <h4 class="showcase-title">Male Dutch Bunny</h4>
                </a>
            
           
            
                <div class="age-box">
                  <p class="age">6 Years old </p>
           
                </div>
            
              </div>
            
            </div>

            <div class="showcase">
            
              <a href="#" class="showcase-img-box">
                <img src="image/newzealand white.jpeg" class="showcase-img"
                  width="70">
              </a>
            
              <div class="showcase-content">
            
                <a href="#">
                  <h4 class="showcase-title">White Male Newzealand Bunny </h4>
                </a>
            
          
            
                <div class="age-box">
                  <p class="age">6 Years and 2 Months old </p>
                  
                </div>
            
              </div>
            
            </div>

          

          </div>

        </div>

      </div>

      <div class="animal-showcase">

        <h2 class="title">New birds</h2>

        <div class="showcase-wrapper has-scrollbar">

          <div class="showcase-container">

            <div class="showcase">

              <a href="#" class="showcase-img-box">
                <img src="image/canary.png" alt="" width="70" class="showcase-img">
              </a>

              <div class="showcase-content">

                <a href="#">
                  <h4 class="showcase-title">Female Canary </h4>
                </a>

            

                <div class="age-box">
                  <p class="age">2 Years old </p>
              
                </div>

              </div>

            </div>

            <div class="showcase">
            
              <a href="#" class="showcase-img-box">
                <img src="image/Cockatiel.webp" alt="" class="showcase-img" width="70">
              </a>
            
              <div class="showcase-content">
            
                <a href="#">
                  <h4 class="showcase-title">Male Cockatiel Bird </h4>
                </a>
            
           
            
                <div class="age-box">
                  <p class="age">6 Years old </p>
           
                </div>
            
              </div>
            
            </div>

            <div class="showcase">
            
              <a href="#" class="showcase-img-box">
                <img src="image/Gold finsh.jpg" alt="black floral wrap midi skirt" class="showcase-img"
                  width="70">
              </a>
            
              <div class="showcase-content">
            
                <a href="#">
                  <h4 class="showcase-title">Couple Of Gold Finsh</h4>
                </a>
            
          
            
                <div class="age-box">
                  <p class="age">6 Years old </p>
                  
                </div>
            
              </div>
            
            </div>

          

          </div>

          <div class="showcase-container">

            <div class="showcase">

              <a href="#" class="showcase-img-box">
                <img src="image/kanariefugl-660x330.jpg" alt="relaxed short full sleeve t-shirt" width="70" class="showcase-img">
              </a>

              <div class="showcase-content">

                <a href="#">
                  <h4 class="showcase-title">3 Canary Birds</h4>
                </a>

            

                <div class="age-box">
                  <p class="age">3 Years and 6 Months old  </p>
              
                </div>

              </div>

            </div>

            <div class="showcase">
            
              <a href="#" class="showcase-img-box">
                <img src="image/lovebird.jpg" alt="girls pink embro design top" class="showcase-img" width="70">
              </a>
            
              <div class="showcase-content">
            
                <a href="#">
                  <h4 class="showcase-title">couple of a love Bird </h4>
                </a>
            
           
            
                <div class="age-box">
                  <p class="age">2 Years Old - 3 Years Old </p>
           
                </div>
            
              </div>
            
            </div>

            <div class="showcase">
            
              <a href="#" class="showcase-img-box">
                <img src="image/robin bird.jpg" alt="" class="showcase-img"
                  width="70">
              </a>
            
              <div class="showcase-content">
            
                <a href="#">
                  <h4 class="showcase-title">Female Robin Bird </h4>
                </a>
            
          
            
                <div class="age-box">
                  <p class="age">9 Months Old </p>
                  
                </div>
            
              </div>
            
            </div>

          

          </div>

        </div>

      </div>

    </div>
    <div class="anim">
      
    <div class="container-anim">
      <div class="sidebar" data-mobile-menu>

        <div class="sidebar-category">

          <div class="sidebar-top">
            <h2 class="sidebar-title">Category</h2>

            <button class="sidebar-close-btn" data-mobile-menu-close-btn>
              <ion-icon name="close-outline"></ion-icon>
            </button>
          </div>

          <ul class="sidebar-menu-category-list">

            <li class="sidebar-menu-category">

              <button class="sidebar-accordion-menu" data-accordion-btn>

                <div class="menu-title-flex">
                <div>
                  <img src="image/caticon.png" alt="cat" width="20" height="20"
                    class="menu-title-img">
                  </div>
                <div>
                  <p class="menu-title">Cats</p>
                </div>
              </div>

                <div>
                  <ion-icon name="add-outline" class="add-icon"></ion-icon>
                  <ion-icon name="remove-outline" class="remove-icon"></ion-icon>
                </div>
             
              </button>

              <ul class="sidebar-submenu-category-list" data-accordion>

                <li class="sidebar-submenu-category">
                  <a href="#" class="sidebar-submenu-title">
                    <p class="product-name">regdoll</p>
                 
                  </a>
                </li>

                <li class="sidebar-submenu-category">
                  <a href="#" class="sidebar-submenu-title">
                    <p class="product-name">scottish Fold</p>
                    
                  </a>
                </li>

                <li class="sidebar-submenu-category">
                  <a href="#" class="sidebar-submenu-title">
                    <p class="product-name">Black&White</p>
                  
                  </a>
                </li>

               

              </ul>

            </li>

            <li class="sidebar-menu-category">

              <button class="sidebar-accordion-menu" data-accordion-btn>

                <div class="menu-title-flex">
                  <div>
                  <img src="image/birdicon.png" alt="birds" class="menu-title-img" width="20"
                    height="20">
                  </div>
                <div>
                  <p class="menu-title">Birds</p>
                </div>
              </div>

                <div>
                  <ion-icon name="add-outline" class="add-icon"></ion-icon>
                  <ion-icon name="remove-outline" class="remove-icon"></ion-icon>
                </div>
            
              </button>

              <ul class="sidebar-submenu-category-list " data-accordion>

                <li class="sidebar-submenu-category">
                  <a href="#" class="sidebar-submenu-title">
                    <p class="product-name">canary</p>
                  
                  </a>
                </li>

                <li class="sidebar-submenu-category">
                  <a href="#" class="sidebar-submenu-title">
                    <p class="product-name">Cockatiel</p>
                 
                  </a>
                </li>

                <li class="sidebar-submenu-category">
                  <a href="#" class="sidebar-submenu-title">
                    <p class="product-name">Gold finsh</p>
                 
                  </a>
                </li>

               

              </ul>

            </li>

            <li class="sidebar-menu-category">

              <button class="sidebar-accordion-menu" data-accordion-btn>

                <div class="menu-title-flex">
                <div>
                  <img src="image/hamstericon.png" alt="clothes" class="menu-title-img" width="20"
                    height="20">
                  </div>
                <div>
                  <p class="menu-title">Hamster</p>
                </div>
              </div>

                <div>
                  <ion-icon name="add-outline" class="add-icon"></ion-icon>
                  <ion-icon name="remove-outline" class="remove-icon"></ion-icon>
                </div>
              
              </button>

              <ul class="sidebar-submenu-category-list" data-accordion>

                <li class="sidebar-submenu-category">
                  <a href="#" class="sidebar-submenu-title">
                    <p class="product-name">guinea-pig</p>
                    
                  </a>
                </li>

                <li class="sidebar-submenu-category">
                  <a href="#" class="sidebar-submenu-title">
                    <p class="product-name">Syrian-Golden</p>
                  
                  </a>
                </li>

                <li class="sidebar-submenu-category">
                  <a href="#" class="sidebar-submenu-title">
                    <p class="product-name">White-legged</p>
                   
                  </a>
                </li>

              </ul>

            </li>

            <li class="sidebar-menu-category">

              <button class="sidebar-accordion-menu" data-accordion-btn>

                <div class="menu-title-flex">
                <div>
                  <img src="image/rabbiticon.png" alt="perfume" class="menu-title-img" width="20"
                    height="20">
                  </div>
                <div>
                  <p class="menu-title">Bunnies</p>
                </div>
              </div>

                <div>
                  <ion-icon name="add-outline" class="add-icon"></ion-icon>
                  <ion-icon name="remove-outline" class="remove-icon"></ion-icon>
                </div>
              
              </button>

              <ul class="sidebar-submenu-category-list" data-accordion>

                <li class="sidebar-submenu-category">
                  <a href="#" class="sidebar-submenu-title">
                    <p class="product-name">rex</p>
                    
                  </a>
                </li>

                <li class="sidebar-submenu-category">
                  <a href="#" class="sidebar-submenu-title">
                    <p class="product-name">flemish giant</p>
                  
                  </a>
                </li>

                <li class="sidebar-submenu-category">
                  <a href="#" class="sidebar-submenu-title">
                    <p class="product-name">Fluffy-Bunny</p>
                  
                  </a>
                </li>

                <li class="sidebar-submenu-category">
                  <a href="#" class="sidebar-submenu-title">
                    <p class="product-name">Lop Eared Bunny</p>
                   
                  </a>
                </li>

              </ul>

            </li>

           

           

           

          </ul>

        </div>

      

      </div>
      <div class="section">
    <section class="product1 p1">
 
      
      <h2>Adopt a Pet</h2>
      <p>Responsible adoption changes the life of the animal as much as it changes yours.</p>
      <div class="pro-container">
        
       
<?php
include 'config.php';

// Assuming you have a session variable storing the current user's ID
// Replace 'user_id' with the session variable name if it's different

// Query to select publications from the wishlist of the connected user along with user information
$sql = "SELECT * FROM pub_adoption";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
     
           
      if(isset($_SESSION['user_id'])) {
        echo '<div class="pro" onclick="window.location.href=\'animal-card.php?pub_id='.$row['pub_id'].'\'">';
      }else{
        echo '<div class="pro" onclick="window.location.href=\'signin-signup.php\'">';
      }
        echo '<div class="insta-post-link">';
        echo '<img src="'.$row['anim_image1'].'" alt="" class="img-cover">';
        echo '</div>';
        echo '<div class="card-bar">';
        echo '<div>'; 
    
        if($row['anim_gender']=="male") {
        
        echo '<ion-icon name="male-outline"></ion-icon>';
      }elseif($row['anim_gender']=="female") {      
        echo '<ion-icon name="female-outline"></ion-icon>';
      }
    
        echo '</div>';
        echo '<div class="heart">';
        echo '<a href="#"><ion-icon name="heart-outline"></ion-icon></a>';
        echo '</div>';
        echo '</div>';
        echo '<div class="des">';
        echo '<div>';
        echo '<span>'.$row['anim_type'].'</span>';
        echo '<h5>'.$row['anim_name'].'</h5>';
        echo '</div>';
        echo '<div>';
        if(isset($_SESSION['user_id'])) {
        echo '<a onclick="window.location.href=\'animal-card.php?pub_id='.$row['pub_id'].'\'">Adopt</a>';
       }else{
        echo '<a onclick="window.location.href=\'signin-signup.php\'">Adopt</a>';
      }
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "<h3>There are no pets to adopt</h3>";
}
?>


   

  </div>
 
 
  </section>
  <section class="product1 p1">
 
      
 <h2>Earn Money From Hosting Pets</h2>
 <p>New Adventures Are Waiting.</p>
 <div class="pro-container">
   
  
<?php
include 'config.php';

// Assuming you have a session variable storing the current user's ID
// Replace 'user_id' with the session variable name if it's different

// Query to select publications from the wishlist of the connected user along with user information
$sql = "SELECT * FROM pub_host";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
// Output data of each row
while($row = $result->fetch_assoc()) {
  if(isset($_SESSION['user_id'])) {
    echo '<div class="pro" onclick="window.location.href=\'host-card.php?host_id='.$row['host_id'].'\'">';
  }else{
    echo '<div class="pro" onclick="window.location.href=\'signin-signup.php\'">';
  }
   echo '<div class="insta-post-link">';
   echo '<img src="'.$row['anim_image1'].'" alt="" class="img-cover">';
   echo '</div>';
   echo '<div class="card-bar">';
   echo '<div>'; 

   if($row['anim_gender']=="male") {
   
   echo '<ion-icon name="male-outline"></ion-icon>';
 }elseif($row['anim_gender']=="female") {      
   echo '<ion-icon name="female-outline"></ion-icon>';
 }

   echo '</div>';
   echo '<div class="heart">';
   echo '<a href="#"><ion-icon name="heart-outline"></ion-icon></a>';
   echo '</div>';
   echo '</div>';
   echo '<div class="des">';
   echo '<div>';
   echo '<span>'.$row['delay'].'</span>';
  
   echo '<h5>'.$row['price'].'</h5>';
   echo '</div>';
   echo '<div>';
   if(isset($_SESSION['user_id'])) {
   echo '<a onclick="window.location.href=\'host-card.php?host_id='.$row['host_id'].'\'">Host</a>';
  } else{
    echo '<a onclick="window.location.href=\'signin-signup.php\'">Host</a>';
  }
   echo '</div>';
   echo '</div>';
   echo '</div>';
}
} else {
echo "<h3>There are no pets to host</h3>";
}
?>




</div>


</section>
<section class="produc p1">
 
      
 <h2>Find Your Pet</h2>
 <p>We Work To Keep Your Pet Safe .</p>
 <div class="pro-container">
 <?php
include 'config.php';
if ( $miss_message) {
echo '<span id="done">' .  $miss_message . '</span>';
}else{
echo '<span id="done">' .  $error_message . '</span>';
}
// Assuming you have a session variable storing the current user's ID
// Replace 'user_id' with the session variable name if it's different

// Query to select publications from the wishlist of the connected user along with user information
$sql = "SELECT * FROM pub_missing";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
// Output data of each row
while($row = $result->fetch_assoc()) {
 echo '<div  class="lost-anim">';
   echo '<div class="miss-annonce">';
   echo '<div class="single-anim-image">';
   echo '<img src="' . $row['anim_image1'] . '" width="70%" class="mainimg" alt="">';
   echo '</div>';
   echo '<div class="miss-info">';
   echo '<h3>missing at' . $row['user_city'] . '</h3>';
 
   echo '<div class="info-anim">';
   echo '<ion-icon name="female-outline"></ion-icon>';
   echo '<h5>' . $row['anim_name'] . '</h5>';
   echo '<h5>' . $row['anim_race'] . '</h5>';
   echo '<h5>' . $row['anim_type'] . '</h5>';
   echo '</div>';
   echo '<div class="owner-info">';
   echo '<div class="field">';
   echo '<ion-icon name="person-outline"></ion-icon><h5>owner name : ' . $row['user_name'] . '</h5>';
   echo '</div>';
   echo '<div class="field">';
   echo '<ion-icon name="call-outline"></ion-icon><h5>phone: ' . $row['user_phone'] . '</h5>';
   echo '</div>';
   echo '<div class="field">';
   echo '<ion-icon name="mail-outline"></ion-icon><h5>email: ' . $row['user_email'] . '</h5>';
   echo '</div>';
   echo '</div>';
   echo '<div class="date-info">';
   echo '<ion-icon name="calendar-outline"></ion-icon><h5>Last seen : ' . $row['date'] . '</h5>';
   echo '</div>';
   echo '<div class="found-btn">';
   echo '<form method="post">';
   echo '<input type="submit" name="found" value="I found " class="login-btn">';
   echo '<input type="hidden" name="miss_id" value="'. $row['miss_id'] .'">';
   echo '</form>';

   echo '</div>';
   echo '</div>';
   echo '</div>';
}
}
?>

</div>
</section>
</div>
</div>
</div>
<section class="section donate" id="donate">
  <div class="container">

    <ul class="donate-list">

      <li>
       

          <figure class="card-banner">
            <img src="image/street cat 1.jpg" width="520" height="325"  alt="Elephant"
              class="img-cover">
          </figure>

       

       
        <div class="card-content">

          <div class="progress-wrapper">
            <p class="progress-text">
              <span>Raised</span>

              <data value="256">$256</data>
            </p>
            <data class="progress-value" value="83">83%</data>
          </div>

          <div class="progress-box">
            <div class="progress"></div>
          </div>

          <h3 class="h3 card-title">Raise Hand To Save Animals</h3>

          <div class="card-wrapper">

            <p class="card-wrapper-text">
              <span>Goal</span>

              <data class="green" value="34562">$34562</data>
            </p>

            <p class="card-wrapper-text">
              <span>Raise</span>

              <data class="yellow" value="562">$562</data>
            </p>

            <p class="card-wrapper-text">
              <span>To Go</span>

              <data class="cyan" value="864">$864</data>
            </p>

          </div>

          <button class="btn btn-secondary">
            <span>Donation</span>

            <ion-icon name="heart-outline" aria-hidden="true"></ion-icon>
          </button>

        </div>
      </li>

      <li>
      
        <div class="donate-card">

          <figure class="card-banner">
            <img src="image/street cat2.jpg" width="520" height="325"  alt="cat"
              class="img-cover">
          </figure>

        
        </div>
        <div class="card-content">

          <div class="progress-wrapper">
            <p class="progress-text">
              <span>Raised</span>

              <data value="256">$256</data>
            </p>

            <data class="progress-value" value="83">83%</data>
          </div>

          <div class="progress-box">
            <div class="progress"></div>
          </div>

          <h3 class="h3 card-title">Raise Hand To Save Animals</h3>

          <div class="card-wrapper">

            <p class="card-wrapper-text">
              <span>Goal</span>

              <data class="green" value="34562">$34562</data>
            </p>

            <p class="card-wrapper-text">
              <span>Raise</span>

              <data class="yellow" value="562">$562</data>
            </p>

            <p class="card-wrapper-text">
              <span>To Go</span>

              <data class="cyan" value="864">$864</data>
            </p>

          </div>

          <button class="btn">
            <span>Donation</span>

            <ion-icon name="heart-outline" aria-hidden="true"></ion-icon>
          </button>

        </div>

      </li>

    

 

    </ul>
    

  </div>
  
</section>
 <!-- 
        - #TESTIMONIALS
      -->

      <section class="testi">

        <div class="testi-content">

      

          <h2 class="h2 section-title">
            What People Say LOST <strong>Our Organization</strong>
          </h2>

          <div class="testi-card">

            <figure class="card-avatar">
              <img src="image/testi-avatar.png" width="60" height="60"  alt="David S. Neuman">
              <h3 class="testi-name">David S. Neuman</h3>
            </figure>

            <div>
              <blockquote class="testi-text">
                Sed ut perspiciatis unde omnis iste natus error voluptatem accusantium doloremque laudantium totam rem
                aperiam eaquesa
                quae abillo inventore veritatis quasi architecto beatae vitae dicta sunt explicabo enimpsam voluptatem
              </blockquote>

           

            </div>

          </div>

        </div>

      
        <img class="cattest-img" src="image/owner-petting-adorable-cat.jpg" alt="">
        

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
</body>
<script src="index.js"></script>
</html>