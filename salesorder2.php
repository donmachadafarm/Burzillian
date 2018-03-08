                    <?php
session_start();
require 'connect.php';

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Burzillian Nation</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
             <style>
                    @font-face{
                            font-family: hipsterish;
                            src: url(hipsterishfontnormal.ttf);
                        }
                        #title{
                            font-family: hipsterish;
                        }
                </style>
                <a class="navbar-brand" href="index.php" id="title"><font size="5">Burzillian Nation</font></a> <!-- INPUT LOGO OF BURZILLIAN -->
            </div>
            <!-- /.navbar-header -->

          <ul class="nav navbar-top-links navbar-right">
                
                <li class="dropdown">
                <style>
                #woo{
                    overflow: auto; 
  max-height: 40vh;
}
  </style>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages" id="woo">
                        <li>
                           <?php
                           //require 'Connect.php';
                           $sql = mysql_query('SELECT * FROM message');
                        while($row = mysql_fetch_array($sql)){
                            echo  "<a href='#'>";
                               echo "<div>";
                                    echo "<strong>";
                                    
                                        echo $row['fullName'];
                                
                                    echo "</strong>";
                                   echo "<span class='pull-right text-muted'>
                                        <em>";
                                 
                                        echo $row['msgdate'];
                                    
                                    echo "</em>
                                    </span>
                                </div>";
                                echo "<div>";
                             
                                        echo $row['message'];
                                    
                                    echo "</div> </a>";
                                }
                            ?>
                        </li>
                        
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="addnewaccount.php"><i class="fa fa-user fa-fw"></i> Add New User</a>
                        </li>
                        <li><a href="message.php"><i class="fa fa-user fa-fw"></i> Leave message</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="login.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
            </ul>
            <!-- /.navbar-top-links -->

    
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
<li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> Inventory<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="rawmaterials.php">Raw Materials</a>
                                </li>
                                <li>
                                    <a href="inputphysical.php">Input Physical Count</a>
                                </li>
                                <li>
                                    <a href="converter.php">Add Conversion</a>
                                </li>
                                <li>
                                    <a href="convertvalue.php">Converter</a>
                                </li>
                                </ul>

                        <li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> Recipe<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="addIngredients.php">Add Ingredients</a>
                                </li>
                                <li>
                                    <a href="ingredientList.php">Ingredient List</a>
                                </li>
                                <li>
                                    <a href="recipeList.php">Recipe List</a>
                                </li>
                                <li>
                                    <a href="addRecipe.php">Add Recipe</a>
                                </li>
                                </ul>
                     <li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> Reports<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="inventoryreport.php">Historical Inventory Report</a>
                                </li>
                                <li>
                                    <a href="salesreport.php">Historical Sales Report</a>
                                </li>
                                
                        </ul>
                        </li>
                         <li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> Products<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="addProducts.php">Add Products</a>
                                </li>
                                <li>
                                    <a href="viewProducts.php">View Products</a>
                                </li>
                                <li>
                                    <a href="addsalesorder.php">Add Sales Order</a>
                                </li>
                                
                                
                        </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> Forecasting<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="rawmaterialforecast.php">Inventory and Sales Forecast</a>
                                </li>
                              
                                
                                
                        </ul>
                        </li>


            </div>
            <!-- /.navbar-static-side -->
        </nav>



                <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"> Create Sales Order</h1>
                    </div>
                    <!-- /.col-lg-12 -->
<div class="form-group">  

                     <table id="menu" class='table table-striped table-bordered table-hover' >
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Product Type</th>
                                        <th>Price</th>
                                        <th width="20%">Quantity</th>
                                        <th>Action</th>
                                       
                                    </tr>
                                </thead>
                             

<?php
//require 'Connect.php';

$sql = mysql_query("SELECT prodID, prodName, prodType, price FROM product ORDER BY prodType, prodName");
$count=1;
$items = array();

if($sql){

while($row = mysql_fetch_array($sql)){
echo '<tr id="t'.$count.'" ><td align="left">' .
$row['prodName'] . '</td><td>' .
$row['prodType'] . '</td><td>' .
$row['price'] .  '</td><td><input type="text" name="quantity" class="form-control"/></td>
<td><center><button id="'. $count.'" name = "submit" type="submit" class="btn btn-default" onclick="addToOrder(this)">Add</button></td></tr></center>';
$count++;

}
}
?>
</table>

<?php

$flag=0;

 if(empty($_POST['hidden_prodName'])){
    $prodName = '';
    $flag=1;
    } else
    $prodName = ($_POST['hidden_prodName']);

    if(empty($_POST['hidden_price'])){
    $price = '';
    $flag=1;
    } else
    $price = ($_POST['hidden_price']);

    if(empty($_POST['hidden_quantity'])){
    $quantity = '';
    $flag=1;
    } else
    $quantity = ($_POST['hidden_quantity']);

    //$prodName = $_POST['hidden_prodName'];
    //$price = $_POST['hidden_price'];
    //$quantity = $_POST['hidden_quantity'];

    echo $quantity;
    echo $price;
    echo $prodName;

    $subTotal = $quantity * $price;


    $query = mysql_query("SELECT * FROM productreceipt");

    while($row=mysql_fetch_array($query)){
      $receiptID = $row['receiptID'];
    }

      $sql1 = " INSERT INTO products_sales_receipt(prodName, quantity, subTotal) 
            VALUES ($prodName', '$quantity', '$subTotal'); ";



        if($flag != 1){
    $result = mysql_query($sql1);
        if (!$result){
          die('Invalid Input: ' . mysql_error().$sql);
        }  
        else{
          echo "<script> alert('Successfully Added'); 
                window.location.href='index.php';
                </script> ";
        }
    }    

?>

<h3>Order Details</h3>
<div class="table-responsive">
<form role="form" method="post">
    <table id="details" class="table table-bordered">
    <tbody>
    <tr>
    <th width ="30%">Product Name</th>
    <th width="10%">Price</th>
    <th width="20%">Quantity</th>
    </tr>
    </tbody></table>
</div>

<input type="hidden" id="hidden_prodName" name="hidden_prodName" value="" />
<input type="hidden" id="hidden_price" name="hidden_price" value="" />
<input type="hidden" id="hidden_quantity" name="hidden_quantity" value="" />

<button name = "submit" type="submit" class="btn btn-default">Submit</button>
    </form>

                </div>
                <!-- /.row -->



            </div>
            <!-- /.container-fluid -->
        
        <!-- /#page-wrapper -->



    </div>


    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>

    var init = 0;
    var total = 0;
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });

    function addToOrder(button) {
  console.log(button.id);

  total = 0;
  var name = [];
  name.push($("#t"+button.id).find('td').eq(0).html());
  var price = [];
  price.push($("#t"+button.id).find('td').eq(2).html());
  var quantity = [];
  quantity = $("#t"+button.id).find('input');
  quantity.push($("#t"+button.id).find('input'));

  $('#details tbody').append('<tr class="child"><td>'+name+'</td><td>'+price+'</td><td>'+quantity.val()+'</td></tr>');

  console.log(name[0]);
  console.log(price[0]);
  console.log(quantity.val());

   $("#hidden_prodName").val(name);
   $("#hidden_price").val(price);
   $("#hidden_quantity").val(quantity.val());
  //document.getElementById('#hidden_prodName').value(name);
  //document.getElementById('#hidden_price').value(price);
  //document.getElementById('#hidden_quantity').value(quantity.val());
}

    </script>

</body>

</html>
