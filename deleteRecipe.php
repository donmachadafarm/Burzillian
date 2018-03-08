<?php
	if(isset($_GET['del'])){
		require 'Connect.php';
		$id = $_GET['del'];
		$query = "DELETE FROM recipe WHERE recipeID = '$id'";
		$result=mysql_query($query);	
		$sql = "DELETE FROM recipeing WHERE recipeID = '$id'";
		$res=mysql_query($sql);	
		 header('location:recipeList.php');
	}
	
?>