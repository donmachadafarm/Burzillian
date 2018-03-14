<?php include 'includes/sections/header.php';
      include 'includes/sections/navbar.php';

      if (!isset($_SESSION['usertype']) || $_SESSION['usertype']!=102){
        echo "<script>window.location='logout.php'</script>";
      }
 ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Ingredients</h1>
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

                        <?php

                            echo '<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th style= \'text-align:center;\'>Ingredients</th>
                                        <th style= \'text-align:center;\'>Total</th>
                                        <th style= \'text-align:center;\'>Measurement Type</th>
                                    </tr>
                                </thead>
                                <tbody>';

                          //  $query = mysqli_query($conn,"SELECT ING.ingName, INV.measurement, INV.ingID, ING.ingID, sum(quantity * measurement_value) AS total FROM inventory INV JOIN ingredient ING ON ING.ingID = INV.ingID GROUP BY ING.ingName");

                               $query = mysqli_query($conn, "SELECT * FROM ingredient");


                                    while($row = mysqli_fetch_array($query)){


                                    $ID = $row['ingID'];
                                    $measurement = $row['measurement'];
                                    $total = $row['total'];

                                    if($total > 0){
                                    echo '<tr class="recipe">';
                                        echo "<td style= \"text-align:center;\">{$row['ingName']}</td>";
                                        echo "<td style= \"text-align:center;\">";
                                        echo number_format($total,2)."<br></td>";
                                        echo "<td style= \"text-align:center;\">$measurement</td>";
                                    echo'</tr>';
                                }
                               mysqli_query($conn,"UPDATE ingredient SET total = '$total', measurement = '$measurement' WHERE ingID = $ID");

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
    <!-- /#wrapper -->
<?php include 'includes/sections/footer.php'; ?>
