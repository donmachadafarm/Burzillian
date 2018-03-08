<?php include 'includes/sections/header.php';
      include 'includes/sections/navbar.php';
 ?>

       <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Change Price Report</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Price Details
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
                                        <th>Products</th>
                                        <th>Old Price</th>
                                        <th>New Price</th>
										<th>Date Changed</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                if(isset($_POST['submit'])){
                                    $dt1 = new DateTime($_POST['datetimepicker1']);
                                    $dt2 = new DateTime($_POST['datetimepicker2']);
                                    $_SESSION['from_date'] = $dt1->format('Y-m-d');
                                    $_SESSION['to_date'] =  $dt2->format('Y-m-d');
                                    $date = $_SESSION['from_date']." to ". $_SESSION['to_date'];
                                    $query ="Select '$date' as date, old_price, new_price, product_id, date_edited
                                            from price_list
                                            where date_edited BETWEEN '{$_SESSION['from_date']}' AND '{$_SESSION['to_date']}'
                                            group by product_id
                                            order by date_edited ASC;";
									$result=mysqli_query($conn,$query);


                                    while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                                    echo '<tr">';
										$productid = $row['product_id'];
										$query1="SELECT prodName
											from product
											where prodID = '$productid'";
										$result1=mysqli_query($conn,$query1);
										$row1=mysqli_fetch_array($result1,MYSQLI_ASSOC);

                                        echo "<td>{$row1['prodName']}</td>";
                                        echo "<td>{$row['old_price']}</a></td>";
                                        echo "<td>{$row['new_price']}</td>";
										echo "<td>{$row['date_edited']}</td>";

                                        echo'</td>';
                                    echo '</tr>';
                                    }
                                }


                            echo '</tbody>
                                </table>';


                        ?>


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
g
