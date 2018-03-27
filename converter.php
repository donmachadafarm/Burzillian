<?php include 'includes/sections/header.php';
      include 'includes/sections/navbar.php';

      if (!isset($_SESSION['userType']) || $_SESSION['userType']!=102){
        echo "<script>window.location='logout.php'</script>";
      }
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
                                            <th>Conver To</th>

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

                                        </tr>
                                     <?php endwhile ?>


                                    </tbody>

                                </table>



                            </div>
                            <!-- /.table-responsive -->

                                                                    <form name="form1" id="form1" action="" class="form-signin" method="post">


                                                    <p class="form-control-static">
                                                        <label>Measurement Convert From Value:</label></br> <input type="text" name="convertfrom" class="form-control" value="<?php if (isset($_POST['convertfrom'])) echo $_POST['convertfrom']; ?>"/>
                                                        </br>
                                                        <label>Measurement Convert To Value: </label></br><input type="text" name="convertto" class="form-control" value="<?php if (isset($_POST['convertto'])) echo $_POST['convertto']; ?>"/>
                                                        </br>
                                                        <label>Convertion Value: </label> </br><input type="text" name="convertvalue" class="form-control" maxlength="30" value="<?php if (isset($_POST['convertvalue'])) echo $_POST['convertvalue']; ?>"/>
                                                        </p>
                                                        <input type="submit" name="submit" value="Add Measurements" class="btn btn-default"/></div>
                                                        <br><br>
                      </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->

                            </div>



                                                 <?php


if (isset($_POST['submit'])){

$message=NULL;

 if (empty($_POST['convertfrom'])){
  $convertfrom=FALSE;
  $message.='<p>You forgot to enter the measurement for the convert from value!';
 }else
  $convertfrom=$_POST['convertfrom'];

 if (empty($_POST['convertto'])){
  $convertto=FALSE;
  $message.='<p>You forgot to enter the measurement for the convert to value!';

 }else
  $convertto=$_POST['convertto'];

 if (empty($_POST['convertvalue'])){
  $convertvalue=FALSE;
  $message.='<p>You forgot to enter the measurement value!';
 }else
  $convertvalue=$_POST['convertvalue'];





if(!isset($message)){
$query="insert into converter (convert_from,convert_to,convert_value) values ('{$convertfrom}','{$convertto}','{$convertvalue}')";
$result=mysqli_query($conn,$query);
$message="<b>INPUT SUCCESSFUL! </b>";

}


}/*End of main Submit conditional*/

if (isset($message)){
 echo '<font color="red">'.$message. '</font>';

}

?>
                                    </div></div></form></div></div><!--End Modal-->
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

    </div>
    <!-- /#wrapper -->
    <?php include 'includes/sections/footer.php'; ?>
