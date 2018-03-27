<?php
     include 'includes/sections/header.php';
		 include 'includes/sections/navbar.php';
	if(isset($_GET['del'])){
		// require 'Connect.php';
		$id = $_GET['del'];
		$query = "DELETE FROM recipe WHERE recipeID = '$id'";
		$result=mysqli_query($conn,$query);
		$sql = "DELETE FROM recipeing WHERE recipeID = '$id'";
		$res=mysqli_query($conn,$sql);
		 header('location:recipeList.php');
	}

?>
