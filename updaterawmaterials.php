<?php
session_start();

		// require 'Connect.php';

$rmName = isset($_POST['rmName']);
$quantity = $_POST['quantity'];
$purchasedate = $_POST['purchasedate'];
$measurement_value = $_POST['measurement_value'];
$measurement = $_POST['measurement'];
$ingName = $_POST['ingName'];

$sql1 = "UPDATE record_purchases
		 SET rmName = '$rmName', quantity = '$quantity', purchasedate = '$purchasedate', measurement_value = '$measurement_value', measurement = '$measurement', ingName = '$ingName';
		 ";

		 $result1 = mysql_query($sql1);
		 if(!$result1){
		 	die ('Invalid ' . mysql_error().$sql1);
		 }
		 else{
		 	echo "<script> alert('Edit Success');
		 		  window.location.href='';
		 		  </script>";
		 }



?>
