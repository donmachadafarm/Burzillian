<?php include 'includes/sections/header.php';
      include 'includes/sections/navbar.php';

      if (!isset($_SESSION['userType']) || $_SESSION['userType']!=101){
        echo "<script>window.location='logout.php'</script>";
      }
 ?>

       <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Discrepancy Reports</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Discrepancy Table
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <!--php code-->
                        <div class="container">

                          <form method="post">
                              <div class ="row">
                                  <div class='col-md-3 col-md-offset-3'>
                                      <div class="form-group">
                                          <div class='input-group date'>
                                              <input type='date' class="form-control" id='datetimepicker1' name='datetimepicker'/>
                                              <span class="input-group-addon">
                                                  <span class="glyphicon glyphicon-calendar"></span>
                                              </span>
                                          </div>
                                      </div>
                                  </div>
                                  <input name = "submit" type="submit" class="btn btn-primary" value= "Generate"/>
                              </div>
                          </form>
                        </div>
                        <?php
                          echo '<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>Ingredient Name</th>
                                    <th>Discrepancy Count</th>
                                    <th>Counted By:</th>
                                    <th>Date Counted</th>
                                </tr>
                            </thead>
                            <tbody>';

                        // $qry = "SELECT ingredient.ingName AS 'ingname', discrepancy.discrepancyCount AS 'count', users.fullName AS 'user', discrepancy.checkedDate AS 'date'
                        //         FROM discrepancy
                        //         JOIN ingredient ON discrepancy.ingredientID = ingredient.ingID
                        //         JOIN users ON discrepancy.checkerUser = users.userID
                        //         ORDER BY discrepancy.checkedDate ASC";
                        // if ($p = mysqli_query($conn,$qry)) {
                        //   while ($row=mysqli_fetch_array($p)) {
                        //     echo "<tr>";
                        //       echo "<td>{$row['ingname']}</td>";
                        //       echo "<td>{$row['count']}</td>";
                        //       echo "<td>{$row['user']}</td>";
                        //       echo "<td>{$row['date']}</td>";
                        //     echo "</tr>";
                        //   }
                        // }

                                // not yet updated if button is clicked
                                if(isset($_POST['submit'])){
                                    $dt1 = $_POST['datetimepicker'];
                                    // $_SESSION['from_date_desc'] = $dt1->format('Y-m-d');
                                    // $query ="SELECT inventory.rmName as 'rawname', sum(inventory.quantity) as 'quantity',
                                    //         input_physical_count.date as 'display_day', sum(input_physical_count.quantity) as 'counted',
                                    //         users.fullName as 'fullname' from inventory
                                    //         join input_physical_count on inventory.rmID = input_physical_count.rmID
                                    //         join users on input_physical_count.userID = users.userID
                                    //         where input_physical_count.date BETWEEN '{$_SESSION['from_date_desc']}' AND '{$_SESSION['to_date_desc']}'
                                    //         AND inventory.rmName = '{$_POST['rmName']}' order by input_physical_count.date ASC;";
                                    // $query = "SELECT inventory.rmName as 'rawname', input_physical_count.quantity as 'quantity', input_physical_count.date as 'display_date',
                                    //                  input_physical_count.
                                    //           FROM input_physical_count
                                    //           WHERE input_physical_count.date = $_SESSION['from_date_desc']";

                                    $query = "SELECT ingredient.ingName AS 'ingname', discrepancy.discrepancyCount AS 'count', users.fullName AS 'user', discrepancy.checkedDate AS 'date'
                                            FROM discrepancy
                                            JOIN ingredient ON discrepancy.ingredientID = ingredient.ingID
                                            JOIN users ON discrepancy.checkerUser = users.userID
                                            WHERE discrepancy.checkedDate = '$dt1'
                                            ORDER BY discrepancy.checkedDate ASC";

                                    if ($result=mysqli_query($conn,$query)) {
                                      while($row=mysqli_fetch_array($result)){
                                      echo '<tr">';
                                          // echo "<td>{$row['rawname']}</td>";
                                          // echo "<td>{$row['quantity']}</td>";
                                          // echo "<td>{$row['display_day']}</td>";
                                          // echo "<td>{$row['fullname']}</td>";
                                          echo "<td>{$row['ingname']}</td>";
                                          echo "<td>{$row['count']}</td>";
                                          echo "<td>{$row['user']}</td>";
                                          echo "<td>{$row['date']}</td>";
                                      echo '</tr>';
                                      }
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

    <?php include 'includes/sections/footer.php'; ?>
