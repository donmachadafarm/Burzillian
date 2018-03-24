<?php include 'includes/sections/header.php';
      include 'includes/sections/navbar.php';
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
                                <div class='col-md-3'>
                                    <div class="form-group">
                                        <div class='input-group date'>
                                            <input type='date' class="form-control" id='datetimepicker1' name='datetimepicker1'/>
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
                                        <th>Raw Material</th>
                                        <th>Physical Count</th>
                                        <th>Disc</th>
                                        <th>Date Counted</th>
                                        <th>Counted By:</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                // not yet updated if button is clicked
                                if(isset($_POST['submit'])){
                                    $dt1 = new DateTime($_POST['datetimepicker1']);
                                    $_SESSION['from_date_desc'] = $dt1->format('Y-m-d');
                                    // $query ="SELECT inventory.rmName as 'rawname', sum(inventory.quantity) as 'quantity',
                                    //         input_physical_count.date as 'display_day', sum(input_physical_count.quantity) as 'counted',
                                    //         users.fullName as 'fullname' from inventory
                                    //         join input_physical_count on inventory.rmID = input_physical_count.rmID
                                    //         join users on input_physical_count.userID = users.userID
                                    //         where input_physical_count.date BETWEEN '{$_SESSION['from_date_desc']}' AND '{$_SESSION['to_date_desc']}'
                                    //         AND inventory.rmName = '{$_POST['rmName']}' order by input_physical_count.date ASC;";
                                    $query = "SELECT inventory.rmName as 'rawname', input_physical_count.quantity as 'quantity', input_physical_count.date as 'display_date',
                                                     input_physical_count.
                                              FROM input_physical_count
                                              WHERE input_physical_count.date = $_SESSION['from_date_desc']";
                                    $result=mysqli_query($conn,$query);
                                    while($row=mysqli_fetch_array($result)){
                                    echo '<tr">';
                                        echo "<td>{$row['rawname']}</td>";
                                        echo "<td>{$row['quantity']}</td>";
                                        echo "<td>{$row['display_day']}</td>";
                                        echo "<td>{$row['fullname']}</td>";
                                        echo'</td>';
                                    echo '</tr>';
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
