<?php 
    $conn= mysqli_connect('localhost','root','','qlsk_dapm');
    if(mysqli_connect_errno()!==0)
    {
        die("Error");
    }
    mysqli_set_charset($conn,'utf8');
?>