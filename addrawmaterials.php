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
                           require 'Connect.php';
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

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Record Purchases</h1>
                </div>
            </div>
<div>
<?php
    require 'Connect.php';
    $flag=0;

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

    if(empty($_POST['purchasedate'])){
    $purchasedate = '';
    $flag=1;
    } else
    $purchasedate = ($_POST['purchasedate']);

    if(empty($_POST['ingID'])){
    $ingID = '';
    $flag=1;
    } else
    $ingID = ($_POST['ingID']);

    if(empty($_POST['measurement'])){
    $measurement = '';
    $flag=1;
    } else
    $measurement = ($_POST['measurement']);

    if(empty($_POST['measurement_value'])){
    $measurement_value = '';
    $flag=1;
    } else
    $measurement_value = ($_POST['measurement_value']);
    
   $convert = mysql_query('SELECT *
                            FROM converter');

    while($row = mysql_fetch_array($convert))
    {
        if($measurement == $row['convert_from']){
           $measurement_value *= $row['convert_value'];
            $measurement = $row['convert_to'];
        } 
    }

    $sql1 = " INSERT INTO inventory(quantity, rmName, measurement_value, measurement, ingID) 
            VALUES ('$quantity', '$rmName', '$measurement_value', '$measurement', '$ingID'); ";



        if($flag != 1){
    $result = mysql_query($sql1);
        if (!$result){
          die('Invalid Input: ' . mysql_error().$sql);
        }  
        else{
          echo "<script> alert('Successfully Added'); 
                window.location.href='addrawmaterials.php';
                </script> ";
        }
    }

    $sql2 = " INSERT INTO record_purchases(quantity, rmName, purchasedate, measurement_value, measurement, ingID) 
            VALUES ('$quantity', '$rmName', '$purchasedate', '$measurement_value', '$measurement', '$ingID'); ";



        if($flag != 1){
    $result = mysql_query($sql2);
        if (!$result){
          die('Invalid Input: ' . mysql_error().$sql2);
        }  
        else{
          echo "<script> alert('Successfully Added'); 
                window.location.href='addrawmaterials.php';
                </script> ";
        }
    }
?>


</div>
     <div id = "formContent">
     <form class="form-signin" action='' method="POST">

   

        <label class="control-label"  for="rmName">Raw Material Name: </label><br>
        <input type="text" id="textbox" name="rmName" placeholder="" class="form-control"><br><br>

         <label class="control-label"  for="measurement_value">Measurement Value: </label><br>
        <input type="text" id="textbox" name="measurement_value" placeholder="Ex. 250" class="form-control"><br><br>



       <label class="control-label" for="measurement">Measurement: </label><br>
<select name ="measurement" class="form-control">
        <?php
    require 'Connect.php';
    $flag=0;
    $i = 1;

        $result = mysql_query('SELECT *
                                FROM converter');

        while($row = mysql_fetch_array($result)){
            
            $convert_from = $row['convert_from'];
            $convert_to = $row['convert_to'];

             echo "<label><option value = \"{$row['convert_from']}\"/>{$row['convert_from']}</label>"; 
             echo "<br>";
        }
           

             echo "<label><option value = \"Liter\"/>Liter</label> <br>"; 
             echo "<label><option value = \"Kilogram\"/>Kilogram</label>"; 
             echo "</div>";
?>
</select>
<br><br>
        <label class="control-label"  for="quantity">Quantity: </label><br>
        <input type="text" id="textbox" name="quantity" placeholder="" class="form-control"><br><br>

        <label class="control-label"  for="purchasedate">Date: </label><br>
        <input type="text" id="textbox" name="purchasedate" placeholder="" class="form-control"><br><br>

<style>
#textbox{
        width: 300px;
        height:30px;
        padding: 1%;
        border-radius: 4%;
    }
</style>
       <div class="form-group">
        
        <select name ="ingID" class="form-control">                               
    <?php
    require 'Connect.php';
    $flag=0;
    $i = 1;

        $result = mysql_query('SELECT *
                                FROM ingredient');

        
        while($row = mysql_fetch_array($result)){
            
        $ingID = $row['ingID'];
             echo "<label><option value = \"{$ingID}\"/>{$row['ingName']}</label>"; 
             
        }
           
            ?>
            </select> 
<br><br>
                                
        <button type="submit" class="btn btn-success" value="submit">Add Raw Material</button>
        </form>


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
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>

</body>

</html>
