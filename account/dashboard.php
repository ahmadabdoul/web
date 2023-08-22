<?php
// Start a session to store and manage user data
session_start();

// Check if the user is logged in, otherwise redirect to the login page
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit();
}

// Database configuration
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'porcode_db';

// Create a database connection
$conn = mysqli_connect($hostname, $username, $password, $database);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Function to sanitize user input
function sanitize_input($data)
{
  return htmlspecialchars(stripslashes(trim($data)));
}

?>

<!DOCTYPE html>
<html>

<head>
  <title>User Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="styles.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>

<body>
  <div class="navbar">
    <span>Welcome, <?php echo $_SESSION['user_name'] ?? ''; ?>!</span>
    <div class="menu-icon" onclick="toggleSidebar()">
      <i class="fas fa-bars"></i>
    </div>
  </div>
  <div class="menu-icon-desktop" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
  </div>

  <div class="sidebar" id="sidebar">
    <h2>Dashboard</h2>
    <ul>
      <li>
        <a href="index.php"><i class="fas fa-home"></i> Home</a>
      </li>
      <li>
        <a href="profile.php"><i class="fas fa-user"></i> Profile</a>
      </li>
      <li>
        <a href="/services.html"><i class="fas fa-box"></i> Services</a>
      </li>
      <li>
        <a href="#"><i class="fas fa-shopping-cart"></i> Orders</a>
      </li>
      <li>
        <a href="topup.html"><i class="fas fa-wallet"></i> Top Up Wallet</a>
      </li>
      <li>
        <a href="profile.php"><i class="fas fa-cog"></i> Settings</a>
      </li>
      <li>
        <a href="/account/index.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
      </li>
    </ul>
  </div>

  <div class="content">
    <h1>Welcome to Your Dashboard, <?php echo $_SESSION['user_name'] ?? ''; ?>!</h1>
    <p>
      Here, you can manage your profile, access various services, view your
      orders, and top up your wallet. You also have access to the settings and
      logout options.
    </p>
    <h2>Profile Information</h2>
    <div class="profile-info">
      <div class="profile-item">
        <span>Name:</span>
        <span><?php echo $_SESSION['user_name'] ?? ''; ?></span>
      </div>
      <div class="profile-item">
        <span>Email:</span>
        <span><?php echo $_SESSION['user_email'] ?? ''; ?></span>
      </div>
      <!-- Add more profile information as needed -->
    </div>

    <h2>Recent Orders</h2>
    <div class="order-list">
      <?php
      // Query the database to get the user's recent orders
      $user_id = $_SESSION['user_id'];
      $sql = "SELECT order_id, order_date, order_status FROM orders WHERE user_id = ? ORDER BY order_date DESC LIMIT 5";
      $stmt = mysqli_prepare($conn, $sql);
      if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $order_id, $order_date, $order_status);

        while (mysqli_stmt_fetch($stmt)) {
          echo '<div class="order-item">';
          echo '<span>Order ID:</span><span>#' . $order_id . '</span>';
          echo '<span>Date:</span><span>' . $order_date . '</span>';
          echo '<span>Status:</span><span>' . $order_status . '</span>';
          echo '</div>';
        }

        // Close the statement
        mysqli_stmt_close($stmt);
      } else {
        echo "Error: " . mysqli_error($conn);
      }
      ?>
      <!-- Add more order items as needed -->
    </div>

    <!-- Add more sections and content as needed -->
  </div>

  <script src="script.js"></script>
</body>

</html>

<?php
// Close the database connection
mysqli_close($conn);
?>