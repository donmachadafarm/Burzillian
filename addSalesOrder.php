<?php include 'includes/sections/header.php';
      include 'includes/sections/navbar.php';

            if (!isset($_SESSION['userType']) || $_SESSION['userType']!=103){
        echo "<script>window.location='logout.php'</script>";
      }
 ?>

                <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"> Create Sales Order</h1>
                    </div>
                    <!-- /.col-lg-12 -->



                </div>
                <!-- /.row -->



            </div>
            <!-- /.container-fluid -->



    <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form action="" method="post">
                                      <div class="form-group">

             <div class="form-group">

                     <table  class='table table-striped table-bordered table-hover' >
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Product Type</th>
                                        <th>Price</th>

                                    </tr>
                                </thead>


                                <?php
//require 'Connect.php';

$sql = mysqli_query($conn,"SELECT prodName, prodType, price FROM product ORDER BY prodType, prodName");

if($sql){

while($row = mysqli_fetch_array($sql)){
echo '<tr><td align="left">' .
$row['prodName'] . '</td><td>' .
$row['prodType'] . '</td><td>' .
$row['price'] .
'</tr>';
}
?>
</table>
<?php
}
else
echo "0 results!";
                                ?>
                <!--<h2 align="center">Create Sales Order</h2>-->

                    <hr>
                     <form name="add_order" id="add_order" >
                          <div class="table-responsive">
                               <table class="table table-bordered" id="dynamic_field">
                                   <!-- <tr>   <td><input type="date" name="date" placeholder="Enter date" class="form-control name_list" /></td> </tr> -->
                                    <tr>
                                         <td>
                                         <!--<input type="text" name="name[]" placeholder="Enter Product" class="form-control name_list" />-->

                                         <?php

$sql = "SELECT prodName, price FROM product";
$result=mysqli_query($conn,$sql); // Run query

echo '<select name="name[]" class="form-control name_list" >'; // Open drop down box

// Loop through the query results, outputing the options one by one
while($row = mysqli_fetch_array($result)){
echo '<option value="'.$row['prodName'].'">'.$row['prodName'].'</option>';
//
}

echo '</select>';// Close drop down box
?>

                                         </td>
                                         <td><input type="number" name="quantity[]" placeholder="Enter quantity" class="form-control name_list" /></td>
                                         <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>
                                    </tr>
                               </table>
 <div class="form-group">
       <p class="form-control-static">
                                <B>Enter customer cash:</B>
                                <input type="number" id="textbox" name="cash" placeholder="Enter customer cash" class="form-control"/>

                                <br><br>
<center><hr>
                              <button type="submit" name = "submit" class="btn btn-success">Submit Order</button>

                               <br>

                          </div>
                     </form>

 <style>
 #texbox{
    width: 40%;
    height: 30%;
    padding: 2%;
 }

 </style>

                </div>

      </body>
 </html>

<script>
function myFunction() {
    window.print();
}
</script>

 <script>
 $(document).ready(function(){
      var i=1;
      $('#add').click(function(){
           i++;
           $('#dynamic_field').append('<tr id="row'+i+'"><td><?php
$sql = "SELECT prodName, price FROM product";
$result=mysqli_query($conn,$sql); // Run query

echo '<select name="name[]" class="form-control name_list">'; // Open drop down box

// Loop through the query results, outputing the options one by one
while($row = mysqli_fetch_array($result)){
echo '<option value="'.$row['prodName'].'">'.$row['prodName'].'</option>';
}

echo '</select>';// Close drop down box
?></td>  <td><input type="number" name="quantity[]" placeholder="Enter Quantity" class="form-control name_list" /></td>  <td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
      });



      $(document).on('click', '.btn_remove', function(){
           var button_id = $(this).attr("id");
           $('#row'+button_id+'').remove();
      });



 });  //end Document function
 </script> <!-- Sales Order Functionality END-->

 <?php

  if (isset($_POST['submit'])){
        $message=NULL;
$needed_cash = 0;
$quantity_error = 0;

 $number = count($_POST["name"]);  //counts transaction rows

 $name=$_POST['name'];
 $quantity=$_POST['quantity'];
 $cash = $_POST['cash'];

$subTotal_array = [];
 if($number > 0)
 {
    $total = 0;
for($i=0; $i<$number; $i++)
{
$subTotal = 0;
 $sql = "SELECT prodName, price FROM product";
$result=mysqli_query($conn,$sql);

  if ($result){
  //$result is 0
  while($row = mysqli_fetch_array($result))
  {
      if ($quantity[$i] <= 0)
    {
      $quantity_error = 1;
    }


    if($row['prodName'] == $name[$i]){
  $subTotal += ($row['price'] * $quantity[$i]);
  $subTotal_array[$i] = $subTotal;
  $total += $subTotal;
        }
  }//end while conditional

  }//end if conditional

}//end for conditional


$cash_change = $cash - $total;
//header("Location: receipt.php");
//Insert Confirmation Here

}




if ($cash_change >= 0 &&  $quantity_error == 0){
 $sql = "INSERT INTO sales_order(salesDate, totalPrice, cash, cashChange) VALUES(NOW(),'$total', '$cash', '$cash_change')";
  mysqli_query($conn, $sql);

// Calculate Total ()


 if($number > 0)
 {
      for($i=0; $i<$number; $i++)
      {

                $sql = "INSERT INTO receipt(salesID, prodName, quantity, subTotal) VALUES((SELECT MAX(salesID) FROM sales_order), '$name[$i]', '$quantity[$i]', '$subTotal_array[$i]')";

        if($flag != 1){
    $result = mysqli_query($conn,$sql);
        if (!$result){
          die('Invalid Input: ' . mysqli_error().$sql);
        }
        else{
          echo "<script> alert('Successfully Added');
                window.location.href='receipt.php';
                </script> ";
        }
    }

      }

$sql = mysqli_query($conn, "SELECT receipt.prodName, receipt.salesID , receipt.quantity AS receipt_quantity, sales_order.salesDate,
recipe.recipeName, ingredient.ingID AS 'ingID', ingredient.ingName, converter.convertFrom, converter.convertTo, recipeing.measureVal, ingredient.total,
round(receipt.quantity*recipeing.convertedMeasurement, 3) AS 'subtract', round(ingredient.total - (receipt.quantity*recipeing.convertedMeasurement), 3) AS 'new_measurement'
FROM recipe
JOIN recipeing on recipe.recipeID = recipeing.recipeID
JOIN product on recipe.prodID = product.prodID
JOIN receipt on receipt.prodName = product.prodName
JOIN sales_order on receipt.salesID = sales_order.salesID
JOIN ingredient on ingredient.ingID = recipeing.ingID
JOIN converter on recipeing.measureID = converter.convertID
WHERE  receipt.salesID = (SELECT MAX(receipt.salesID) FROM receipt)
GROUP BY recipe.recipeID,ingredient.ingName,receipt.prodName, sales_order.salesDate;");

while($row = mysqli_fetch_array($sql)){
$i = 0;

$updateING = "UPDATE ingredient
SET total = '{$row['new_measurement']}'
WHERE ingID = '{$row['ingID']}';
";

$result2=mysqli_query($conn, $updateING);
}


 }
 else
 {
      echo "Please Select Product";
 }
}//end change conditional
else{

  if($cash_change < 0){
  $needed_cash = $cash_change * (-1);
    echo "Insufficient cash! Need P$needed_cash more!\n";
  }

  if ($quantity_error == 1)
    {
      echo "Invalid quantity input on some orders! Please input positive or non-zero values.";
    }
  }

}


 ?>

<?php include 'includes/sections/footer.php'; ?>
