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
                <a class="navbar-brand" href="index.php" id="title"><font size="5">Burzillian Nation</font></a>  <!-- INPUT LOGO OF BURZILLIAN -->
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
                    <h1 class="page-header">Purchase Order Report</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Raw Materials
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <!--php code-->
            

                  <header><B><font size="5">Inventory Report</font></B><br>
                  <?php
                  session_start();
                  require 'Connect.php';
                   echo $_SESSION['from_date'];
                        echo " to ";
                        echo $_SESSION['to_date'];
                        ?>
                  </header><br>


                      <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Raw Material</th>
                                        <th>Quantity</th>
                                        <th>Measurement Value</th>
                                        <th>Measurement Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $query ="Select '$date' as date, rmName, sum(quantity) as 'quantity', measurement, measurement_value, purchasedate, purchaseID
                                            from record_purchases
                                            where purchasedate BETWEEN '{$_SESSION['from_date']}' AND '{$_SESSION['to_date']}'
                                            and rmName = '$rmName'
                                            group by purchaseID;";
                                    $result=mysqli_query($dbc,$query);  
                                    while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                                    echo '<tr">';
                                        echo "<td>{$row['purchasedate']}</td>";
                                        echo "<td>{$row['rmName']}</td>";
                                        echo "<td>{$row['quantity']}</td>";
                                        echo "<td>{$row['measurement_value']}</td>";
                                        echo "<td>{$row['measurement']}</td>";
                                                                      
                                    echo '</tr>';   
                                    }

                                ?>
                                </tbody></table>
                                End of Report
                                <?php  echo '<p>Generated: '.date("M-d-Y  h:i").'</p>';?>

                        <br><br>
            
            </div></center></form>
                  
                  </div>

                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
        </div>
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
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });


    $(document).on("click", ".open-AddBookDialog", function () {
         var myBookId = $(this).data('id');
         $(".modal-body #bookId").val( myBookId );
         // As pointed out in comments, 
         // it is superfluous to have to manually call the modal.
         // $('#addBookDialog').modal('show');
    });



    });
    </script>

</body>

</html>
