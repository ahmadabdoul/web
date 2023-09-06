<?php
session_start();
require 'assets/connection.php';
require 'assets/inject.php';

            $user_id = $_SESSION['user_id'];
            
$payment_method = sanitizeInput($conn, $_POST['type']);
$topup_amount = sanitizeInput($conn, $_POST['amount']);


if($_POST['submit']){
    $amount = $topup_amount;
    $type = $payment_method;
    $date = date('d-m-Y');

    if(isset($_FILES['image'])){
        $errors= '';
        
        $file_name = $_FILES['image']['name'];
        $file_size =$_FILES['image']['size'];
        $file_tmp =$_FILES['image']['tmp_name'];
        $file_type=$_FILES['image']['type'];
        $tmp = explode('.', $file_name);
    $file_ext = end($tmp);
        $file_ext=strtolower($file_ext);
    //echo $file_ext;
        $expensions= array("jpg", "jpeg", "png");
    
        if(in_array($file_ext,$expensions)=== false){
            $errors="extension not allowed, please choose an image with jpg or png extension";
        }
        //chec if file size is greater than 20mb
        if($file_size > 20971520){
            $errors='File size must not exceed 20 MB';
        }
    
        if(empty($errors)==true){
            move_uploaded_file($file_tmp,"../uploads/".$file_name);
            $file_name = "uploads/".$file_name;

            //generate order_id
            $order_id = mt_rand(10000000, 99999999);
            //update database
            $sql = "INSERT INTO `topup` (`id`, `user_id`, `method`, `amount`, `receipt`, `date`, `status`) VALUES (NULL, '$user_id', '$payment_method', '$topup_amount', '$file_name', '$date', 'pending')";
            $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

            $sql2 = "INSERT INTO `transactions` (`id`, `user_id`, `type`, `order_id`, `amount`, `creation_date`, `status`) 
            VALUES (NULL, '$user_id', 'topup', '$order_id', '$topup_amount', '$date', 'pending')";
             $result2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));


            if($result && $result2){
                ?><script>
                alert('Upload successfull! Our account department will review and verify your payment shortly');
                history.back()
                </script>
                <?php
              
            }else{
                ?><script>alert('Upload not successfull! An error occured');</script>
                <?php
                
            }
        }else{
            ?><script>alert('<?php echo $errors ?>');
             history.back()
             </script>
            <?php
            
        }
    }else{
        ?>
        <script>alert('Upload not successfull! Please select an image');
         history.back()
    </script>
        <?php
    }
            
}else{
    ?>
    <script>alert('Upload not successfull! ');
     history.back()
</script>
    <?php
}
?>