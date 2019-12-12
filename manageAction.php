<?php
  session_start();
  
  require('config.php');
  $conn_string = "mysql:host=$host;dbname=$database;charset=utf8mb4";
  $db = new PDO($conn_string, $username, $password);
  
if(isset($_POST['appointmentID']) && is_numeric($_POST['appointmentID'])){
  $appointment = $_POST['appointmentID'];
  
   $id = $_SESSION['id'];  
  $appointmentTable = $id."appointments"; 
        $delete_query="DELETE FROM $appointmentTable WHERE id = '$appointment'";
        $stmt = $db->prepare($delete_query);
        $r = $stmt->execute();


  header("Location: landingPage.php#appointmentDeleted");
}else{
  header("Location: landingPage.php#manageFail");
}



 
?>