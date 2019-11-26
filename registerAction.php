<?php
require('config.php');
$conn_string = "mysql:host=$host;dbname=$database;charset=utf8mb4";
$db = new PDO($conn_string, $username, $password);


$stmt = $db->query("SELECT * from ProjectAccounts");
$result = $stmt->fetch();


  $enteredUsername = $_POST['Rname'];
  $enteredPassword = $_POST['Rpassword'];
  $enteredConfirmPassword = $_POST['RCpassword'];

if(strlen($enteredUsername) > 0 && isset($enteredUsername)){
  echo "Username Entered:".$enteredUsername."<br>";
} else {
  header("Location: index.html#register");
}
if(strlen($enteredPassword) > 0 && isset($enteredPassword)){
  echo "Password Entered:".$enteredPassword."<br>";
} else {
  header("Location: index.html#register");
}
if(strlen($enteredConfirmPassword) > 0 && isset($enteredConfirmPassword)){
  echo "Confirmation Password Entered:".$enteredConfirmPassword."<br>";
} else {
  header("Location: index.html#register");
}


$hashed = hash('sha512', $enteredPassword);

if(strlen($enteredPassword) > 0 && $enteredPassword == $enteredConfirmPassword){
  $insert_query = "INSERT INTO ProjectAccounts (username, password, dogName, date) VALUES ('$enteredUsername', '$enteredPassword', 'NULL', 'NULL')";
  $stmt = $db->prepare($insert_query);
  $r = $stmt->execute();
  
  header("Location: registerSuccess.html");
  
} else {
  header("Location: index.html#register");
}



?>
