<?php
     include 'includes/sections/header.php';
     include 'includes/sections/navbar.php';

  if(isset($_GET['del'])){
    // require 'Connect.php';
    $id = $_GET['del'];
    $query = "DELETE FROM inventory WHERE rmID = '$rmID'";
    $result=mysqli_query($conn,$query);
     header('location:rawmaterials.php');
  }

?>
