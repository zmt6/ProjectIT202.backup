<?php
session_start();

if(session_status() == PHP_SESSION_ACTIVE && $_SESSION['id'] != '') {
  //echo 'Session is active';
}
else{
  header("Location: index.php#loginPrompt");
  //echo 'Session is not active';
}

//Dog name
if(isset($_POST['dogName']) && $_POST['dogName'] != ""){
  $enteredDogName = $_POST['dogName'];
}
else{
  header("Location: landingPage.php#scheduleFail");
}

//dog breed
if(isset($_POST['dogBreed']) && $_POST['dogBreed'] != ""){
  $enteredDogBreed = $_POST['dogBreed'];
}
else{
  header("Location: landingPage.php#scheduleFail");
}

//dog size
if(isset($_POST['dogSize']) && $_POST['dogSize'] != ""){
  $enteredDogSize = $_POST['dogSize'];
}
else{
  header("Location: landingPage.php#scheduleFail");
}

//dog size
if(isset($_POST['date']) && $_POST['date'] != ""){
  $enteredDate = $_POST['date'];
}
else{
  header("Location: landingPage.php#scheduleFail");
}

require('config.php');
$conn_string = "mysql:host=$host;dbname=$database;charset=utf8mb4";
$db = new PDO($conn_string, $username, $password);
    
    $id = $_SESSION['id'];
    $appointmentTable = $id."appointments";
    $insert_query = "INSERT INTO $appointmentTable (`id`, `dogName`, `dogBreed`, `dogSize`, `date`) VALUES (NULL, '$enteredDogName', '$enteredDogBreed', '$enteredDogSize', '$enteredDate');";
    $stmt = $db->prepare($insert_query);
    $r = $stmt->execute();

header("Location: landingPage.php#scheduleSucceed");

?>
