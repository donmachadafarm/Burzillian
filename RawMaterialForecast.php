<?php include 'includes/sections/header.php';
      include 'includes/sections/navbar.php';

      if (!isset($_SESSION['userType']) || $_SESSION['userType']!=101){
        echo "<script>window.location='logout.php'</script>";
      }
 ?>
<div id="page-wrapper">

 <h1 class="page-header">Ingredients Forecast</h1>

   <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id ="table_select">

                                        <div class="form-group">
                                            <label>Select Tables to Display</label>
                                            <select name = "table_select" class="form-control" style="width: 300px;">
                                              <option selected>--Select table--</option>
                                              <option value="1">Monthly Forecast</option>
												                      <option value="2">Yearly Forecast</option>
												                      <option value="3">Seasonal Forecast</option>
											                      </select>
                                        </div>

                                             <button type="submit" name = "submit" class="btn btn-default">Display Table</button>

                                    </form>


<?php

$display = 1;

if (isset($_POST['submit']))
{
    $display = $_POST['table_select'];
}


//Calculate the median of array
function calculate_median($arr) {
    sort($arr);
    $count = count($arr); //total numbers in array
    $middleval = floor(($count-1)/2); // find the middle value, or the lowest middle value
    if($count % 2) { // odd number, middle is the median
        $median = $arr[$middleval];
    } else { // even number, calculate avg of 2 medians
        $low = $arr[$middleval];
        $high = $arr[$middleval+1];
        $median = floor(($low+$high)/2);
    }
    return $median;
} // end median function


/*



            MONTHLY



*/

if($display ==1){
$curyear = date('Y');
$curmonth = date('m');
$past1 = $curmonth - 1;
$past2 = $past1 - 1;

$query2 = "SELECT MONTH(sales_order.salesDate) AS salesDate, sales_order.salesID, receipt.prodName AS prodName, COUNT(*) as count
  FROM receipt
  JOIN sales_order ON sales_order.salesID = receipt.salesID
  WHERE MONTH(sales_order.salesDate) BETWEEN '$past2' AND '$past1'
  GROUP BY receipt.prodName";

$query = "SELECT MONTH(sales_order.salesDate) AS salesDate,sales_order.salesID, product.prodName, ingredient.ingName, ingredient.measurement, recipeing.convertedMeasurement AS convertedMeasurement, ingredient.total AS ingTotal
  FROM recipe
  JOIN recipeing on recipe.recipeID = recipeing.recipeID
  JOIN product on recipe.prodID = product.prodID
  JOIN ingredient on ingredient.ingID = recipeing.ingID
  JOIN converter on recipeing.measureID = converter.convertID
  JOIN inventory on ingredient.ingID = inventory.ingID
  JOIN receipt on product.prodName = receipt.prodName
  JOIN sales_order on sales_order.salesID = receipt.salesID
  WHERE MONTH(sales_order.salesDate) BETWEEN '$past2' AND '$past1'
  GROUP BY ingredient.ingName";

echo "<table class='table table-striped table-bordered table-hover' id='dataTables-example'>";
echo "<h2 class='page-header'>Monthly Forecast</h2>";
echo "<thead>";
echo "<tr align = center>";


echo "<th>Ingredient Name</td>";
echo "<th>Current Total Measurement Value</td>";
echo "<th>Forecasted Needed Value Monthly</td>";

echo "</tr></thead>";

$h = 0;
$i = 0;
$j = 0;
$product_name_array = [];
$ingredient_name_array = [];
$type_array = [];
$current_value_array = [];
$measurement_array = [];
$forecasted = [];

$prodName1 = [];
$count = [];
$result1=mysqli_query($conn,$query2);
  while($row = mysqli_fetch_array($result1)){
    $prodName1[$i] = $row['prodName'];
    $count[$i] = $row['count'];

    $i++;
  }

$result=mysqli_query($conn,$query);
while($row = mysqli_fetch_array($result)){

    $product_name_array[$h] = $row['prodName']; // product name
    $ingredient_name_array[$h] = $row['ingName']; // ingredient name
       $type_array[$h] = $row['measurement']; // measurement type
        $current_value_array[$h] = $row['ingTotal']; // total ingredients in database
    $measurement_array[$h] = $row['convertedMeasurement']; // converted measurement per ingredient

    $h++;
}

for($j; $j < $h; $j++){

    for($k = 0; $k < $i; $k++){

        if($product_name_array[$j] == $prodName1[$k])

          $forecasted[$j] = ($measurement_array[$j] * $count[$k]) / 2;
      }
    }

echo "<tbody>";
for($l = 0; $l < $h; $l++){

 echo '<tr><td align="left">';
  echo $ingredient_name_array[$l];
  echo '</td><td>';
  echo number_format($current_value_array[$l],2);
  echo '&nbsp';
  echo $type_array[$l];
  echo '</td><td>';
  echo number_format($forecasted[$l],2);
  echo '&nbsp';
  echo $type_array[$l];
  echo '</td>';
  echo '</tr>';
}


echo "</tbody></table>";

}

