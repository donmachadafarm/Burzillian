<?php include 'includes/sections/header.php';
      include 'includes/sections/navbar.php';

      if (!isset($_SESSION['usertype']) || $_SESSION['usertype']!=101){
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
                            <h2 style = "font-size:20px;display: flex; justify-content: center;"><?php echo date('M-d-Y', strtotime($_SESSION['from_date'])) ." to ". date('M-d-Y', strtotime($_SESSION['to_date'])); ?></h2>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <!--php code-->

                        <?php

                            echo '<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                $query=
"SELECT PR.salesDate as 'date', S.prodName as 'product',(S.subTotal / S.quantity) as 'price', S.quantity as 'quantity', S.subTotal as 'subTotal'
FROM productreceipt PR
JOIN products_sales_receipt S
ON PR.receiptID = S.receiptID
WHERE PR.salesDate BETWEEN
'".$_SESSION['from_date']."' AND '".$_SESSION['to_date']."'
GROUP BY S.prodName, PR.salesDate;";
                                $result=mysqli_query($conn,$query);

                                while($row=mysqli_fetch_array($result)){
                                    echo '<tr>';
                                        echo "<td>{$row['date']}</td>";
                                        echo "<td>{$row['product']}</td>";
                                        echo "<td>{$row['price']}</td>";
                                        echo "<td>{$row['quantity']}</td>";
                                        echo "<td>{$row['subTotal']}</td>";
                                    echo '</tr>';

                                }

                            echo '</tbody>
                                </table>';
                                $query1=
"SELECT SUM(PR.totalPrice) AS 'total'
FROM productreceipt PR
WHERE PR.salesDate BETWEEN
'".$_SESSION['from_date']."' AND '".$_SESSION['to_date']."';";
                                $result1=mysqli_query($conn,$query1);

                            echo '<div style="font-weight:bold;font-size:20px;display: flex; justify-content: center;">';
                                echo '<label>Total Income:&nbsp;</label>';
                                while($row=mysqli_fetch_array($result1)){
                                    echo "<span>{$row['total']}</span>";
                                }
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
