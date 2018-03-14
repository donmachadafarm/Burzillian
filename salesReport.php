<?php include 'includes/sections/header.php';
      include 'includes/sections/navbar.php';

      if (!isset($_SESSION['usertype']) || $_SESSION['usertype']!=101){
        echo "<script>window.location='logout.php'</script>";
      }
 ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Sales Report</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <!--php code-->
                        <div class="container">
                        <form method="post">
                                <div class='col-md-4'>
                                    <div class="form-group">
                                        <div class='input-group date'>
                                            <input type='date' class="form-control" id='datetimepicker1' name='datetimepicker1'/>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class='col-md-4'>
                                    <div class="form-group">
                                        <div class='input-group date'>
                                            <input type='date' class="form-control" id='datetimepicker2' name='datetimepicker2'/>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <input name = "submit" type="submit" class="btn btn-primary" value= "Generate"/>
                        </form>
                        </div>
                        <?php

                            echo '<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Quantity</th>
                                        <th>Total Income</th>
                                        <th>Generate Report</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                if(isset($_POST['submit'])){
                                    $dt1 = new DateTime($_POST['datetimepicker1']);
                                    $dt2 = new DateTime($_POST['datetimepicker2']);
                                    $_SESSION['from_date'] = $dt1->format('Y-m-d');
                                    $_SESSION['to_date'] =  $dt2->format('Y-m-d');
                                    $date = $_SESSION['from_date']." to ". $_SESSION['to_date'];
                                    $query ="Select '.$date.' as date, sum(receipt.quantity) as 'quantity', sum(receipt.subTotal) as 'income'
                                            from sales_order join receipt on sales_order.salesID = receipt.salesID
                                            where sales_order.salesDate BETWEEN '{$_SESSION['from_date']}' AND '{$_SESSION['to_date']}';";
                                    $result=mysqli_query($conn,$query);
                                    while($row=mysqli_fetch_array($result)){
                                    echo '<tr">';
                                        echo "<td>{$row['date']}</td>";
                                        echo "<td>{$row['quantity']}</td>";
                                        echo "<td>{$row['income']}</td>";
                                        echo '<td style = "display: flex; justify-content: space-around;">';
                                                echo "<a href = 'viewSalesReport.php'>View Report</a>";
                                        echo'</td>';
                                    echo '</tr>';
                                    }
                                    echo  $_SESSION['from_date'] ;

                                }


                            echo '</tbody>
                                </table>';


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

<?php include 'includes/sections/footer.php'; ?>
