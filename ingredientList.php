<?php include 'includes/sections/header.php';
      include 'includes/sections/navbar.php';

            if (!isset($_SESSION['userType'])){
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
                            if ($_SESSION['userType']==101) {
                              $query = mysqli_query($conn, "SELECT ingredient.ingID, ingredient.ingName, ingredient.total, ingredient.measurement, inventory.ingID, inventory.measurement FROM ingredient JOIN inventory ON ingredient.ingID = inventory.ingID WHERE ingredient.total = 0 GROUP BY ingredient.ingName");
                            }else {
                              $query = mysqli_query($conn, "SELECT ingredient.ingID, ingredient.ingName, ingredient.total, ingredient.measurement, inventory.ingID, inventory.measurement FROM ingredient JOIN inventory ON ingredient.ingID = inventory.ingID GROUP BY ingredient.ingName");
                            }


                                    while($row = mysqli_fetch_array($query)){


                                    $ID = $row['ingID'];
                                    $measurement = $row['measurement'];
                                    $total = $row['total'];

                                    if ($_SESSION['userType']==102) {
                                      if($total <= 0)
                                          $total = 0;

                                      if($total > 0){
                                      echo '<tr class="recipe">';
                                          echo "<td style= \"text-align:center;\">{$row['ingName']}</td>";
                                          echo "<td style= \"text-align:center;\">";
                                          echo number_format($total,4)."<br></td>"; // made 5 decimal places
                                          echo "<td style= \"text-align:center;\">$measurement</td>";
                                      echo'</tr>';
                                      }
                                      mysqli_query($conn,"UPDATE ingredient SET total = '$total', measurement = '$measurement' WHERE ingID = $ID");
                                    }elseif ($_SESSION['userType']==101) {
                                      echo '<tr class="recipe">';
                                          echo "<td style= \"text-align:center;\">{$row['ingName']}</td>";
                                          echo "<td style= \"text-align:center;\">";
                                          echo number_format($total,4)."<br></td>"; // made 5 decimal places
                                          echo "<td style= \"text-align:center;\">$measurement</td>";
                                      echo'</tr>';
                                    }
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
