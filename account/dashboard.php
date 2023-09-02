<?php

include_once 'header.php';


?>

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