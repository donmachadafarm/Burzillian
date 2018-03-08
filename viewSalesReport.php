<?php include 'includes/sections/header.php';
      include 'includes/sections/navbar.php';
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
                                $query="Select sales_order.salesDate as 'date', receipt.prodName as 'product', product.price as 'price',
                                    receipt.quantity as 'quantity', receipt.subTotal as 'subTotal' from receipt join sales_order on
                                    receipt.salesID = sales_order.salesID join product on
                                    receipt.prodName = product.prodName
                                    where sales_order.salesDate BETWEEN '".$_SESSION['from_date']."' AND '".$_SESSION['to_date']."'
                                    group by receipt.prodName, sales_order.salesDate;";
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
                                $query1="Select sum( receipt.subTotal) as 'total'
                                    from receipt join sales_order on receipt.salesID = sales_order.salesID
                                    join product on receipt.prodName = product.prodName
                                    where sales_order.salesDate BETWEEN '".$_SESSION['from_date']."' AND '".$_SESSION['to_date']."';";
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
