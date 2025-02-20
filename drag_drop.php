<?php
// At the beginning of events.php
session_start();

// Check if the user is logged in and has the 'admin' role
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
  $isAdmin = true;
} else {
  $isAdmin = false;
}

// Adatbázis kapcsolat létrehozása (példa)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "it_project";

// Kapcsolat létrehozása és ellenőrzése
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Lekérdezés az adatbázisból
$sql = "SELECT * FROM events"; // Példa lekérdezés, a táblanevet és az oszlopnevet az adatbázisodnak megfelelően módosítsd
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Drag and drop</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Roboto:100,300,400,500,700|Philosopher:400,400i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <!--<link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">-->
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <link href="assets/drag_drop/css/style.css" rel="stylesheet">

  <!-- =======================================================
    * Template Name: eStartup
    * Updated: Sep 18 2023 with Bootstrap v5.3.2
    * Template URL: https://bootstrapmade.com/estartup-bootstrap-landing-page-template/
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

      <div id="logo">
        <h1><a href="index.php">Kortrijk</a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" title="" /></a>-->
      </div>
      <?php
      $isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
      ?>
      <nav id="navbar" class="navbar">
        <ul>
        <li><a class="nav-link scrollto active" href="index.php">HOME</a></li>
              <li><a class="nav-link scrollto" href="events.php">EVENTS</a></li>
              <li><a class="nav-link scrollto" href="drag_drop.php">DRAG&DROP</a></li>
                <li><a class="nav-link scrollto" href="contact.php">CONTACT US</a></li>
                <li><div class="donate_bt"><a href="#">Donate Now</a></div></li>
              <?php if ($isLoggedIn): ?>
                  <li><a class="nav-link scrollto" href="logout.php">LOG OFF</a></li>
              <?php else: ?>
                  <li><a class="nav-link scrollto" href="login.php">LOGIN</a></li>
              <?php endif; ?>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero">
    <div id="marketWidth" ></div>
    <div id="marketHeight" ></div>
    <label>Select the event: </label>
    <select class="custom-select" id="eventSelect">
      <?php
      if ($result->num_rows > 0) {
        foreach ($result as $row) {
          if (isset($row["id"]) && isset($row["event_name"])) {
            echo "<option value='" . $row["id"] . "'>" . $row["event_name"] . "</option>";
          } else {
            echo "<option value=''>Missing data</option>";
          }
        }
      } else {
        echo "<option value=''>No data available</option>";
      }
      ?>
    </select>
    <button id="saveButton">Mentés</button>

    <!-- après le bouton de définition -->
    <p id="marketSize">
    </p>
  

    <button id="sendDataBtn">Send Data</button>

    <div id="container">
      <div id="market">
      </div>
      <div id="standsListContainer">
        <h2>
          Liste des stands
        </h2>
        <button onclick="createStandTypeButtons()">Create New Stand</button>
        <ul id="buttonList"></ul>
        <ul id="standsList">
        </ul>
      </div>
    </div>
  </section><!-- End Hero Section -->


  <!-- ======= Footer ======= -->
  <footer class="footer">
    <div class="container">
      <div class="row">

        <div class="col-md-12 col-lg-4">
          <div class="footer-logo">

            <a class="navbar-brand" href="#">Kortrijk</a>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
              industry's standard dummy text ever since the.</p>

          </div>
        </div>

        <div class="col-sm-6 col-md-3 col-lg-2">
          <div class="list-menu">

            <h4>About Us</h4>

            <ul class="list-unstyled">
              <li><a href="#">About us</a></li>
              <li><a href="#">Features item</a></li>
              <li><a href="#">Live streaming</a></li>
              <li><a href="#">Privacy Policy</a></li>
            </ul>

          </div>
        </div>

        <div class="col-sm-6 col-md-3 col-lg-2">
          <div class="list-menu">

            <h4>About Us</h4>

            <ul class="list-unstyled">
              <li><a href="#">About us</a></li>
              <li><a href="#">Features item</a></li>
              <li><a href="#">Live streaming</a></li>
              <li><a href="#">Privacy Policy</a></li>
            </ul>

          </div>
        </div>

        <div class="col-sm-6 col-md-3 col-lg-2">
          <div class="list-menu">

            <h4>Support</h4>

            <ul class="list-unstyled">
              <li><a href="#">faq</a></li>
              <li><a href="#">Editor help</a></li>
              <li><a href="#">Contact us</a></li>
              <li><a href="#">Privacy Policy</a></li>
            </ul>

          </div>
        </div>

        <div class="col-sm-6 col-md-3 col-lg-2">
          <div class="list-menu">

            <h4>About Us</h4>

            <ul class="list-unstyled">
              <li><a href="#">About us</a></li>
              <li><a href="#">Features item</a></li>
              <li><a href="#">Live streaming</a></li>
              <li><a href="#">Privacy Policy</a></li>
            </ul>

          </div>
        </div>

      </div>
    </div>

    <div class="copyrights">
      <div class="container">
        <p>&copy; Copyrights eStartup. All rights reserved.</p>
        <div class="credits">
          <!--
            All the links in the footer should remain intact.
            You can delete the links only if you purchased the pro version.
            Licensing information: https://bootstrapmade.com/license/
            Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=eStartup
          -->
          Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
      </div>
    </div>

  </footer><!-- End  Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="assets/drag_drop/js/drag_drop.js"></script>
</body>

</html>
