<?php
session_start();
include 'config.php'; // Include the database configuration file

$error = ''; // Variable to store form errors
$message = ''; // Variable to store success messages
$pub_id = isset($_GET['host_id']) ? $_GET['host_id'] : null;

// Function to fetch publication details by ID
function get_publication_details($conn, $pub_id) {
    $pub_id = mysqli_real_escape_string($conn, $pub_id);
    $query = "SELECT * FROM pub_host WHERE host_id = '$pub_id'";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

// Function to update publication details
function update_publication($conn, $pub_id, $anim_type, $anim_race,$anim_gender, $anim_description, $price, $date, $delay) {
    $pub_id = mysqli_real_escape_string($conn, $pub_id);

    $price = mysqli_real_escape_string($conn, $price);
    $date = mysqli_real_escape_string($conn, $date);
    $delay = mysqli_real_escape_string($conn, $delay);
    $anim_type = mysqli_real_escape_string($conn, $anim_type);
    $anim_race = mysqli_real_escape_string($conn, $anim_race);
    $anim_gender = mysqli_real_escape_string($conn, $anim_gender);
    $anim_description = mysqli_real_escape_string($conn, $anim_description);

    $update_query = "UPDATE pub_host SET 
    anim_type = '$anim_type', 
    anim_race = '$anim_race', 
    anim_gender = '$anim_gender', 
    anim_description = '$anim_description', 
    price = '$price', 
    date = '$date', 
    delay = '$delay'
    WHERE host_id = '$pub_id'";

    if (mysqli_query($conn, $update_query)) {
        return true; // Successful modification
    } else {
        return false; // Error during modification
    }
}

// Fetch publication details if pub_id is set
if (!empty($pub_id)) {
    $publication = get_publication_details($conn, $pub_id);
    if (!$publication) {
        $error = "Publication not found.";
    }
}

// Handle form submission
if (isset($_POST['update_submit'])) {
    $price = $_POST['price'] ?? '';
    $date = $_POST['date'] ?? '';
    $delay = $_POST['delay'] ?? '';
    $anim_type = $_POST['anim_type'] ?? '';
    $anim_race = $_POST['anim_race'] ?? '';
    $anim_gender = $_POST['anim_gender'] ?? '';
    $anim_description = $_POST['anim_description'] ?? '';

    if (update_publication($conn, $pub_id, $anim_type, $anim_race,$anim_gender, $anim_description, $price, $date, $delay)) {
        $message = "Announcement updated successfully.";
        // Fetch updated publication details
        $publication = get_publication_details($conn, $pub_id);
    } else {
        $error = "Error updating publication.";
    }
}
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
    <link rel="stylesheet" href="annonce.css">
    <link rel="shortcut icon" type="image/x-icon" href="image/logoh.png">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic" rel="stylesheet">
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
                <button class="nav-open-btn">
                    <ion-icon name="menu-outline"></ion-icon>
                </button>
                <form class="header-search-container" method="POST" action="index.php">
                    <input type="search" name="search" class="search-field" placeholder="Enter Animal name or type...">
                    <button class="search-btn" name="submit">
                        <ion-icon name="search-outline"></ion-icon>
                    </button>
                </form>
            </div>
            <?php 
            if (!isset($_SESSION['user_id'])) {
                echo '<div>
                        <button class="login-btn" onclick="window.location.href=\'signin-signup.php\';">log in</button>
                    </div>';
            } else {
                echo '<div>
                        <button class="login-btn" onclick="window.location.href=\'profile.php\';">profile</button>
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
                    <li><a class="active" href="#index.php" onclick="window.location.href='index.php';">HOME</a></li>
                    <li><a href="#adopt.html" onclick="window.location.href='adopt.html';">ADOPT</a></li>
                    <li class="name-list"><a>PUBLISH</a>
                        <div class="pub-list">
                        <?php 
                        if (!isset($_SESSION['user_id'])) {
                            echo '<ul>';
                            echo '<a href="#signin-signup.php" onclick="window.location.href=\'signin-signup.php\';"><li>ADOPTION</li></a>';
                            echo '<a href="#signin-signup.php" onclick="window.location.href=\'signin-signup.php\';"><li>HOSTING</li></a>';
                            echo '<a href="#signin-signup.php" onclick="window.location.href=\'signin-signup.php\';"><li>MISSING</li></a>';
                            echo '</ul>';
                        } else {
                            echo '<ul>';
                            echo '<a href="#pub-adoption.php" onclick="window.location.href=\'pub-adoption.php\';"><li>ADOPTION</li></a>';
                            echo '<a href="#pub-hosting.php" onclick="window.location.href=\'pub-hosting.php\';"><li>HOSTING</li></a>';
                            echo '<a href="#pub-missing.php" onclick="window.location.href=\'pub-missing.php\';"><li>MISSING</li></a>';
                            echo '</ul>';
                        }
                        ?>
                        </div>
                    </li>
                    <li><a href="#LOST.html" onclick="window.location.href='LOST.html';">LOST</a></li>
                    <li><a href="#ABOUT.html" onclick="window.location.href='ABOUT.html';">ABOUT</a></li>
                </ul>
            </div>
            <div class="header-user-actions">
                <?php 
                if (!isset($_SESSION['user_id'])) {
                    echo '<button class="action-btn" onclick="window.location.href=\'signin-signup.php\';">
                    <ion-icon name="person-outline"></ion-icon>
                </button>';
                    echo '<button class="action-btn" onclick="window.location.href=\'signin-signup.php\';">
                    <ion-icon name="heart-outline"></ion-icon>
                    <span class="count">0</span>
                </button>';
                    echo '<button class="action-btn" onclick="window.location.href=\'signin-signup.php\';">
                    <ion-icon name="megaphone-outline"></ion-icon>
                    <span class="count">0</span>
                </button>';
                } else {
                    echo '<button class="action-btn" onclick="window.location.href=\'profile.php\';">
                    <ion-icon name="person-outline"></ion-icon>
                </button>';
                    echo '<button class="action-btn" onclick="window.location.href=\'wishlist.php\';">
                    <ion-icon name="heart-outline"></ion-icon>
                    <span class="count">0</span>
                </button>';
                    echo '<button class="action-btn" onclick="window.location.href=\'myannonce.php\';">
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
    <h3 class="title-info">Annonce Request Hosting Form</h3>
    <form method="post" class="annonce-form" enctype="multipart/form-data">
        <?php if (!empty($message)): ?>
            <span id="massg"><?= htmlspecialchars($message) ?></span>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <span id="massg"><?= htmlspecialchars($error) ?></span>
        <?php endif; ?>
        <?php if (!empty($publication)): ?>
        <div class="partition">
            <div class="parrtion-info">
                <h5>Please enter your pet information</h5>
                <input type="text" placeholder="Enter your pet race" name="anim_race" class="anim-init" value="<?= htmlspecialchars($publication['anim_race']) ?>" required>
            </div>
            <div class="options">
                <h5>Enter your pet type</h5>
                <div class="check">
                    <select class="animals" name="anim_type">
                        <option value="cat" <?= $publication['anim_type'] == 'cat' ? 'selected' : '' ?>>Cat</option>
                        <option value="bird" <?= $publication['anim_type'] == 'bird' ? 'selected' : '' ?>>Bird</option>
                        <option value="rabbit" <?= $publication['anim_type'] == 'rabbit' ? 'selected' : '' ?>>Rabbit</option>
                        <option value="others" <?= $publication['anim_type'] == 'others' ? 'selected' : '' ?>>Others</option>
                    </select>
                    <div>
                        <h5>Enter your pet gender</h5>
                        <select class="animals" name="anim_gender">
                            <option value="male" <?= $publication['anim_gender'] == 'male' ? 'selected' : '' ?>>Male</option>
                            <option value="female" <?= $publication['anim_gender'] == 'female' ? 'selected' : '' ?>>Female</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <textarea name="anim_description" class="description" cols="80" rows="10" placeholder="Enter your animal description, needs"><?= htmlspecialchars($publication['anim_description']) ?></textarea>
        <div class="time-item">
            <h5>Enter the day of hosting:</h5>
            <input type="date" name="date" class="time" value="<?= htmlspecialchars($publication['date']) ?>" required>
            <h5>Enter duration of hosting:</h5>
            <input type="text" name="delay" class="time" placeholder="Enter duration" value="<?= htmlspecialchars($publication['delay']) ?>" required>
            <h5>Enter the offered price:</h5>
            <input type="text" name="price" class="time" placeholder="Enter price" value="<?= htmlspecialchars($publication['price']) ?>" required>
        </div>
        <input type="submit" class="publish" name="update_submit" value="Update">
        <?php else: ?>
        <p>No publication details found.</p>
        <?php endif; ?>
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
