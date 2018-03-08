<?php
  if(isset($_GET['del'])){
    require 'Connect.php';
    $id = $_GET['del'];
    $query = "DELETE FROM inventory WHERE rmID = '$rmID'";
    $result=mysql_query($query);  
     header('location:rawmaterials.php');
  }
  
?>