/*



            YEARLY



*/

if($display ==2){
	$curyear = date('Y');
$past1 = $curyear - 1;
$past2 = $past1 - 1;

$query2 = mysqli_query($conn, "SELECT sales_order.salesDate, sales_order.salesID, receipt.prodName AS prodName, COUNT(*) AS count
  FROM receipt
  JOIN sales_order ON sales_order.salesID = receipt.salesID
  WHERE sales_order.salesDate BETWEEN '$past2-1-1' AND '$past1-12-31'
  GROUP BY receipt.prodName ");

$query = "SELECT sales_order.salesDate AS salesDate,sales_order.salesID, product.prodName, ingredient.ingName, ingredient.measurement, recipeing.convertedMeasurement AS convertedMeasurement, ingredient.total AS ingTotal
  FROM recipe
  JOIN recipeing on recipe.recipeID = recipeing.recipeID
  JOIN product on recipe.prodID = product.prodID
  JOIN ingredient on ingredient.ingID = recipeing.ingID
  JOIN converter on recipeing.measureID = converter.convertID
  JOIN inventory on ingredient.ingID = inventory.ingID
  JOIN receipt on product.prodName = receipt.prodName
  JOIN sales_order on sales_order.salesID = receipt.salesID
  WHERE sales_order.salesDate BETWEEN '$past2-1-1' AND '$past1-12-31'
  GROUP BY ingredient.ingName";
echo "<h2 class='page-header'>Yearly Forecast</h2>";
echo "<table class='table table-striped table-bordered table-hover' id='dataTables-example'>";
echo "<thead>";
echo "<tr align = center>";


echo "<th>Ingredient Name</td>";
echo "<th>Current Total Measurement Value</td>";
echo "<th>Forecasted Needed Value Yearly</td>";

echo "</tr></thead>";

$h = 0;
$i = 0;
$j = 0;
$product_name_array = [];
$ingredient_name_array = [];
$type_array = [];
$current_value_array = [];
$measurement_array = [];
$forecasted = [];

$prodName1 = [];
$count = [];

  while($row = mysqli_fetch_array($query2)){
    $prodName1[$i] = $row['prodName'];
    $count[$i] = $row['count'];

    $i++;
  }

$result=mysqli_query($conn,$query);
while($row = mysqli_fetch_array($result)){

    $product_name_array[$h] = $row['prodName']; // product name
    $ingredient_name_array[$h] = $row['ingName']; // ingredient name
    $type_array[$h] = $row['measurement']; // measurement type
    $current_value_array[$h] = $row['ingTotal']; // total ingredients in database
    $measurement_array[$h] = $row['convertedMeasurement']; // converted measurement per ingredient

    $h++;
}

for($j; $j < $h; $j++){

    for($k = 0; $k < $i; $k++){

        if($product_name_array[$j] == $prodName1[$k])

          $forecasted[$j] = ($measurement_array[$j] * $count[$k]) / 2;
      }
    }

    echo "<tbody>";

for($l = 0; $l < $h; $l++){
 echo '<tr><td align="left">';
  echo $ingredient_name_array[$l];
  echo '</td><td>';
  echo number_format($current_value_array[$l],2);
  echo '&nbsp';
  echo $type_array[$l];
  echo '</td><td>';
  echo number_format($forecasted[$l],2);
  echo '&nbsp';
  echo $type_array[$l];
  echo '</td>';
  echo '</tr>';
}
echo "</tbody>";

}

/*



            SEASONAL



*/

if ($display==3) {
  echo "<h2 class='page-header'>Seasonal Forecast</h2>";

  if ($sql = mysqli_query($conn,'SELECT * FROM ingredient')) {

  }



}


?>

</div>
<?php include 'includes/sections/footer.php'; ?>
