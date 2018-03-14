<?php include 'includes/sections/header.php';
      include 'includes/sections/navbar.php';
 ?>

<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Record Purchases</h1>
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
                                            <label>Select Raw Material<b></label>
                                            <select name = "rmName" class="form-control">
        <?php
   // require 'Connect.php';
    $flag=0;
    $i = 1;

        $result = mysqli_query($conn, 'SELECT *
                                FROM inventory');

        while($row = mysqli_fetch_array($result)){

            $rmName = $row['rmName'];

             echo "<label><option value = \"{$row['rmName']}\"/>{$row['rmName']}</label>";
             echo "<br>";
        }
             echo "</div>";
?>
</select>
                                            <br>
                                            <p><b><label>Quantity</b><input type = "text" name = "quantity" class="form-control" placeholder="Enter Quantity Added" />


                                    <style>
                                        #textbox{
                                            padding: 2%;
                                        }
                                    </style>

        <br>
        <button class="btn cart" id="addraw">Add Raw Material</button>
        </form>


        <?php

   // require 'Connect.php';
    $flag = 0;
  if(empty($_POST['rmName'])){
    $rmName = '';
    $flag=1;
    } else
    $rmName = ($_POST['rmName']);

    if(empty($_POST['quantity'])){
    $quantity = '';
    $flag=1;
    } else
    $quantity = ($_POST['quantity']);

    $purchasedate = date('Y-m-d');

    $measurement_value = 0;
    $totalinDB = 0;
    $ingID = 0;

    $sql2 = mysqli_query($conn, "SELECT inventory.ingID as inv_ID, ingredient.ingID AS ing_ID, inventory.measurement_value AS measurement_value, ingredient.total AS total, inventory.rmName AS inv_rmName FROM inventory, ingredient WHERE inventory.rmName = '{$rmName}' AND inventory.ingID = ingredient.ingID");


     while($row = mysqli_fetch_array($sql2)){
        $inv_rmName = $row['inv_rmName'];
        $ingID = $row['inv_ID'];
        $measurement_value = $row['measurement_value'];
           if($inv_rmName == $rmName){
            $ingID = $row['inv_ID'];
        $measurement_value = $row['measurement_value']; 
         $totalinDB = $row['total'];
          }

        }

            $totalQuantity = $quantity * $measurement_value;
            $total = $totalinDB + $totalQuantity;   


        $sql3 = mysqli_query($conn, " UPDATE ingredient SET total = $total WHERE ingID = '$ingID'"); 

   /* $result = mysqli_query($conn, 'SELECT *
                            FROM inventory');

        while($row = mysqli_fetch_array($result)){

            $rmName1 = $row['rmName'];
           // $measurement_value = $row['measurement_value'];
             //   $measurement = $row['measurement'];
                $ingID = $row['ingID'];

            if($rmName1 == $rmName){
              //  $measurement_value = $row['measurement_value'];
              //  $measurement = $row['measurement'];
                $ingID = $row['ingID'];
            }
        }*/


  $sql1 = " INSERT INTO record_purchases(quantity, rmName, purchasedate)
            VALUES ('$quantity', '$rmName', '$purchasedate'); ";


        if($flag != 1){
    $result = mysqli_query($conn, $sql1);
        if (!$result){
          die('Invalid Input: ' . mysqli_error().$sql);
        }
        else{
          echo "<script> alert('Successfully Added');
                window.location.href='rawmaterials.php';
                </script> ";

        }
    }

    $totalQuantity = 0;


/* $sql3 = mysqli_query($conn, "SELECT * FROM record_purchases ORDER BY purchasedate ASC");

    while($row = mysqli_fetch_array($sql3)){
      $quantity = $row['quantity'];
      $rmName = $row['rmName'];
     // $ingredientID = $row['ingID'];
    }

   echo "LAST QUANTITY ";
    echo $quantity;
    echo "<br>";
    echo "raw material name ";
    echo $rmName;
    echo "<br><br>";*/

/*$sql2 = mysqli_query($conn, "SELECT inventory.ingID as inv_ID, ingredient.ingID AS ing_ID, inventory.measurement_value, ingredient.total, inventory.rmName AS inv_rmName FROM inventory, ingredient WHERE inventory.rmName = '{$rmName}' AND inventory.ingID = ingredient.ingID");


     while($row = mysqli_fetch_array($sql2)){
        $inv_rmName = $row['inv_rmName'];
        $ingID = $row['inv_ID'];
        $measurement_value = $row['measurement_value'];
           if($inv_rmName == $rmName){
            $ingID = $row['inv_ID'];
        $measurement_value = $row['measurement_value']; 
         $totalinDB = $row['total'];
          }

        }

            $totalQuantity = $quantity * $measurement_value;
            $total = $totalinDB + $totalQuantity;   

    /*    echo "MEASUREMENT VALUE ";
        echo $measurement_value;
        echo "<br>";
        echo "ingID ";
          echo $ingID;
          echo "<br>";
                  echo "TOTAL ";
          echo $totalinDB;
          echo "<br>";
          echo "TOTAL QUANTITY ";
          echo $totalQuantity;
          echo "<br>";
          echo "TOTAL ";
          echo $total;

        $sql3 = mysqli_query($conn, " UPDATE ingredient SET total = $total WHERE ingID = '$ingID'"); */


/*$sql2 = mysqli_query($conn, "SELECT *
              FROM inventory
              WHERE rmName = '$rmName'");


     while($row = mysqli_fetch_array($sql2)){

            $ingID = $row['ingID'];
            $quantityinDB = $row['quantity'];
            $totalQuantity = $quantityinDB + $quantity;

        }

        $sql3 = " UPDATE inventory SET quantity = $totalQuantity WHERE rmName = '$rmName'";


        if($flag != 1){
    $result = mysqli_query($conn, $sql3);
        if (!$result){
          die('Invalid Input: ' . mysql_error().$sql);
        }
        else{
          echo "<script> alert('Successfully Added');
                window.location.href='rawmaterials.php';
                </script> ";

        }
    }*/



?>


<?php include 'includes/sections/footer.php'; ?>
