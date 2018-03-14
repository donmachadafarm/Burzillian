<?php include 'includes/sections/header.php';
      include 'includes/sections/navbar.php';

      if (!isset($_SESSION['usertype']) || $_SESSION['usertype']!=101){
        echo "<script>window.location='logout.php'</script>";
      }
 ?>
<div id="page-wrapper">

 <h1 class="page-header">Sales and Raw Material Forecast</h1>

   <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id ="table_select">

                                        <div class="form-group">
                                            <label>Select Tables to Display</label>
                                            <select name = "table_select" class="form-control" style="width: 300px;">
                                              <option value="1" selected>Daily Sales Per Item</option>
                                              <option value="2">Daily Sales Forecast Per Item</option>
                                              <option value="3">Total Sales Per Item</option>
                                              <option value="4">Raw Materials Forecast</option>
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
function calculate_average($arr) {
    $count = count($arr); //total numbers in array
    foreach ($arr as $value) {
        $total = $total + $value; // total value of array numbers
    }
    $average = floor($total/$count); // get average value
    return $average;
}// end average function


//Get most recent date
$most_recent_date = "";

$sql = "SELECT MAX(salesDate) AS dateMax FROM sales_order";
$result=mysqli_query($conn,$sql);

echo "<table>";

while($row = mysqli_fetch_array($result)){

$most_recent_date = $row['dateMax'];

echo "<br>";

if($display == 1){
echo '<tr><td align="left">' .
"Last order made was on ".$most_recent_date . '</td><td>' .

'</tr>';
}
}
echo "</table>";
echo "<br>";


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
echo "DAILY SALES PER ITEM";
echo "<table class='table table-striped table-bordered table-hover'>";

echo "<tr align = left>";

echo "<th>Date</td>";
echo "<th>Product Name</td>";
echo "<th>Sales Volume</td>";
echo "<th>Sales</td>";
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
echo "</table>";


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

//DAILY SALES FORECAST TABLE
if ($display == 2){
echo "<table class='table table-striped table-bordered table-hover'>";
echo "<tr align = center>";

echo "<th>Product Name</th>";
echo "<th>Daily Sales Volume Forecast</th>";
echo "<th>Daily Sales Forecast</th>";
echo "</tr>";

echo "DAILY SALES FORECAST PER ITEM";
$total_sales_forecast = 0;
for ($i = 0; $i < $count_unique; $i++)
{

    echo '<tr><td align="left">' .
$unique_prodName_array[$i] . '</td><td>' .
$median_quantity_array[$i] . '</td><td>' .
$unique_price_array[$i] *  $median_quantity_array[$i]. '</td>' .
'</tr>';
$total_sales_forecast += ($unique_price_array[$i] *  $median_quantity_array[$i]);
}
echo '<tr><th>Total: </th> <td>'. $total_sales_forecast.' </td></tr>';

echo "</table>";
}

