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
                        <div class="panel-heading">Raw Materials
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
                                        <th>Raw Material</th>
                                        <th>Total Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                if(isset($_POST['submit'])){
                                    $dt1 = new DateTime($_POST['datetimepicker1']);
                                    $dt2 = new DateTime($_POST['datetimepicker2']);
                                    $_SESSION['from_date'] = $dt1->format('Y-m-d');
                                    $_SESSION['to_date'] =  $dt2->format('Y-m-d');
                                    $date = $_SESSION['from_date']." to ". $_SESSION['to_date'];
                                    $query ="Select '$date' as date, rmName, sum(quantity) as 'quantity', measurement, measurement_value, purchasedate, ingID
                                            from record_purchases
                                            where purchasedate BETWEEN '{$_SESSION['from_date']}' AND '{$_SESSION['to_date']}'
                                            group by rmName
                                            order by purchasedate ASC;";
                                    $result=mysqli_query($conn,$query);
                                    while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                                    echo '<tr">';
                                        echo "<td>{$row['date']}</td>";
                                        echo "<td>{$row['rmName']}</a></td>";
                                        echo "<td>{$row['quantity']}</td>";


                                        echo'</td>';
                                    echo '</tr>';
                                    }
                                }


                            echo '</tbody>
                                </table>';


                        ?>

                           <center> <a data-toggle="modal" href="#inventoryreport" class="btn btn-primary">View Report</a>
                        <div class="modal fade" id="inventoryreport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <form name="form1" id="form1" action="" class="form-signin" method="POST">
              <center>
                <h2 class="modal-title"></h2>

                  <div class="modal-body">

                  <header><B><font size="5">Inventory Report</font></B><br>
                  <?php echo $_SESSION['from_date'];
                        echo " to ";
                        echo $_SESSION['to_date'];?>
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
                                            group by purchaseID;";
                                    $result=mysqli_query($conn,$query);
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

                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

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

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>


    $(document).on("click", ".open-AddBookDialog", function () {
         var myBookId = $(this).data('id');
         $(".modal-body #bookId").val( myBookId );
         // As pointed out in comments,
         // it is superfluous to have to manually call the modal.
         // $('#addBookDialog').modal('show');
    });



    });
    </script>
<?php include 'includes/sections/footer.php'; ?>
