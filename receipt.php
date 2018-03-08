
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

 echo $name[0];
 echo $quantity[0];
 echo $cash[0];

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