//TOTAL SALES PER ITEM TABLE
if ($display == 3){
echo "<table class='table table-striped table-bordered table-hover'>";

echo "TOTAL SALES PER ITEM";

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




$sql = "
SELECT product.prodName, ingredient.ingName, ingredient.measurement, ingredient.total, recipeing.converted_measurement, inventory.rmName, inventory.quantity, inventory.measurement_value
FROM recipe
JOIN recipeing on recipe.recipeID = recipeing.recipeID
JOIN product on recipe.prodID = product.prodID
JOIN ingredient on ingredient.ingID = recipeing.ingID
JOIN converter on recipeing.measureID = converter.convertID
JOIN inventory on inventory.ingID = ingredient.ingID

";

$result=mysqli_query($conn,$sql);

 if ($display == 4){
echo "RAW MATERIALS FORECAST";
echo "<table class='table table-striped table-bordered table-hover'>";

echo "<tr align = center>";

//echo "<th>Product Name</td>";
echo "<th>Ingredient Name</td>";
echo "<th>Measurement</td>";
echo "<th>Current Total Measurement Value</td>";
echo "<th>Forecasted Needed Value Per Day</td>";
echo "<th>Raw Material</td>";
echo "<th>Current Quantity</td>";
echo "<th>Forecasted Quantity</td>";
echo "</tr>";


$product_name_array = [];
$ingredient_name_array = [];
$type_array = [];
$current_value_array = [];
$measurement_array = [];
$rawMaterial_array = [];
$quantity_array = [];
$forecasted_quantity_array = [];


$h = 0;
while($row = mysqli_fetch_array($result)){
/*
    echo '<tr align = "center"><td>' .
$row['prodName'] . '</td><td>' .
$row['ingName'] . '</td><td>' .
$row['measurement']. '</td><td>' .
$row['converted_measurement']. '</td><td>' .

'</tr>';
  */

    $product_name_array[$h] = $row['prodName'];
    $ingredient_name_array[$h] = $row['ingName'];
       $type_array[$h] = $row['measurement'];
       $current_value_array[$h] = $row['total'];
    $measurement_array[$h] = $row['converted_measurement'];
      $current_value_array[$h] = $row['total'];
      //$forecasted_measurement_array =
      $rawMaterial_array[$h] =  $row['rmName'];
          $quantity_array[$h] =  $row['quantity'];

          $forecasted_quantity_array[$h] = $row['measurement_value'];


$h++;
}

for ($i = 0; $i < $count_unique; $i++) //checks every unique product name
{

//compares product name to every ingredient associated to a product
for($j = 0; $j< $h; $j++)
{
    if ($unique_prodName_array[$i] == $product_name_array[$j] &&  $measurement_array[$j] != NULL)
    {
          echo '<tr><td align="left">' .
//$product_name_array[$j] . '</td><td>' .
  $ingredient_name_array[$j]. '</td><td>' .
  $type_array[$j]. '</td><td>' .
    $current_value_array[$j]. '</td><td>' .
($measurement_array[$j] * $median_quantity_array[$i]). '</td><td>' .
$rawMaterial_array[$j]. '</td><td>' .
$quantity_array[$j]. '</td><td>' .
floor(($measurement_array[$j] * $median_quantity_array[$i]) / $forecasted_quantity_array[$j]). '</td>' .
'</tr>';
    }
}

}

/*
echo "<tr align = center>";
echo "<td>prodName</td>";
echo "<td>salesID</td>";
//echo "<td>receipt_quantity</td>";
echo "<td>salesDate</td>";
echo "<td>recipeName</td>";
echo "<td>ingName</td>";
//echo "<td>convert_from</td>";
echo "<td>convert_to</td>";
//echo "<td>measureval</td>";
echo "<td>rmName</td>";
echo "<td>measurement</td>";
echo "<td>measurement_value</td>";
echo "<td>inventory_quantity</td>";
echo "<td>subtract</td>";
echo "<td>new_measurement</td>";
echo "</tr>";

while($row = mysqli_fetch_array($result)){

echo '<tr align = "center"><td>' .
$row['prodName'] . '</td><td>' .
$row['salesID'] . '</td><td>' .
//$row['receipt_ quantity'] . '</td><td>' .
$row['salesDate'] . '</td><td>' .
$row['recipeName'] . '</td><td>' .
$row['ingName'] . '</td><td>' .
//$row['convert_from'] . '</td><td>' .
$row['convert_to'] . '</td><td>' .
//$row['measureval'] . '</td><td>' .
$row['rmName'] . '</td><td>' .
$row['measurement'] . '</td><td>' .
$row['measurement_value'] . '</td><td>' .
$row['inventory_quantity'] . '</td><td>' .
$row['subtract'] . '</td><td>' .
$row['new_measurement'] . '</td><td>' .


'</tr>';

}
*/
echo "</table>";
}


/*
$sql = "SELECT receipt.prodName, receipt.salesID , receipt.quantity AS receipt_quantity, sales_order.salesDate,
recipe.recipeName, ingredient.ingName, converter.convert_from, converter.convert_to, recipeing.measureVal,
inventory.rmName, inventory.measurement, inventory.measurement_value, inventory.quantity AS inventory_quantity,
round(receipt.quantity*recipeing.converted_measurement, 3) AS 'subtract', round(inventory.measurement_value - (receipt.quantity*recipeing.converted_measurement), 3) AS 'new_measurement'
FROM recipe
JOIN recipeing on recipe.recipeID = recipeing.recipeID
JOIN product on recipe.prodID = product.prodID
JOIN receipt on receipt.prodName = product.prodName
JOIN sales_order on receipt.salesID = sales_order.salesID
JOIN ingredient on ingredient.ingID = recipeing.ingID
JOIN converter on recipeing.measureID = converter.convertID
JOIN inventory on inventory.ingID = ingredient.ingID
WHERE  receipt.salesID = (SELECT MAX(receipt.salesID) FROM receipt)
GROUP BY recipe.recipeID,ingredient.ingName,receipt.prodName, sales_order.salesDate;";
$result=mysqli_query($sql);
*/


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
