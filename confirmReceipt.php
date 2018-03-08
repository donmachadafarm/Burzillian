                    <?php
session_start();
require 'connect.php';

?>


              <?php

$number = 0;
$needed_cash = 0;

$quantity_error = 0;

 if (isset($_POST['name'])){
  $name=$_POST['name'];
 $number = count($_POST["name"]);  //counts transaction rows
}

if (isset($_POST['quantity']))
 $quantity=$_POST['quantity'];

if (isset($_POST['cash']))
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


echo "Confirm Receipt\n\n\n\n";

for ($i = 0; $i < $number; $i++)
{
	echo "$name[$i]    ";
	echo "$quantity[$i]     ";
	echo "$subTotal_array[$i]\n";

}

echo "\n\n\nTotal:  $total";
echo "\n\nCash:     $cash";
echo "\nChange:     $cash_change"; 

if ($cash_change < 0)
{
	 $needed_cash = $cash_change * (-1);

    echo "\n\n\nInsufficient Cash! Need P$needed_cash more!";
}

if ($quantity_error == 1)
{
	echo "\n\n\nInvalid quantity input on some orders! Please input positive or non-zero values";
}

              ?>


