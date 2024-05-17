<?php
session_start();
include 'config.php';
// send information to the whishlist table 

// send information to the formulaire table 
if (isset($_POST['adopt_submit'])) {
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    $pub_id = isset($_GET['host_id']) ? $_GET['host_id'] : null;
   

    if ($user_id) {
  
        $check_query = "SELECT * FROM hosting WHERE hosting_user_id = $user_id AND hosting_pub_id = $pub_id";
        $result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($result) > 0) {
        
    
            $_SESSION['adopt_message'] = "we aleardey sent your form to the pet owner .";
        } else {
           
            $insert_query = "INSERT INTO hosting (hosting_user_id, hosting_pub_id) VALUES ($user_id, $pub_id)";
            mysqli_query($conn, $insert_query);
            $_SESSION['adopt_message'] = "we sent your information to the owner .";
        }
    }
    
    

    header("Location: {$_SERVER['REQUEST_URI']}");
    exit();
}

// Check if there's any wishlist message to display
$wishlist_message = isset($_SESSION['wishlist_message']) ? $_SESSION['wishlist_message'] : null;
unset($_SESSION['wishlist_message']);
// Check if there's any adopt message to display
$adopt_message = isset($_SESSION['adopt_message']) ? $_SESSION['adopt_message'] : null;
unset($_SESSION['adopt_message']);
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

    <section class="section-container">
<?php
include 'config.php';

// Retrieve the pub_id from the session
$host_id = isset($_GET['host_id']) ? $_GET['host_id'] : null;

if ($host_id) {
    // Query the database to fetch the pub_adoption details based on pub_id
    $sql = "SELECT * FROM pub_host WHERE host_id = '$host_id'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $pub_host = $result->fetch_assoc();
        $user_id = $pub_host['user_id'];

        // Query the database to fetch the user details based on user_id
        $user_query = "SELECT * FROM member WHERE user_id = '$user_id'";
        $user_result = $conn->query($user_query);

        if ($user_result && $user_result->num_rows > 0) {
            $user = $user_result->fetch_assoc();

            // Display the pub_adoption details and user information within the HTML structure
            echo '<div class="card-container p1">';
            echo '<div class="single-anim-image">';
            echo '<img src="' . $pub_host['anim_image1'] . '" width="50%" class="mainimg" alt="">';
            echo '<div class="small-img-groupe">';
            echo '<div class="small-img-col">';
            echo '<img src="' . $pub_host['anim_image1'] . '" width="100%" class="small-img" alt="">';
            echo '</div>';
            echo '<div class="small-img-col">';
            echo '<img src="' . $pub_host['anim_image2'] . '" width="100%" class="small-img" alt="">';
            echo '</div>';
            echo '<div class="small-img-col">';
            echo '<img src="' . $pub_host['anim_image3'] . '" width="100%" class="small-img" alt="">';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '<div class="single-anim-details">';
            echo '<h6>' . $pub_host['anim_type'] . '</h6>';
            echo '<div class="adresse-container"><ion-icon name="pin-outline"></ion-icon><p class="adresse">' . $user['user_city'] . '</p></div>';
            echo '<div class="box-container">';
            echo '<div class="box">Gender <br> <strong>' . $pub_host['anim_gender'] . '</strong></div>';
            echo '<div class="box">Race <br> <strong>' . $pub_host['anim_race'] . '</strong></div>';
            echo '<div class="box"> delay <br> <strong> ' . $pub_host['delay'] . '</strong></div>';
            echo '<div class="box"> date<br> <strong>' . $pub_host['date'] . '</strong></div>';
            echo '</div>';
            echo '<h4>Pet details</h4>';
            echo '<p class="description">' . $pub_host['anim_description'] . '</p>';
            echo '<a href="tel:' . $user['user_phone'] . '" class="btn-link">';
            echo '<ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>';
            echo '<span>Get phone number </span>';
            echo '</a>';
            echo '<a href="mailto:' . $user['user_email'] . '" class="btn-link">';
            echo '<ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>';
            echo '<span>Get email address </span>';
            echo '</a>';

   
            echo '<div class="btn-container">';
        
            echo '<form method="post">';
            echo '<button class="btn" name="adopt_submit" >host Now</button>';
            echo '</form>';
            echo '</div>';
        
            if ($adopt_message) {
                echo '<span id="massg">' . $adopt_message . '</span>';
            }
            echo '</div>';
            echo '</div>';
        } else {
            echo "<h3>Error: User not found.</h3>";
        }
    } else {
        echo "<h3>Error: Publication not found.</h3>";
    }
} else {
    echo "<h3>Error: pub_id not found in session.</h3>";
}
?>
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
<script >

    document.addEventListener("DOMContentLoaded", function() {
        var mainimg = document.querySelector(".mainimg");
        var smallimg = document.querySelectorAll(".small-img");

        smallimg.forEach(function(img) {
            img.addEventListener('click', function() {
                var tempSrc = mainimg.src;
                mainimg.src = img.src;
                img.src = tempSrc;
            });
        });
    });
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