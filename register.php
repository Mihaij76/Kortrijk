<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "it_project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    header('Content-Type: application/json');
    echo json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]);
    exit();
}

// If this is a POST request via AJAX, process registration
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['email']) && isset($_POST['password'])) {
    header('Content-Type: application/json');

    $email = trim($_POST["email"]);
    $userPassword = trim($_POST["password"]);

    // Basic email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["status" => "error", "message" => "Invalid email address!"]);
        $conn->close();
        exit();
    }

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "This email address has already been registered!"]);
        $stmt->close();
        $conn->close();
        exit();
    }
    $stmt->close();

    // Validate password strength
    // Criteria: At least 8 chars, one uppercase, one lowercase, one digit
    if (strlen($userPassword) < 8 ||
        !preg_match('/[A-Z]/', $userPassword) ||
        !preg_match('/[a-z]/', $userPassword) ||
        !preg_match('/\d/', $userPassword)) {
        echo json_encode(["status" => "error", "message" => "Password must be at least 8 characters, contain at least one uppercase letter, one lowercase letter, and one digit."]);
        $conn->close();
        exit();
    }

    // Hash the password
    $hashedPwd = password_hash($userPassword, PASSWORD_BCRYPT);

    // Insert user data into the database
    $insertStmt = $conn->prepare("INSERT INTO user (email, password) VALUES (?, ?)");
    $insertStmt->bind_param("ss", $email, $hashedPwd);

    if ($insertStmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Account created successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Registration failed: " . $conn->error]);
    }

    $insertStmt->close();
    $conn->close();
    exit();
}

// If not a POST request, just show the HTML form
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Registration</title>
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

  <style>
    .mainpart {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        background-color: #f4f4f4;
    }

    form {
        max-width: 400px;
        background-color: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
        text-align: center;
    }

    label {
        font-size: 14px;
        font-weight: bold;
        margin-bottom: 5px;
        display: block;
    }

    input[type="text"],
    input[type="password"] {
        width: 100%;
        padding: 12px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    #passwordHelp {
        font-size: 13px;
        color: red;
        margin-bottom: 20px;
        display: none;
    }

    input[type="submit"] {
        width: 100%;
        padding: 12px;
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    input[type="submit"]:hover {
        background-color: #218838;
    }

    /* Popup styling */
    .popup {
        display: none;
        position: fixed;
        z-index: 999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        align-items: center;
        justify-content: center;
    }

    .popup-content {
        background-color: white;
        padding: 20px;
        text-align: center;
        width: 300px;
        border-radius: 10px;
    }

    .popup-content button {
        background-color: #4caf50;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
  </style>
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

  <div class="mainpart">
    <form id="registrationForm">
      <h1>Registration</h1>
      <label for="email">Email Address:</label>
      <input type="text" name="email" id="email" required>

      <label for="password">Password:</label>
      <input type="password" name="password" id="password" required>
      <div id="passwordHelp">Password must be at least 8 characters, contain an uppercase letter, a lowercase letter, and a digit.</div>

      <input type="submit" value="Submit">
    </form>
  </div>

  <!-- Success Popup -->
  <div id="successPopup" class="popup">
    <div class="popup-content">
      <p id="popupMessage"></p>
      <button id="closePopupBtn">OK</button>
    </div>
  </div>

  <script>
    const form = document.getElementById('registrationForm');
    const passwordInput = document.getElementById('password');
    const passwordHelp = document.getElementById('passwordHelp');

    // Check password strength on input
    passwordInput.addEventListener('input', function() {
      const passwordValue = passwordInput.value;
      const strong = validatePassword(passwordValue);
      if (!strong) {
        passwordHelp.style.display = 'block';
      } else {
        passwordHelp.style.display = 'none';
      }
    });

    // Validate password strength function
    function validatePassword(pw) {
      return pw.length >= 8 &&
             /[A-Z]/.test(pw) &&
             /[a-z]/.test(pw) &&
             /\d/.test(pw);
    }

    form.addEventListener('submit', function(event) {
      event.preventDefault(); // Prevent form from submitting normally

      const emailValue = document.getElementById('email').value;
      const passwordValue = passwordInput.value;

      // Final check before submission
      if (!validatePassword(passwordValue)) {
        passwordHelp.style.display = 'block';
        return;
      }

      // If password is strong, proceed with AJAX submission
      var formData = new FormData(form);

      fetch('register.php', {
        method: 'POST',
        body: formData
      })
      .then(response => {
          if (!response.ok) {
              throw new Error('Network response was not ok: ' + response.statusText);
          }
          return response.json();
      })
      .then(data => {
          if (data.status === 'success') {
              // Show success popup
              document.getElementById('popupMessage').innerText = data.message;
              document.getElementById('successPopup').style.display = 'flex';
          } else {
              // Show error message
              alert(data.message);
          }
      })
      .catch(error => {
          console.error('Fetch error:', error);
          alert('An error occurred: ' + error.message);
      });
    });

    // Close the popup and redirect
    document.getElementById('closePopupBtn').addEventListener('click', function() {
        document.getElementById('successPopup').style.display = 'none';
        window.location.href = 'login.php';
    });
  </script>

</body>
</html>
