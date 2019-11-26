<?php
require('config.php');
$conn_string = "mysql:host=$host;dbname=$database;charset=utf8mb4";
$db = new PDO($conn_string, $username, $password);


if($_POST['Lname']){
  $enteredUsername = $_POST['Lname'];

}
if($_POST['Lpassword']){
  $enteredPassword = $_POST['Lpassword'];
}

if($_POST['Dname']){
  $enteredDogName = $_POST['Dname'];

}
if($_POST['date']){
  $enteredDate = $_POST['date'];
}



echo "Entered Username:".$enteredUsername."<br>";
echo "Entered Password:".$enteredPassword."<br>";
echo "Entered Username:".$enteredUsername."<br>";
echo "Entered Password:".$enteredPassword."<br>";


$stmt = $db->query("SELECT * FROM ProjectAccounts where username = '$enteredUsername'");
$result = $stmt->fetch();


$hashed = hash('sha512', $enteredPassword);

if($result['username'] == $enteredUsername && strlen($enteredUsername) > 0 && $result['password'] == $hashed){ 
  
  $stmt = $db->query("UPDATE ProjectAccounts SET dogName = '$enteredDogName' WHERE username = '$enteredUsername' AND password = '$enteredPassword';"); 
  $stmt = $db->query("UPDATE ProjectAccounts SET date = '$enteredDate' WHERE username = '$enteredUsername' AND password = '$enteredPassword';"); 
  
  
  header("Location: appointmentSuccess.html");
} else {
  echo "Login Failed<br><br>";
  header("Location: loggedIndex.html#schedule");
}



?>
