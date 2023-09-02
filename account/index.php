<?php
require 'assets/connection.php';
require 'assets/inject.php';

// Start a session to store and manage user data
session_start();

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Handle login form submission
  if (isset($_POST['login'])) {
    $email = sanitizeInput($conn, $_POST['email']);
    $password = sanitizeInput($conn, $_POST['password']);

    // Validate the input (you can add more validation here)
    if (empty($email) || empty($password)) {
      $_SESSION['login_error'] = 'Please enter both email and password.';
    } else {
      // Query the database to check if the user exists
      $sql = "SELECT id, email, password FROM users WHERE email = ?";
      $stmt = mysqli_prepare($conn, $sql);
      mysqli_stmt_bind_param($stmt, 's', $email);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);

      // Check if a user with the given email exists
      if (mysqli_stmt_num_rows($stmt) == 1) {
        mysqli_stmt_bind_result($stmt, $user_id, $db_email, $db_password);
        mysqli_stmt_fetch($stmt);

        // Verify the password
        if (password_verify($password, $db_password)) {
          // Password is correct, create a session for the user
          $_SESSION['user_id'] = $user_id;
          // Redirect to the dashboard or user profile page
          header('Location: dashboard.php');
          exit();
        } else {
          $_SESSION['login_error'] = 'Incorrect email or password.';
        }
      } else {
        $_SESSION['login_error'] = 'Invalid email or password.';
      }
    }
  }

  // Handle signup form submission
  if (isset($_POST['signup'])) {
    $email = sanitizeInput($conn, $_POST['email']);
    $password = sanitizeInput($conn, $_POST['password']);
    $confirm_password = sanitizeInput($conn, $_POST['confirm_password']);

    // Validate the input (you can add more validation here)
    if (empty($email) || empty($password) || empty($confirm_password)) {
      $_SESSION['signup_error'] = 'Please fill in all fields.';
    } elseif ($password !== $confirm_password) {
      $_SESSION['signup_error'] = 'Passwords do not match.';
    } else {
      // Check if the email is already registered
      $sql = "SELECT id FROM users WHERE email = ?";
      $stmt = mysqli_prepare($conn, $sql);
      mysqli_stmt_bind_param($stmt, 's', $email);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);

      if (mysqli_stmt_num_rows($stmt) > 0) {
        $_SESSION['signup_error'] = 'Email is already registered. Please use a different email.';
      } else {
        // Hash the password before storing in the database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new user into the 'users' table
        $sql = "INSERT INTO users (email, password) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ss', $email, $hashed_password);

        if (mysqli_stmt_execute($stmt)) {
          // User registration successful, redirect to the login page
          $_SESSION['signup_success'] = 'Registration successful. You can now log in.';
          header('Location: index.php');
          exit();
        } else {
          $_SESSION['signup_error'] = 'Registration failed. Please try again later.';
        }
      }
    }
  }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login and Signup Form</title>

  <!-- CSS -->
  <link rel="stylesheet" href="css/style.css" />

  <!-- Boxicons CSS -->
  <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet" />
</head>

<body>
  <section class="container forms">
    <!-- Login Form -->
    <div class="form login">
      <div class="form-content">
        <header>Login</header>
        <form action="#" method="post">
          <div class="field input-field">
            <input type="email" name="email" placeholder="Email" class="input" />
          </div>

          <div class="field input-field">
            <input type="password" name="password" placeholder="Password" class="password" />
            <i class="bx bx-hide eye-icon"></i>
          </div>

          <div class="form-link">
            <a href="#" class="forgot-pass">Forgot password?</a>
          </div>

          <div class="field button-field">
            <button type="submit" name="login">Login</button>
          </div>
        </form>

        <div class="form-link">
          <span>Don't have an account? <a href="#" class="link signup-link">Signup</a></span>
        </div>
      </div>

      <div class="line"></div>

      <div class="media-options">
        <a href="#" class="field facebook">
          <i class="bx bxl-facebook facebook-icon"></i>
          <span>Login with Facebook</span>
        </a>
      </div>

      <div class="media-options">
        <a href="#" class="field google">
          <img src="images/google.png" alt="" class="google-img" />
          <span>Login with Google</span>
        </a>
      </div>

      <!-- Download App Options -->
      <div>
        <!-- Add download app options here -->
        <p>Download our app from:</p>
        <a href="#" class="app-download">App Store</a>
        <a href="#" class="app-download">Google Play</a>
      </div>
      <!-- End of Download App Options -->
    </div>

    <!-- Signup Form -->
    <div class="form signup">
      <div class="form-content">
        <header>Signup</header>
        <form action="#" method="post">
          <div class="field input-field">
            <input type="email" name="email" placeholder="Email" class="input" />
          </div>

          <div class="field input-field">
            <input type="password" name="password" placeholder="Create password" class="password" />
          </div>

          <div class="field input-field">
            <input type="password" name="confirm_password" placeholder="Confirm password" class="password" />
            <i class="bx bx-hide eye-icon"></i>
          </div>

          <div class="field button-field">
            <button type="submit" name="signup">Signup</button>
          </div>
        </form>

        <div class="form-link">
          <span>Already have an account? <a href="#" class="link login-link">Login</a></span>
        </div>
      </div>

      <div class="line"></div>

      <div class="media-options">
        <a href="#" class="field facebook">
          <i class="bx bxl-facebook facebook-icon"></i>
          <span>Login with Facebook</span>
        </a>
      </div>

      <div class="media-options">
        <a href="#" class="field google">
          <img src="images/google.png" alt="" class="google-img" />
          <span>Login with Google</span>
        </a>
      </div>

      <!-- Download App Options -->
      <div>
        <!-- Add download app options here -->
        <p>Download our app from:</p>
        <a href="#" class="app-download">App Store</a>
        <a href="#" class="app-download">Google Play</a>
      </div>
      <!-- End of Download App Options -->
    </div>
  </section>
  <!-- Display messages -->
  <?php if (isset($_SESSION['login_error'])) : ?>
    <div class="message error"><?php echo $_SESSION['login_error']; ?></div>
    <?php unset($_SESSION['login_error']); ?>
  <?php endif; ?>

  <?php if (isset($_SESSION['signup_error'])) : ?>
    <div class="message error"><?php echo $_SESSION['signup_error']; ?></div>
    <?php unset($_SESSION['signup_error']); ?>
  <?php endif; ?>

  <?php if (isset($_SESSION['signup_success'])) : ?>
    <div class="message success"><?php echo $_SESSION['signup_success']; ?></div>
    <?php unset($_SESSION['signup_success']); ?>
  <?php endif; ?>
  <!-- JavaScript -->
  <script src="js/script.js"></script>
</body>

</html>