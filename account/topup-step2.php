<?php

include_once 'header.php';

$payment_method = sanitizeInput($conn, $_POST['payment_method']);
$topup_amount = sanitizeInput($conn, $_POST['topup_amount']);

?>