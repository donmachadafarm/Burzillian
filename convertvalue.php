<?php include 'includes/sections/header.php';
      include 'includes/sections/navbar.php';
 ?>

  <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Measurement Converter</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            <!-- /.row -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Measurements
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Convert From</th>
                                            <th>Convert To</th>
                                            <th>Value</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sql = "SELECT * from converter";
                                            $result = mysqli_query($conn,$sql);
                                            while($row = mysqli_fetch_array($result)):;
                                            ?>

                                        <tr>
                                            <td><?php echo $row['convertID']?></td>
                                            <td><?php echo $row['convert_from']?></td>
                                            <td><?php echo $row['convert_to']?></td>
                                            <td><?php echo $row['convert_value']?></td>

                                        </tr>
                                     <?php endwhile ?>


                                    </tbody>

                                </table>



                            </div>
                            <!-- /.table-responsive -->

                                                                               <form name="form1" id="form1" action="" class="form-signin" method="post">
                          <label>Choose raw material: </label>
                                                  <select name ="rmName" class="form-control">
     <?php
    $flag=0;
    $i = 1;

        $result = mysqli_query($conn,'SELECT *
                                FROM inventory');
        while($row = mysqli_fetch_array($result)){

        $rmName = $row['rmName'];
             echo "<label><option value = \"{$rmName}\"/>{$row['rmName']}</label>";

        }

            ?>
            </select>
            <br>
                                                        <label>Convert to:</label></br>
                                                        <select name ="convertto" class="form-control">
     <?php
    $flag=0;
    $i = 1;

        $result = mysqli_query($conn,'SELECT *
                                FROM converter');
        while($row = mysqli_fetch_array($result)){

        $convertfrom = $row['convert_from'];
             echo "<label><option value = \"{$convertfrom}\"/>{$row['convert_from']}</label>";

        }

            ?>
            </select>
            <br>
                                                        <input type="submit" name="submit" value="Convert" class="btn btn-default"/></div>
                                                        <br><br>

                                    </form>
                      </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->


                            </div>
                               <?php
                                          $flag = 1;

                                            if (isset($_POST['submit'])){
                                            $convertto = $_POST['convertto'];
                                            $rmName = $_POST['rmName'];

                                            $result = mysqli_query($conn,'SELECT *
                                                                    FROM inventory, converter');

                                            while($row = mysqli_fetch_array($result)){
                                                $rmName1 = $row['rmName'];
                                                $convertfrom1 = $row['convert_from'];

                                                if($rmName == $rmName1 && $convertfrom1 == $convertto){
                                                    $measurement_value = $row['measurement_value'];
                                                    $convertfrom = $row['convert_from'];
                                                    $convertvalue = $row['convert_value'];
                                                }
                                            }

                                                $converted = $measurement_value/$convertvalue;
                                                echo "<B>Converted value: </B>";
                                                echo $converted;

                                                $flag++;

                                                $sql3 = " UPDATE inventory SET measurement = '$convertto', measurement_value = '$converted' WHERE rmName = '$rmName'";
                                            }


                                        if($flag != 1){
    $result = mysqli_query($conn,$sql3);
        if (!$result){
          die('Invalid Input: ' . mysqli_error().$sql);
        }
        else{
          echo "<script> alert('Successfully Added');
                window.location.href='rawmaterials.php';
                </script> ";

        }
    }



                                    ?>



                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

<?php include 'includes/sections/footer.php'; ?>
