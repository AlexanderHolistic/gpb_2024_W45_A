<?php
$db= new mysqli('172.16.1.49:3306', 'user_a', 'test123', 'NotizY_404' );

if($db->connect_error) {
    die("Connection failed: ". $conn->connect_error);
} else {
    echo "Connection successful!";
}


?>




