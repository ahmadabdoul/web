<?php

include 'header.php';
$user_id = $_SESSION['user_id'];
$token = 'eyJhbGciOiJSUzUxMiIsInR5cCI6IkpXVCJ9.eyJleHAiOjE3MDA4MjIwMDgsImlhdCI6MTY2OTI4NjAwOCwicmF5IjoiNjM1NDIwMWVlODYzNWUyYTQxYzkyMTUxOThhNzNiNmQiLCJzdWIiOjEyNTE1MDl9.ZThNaYQsW9nLbfGsmQYpJKW6Ga1qYq87gVrZ6KNIg27Yd7APsSnOev-1Cx4LVFNcZcfEvDNjow5-r-xPK6QiJTbJVLcPLuzO3-b0jbWXWjejYCAQG3vcQu9he-Vp2psFevnGVCJqDeDlsf4y32hCJvsiWufu2OcLXUdyVSFpEXb13bTM10s1sq4UeOekrDtWX3KK9Nli3HMuaxL_lFW_rtpVxBv3Ku61As5uB40_qGP1sl7qZzLEkVB5QKwkwNBF7cr-kLJmGlj200LAzWSzOyfQ7wE7s8oVmq5YkzZlosmXQOxwbEmGhI_aAkyPSmafO0kV6ORtj-xNGVeTW3Ly1A';
$domain = '5sim.net';


?>


    <div class="content">
      <h1>Order History</h1>
      <div class="order-list">
        <table class="table table-striped" id="orders">
          <thead>
            <th>Order ID</th>
            <th>Creation Date</th>
            <th>Expiry</th>
            <th>Country</th>
            <th>Product</th>
            
            <th>Number</th>
            <th>SMS Code</th>
            <th>Status</th>
</thead>
<tbody>
  <?php

    $sql = "SELECT * FROM activation_numbers WHERE user_id='$user_id' ORDER BY created DESC LIMIT 5";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    if(mysqli_num_rows($result)>0){
      while($row = mysqli_fetch_assoc($result)){
        $operator = $row['operator'];
        $country = $row['country'];
        $product = $row['product'];
        $price = $row['price'];
        $phone = $row['phone'];
        $status = $row['status'];
        $order_id = $row['order_id'];
        $created = $row['created'];

$ch = curl_init();


curl_setopt($ch, CURLOPT_URL, 'https://'.$domain.'/v1/user/check/' . $order_id);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


$headers = array();
$headers[] = 'Authorization: Bearer ' . $token;
$headers[] = 'Accept: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$resultc = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

$data = json_decode($resultc, true);

//print_r($data);
    // Check if data is not empty and display it in a table row
    if (!empty($data)) {
      echo '<tr>';
      echo '<td>' . $data['id'] . '</td>';
      echo '<td>' . $data['created_at'] . '</td>';
      echo '<td>' . $data['expires'] . '</td>';
      echo '<td>' . $data['country'] . '</td>';
      echo '<td>' . $data['product'] . '</td>';
      
      echo '<td>' . $data['phone'] . '</td>';
      echo '<td>';
      if (isset($data['sms']) && is_array($data['sms'])) {
        // Loop through the 'sms' array and display its elements
        foreach ($data['sms'] as $sms) {
            echo '<ul>';
            echo '<li>Text: ' . $sms['text'] . '</li>';
            echo '<li>Code: ' . $sms['code'] . '</li>';
            echo '<li>Sender: ' . $sms['sender'] . '</li>';
            // Add more elements as needed
            echo '</ul>';
        }
    } // You can display SMS code here if needed
      echo '<td>' . $data['status'] . '</td>';
      echo '</tr>';
  }

      }
    }
    ?>
</tbody>
  </table>
        
    </div>

    <script src="script.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script
      src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"
      type="text/javascript"
    ></script>
    <script>
      $(document).ready(()=>{
          $('#orders').DataTable();
      })
      </script>
  </body>
</html>
