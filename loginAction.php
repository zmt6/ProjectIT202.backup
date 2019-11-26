<?php
require('config.php');
$conn_string = "mysql:host=$host;dbname=$database;charset=utf8mb4";
$db = new PDO($conn_string, $username, $password);

//CHECK IF 'Lname' EXISTS
if($_POST['Lname']){
  $enteredUsername = $_POST['Lname'];
}
//CHECK IF 'Lpassword' EXISTS
if($_POST['Lpassword']){
  $enteredPassword = $_POST['Lpassword'];
}



echo "Entered Username:".$enteredUsername."<br>";
echo "Entered Password:".$enteredPassword."<br>";


$stmt = $db->query("SELECT * FROM ProjectAccounts where username = '$enteredUsername'");
$result = $stmt->fetch();

echo "Database Username:".$result['username']."<br>";


if($result['username'] == $enteredUsername && strlen($enteredUsername) > 0 && $result['password'] == $enteredPassword){
  echo "Login Succeded<br><br>";  
  header("Location: loggedIndex.html");
} else {
  echo "Login Failed<br><br>";
  header("Location: index.html#login");
}



?>