<?php include 'includes/sections/header.php';
      include 'includes/sections/navbar.php';
 ?>
<div id="page-wrapper">

 <h1 class="page-header">Ingredients Forecast</h1>

   <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id ="table_select">

                                        <div class="form-group">
                                            <label>Select Tables to Display</label>
                                            <select name = "table_select" class="form-control" style="width: 300px;">
                                              <option value="1">Monthly Forecast</option>
                                              <option value="2">Yearly Forecast</option>
                                              <option value="3">Seasonal Forecast</option>
                                        </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Select Forecasting Method</label>
                                            <select name = "method" class="form-control" style="width: 300px;">
                                              <option value="1">Simple Moving Average</option>
                                              <option value="2">Exponential Smoothing</option>
                                              <option value="3">Weighted Moving Average</option>
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

$display = 0;

if (isset($_POST['submit']))
{
    $display = $_POST['table_select'];
    $method = $_POST['method'];
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

$sql = "SELECT MAX(salesDate) AS dateMax FROM sales_order";
$result=mysqli_query($conn,$sql);

echo "<table>";

while($row = mysqli_fetch_array($result)){

$most_recent_date = $row['dateMax'];

echo "<br>";

/*if($display == 1){
echo '<tr><td align="left">' .
"Last order made was on ".$most_recent_date . '</td><td>' .

'</tr>';
}*/
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

if($display == 1 && $method == 1){ // monthly and simple moving average
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


echo "<table class='table table-striped table-bordered table-hover'>";
echo "<tr align = center>";


echo "<th>Ingredient Name</td>";
echo "<th>Current Total Measurement Value</td>";
echo "<th>Forecasted Needed Value Monthly</td>";

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


echo "</table>";

} // end of if statement

if($display == 2 && $method == 1){ //yearly and simple moving average
$curyear = date('Y');
$past1 = $curyear - 1;
$past2 = $past1 - 1;

$query2 = mysqli_query($conn, "SELECT sales_order.salesDate, sales_order.salesID, receipt.prodName AS prodName, COUNT(*) AS count
  FROM receipt
  JOIN sales_order ON sales_order.salesID = receipt.salesID
  WHERE sales_order.salesDate BETWEEN '$past2-1-1' AND '$past1-12-31'
  GROUP BY receipt.prodName ");

$query = "SELECT sales_order.salesID, sales_order.salesDate AS salesDate,sales_order.salesID, product.prodName, ingredient.ingName, ingredient.measurement, recipeing.convertedMeasurement AS convertedMeasurement, ingredient.total AS ingTotal
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

} // end of if statement

if($display == 1 && $method == 2){ // monthly and exponential smoothing
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

for($m=0; $m < $h; $m++){

    for($k = 0; $k < $i; $k++){

        if($product_name_array[$m] == $prodName1[$k])

          $forecastedaverage[$m] = ($measurement_array[$m] * $count[$k]) / 2;
         $actualdemand[$m] = ($measurement_array[$m] * $count[$k]);
      }
    }
   //New forecast = Last period’s forecast + (Last period’s actual demand – Last period’s forecast)

$query2 = mysqli_query($conn, "SELECT sales_order.salesDate, sales_order.salesID, receipt.prodName AS prodName, COUNT(*) AS count
  FROM receipt
  JOIN sales_order ON sales_order.salesID = receipt.salesID
  WHERE MONTH(sales_order.salesDate) = '$past1'
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
  WHERE MONTH(sales_order.salesDate) = '$past1'
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

$smoothingcoefficient = 0.7;

    for($j =0; $j < $h; $j++){

    for($k = 0; $k < $i; $k++){

        if($product_name_array[$j] == $prodName1[$k])

          $forecasted[$j] = (($smoothingcoefficient * $actualdemand[$j]) + ((1-$smoothingcoefficient) * $forecastedaverage[$j]));
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
}// end of if statement

if($display == 2 && $method == 2){ // yearly and exponential smoothing
  $curyear = date('Y');
  $past1 = $curyear - 1;
  $past2 = $past1 - 1;

  //New forecast = Last period’s forecast + (Last period’s actual demand – Last period’s forecast)

$query2 = mysqli_query($conn, "SELECT sales_order.salesDate, sales_order.salesID, receipt.prodName AS prodName, COUNT(*) AS count
  FROM receipt
  JOIN sales_order ON sales_order.salesID = receipt.salesID
  WHERE sales_order.salesDate BETWEEN '$past2-1-1' AND '$past1-12-31'
  GROUP BY receipt.prodName ");

$query = "SELECT sales_order.salesID, sales_order.salesDate AS salesDate,sales_order.salesID, product.prodName, ingredient.ingName, ingredient.measurement, recipeing.convertedMeasurement AS convertedMeasurement, ingredient.total AS ingTotal
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

$smoothingcoefficient = 0.7;

for($m=0; $m < $h; $m++){

    for($k = 0; $k < $i; $k++){

        if($product_name_array[$m] == $prodName1[$k])

          $forecastedaverage[$m] = ($measurement_array[$m] * $count[$k]) / 2;
         $actualdemand[$m] = ($measurement_array[$m] * $count[$k]);
      }
    }


    for($j =0; $j < $h; $j++){

    for($k = 0; $k < $i; $k++){

        if($product_name_array[$j] == $prodName1[$k])

          $forecasted[$j] = (($smoothingcoefficient * $actualdemand[$j]) + ((1-$smoothingcoefficient) * $forecastedaverage[$j]));
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

} // end of if statement

if($display == 1 && $method == 3){ // monthly and weighted moving average
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
$result1=mysqli_query($conn,$query2);
  while($row = mysqli_fetch_array($result1)){
    $prodName1[$i] = $row['prodName'];
    $count[$i] = $row['count'];

    $i++;
  }

$result=mysqli_query($conn,$query);
while($row = mysqli_fetch_array($result)){
  $salesDate[$h] = $row['salesDate'];

    $product_name_array[$h] = $row['prodName']; // product name
    $ingredient_name_array[$h] = $row['ingName']; // ingredient name
       $type_array[$h] = $row['measurement']; // measurement type
        $current_value_array[$h] = $row['ingTotal']; // total ingredients in database
        $measurement[$h] = $row['convertedMeasurement']; // converted measurement per ingredient

    if($salesDate[$h] == $past1){
      $measurement_array[$h] = $measurement[$h] * .5;
    }
    else if($salesDate[$h] == $past2){
      $measurement_array[$h] = $measurement[$h] * .3;
    }

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






} //end of if statement

if($display == 2 && $method == 3){ // yearly and weighted moving average
$curyear = date('Y');
$past1 = $curyear - 1;
$past2 = $past1 - 1;

$query2 = mysqli_query($conn, "SELECT sales_order.salesDate, sales_order.salesID, receipt.prodName AS prodName, COUNT(*) AS count
  FROM receipt
  JOIN sales_order ON sales_order.salesID = receipt.salesID
  WHERE sales_order.salesDate BETWEEN '$past2-1-1' AND '$past1-12-31'
  GROUP BY receipt.prodName ");

$query = "SELECT sales_order.salesID, sales_order.salesDate AS salesDate, YEAR(sales_order.salesDate) AS salesYear, sales_order.salesID, product.prodName, ingredient.ingName, ingredient.measurement, recipeing.convertedMeasurement AS convertedMeasurement, ingredient.total AS ingTotal
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
  $salesYear[$h] = $row['salesYear'];

    $product_name_array[$h] = $row['prodName']; // product name
    $ingredient_name_array[$h] = $row['ingName']; // ingredient name
       $type_array[$h] = $row['measurement']; // measurement type
        $current_value_array[$h] = $row['ingTotal']; // total ingredients in database
        $measurement[$h] = $row['convertedMeasurement']; // converted measurement per ingredient

    if($salesYear[$h] == $past1){
      $measurement_array[$h] = $measurement[$h] * .5;
    }
    else if($salesYear[$h] == $past2){
      $measurement_array[$h] = $measurement[$h] * .3;
    }

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



}//end of if statement




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
