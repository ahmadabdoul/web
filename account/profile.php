<?php
// Start a session to store and manage user data
session_start();

// Database configuration
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'porcode_db'; // Replace 'your_database_name' with your actual database name

// Create a database connection
$conn = mysqli_connect($hostname, $username, $password, $database);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
  // If not logged in, redirect to the login page
  header('Location: index.php');
  exit();
}

// Fetch the user's profile data
$user_id = $_SESSION['user_id'];

$sql = "SELECT username, email FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $user_name, $user_email);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// Handle form submission to update the profile
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $new_name = $_POST['name'];
  $new_email = $_POST['email'];
  $new_password = $_POST['password'];

  // Validate the input (you can add more validation here)

  // Update the user's profile data in the database
  $sql = "UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?";
  $stmt = mysqli_prepare($conn, $sql);
  $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
  mysqli_stmt_bind_param($stmt, 'sssi', $new_name, $new_email, $hashed_password, $user_id);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);

  // Redirect to the profile page with a success message
  $_SESSION['profile_updated'] = true;
  header('Location: profile.php');
  exit();
}

?>

<!DOCTYPE html>
<html>

<head>
  <title>User Profile</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="styles.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>

<body>
  <div class="navbar">
    <span>Welcome,
      <?php echo $user_name; ?>!</span>
    <div class="menu-icon" onclick="toggleSidebar()">
      <i class="fas fa-bars"></i>
    </div>
  </div>

  <div class="sidebar" id="sidebar">
    <!-- Sidebar content here -->
  </div>

  <div class="main-content">
    <div class="profile-info">
      <div class="profile-picture">
        <img src="profile-picture.jpg" alt="Profile Picture" />
        <input type="file" id="profile-picture-input" style="display: none" />
        <label for="profile-picture-input" class="edit-profile-button">
          <i class="fas fa-pencil-alt"></i> Change Picture
        </label>
      </div>
      <div class="profile-details">
        <h2>User Profile</h2>
        <form action="#" method="post">
          <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $user_name; ?>" />
          </div>
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $user_email; ?>" />
          </div>
          <div class="form-group">
            <label for="password">New Password:</label>
            <input type="password" id="password" name="password" />
          </div>
          <button type="submit" class="save-profile-button">
            Save Profile
          </button>
        </form>
      </div>
    </div>
  </div>

  <script src="script.js"></script>
</body>

</html>