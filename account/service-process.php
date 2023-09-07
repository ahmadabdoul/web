

  <?php
session_start();
require 'assets/connection.php';
require 'assets/inject.php';

// Replace 'Your token' and '$DOMAIN' with your actual token and domain
$token = 'eyJhbGciOiJSUzUxMiIsInR5cCI6IkpXVCJ9.eyJleHAiOjE3MDA4MjIwMDgsImlhdCI6MTY2OTI4NjAwOCwicmF5IjoiNjM1NDIwMWVlODYzNWUyYTQxYzkyMTUxOThhNzNiNmQiLCJzdWIiOjEyNTE1MDl9.ZThNaYQsW9nLbfGsmQYpJKW6Ga1qYq87gVrZ6KNIg27Yd7APsSnOev-1Cx4LVFNcZcfEvDNjow5-r-xPK6QiJTbJVLcPLuzO3-b0jbWXWjejYCAQG3vcQu9he-Vp2psFevnGVCJqDeDlsf4y32hCJvsiWufu2OcLXUdyVSFpEXb13bTM10s1sq4UeOekrDtWX3KK9Nli3HMuaxL_lFW_rtpVxBv3Ku61As5uB40_qGP1sl7qZzLEkVB5QKwkwNBF7cr-kLJmGlj200LAzWSzOyfQ7wE7s8oVmq5YkzZlosmXQOxwbEmGhI_aAkyPSmafO0kV6ORtj-xNGVeTW3Ly1A';
$domain = '5sim.net';

$user_id = $_SESSION['user_id'];
$profit_percentage = sanitizeInput($conn, $_POST['profit_percentage']);
$service = sanitizeInput($conn, $_POST['service']);
$country = sanitizeInput($conn, $_POST['country']);
$operator = sanitizeInput($conn, $_POST['operator']);
// $cost = sanitizeInput($conn, $_POST['cost']);


//function to fetch product price 

function getProductCost($country, $service, $operator, $token, $domain, $profit_percentage) {
   
    // Make a GET request to fetch the price list
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://$domain/v1/guest/prices?country=$country&product=$service");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

    $headers = array();
    $headers[] = 'Authorization: Bearer ' . $token;
    $headers[] = 'Accept: application/json';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $priceListResponse = curl_exec($ch);

    if (curl_errno($ch)) {
        return 'Error:' . curl_error($ch);
    }

    curl_close($ch);

    // Parse the response to extract the price list
    $priceListData = json_decode($priceListResponse, true);
    //(print_r($priceListData));
    // Check if the specified country exists in the response
    //die(print_r($priceListData[$country][$service][$operator]));
    if (isset($priceListData[$country])) {
        $countryData = $priceListData[$country];
        
        // Check if the specified product exists in the country data
        if (isset($countryData[$service])) {
            $productData = $countryData[$service];
           // die($productData);
   
            // Check if the specified operator exists in the product data
            if (isset($productData[$operator])) {
                $cost = $productData[$operator]['cost'] * (1 + floatval($profit_percentage) / 100);
                return $cost;
            }
        }
    }

    // Return an error message if the data is not found
    header('Location: services.php?error=Price could not be fetched');
    exit();
}

//getProductCost to fetch cost
$cost = getProductCost($country, $service, $operator, $token, $domain, $profit_percentage);

//die($cost);

// Step 1: Make a GET request to the balance endpoint
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://$domain/v1/user/profile");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

$headers = array();
$headers[] = 'Authorization: Bearer ' . $token;
$headers[] = 'Accept: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$balanceResponse = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
    exit;
}

curl_close($ch);

// Step 2: Parse the response to extract the balance
$balanceData = json_decode($balanceResponse, true);
$apiBalance = $balanceData['balance'];
$sql = "SELECT balance FROM users WHERE id='$user_id'";
$result = mysqli_query($conn, $sql) or die($mysqli_error($conn));

if(mysqli_num_rows($result)>0){
    while($row = mysqli_fetch_assoc($result)){
        $balance = $row['balance'];
    }
  }

$balance = floatval($balance);
// Step 3: Check if the user's balance is sufficient
if ($balance >= $cost) {
    if($apiBalance < $cost){
        header('Location: services.php?error=Oops! There seems to be a problem');
        exit();
    }
    // Step 4: Make a GET request to the purchase number endpoint
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://$domain/v1/user/buy/activation/$country/$operator/$service");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

    $headers = array();
    $headers[] = 'Authorization: Bearer ' . $token;
    $headers[] = 'Accept: application/json';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $purchaseResponse = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
        exit;
    }

    curl_close($ch);

    // Step 5: Parse the response of the purchase number call
    $purchaseData = json_decode($purchaseResponse, true);
    if($purchaseResponse == 'no free phones') {
        header('Location: services.php?error=Phone numbers for this selection not available at this time. Try again later');
        exit();
    }
    //die($purchaseResponse);
    // Step 6: Insert the relevant data into the database
    $phone = $purchaseData['phone'];
    $operator = $purchaseData['operator'];
    $product = $purchaseData['product'];
    $price = $purchaseData['price'];
    $expiry = $purchaseData['expires'];
     $country = $purchaseData['country'];
    $forwarding = @$purchaseData['forwarding'];
    $forwardingNumber = @$purchaseData['forwarding_number'];
    $status = $purchaseData['status'];
    $orderId = $purchaseData['id'];
    $date = date('d-m-Y');
    $updatedBalance = $balance - $cost;

    if(isset($forwarding) && isset($forwardingNumber)){
        $insertSql = "INSERT INTO activation_numbers (user_id, operator, product, price, expiry, created, country, forwarding, forwarding_number, phone, status, order_id)
        VALUES ('$user_id', '$operator', '$product', '$price', '$expiry', '$date', '$country', '$forwarding', '$forwardingNumber', '$phone', '$status', '$orderId')";
    
    }else{
        $insertSql = "INSERT INTO activation_numbers (user_id, operator, product, price, expiry, created, country, phone, status, order_id)
        VALUES ('$user_id', '$operator', '$product', '$price', '$expiry', '$date', '$country', '$phone', '$status', '$orderId')";
     
    }
   
    if (mysqli_query($conn, $insertSql)) {
         $insertTxn = "INSERT INTO `transactions` (`id`, `user_id`, `type`, `order_id`, `amount`, `creation_date`, `status`) 
        VALUES (NULL, '$user_id', 'Purchase', '$orderId', '$cost', '$date', 'completed')";
        $updateBal = "UPDATE `users` SET `balance` = '$updatedBalance' WHERE `users`.`id` = $user_id";
        if (mysqli_query($conn, $insertTxn) && mysqli_query($conn, $updateBal)) {
            header('Location: services.php?success=Number '.$phone.' purchased successfully');
            exit();
        
        }else{
            header('Location: services.php?success=Number '.$phone.' purchased successfully but an error occured while updating our recors. Please contact customer support with the order id '.$orderId);
            exit();
       
        }

    } else {
        $insertTxn = "INSERT INTO `transactions` (`id`, `user_id`, `type`, `order_id`, `amount`, `creation_date`, `status`) 
        VALUES (NULL, '$user_id', 'Purchase', '$orderId', '$cost', '$date', 'failed')";
         if (mysqli_query($conn, $insertTxn)) {
            header('Location: services.php?error=Purchase failed');
            exit();
        }else{
            header('Location: services.php?error=Error: '.mysqli_errror($conn));
            exit();
        }
     
    }
} else {
    header('Location: services.php?error=Insufficient balance to make the purchase ');
    exit();
}
?>
