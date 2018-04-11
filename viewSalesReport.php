<?php include 'includes/sections/header.php';
      include 'includes/sections/navbar.php';
      if (!isset($_SESSION['userType']) || $_SESSION['userType']!=101){
        echo "<script>window.location='logout.php'</script>";
      }
 ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12" >
                    <h1 class="page-header">Sales Report</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php
                            $dt1 =$_SESSION['from_date'];
                            $dt2 =$_SESSION['to_date'];
                            ?>
                            <h2 style = "font-size:20px;display: flex; justify-content: center;">
                            <?php
                            // echo proper date look
                              $fday = new DateTime($_GET['date']); // sets the date from get method into datetime format
                              $ffday = $fday->format('F-d-Y'); // formats the month date into words
                              echo "Sales from ".$ffday; // prints da thing
                            ?>
                            </h2>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <!--php code-->

                        <?php
                            echo '<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Total Items Sold</th>
                                        <th>Total Sales</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                // $query="SELECT S.salesDate as date, S.salesID, R.salesID, R.prodName as product, R.quantity, R.subTotal, (R.subTotal / R.quantity) AS price
                                //           FROM receipt R
                                //           JOIN sales_order S
                                //           ON R.salesID = S.salesID
                                //           WHERE S.salesDate BETWEEN
                                //           '".$_SESSION['from_date']."' AND '".$_SESSION['to_date']."'
                                //           ORDER BY product;";
                                $query="SELECT S.salesID, R.salesID, R.prodName as product, SUM(R.quantity) as 'totalitems', SUM(R.subTotal) as 'totalsales'
                                          FROM receipt R
                                          JOIN sales_order S ON R.salesID = S.salesID
                                          WHERE S.salesDate = '{$_GET['date']}'
                                          GROUP BY product";
                                $result=mysqli_query($conn,$query);
                                $totalsales = 0;
                                while($row=mysqli_fetch_array($result)){
                                    $price = $row['totalsales'];
                                    $totalsales+=$price;
                                    echo '<tr>';
                                        echo "<td>{$row['product']}</td>";
                                        echo "<td>{$row['totalitems']}</td>";
                                        echo "<td>";
                                        echo number_format($price,2);
                                        echo "</td>";
                                    echo '</tr>';
                                }
                            echo '</tbody>
                                </table>';
                                // $query1="SELECT SUM(PR.totalPrice) AS 'total'
                                //         FROM sales_order PR
                                //         WHERE PR.salesDate == '{$_GET['date']}';";
                                // if($result1=mysqli_query($conn,$query1)){
                                  echo '<div style="font-weight:bold;font-size:20px;display: flex; justify-content: center;">';
                                  echo '<label>Total Income:&nbsp;</label>';
                                //   while($row=mysqli_fetch_array($result1)){
                                //       echo "<span>{$row['total']}</span>";
                                //   }
                                // }
                                  echo "<span>".$totalsales."</span>";
                            echo '</div>';
                            echo "<br><p style = 'display: flex; justify-content: center;font-weight:bold;'>***END OF REPORT***</p>";
                            echo '<p>Generated: '.date("M-d-Y  h:i").'</p>';
                        ?>

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
    <!-- /#wrapper -->
<?php include 'includes/sections/footer.php'; ?>
