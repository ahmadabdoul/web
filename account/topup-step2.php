<?php

include_once 'header.php';

$payment_method = sanitizeInput($conn, $_GET['payment_method']);
$topup_amount = sanitizeInput($conn, $_GET['topup_amount']);

if($payment_method == 'Manual' || $payment_method == 'Binance'){
    $sql = "SELECT * FROM account_details WHERE type='bank' OR type='binance'";
    $result = mysqli_query($conn, $sql) or die($mysqli_error($conn));

    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_assoc($result)){
            $bankname = $row['bankname'];
            $account_name = $row['account_name'];
            $account_number = $row['account_number'];
            $type = $row['type'];
            $user_id = $_SESSION['user_id'];

        }
    }else{
        $error = 'Payment Details not available';
    }
}


// if(isset($_POST['sumbit'])){
//     $amount = $topup_amount;
//     $type = $payment_method;
//     $date = date('d-m-Y');

//     if(isset($_FILES['image'])){
//         $errors= '';
        
//         $file_name = $_FILES['image']['name'];
//         $file_size =$_FILES['image']['size'];
//         $file_tmp =$_FILES['image']['tmp_name'];
//         $file_type=$_FILES['image']['type'];
//         $tmp = explode('.', $file_name);
//     $file_ext = end($tmp);
//         $file_ext=strtolower($file_ext);
//     //echo $file_ext;
//         $expensions= array("jpg", "jpeg", "png");
    
//         if(in_array($file_ext,$expensions)=== false){
//             $errors="extension not allowed, please choose an image with jpg or png extension";
//         }
//         //chec if file size is greater than 20mb
//         if($file_size > 20971520){
//             $errors='File size must not exceed 20 MB';
//         }
    
//         if(empty($errors)==true){
//             move_uploaded_file($file_tmp,"../uploads/".$file_name);
//             $file_name = "uploads/".$file_name;
//             //update database
//             $sql = "INSERT INTO `topup` (`id`, `user_id`, `method`, `amount`, `receipt`, `date`, `status`) VALUES (NULL, '$user_id', '$payment_method', '$topup_amount', '$file_name', '$date', 'pending')";
//             $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

//             if($result){
//                 echo "<script>alert('Upload successfull! Our account department will review and verify your payment shortly');</script>";
//             }else{
//                 echo "<script>alert('Upload not successfull! An error occured');</script>";
//             }
//         }else{
//             echo "<script>alert('".$errors."');</script>";
//         }
//     }else{
//         echo "<script>alert('Upload not successfull! Please select an image');</script>";
//     }
            
// }
?>


<div class="main-content">
      <h2>Create Top Up</h2>
      <div class="top-up-form">
        <form action='topup-step3.php' method='post' enctype="multipart/form-data" accept="image/*">
        <div class="payment-method">
          <h3><?php echo $payment_method; ?></h3>
          <p>You can make payment to the account details below. Upload a screenshot or receipt of the payment and our account department will credit your wallet shortly after confirmation.</p>

        </div>
        <div class="top-up-amount">
          <h3>Payment Details&Receipt</h3>
          <?php if(isset($error)){
            echo '<p>'.$error.'</p>';
          }
          ?>
          <input type="hidden" value="<?php echo $topup_amount; ?>" name="amount" />
          <input type="hidden" value="<?php echo $payment_method; ?>" name="type" />
          <p><strong>Amount: <?php echo $topup_amount; ?></strong></p>
          <p><?php echo $bankname; ?></p>
          <p><?php echo $account_name; ?></p>
          <p><?php echo $account_number; ?></p>

          <label>Upload Receipt</label>
          <input type='file' name='image' required />
        </div>
        <input name="submit" type="submit"  class="top-up-button" value="Confirm Payment" />
</form>
      </div>
    </div>
    <script src="script.js"></script>
  </body>
</html>