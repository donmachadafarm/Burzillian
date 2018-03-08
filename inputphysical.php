<?php include 'includes/sections/header.php';
      include 'includes/sections/navbar.php';
 ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Physical Count</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                      <div class="form-group">

                                      <table class='table table-striped table-bordered table-hover' >
                                      <tr>
                                      <th>Raw Material</th>
                                      <th>Quantity</th>
                                      </tr>
                                      <?php
                                          $sql = mysqli_query($conn,'SELECT * from inventory');

                                          $i = 0;
                                          while($row = mysqli_fetch_array($sql)){
                                              $rmName[$i] = $row['rmName'];
                                              $rmID[$i] = $row['rmID'];
                                              $ingID[$i] = $row['ingID'];
                                              $rm = $row['rmID'];
                                              echo "<tr><td>";
                                              echo "<input type ='hidden' name='rmID[]' value='$rm' required>";
                                              echo $rmName[$i];
                                              echo '<td><input type="text" name="quantity[]" placeholder="" class="form-control" required><br>';
                                              echo "</tr>";
                                              $i++;
                                          }
                                      ?>
                                      </table>

                                      <p class="form-control-static">
                                      <?php echo "<b>Counted by: </b>" . $_SESSION['name']; ?>
                                      <br>
                                      <small>Note* Input Physical Count form is submitted once per day only</small>
                                      </p>
                                      </div>

                                      <input type="submit" name="submit" value="Submit"  class="btn btn-default">
                                      </form>


    <?php

        // if submit button is pressed
        if (isset($_POST['submit'])){
          $message=NULL;
          // counting all rawmats in the inventory
          $query1 = mysqli_query($conn,"select count(ingID) as count from inventory");
          while($row=mysqli_fetch_array($query1)){
              $count = $row['count'];
              // $count for container rawmat count in inventory
          }
          // $rmID raw materials id in an array
          $rmID = $_POST['rmID'];
          // $quantity of raw materials per item in an array as counted physically
          $quantity = $_POST['quantity'];
          // $date getting the date to track when the physical count is done. Year Month day format yyyy-mm-dd
          $date = date('Y-m-d');
          // $userID getting the current user who used the form
          $userID = $_SESSION['userid'];
          // getting the total from ingredient table
          $resf = mysqli_query($conn,"SELECT * FROM ingredient");

          // checker if there is actual ingredients in the inventory
          if($count > 0)
          {
             for ($i=0; $i < $count; $i++) {
               // query for inserting into input physical count.
               $sql = "INSERT INTO input_physical_count(rmID, userID, quantity, date) VALUES('$rmID[$i]', '$userID', '$quantity[$i]', '$date')";
               $result = mysqli_query($conn, $sql);
             }
             // looping through count of all ingredients in inventory table listed in input physical
             for($i=0; $i<$count; $i++)
              {
                  $resu = mysqli_query($conn,"SELECT * FROM inventory WHERE ingID = '$ingID[$i]'");
                  $computedvalue = 0;
                  $rowd = mysqli_fetch_array($resf);
                  if ($resu->num_rows > 1) {
                    // for repeating ingID's
                    for ($j=0; $j < $resu->num_rows; $j++) {
                      $row = mysqli_fetch_array($resu);
                      $tempcount = $quantity[$j] * $row['measurement_value'];
                      $computedvalue = $computedvalue + $tempcount;
                    }
                    if ($computedvalue!=$rowd['total']) {
                      $temp = $computedvalue - $rowd['total'];
                      $iding = $rowd['ingID'];
                      $sql = "INSERT INTO discrepancy(ingredientID, discrepancyCount, checkerUser, checkedDate) VALUES('$iding','$temp','$userID','$date')";
                      $resulta = mysqli_query($conn,$sql);
                    }
                    
                    $i += $resu->num_rows-1;
                  }
                  else {
                    // for non repeating ingID
                    $row = mysqli_fetch_array($resu);
                    $computedvalue = $quantity[$i] * $row['measurement_value'];
                    if ($computedvalue!=$rowd['total']) {
                      $temp = $computedvalue - $rowd['total'];
                      $iding = $rowd['ingID'];
                      $sql = "INSERT INTO discrepancy(ingredientID, discrepancyCount, checkerUser, checkedDate) VALUES('$iding','$temp','$userID','$date')";
                      $resulta = mysqli_query($conn,$sql);
                    }
                  }

              }//end of for loop


        }//end of if count > 0

    }//end of if submit statement
    ?>

                                </div>



                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?php include 'includes/sections/footer.php'; ?>
