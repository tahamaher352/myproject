<?php

$conn = mysqli_connect('localhost','root','','taha11');

if(!$conn){
    
    echo 'Error' . mysqli_connect_error();
}

?>