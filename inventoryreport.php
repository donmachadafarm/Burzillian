<?php include 'includes/sections/header.php';
      include 'includes/sections/navbar.php';

      if (!isset($_SESSION['userType']) || $_SESSION['userType']!=101){
        echo "<script>window.location='logout.php'</script>";
      }

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
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                if(isset($_POST['submit'])){
                                    $dt1 = new DateTime($_POST['datetimepicker1']);
                                    $dt2 = new DateTime($_POST['datetimepicker2']);
                                    $_SESSION['from_date'] = $dt1->format('Y-m-d');
                                    $_SESSION['to_date'] =  $dt2->format('Y-m-d');
                                    $date = $_SESSION['from_date']." to ". $_SESSION['to_date'];

                                    // $query ="SELECT S.salesDate as 'dates', SUM(R.subTotal) AS 'sales'
                                    //           FROM receipt R
                                    //           JOIN sales_order S ON R.salesID = S.salesID
                                    //           WHERE S.salesDate BETWEEN '{$_SESSION['from_date']}' AND '{$_SESSION['to_date']}'
                                    //           GROUP BY dates";
                                    // $query = mysqli_query($conn, "Select '$date' as date, rmName, sum(quantity) as 'quantity', purchasedate
                                    //         from record_purchases
                                    //         where purchasedate BETWEEN '{$_SESSION['from_date']}' AND '{$_SESSION['to_date']}'
                                    //         group by purchasedate
                                    //         order by purchasedate ASC;");
                                    // SELECT DISTINCT r.rmName, r.purchaseDate AS 'dateb', SUM(r.quantity) AS 'qty'
                                    //                               FROM record_purchases r
                                    //                               WHERE r.purchaseDate BETWEEN '2018-03-01' AND '2018-04-13'
                                    //                               GROUP BY r.rmName
                                    $query = mysqli_query($conn,"SELECT DISTINCT r.purchaseDate AS 'dateb', SUM(r.quantity) AS 'qty'
                                                                  FROM record_purchases r
                                                                  WHERE r.purchaseDate BETWEEN '{$_SESSION['from_date']}' AND '{$_SESSION['to_date']}'
                                                                  GROUP BY dateb");
                                    //$result=mysqli_query($conn,$query);
                                    while($row=mysqli_fetch_array($query)){
                                    echo '<tr">';
                                        echo "<td><center>{$row['dateb']}</center></td>";
                                        echo "<td><center><a href='viewinventoryreport.php?date={$row['dateb']}'>View Report</a></center></td>";
                                        // echo "<td><a data-toggle='modal' href='#inventoryreport' class='btn btn-primary'>View Report</a></td>";
                                        // echo "<td>{$row['rmName']}</a></td>";
                                        // echo "<td>{$row['qty']}</td>";


                                        echo'</td>';
                                    echo '</tr>';
                                    }
                                }


                            echo '</tbody>
                                </table>';


                        ?>

                        <!-- <center> <a data-toggle="modal" href="#inventoryreport" class="btn btn-primary">View Report</a> -->
        <!-- <div class="modal fade" id="inventoryreport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <form name="form1" id="form1" action="" class="form-signin" method="POST">
              <center>
                <h2 class="modal-title"></h2>

                  <div class="modal-body">

                  <header><B><font size="5">Inventory Report</font></B><br>
                  <?php
                  // echo $_SESSION['from_date'];
                  //       echo " to ";
                  //       echo $_SESSION['to_date'];
                        ?>
                  </header><br>


                      <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Raw Material</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                // $query ="Select '$date' as date, rmName, sum(quantity) as 'quantity', purchasedate, purchaseID
                                //             from record_purchases
                                //             where purchasedate BETWEEN '{$_SESSION['from_date']}' AND '{$_SESSION['to_date']}'
                                //             group by purchaseID;";
                                //     $result=mysqli_query($conn,$query);
                                //     while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                                //     echo '<tr">';
                                //         echo "<td>{$row['purchasedate']}</td>";
                                //         echo "<td>{$row['rmName']}</td>";
                                //         echo "<td>{$row['quantity']}</td>";
                                //
                                //     echo '</tr>';
                                //     }

                                ?>
                                </tbody></table>
                                End of Report
                                <?php
                                // echo '<p>Generated: '.date("M-d-Y  h:i").'</p>';
                                ?>

                        <br><br>

                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

            </div></center></form>

                  </div>

                            <!- /.table-responsive -->
                        <!-- </div> -->
                        <!-- /.panel-body -->
                    <!-- </div> -->
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
