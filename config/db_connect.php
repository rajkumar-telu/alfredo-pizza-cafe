<?php
    $conn  = mysqli_connect('localhost','raj','test','alfredo_pizza');

    if(!$conn){
        echo 'Connection error : ' . mysqli_connect_error();
    }
?>