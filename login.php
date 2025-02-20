<?php
session_start();

// Connect to the database
$host = '127.0.0.1';
$port = '3306';
$db   = 'it_project';
$user = 'root';
$pass = ''; 
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Error, couldn't connect to database: " . $e->getMessage());
}

// If the user has a "remembered" email from a cookie, pre-fill it
$rememberedEmail = isset($_COOKIE['remember_email']) ? $_COOKIE['remember_email'] : '';

// Process the login form
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password']; // raw password entered by the user

    // Fetch the user by email only
    $stmt = $pdo->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Password is correct, log the user in
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role']; // Assuming 'role' is a column in the user table

        // If remember me is checked, store the email in a cookie
        if (isset($_POST['remember_me'])) {
            $month = time() + (3600 * 24 * 30); // 30 days
            setcookie('remember_email', $email, $month, '', '', false, true);
        } else {
            // If 'remember me' not checked, remove the cookie if it exists
            if (isset($_COOKIE['remember_email'])) {
                setcookie('remember_email', '', time() - 3600);
            }
        }

        header('Location: index.php');
        exit();
    } else {
        // Invalid credentials
        $error = "Email or password is incorrect! Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login</title>
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
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

      <div id="logo">
        <h1><a href="index.php">Kortrijk</a></h1>
      </div>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="index.php">HOME</a></li>
          <li><a class="nav-link scrollto" href="events.php">EVENTS</a></li>
          <li><a class="nav-link scrollto" href="drag_drop.php">DRAG&DROP</a></li>
          <li><a class="nav-link scrollto" href="contact.php">CONTACT US</a></li>
          <li><div class="donate_bt"><a href="#">Donate Now</a></div></li>
          <li><a class="nav-link scrollto" href="login.php">LOGIN</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->
  
  <!-- login section start -->
  <section class="gradient-custom">
    <div class="container py-5 h-60">
      <p class="text-white">hidden</p>
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card bg-dark text-white" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">

              <div class="mb-md-5 mt-md-4 pb-5">

                <h2 class="fw-bold mb-2 text-uppercase text-white">Login</h2>
                <p class="text-white-50 mb-5">Please enter your email and password!</p>
                
                <form action="" method="post">
                  <div class="form-group mb-3">
                      <label for="email">Email</label>
                      <input type="text" name="email" id="email" class="form-control" required value="<?php echo htmlspecialchars($rememberedEmail, ENT_QUOTES); ?>">
                  </div>
                  <div class="form-group mb-3">
                      <label for="password">Password</label>
                      <input type="password" name="password" id="password" class="form-control" required>
                  </div>
                  <div class="form-group mb-3">
                      <input type="checkbox" name="remember_me" id="remember_me">
                      <label for="remember_me">Remember Me</label>
                  </div>
                  <button type="submit" class="btn btn-outline-light btn-lg px-5">Login</button>
                </form>
                
                <?php if (isset($error)): ?>
                  <div class="alert alert-danger mt-3">
                      <?= htmlspecialchars($error, ENT_QUOTES) ?>
                  </div>
                <?php endif; ?>

                <p class="small mt-3"><a class="text-white-50" href="forgot-password2.php">Forgot password?</a></p>
                <p class="mb-0">Don't have an account? <a href="register.php" class="text-white-50 fw-bold">Sign Up</a></p>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- login section end -->

  <!-- ======= Footer ======= -->
  <footer class="footer">
    <div class="container">
      <!-- Footer content here -->
    </div>
  </footer><!-- End Footer -->

  <!-- JS Scripts -->
  <script src="js/jquery.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/jquery-3.0.0.min.js"></script>
  <script src="js/plugin.js"></script>
  <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="js/custom.js"></script>
  <script src="js/owl.carousel.js"></script>
  <script>
    $(window).scroll(function(){
      var sticky = $('#navbar'),
      scroll = $(window).scrollTop();

      if (scroll >= 600) sticky.addClass('fix-nav');
      else sticky.removeClass('fix-nav');
    });
  </script>

</body>
</html>
