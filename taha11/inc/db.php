<?php


$conn = mysqli_connect ("localhost","root","","taha11");







if (isset($_POST['submit'])) { 

$firstName = mysqli_real_escape_string($conn ,$_POST['firstName']) ;


$lastName =  mysqli_real_escape_string($conn ,$_POST['lastName']);


$email =     mysqli_real_escape_string($conn ,$_POST['email']);



$sql = "INSERT INTO users(firstName,lastName,email)
 VALUES ('$firstName','$lastName','$email')";



if(empty($firstName)){

echo ' ادخل الاسم الاول';
}

elseif(empty($lastName)){

echo ' ادخل الاسم الثاني';

}

elseif(empty($email)){

echo ' ادخل البريد الالكتروني';
}


elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){

echo ' ادخل بريد الالكتروني صحيح';


}else{

  if(mysqli_query($conn , $sql)){
header('Location: index.php');
echo 'success';
}else{

echo 'Error' . mysqli_error($conn);
}
  
}

} 







?>