<?php
// At the beginning of events.php
session_start();

// Check if the user is logged in and has the 'admin' role
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    $isAdmin = true;
} else {
    $isAdmin = false;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Contact</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Roboto:100,300,400,500,700|Philosopher:400,400i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

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

    <!-- ======= Contact Section ======= -->
	<section id="contact-us" class="footer_section text-center">
      <div class="footer_section layout_padding">
            <div class="contact_taital"><center>Contact Now</center></div>
            <div class="contact_section">
               <div class="row">
                  <div class="col-lg-4 col-sm-12">
                     <div class="contact_main">
                        <form action="/action_page.php">
						<center>
                           <div class="form-group">
                              <input type="text" class="email-bt" placeholder="Name" name="Name">
                           </div>
                           <div class="form-group">
                              <input type="text" class="email-bt" placeholder="Email" name="Name">
                           </div>
                           <div class="form-group">
                              <input type="text" class="email-bt" placeholder="Phone Numbar" name="Email">
                           </div>
                           <div class="form-group">
                              <textarea class="massage-bt" placeholder="Massage" rows="5" id="comment" name="Massage"></textarea>
                           </div>
						   </center>
                        </form>
                        <div class="send_btn"><a href="#">SEND</a></div>
                     </div>
                  </div>
                  <div class="col-lg-8 col-sm-12">
                     <div class="map_main">
                        <div class="map-responsive">

                           <center><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d80626.82151629434!2d4.36301855!3d50.8387917!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c3c486740f9fff%3A0x10099ab2f4c8030!2zQnLDvGtzZWwsIEJlbMOnaWth!5e0!3m2!1str!2saz!4v1701102536593!5m2!1str!2saz" width="300" height="400" frameborder="0" style="border:0; width: 90%;" allowfullscreen=""></center></iframe>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
		</div>
	</div>
	</section>
  <!-- End #main -->
  <!-- ======= Footer ======= -->
  <footer class="footer">
    <div class="container">
      <div class="row">

        <div class="col-md-12 col-lg-4">
          <div class="footer-logo">

            <a class="navbar-brand" href="#">Christmas</a>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the.</p>

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

</body>

</html>