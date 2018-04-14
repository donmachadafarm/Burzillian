<?php include 'includes/sections/header.php';
      include 'includes/sections/navbar.php';
 ?>

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
                        <div class="panel-heading">
                          <h2 style = "font-size:20px;display: flex; justify-content: center;">
                          <?php
                          // echo proper date look
                            $fday = new DateTime($_GET['date']); // sets the date from get method into datetime format
                            $ffday = $fday->format('F-d-Y'); // formats the month date into words
                            echo "Raw Materials purchased on ".$ffday; // prints da thing
                          ?>
                          </h2>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <!--php code-->


                      <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Raw Material</th>
                                        <th>Quantity</th>
                                        <th>Measurement Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                // $query ="Select '$date' as date, rmName = $rmName, sum(quantity) as 'quantity', measurement, measurement_value, purchasedate, purchaseID
                                //             from record_purchases
                                //             where purchasedate BETWEEN '{$_SESSION['from_date']}' AND '{$_SESSION['to_date']}'
                                //             group by purchaseID;";
                                //     $result=mysqli_query($conn,$query);
                                //     while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                                //     echo '<tr">';
                                //         echo "<td>{$row['purchasedate']}</td>";
                                //         echo "<td>{$row['rmName']}</td>";
                                //         echo "<td>{$row['quantity']}</td>";
                                //         echo "<td>{$row['measurement_value']}</td>";
                                //         echo "<td>{$row['measurement']}</td>";
                                //
                                //     echo '</tr>';
                                //     }
                                  $datee = $_GET['date'];
                                  $query = "SELECT DISTINCT r.rmName, SUM(r.quantity) AS 'qty', i.measurement AS 'measurement'
                                                                  FROM record_purchases r
                                                                  JOIN inventory i ON r.rmName = i.rmName
                                                                  WHERE r.purchaseDate = '{$_GET['date']}'
                                                                  GROUP BY r.rmName";
                                  if ($result = mysqli_query($conn,$query)) {
                                    while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
                                      echo "<tr>";
                                        echo "<td>{$row['rmName']}</td>";
                                        echo "<td>{$row['qty']}</td>";
                                        echo "<td>{$row['measurement']}</td>";
                                      echo "</tr>";
                                    }
                                  }

                                ?>
                                </tbody></table>

<?php
echo "<br><p style = 'display: flex; justify-content: center;font-weight:bold;'>***END OF REPORT***</p>";
echo '<p>Generated: '.date("M-d-Y  h:i").'</p>';
 ?>

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

<?php include 'includes/sections/footer.php'; ?>
