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
                                              <option value="1">Daily Sales Per Item</option>
                                              <option value="2">Total Sales Per Item</option>
                                              <option value="3">Weekly Forecast</option>
                                              <option value="4">Monthly Forecast</option>
												<option value="5">Yearly Forecast</option>
												<option value="6">Seasonal Forecast</option>
											</select>
                                        </div>

                                             <button type="submit" name = "submit" class="btn btn-default">Display Table</button>

                                    </form>


<?php

/*
1. Get sales median per item | note : median = better if there are outliers | average = better if values are between two extremes (improbable)
(e.g. 21 Burgers/day)
>>> Get the mean/median of daily sales (Can be from current month, year or just get all daily sales)

2. Multiply number of raw materials used as an ingredient to sales median
(e.g. 2 cheese slices per burger | 2 * 21 = 42 Cheese slices/day)

3. Add up all initial forecasts (per RM)

4. Subtract current inventory from forecasted RM

5. Retrieve final forecast (per RM)


*/

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

//Calculate the average of array

//Get most recent date
$most_recent_date = "";

$sqlz = "SELECT MAX(salesDate) AS dateMax FROM sales_order";
$resultz=mysqli_query($conn,$sqlz);

echo "<table>";

while($row = mysqli_fetch_array($resultz)){

$most_recent_date = $row['dateMax'];

echo "<br>";

if($display == 1){
echo '<tr><td align="left">' .
"Last order made was on ".$most_recent_date . '</td><td>' .

'</tr>';
}
}
echo "</table>";



//Get Daily Sales per Item
 $sql = "SELECT  S.salesDate, R.prodName, SUM(R.quantity) AS quantity_sum , P.price, (P.price * SUM(R.quantity)) AS price_sum
 FROM receipt R
 LEFT JOIN sales_order S ON R.salesID = S.salesID
 JOIN product P ON R.prodName = P.prodName
 GROUP BY S.salesDate, R.prodName
 ORDER BY R.prodName ";

$result=mysqli_query($conn,$sql);


?>



<?php

$prodName_array = [];
$unique_prodName_array = [];
$quantity_array = [];
$price_array = [];
$unique_price_array = [];

if($result){

$i = 0;
if($display == 1){
  echo "<div class='col-lg-12'>";
echo "<div class='panel panel-default'>";
echo "<table class='table table-bordered table-hover' id='dataTables-example' width='100%' cellspacing='0'>";
echo "<div class='panel-heading'>";
 echo "<label><h4>Now Showing: Daily Sales Per Item</h4></label>";
 echo "</div><div class='panel-body'>";
 echo "<thead>";
echo "<tr align = left>";

echo "<th>Date</td>";
echo "<th>Product Name</td>";
echo "<th>Sales Volume</td>";
echo "<th>Sales</td></tr></thead><tbody>";
}//end display conditional

//Convert daily sales per item into multi array so calculate_median can be used effectively
while($row = mysqli_fetch_array($result)){

if($display == 1){
echo '<tr><td align="left">' .
$row['salesDate'] . '</td><td>' .
$row['prodName'] . '</td><td>' .
$row['quantity_sum'] . '</td><td>' .
$row['price_sum'] . '</td>' .

'</tr>';
}//end display conditional

$prodName_array[$i] = $row['prodName'];
$quantity_array[$i] = $row['quantity_sum'];
$price_array[$i] = $row['price_sum'];
$unique_price_array[$i] = $row['price'];
$i++;

}     //end while
}      //end if

if ($display == 1)
echo "</tbody></table></div></div></div>";


$median_quantity_array = [];
$sum_quantity_array = [];
$sum_price_array = [];
//takes the median sales per item

$unique_prodName_array = array_unique($prodName_array);
$unique_prodName_array = array_filter($unique_prodName_array);
$unique_prodName_array = array_values($unique_prodName_array);
//print_r($unique_prodName_array);

$unique_price_array = array_unique($unique_price_array);
$unique_price_array = array_filter($unique_price_array);
$unique_price_array = array_values($unique_price_array);

$count_unique = count($unique_prodName_array);
$count = count($prodName_array);

$calculate_median_perItem_array = []; //Sales Forecast
$calculate_sum_perItem_array = []; //Total Volume Sales
//$calculate_total_perItem_array = []; //Total Sales
$calculate_max_perItem_array = []; //
$calculate_min_perItem_array = []; //

for ($i = 0; $i < $count_unique; $i++)
{
    $k = 0;
    unset($calculate_median_perItem_array);
    unset($calculate_sum_perItem_array);

    //echo "\n\n$unique_prodName_array[$i]";
    for($j=0; $j < $count; $j++)
    {
        if ($unique_prodName_array[$i] == $prodName_array[$j]) //groups together product with same prodName
        {
                $calculate_median_perItem_array[$k] = $quantity_array[$j];
                $calculate_sum_perItem_array[$k] = $quantity_array[$j];
                $calculate_total_perItem_array[$k] = $price_array[$j];
                $k++;
        }
    } // Groups sales per item


    $median_quantity_array[$i] = calculate_median($calculate_median_perItem_array);
    $sum_quantity_array[$i] = array_sum($calculate_sum_perItem_array);
     $sum_price_array[$i] = array_sum($calculate_total_perItem_array);
}



//TOTAL SALES PER ITEM TABLE
if ($display == 2){
echo "<table class='table table-striped table-bordered table-hover'>";

echo "<label>Total Sales Per Item</label>";
echo "<tr align = center>";

echo "<th>Product Name</td>";
echo "<th>Total Sales Volume</td>";
echo "<th>Total Sales</td>";
echo "</tr>";

for ($i = 0; $i < $count_unique; $i++)
{

    echo '<tr><td align="left">' .
$unique_prodName_array[$i] . '</td><td>' .
$sum_quantity_array[$i] . '</td><td>' .
$sum_price_array[$i] . '</td>' .
'</tr>';
}

echo "</table>";
}



if($display ==4){
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

echo "<div class='panel panel-default'>";
echo "<table class='table table-striped table-bordered table-hover' id='dataTables-example'>";
echo "<div class='panel-heading'><label><h4>Now showing: Monthly Forecast</h4> </label>";
echo "<thead>";
echo "<tr align = center>";


echo "<th>Ingredient Name</td>";
echo "<th>Current Total Measurement Value</td>";
echo "<th>Forecasted Needed Value Monthly</td>";

echo "</tr></thead></div><div class='panel-body'>";

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


echo "</tbody></table></div></div>";

}

if($display ==5){
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

echo "<table class='table table-striped table-bordered table-hover'>";


echo "<tr align = center>";


echo "<th>Ingredient Name</td>";
echo "<th>Current Total Measurement Value</td>";
echo "<th>Forecasted Needed Value Yearly</td>";

echo "</tr>";

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


}
if ($display==6) {

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

  echo "<div class='panel panel-default'>";
  echo "<table class='table table-striped table-bordered table-hover' id='dataTables-example'>";
  echo "<div class='panel-heading'><label><h4>Now showing: Monthly Forecast</h4> </label>";
  echo "<thead>";
  echo "<tr align = center>";


  echo "<th>Ingredient Name</td>";
  echo "<th>Current Total Measurement Value</td>";
  echo "<th>Forecasted Needed Value Monthly</td>";

  echo "</tr></thead></div><div class='panel-body'>";

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


  echo "</tbody></table></div></div>";
}


?>




<!--
<script>
   <button onclick="myFunction()">Print this page</button>
function myFunction() {
    window.print();
}
</script>
-->

</div>
<?php include 'includes/sections/footer.php'; ?>
