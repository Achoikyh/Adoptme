<?php
    
  
    session_start();
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
    <link rel="stylesheet" href="profile.css">
    
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
     
    </header>
    <main>
        <ul class="direct">
           
            <li><a href="/index.php">Home /</a></li>
            <li>My Profile</li>
          </ul>
          <div class="profile-container">
        <div class="profile">
            <ul class="profileList">
              <li>
                <a href="profile.php"
                  ><i class="icon"
                    ><ion-icon name="person-outline"></ion-icon></i>
                  My Profile</a
                >
              </li>
              
              <li>
                <a href="myannonce.php" onclick="window.location.href='myannonce.php';"
                  ><i class="icon"
                    ><ion-icon name="megaphone-outline"></ion-icon></i>
                  My annonce</a
                >
              </li>
              <li>
                <a href="my-received-forms.php" onclick="window.location.href='my-received-forms.php';"
                  ><i class="icon"
                    ><ion-icon name="clipboard-outline"></ion-icon></i>
                    my Received Forms</a
                >
              </li>
              <li>
                <a href="wishlist.php" onclick="window.location.href='wishlist.php';"
                  ><i class="icon"
                    ><ion-icon name="heart-outline"></ion-icon></i>
                  My Wishlist</a
                >
              </li>
             
              <li class="logout">
            <a href="logout.php">
                <i class="icon"><ion-icon name="power-outline"></ion-icon></i>
                Log Out
            </a>
        </li>
            </ul>
          
          </div>
       
          <section class="about-member">
          <h3>ABOUT</h3>
          <?php
include 'config.php';

// Assuming you have a session variable storing the current user's ID
// Replace 'user_id' with the session variable name if it's different
$user_id = $_SESSION['user_id'];
$sql = "SELECT user_name,user_email, user_phone, user_city,user_address,user_gender FROM member WHERE user_id ='$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of the member
    while($row = $result->fetch_assoc()) {
        echo '<div class="case"><h5>Full Name </h5><p>'.$row['user_name'].'</p></div>';
        echo '<div class="case"><h5>Email </h5><p>'.$row['user_email'].'</p></div>';
        echo '<div class="case"><h5>Gender </h5><p>'.$row['user_gender'].'</p></div>';
        echo '<div class="case"><h5>Phone </h5><p>'.$row['user_phone'].'</p></div>';
        echo '<div class="case"><h5>City </h5><p>'.$row['user_city'].'</p></div>';
        echo '<div class="case"><h5>Address</h5><p>'.$row['user_address'].'</p></div>';
    }
}
?>

        
                   
          </section>
          </div>
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