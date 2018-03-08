
 <?php 
session_start();
require_once 'connect.php';

/*

1. Add the price of product * quantity to total
2. insert total to sales_order table
3. insert date to sales_order table
4. when inserting testID to receipt table, retrieve MAX salesorderID

*/
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
$result=mysql_query($sql);

  if ($result){
  //$result is 0 
  while($row = mysql_fetch_array($result))
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
 $sql = "INSERT INTO productreceipt(salesDate, totalPrice, cash, change) VALUES(NOW(),'$total', '$cash', '$cash_change')";  
  mysql_query($sql, $con);

// Calculate Total ()


 if($number > 0)  
 {  
      for($i=0; $i<$number; $i++)  
      {  
           
                $sql = "INSERT INTO receipt(salesID, prodName, quantity, subTotal) VALUES((SELECT MAX(salesID) FROM sales_order), '$name[$i]', '$quantity[$i]', '$subTotal_array[$i]')";  
                mysql_query($sql, $con);  


      }  

//converted_measurements is measureVal = convert_to

$sql = "SELECT receipt.prodName, receipt.salesID , receipt.quantity AS receipt_quantity, sales_order.salesDate,
recipe.recipeName, ingredient.ingID, ingredient.ingName, converter.convert_from, converter.convert_to, recipeing.measureVal,
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
$result=mysql_query($sql); 


while($row = mysql_fetch_array($result)){
$i = 0;
$subtract = $row['subtract'];
while($subtract > 0)
{
  $subtract -=  $row['measurement_value'];
  $i++;
}

$new_quantity = $row['new_measurement'];
$updateRM = "UPDATE inventory
SET quantity = quantity - $i
WHERE ingID = {$row['ingID']} AND quantity = {$row['inventory_quantity']};
";
$result2=mysql_query($updateRM, $con); 

}

//subtract = number of ingredients used
//new_measurement = value of inventory after subtracting

      echo "Transaction Complete!";
      //Total Amount: $total | Cash: $cash | Change: $cash_change  
 }  
 else  
 {  
      echo "Please Select Product";  
 }  
}//end change conditional
else{
  
  if($cash_change < 0){
  $needed_cash = $cash_change * (-1);
    echo "Insufficient Cash! Need P$needed_cash more!\n";
  }

  if ($quantity_error == 1)
    {
      echo "Invalid quantity input on some orders! Please input positive or non-zero values.";
    }
  }


 ?> 

