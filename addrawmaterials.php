<?php include 'includes/sections/header.php';
      include 'includes/sections/navbar.php';
 ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Add Raw Material</h1>
                </div>
            </div>
                    <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form action="" method="post">
                                      <div class="form-group">
<div>
<?php
    //require 'Connect.php';
    $flag=0;

    if(empty($_POST['rmName'])){
    $rmName = '';
    $flag=1;
    } else
    $rmName = ($_POST['rmName']);

    if(empty($_POST['ingID'])){
    $ingID = '';
    $flag=1;
    } else
    $ingID = ($_POST['ingID']);

    if(empty($_POST['measurement'])){
    $measurement = '';
    $flag=1;
    } else{
    	$measurement = ($_POST['measurement']);
		$temp = ($_POST['measurement']);
	if($measurement == "Liter" || $measurement == "Kilogram"){
	$measurement = ($_POST['measurement']);

	}

	else{
		$query = "SELECT *
				FROM converter WHERE convertFrom = '$measurement' ";
		$result=mysqli_query($conn,$query);
		$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
		$measurement = $row['convertTo'];

	}
	}

	if(empty($_POST['measurement_value'])){
    $measurement_value = '';
    $flag=1;
    } else{
   $measurement_value = ($_POST['measurement_value']);

    if($temp == "Liter" || $temp == "Kilogram"){
	$measurement_value = ($_POST['measurement_value']);
	}

	else{
			$query1 = "SELECT *
				FROM converter WHERE convertFrom = '$temp' ";
		$result1=mysqli_query($conn,$query1);
		$row1=mysqli_fetch_array($result1,MYSQLI_ASSOC);
		$temp1 = $row1['convertValue'];
	$measurement_value = $measurement_value * $temp1;

	}
	}

  $quantity = 0;


    $sql1 = " INSERT INTO inventory(rmName, measurementValue, measurement, ingID)
            VALUES ('$rmName', '$measurement_value', '$measurement', '$ingID'); ";



        if($flag != 1){
    $result = mysqli_query($conn,$sql1);
        if (!$result){
          die('Invalid Input: ' . mysqli_error().$sql1);
        }
        else{
          echo "<script> alert('Successfully Added');
                window.location.href='rawmaterials.php';
                </script> ";
        }
    }

?>


</div>
    <!-- <div id = "formContent">-->
     <form class="form-signin" action='' method="POST">


        <label>Raw Material Name: </label><br>
        <input type="text" name="rmName" placeholder="" class="form-control"><br>

         <label class="control-label"  for="measurement_value">Measurement Value: </label><br>
        <input type="text" name="measurement_value" placeholder="Ex. 250" class="form-control"><br>



       <label class="control-label" for="measurement">Measurement: </label>
<select name ="measurement" class="form-control">
        <?php
   // require 'Connect.php';
    $flag=0;
    $i = 1;

        $result = mysqli_query($conn, 'SELECT *
                                FROM converter');

        while($row = mysqli_fetch_array($result)){

            $convert_from = $row['convertFrom'];
            $convert_to = $row['convertTo'];

             echo "<label><option value = \"{$row['convertFrom']}\"/>{$row['convertFrom']}</label>";
             echo "<br>";
        }


             echo "<label><option value = \"Liter\"/>Liter</label> <br>";
             echo "<label><option value = \"Kilogram\"/>Kilogram</label>";
             echo "</div>";
?>
</select>
<br>

<style>
#textbox{
        width: 300px;
        height:30px;
        padding: 1%;
        border-radius: 4%;
    }
</style>
       <div class="form-group">
       <p class="form-control-static">
        <label class="control-label"  for="ingName">Type:</label>
        <select name ="ingID" class="form-control">
    <?php
    //require 'Connect.php';
    $flag=0;
    $i = 1;

        $result = mysqli_query($conn, 'SELECT *
                                FROM ingredient');


        while($row = mysqli_fetch_array($result)){

        $ingID = $row['ingID'];
             echo "<label><option value = \"{$ingID}\"/>{$row['ingName']}</label>";

        }

            ?>
            </select>
<br><br>

        <button type="submit" class="btn btn-success" value="submit">Add Raw Material</button>
        </form>


<?php include 'includes/sections/footer.php'; ?>
