<?php
require 'assets/connection.php';
require 'assets/inject.php';

// Start a session to store and manage user data
session_start();

// Check if the user is logged in, otherwise redirect to the login page
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit();
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
        <a href="topup.php"><i class="fas fa-wallet"></i> Top Up Wallet</a>
      </li>
      <li>
        <a href="profile.php"><i class="fas fa-cog"></i> Settings</a>
      </li>
      <li>
        <a href="/account/index.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
      </li>
    </ul>
  </div>
