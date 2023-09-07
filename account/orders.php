<?php

include 'header.php';

?>

    <div class="content">
      <h1>Order History</h1>
      <div class="order-list">
        <div class="order-item">
          <span>Order ID:</span>
          <span>#12345</span>
          <span>Date:</span>
          <span>2023-07-18</span>
          <span>Status:</span>
          <span>Delivered</span>
          <h3>Virtual SIM Card Numbers:</h3>
          <ul class="sim-number-list">
            <li>123-456-789</li>
            <li>987-654-321</li>
            <!-- Add more virtual SIM card numbers as needed -->
          </ul>
        </div>
        <div class="order-item">
          <span>Order ID:</span>
          <span>#54321</span>
          <span>Date:</span>
          <span>2023-07-15</span>
          <span>Status:</span>
          <span>In Progress</span>
          <h3>Virtual SIM Card Numbers:</h3>
          <ul class="sim-number-list">
            <li>111-222-333</li>
            <li>444-555-666</li>
            <!-- Add more virtual SIM card numbers as needed -->
          </ul>
        </div>
        <!-- Add more order items as needed -->
      </div>
    </div>

    <script src="script.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script
      src="https://cdn.jsdelivr.net/npm/simple-datatables@latest"
      type="text/javascript"
    ></script>
  </body>
</html>
