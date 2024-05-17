<?php
session_start(); // Start session if not already started
include 'config.php';

// Check if the form is submitted
if(isset($_POST['submit'])){
    // Retrieve the search term from the form
    $search = mysqli_real_escape_string($conn, $_POST['search']);

    // Perform a query based on the search term
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
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="search.css">
    <link rel="shortcut icon" type="image/x-icon" href="image/logoh.png"  />
   
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic" rel="stylesheet" />
    <title>Adopt Me</title>
</head>
<body>
  <div class="overlay" data-overlay></div>

 

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

        
        <div class="header2" >
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

 <div class="container">
      
  <div class="filter"></div>
      
                  <video class="banner-video" autoplay muted loop width="1500px">
                      <source src="image/catvd1.mp4" type="video/mp4" >
                  
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
    <section class="product1 p1">
      <h2>Find Your Pet</h2>
      <p>Responsible adoption changes the life of the animal as much as it changes yours.</p>
      <div class="pro-container">
  
       
        <?php
            // Start session if not already started
       

            // Check if search results are stored in the session
            if(isset($_SESSION['search_results'])){
                // Retrieve search results from the session
                $search_results = $_SESSION['search_results'];
                // Loop through the results and display them
                foreach($search_results as $row){
                    // Output the search results here
                    if(!isset($_SESSION['user_id'])) {
                    echo '<div class="pro" onclick="window.location.href=\'animal-card.php?pub_id='.$row['pub_id'].'\'">';
                    }else{
                      echo '<div class="pro" onclick="window.location.href=\'signin-signup.php\'">';
                    }

                    echo '<div class="insta-post-link">';
                    echo '<img src="'.$row['anim_image1'].'" alt="" class="img-cover">';
                    echo '</div>';
                    echo '<div class="card-bar">';
                    echo '<div>';
                    echo '<ion-icon name="male-outline"></ion-icon>';
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
                    if(!isset($_SESSION['user_id'])) {
                      echo '<a onclick="window.location.href=\'animal-card.php?pub_id='.$row['pub_id'].'\'">Adopt</a>';
                    }else{
                      echo '<a onclick="window.location.href=\'signin-signup.php\'">Adopt</a>';
                    }
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            }
          
            if(isset($_SESSION['no_results']) && $_SESSION['no_results'] === true) {
                echo '<div class="no-search-results">No search results available.</div>';
                unset($_SESSION['no_results']); // Clear the session variable
            }
            ?>
       
        </div>
     
  
 


 
  </section>
</div>
</div>

 <!-- 
        - #TESTIMONIALS
      -->

 
      
    </main>
    <footer class="p1">
      <div class="col">
          <img src="image/logo.png"  class="logo"alt="" width="190px" height="60px">
          <h4>contact</h4>
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
          <h4>About</h4>
          <a href="#">About Us</a>
          <a href="#">Delivery Information</a>
          <a href="#">Privacy Policy</a>
          <a href="#">Terms & Conditions</a>
          <a href="#">Contact Us</a>
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
<script>
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
</html>