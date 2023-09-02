<?php
require_once 'assets/connection.php';

function mysql_fix_string($conn, $string)  { 
    // $string = stripslashes($string);  
       return mysqli_real_escape_string($conn, $string); 
        }


function sanitizeInput($conn, $string)  { 
   return htmlentities(mysql_fix_string($conn, $string)); 
    }


?>