<?php
include 'includes/sections/header.php';
if ($_SESSION['userType']!=101)
       header("Location:logout.php");
if (isset($_POST['remove'])){
  $deletedaccount = $_POST['userID'];
  $query = "DELETE FROM users WHERE userID = '$deletedaccount'";
  if (mysqli_query($conn,$query)) {
    echo "<script> alert('Succesfully removed account!');
        </script>";
  }else {
    echo "di gumana<br>";
  }
}/*End of main Submit conditional*/
include 'includes/sections/navbar.php';
?>


            <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Remove User</h1>
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

                                  <!-- BODY/CONTENT -->
                                  <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                      <thead>
                                        <tr>
                                          <th>Username</th>
                                          <th>Full name</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                  <?php
                                  $sql1 = "SELECT * FROM users WHERE userType != '101'";
                                  $query1 = mysqli_query($conn,$sql1);
                                  while ($result = mysqli_fetch_array($query1,MYSQLI_ASSOC)) {
                                   ?>
                                        <tr>
                                          <td><?php echo $result['userName']; ?></td>
                                          <td><?php echo $result['fullName']; ?></td>
                                        </tr>
                                  <?php } ?>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                              </div>
                              <div class="card card-register mx-auto mt-5">
                                <div class="card-header"><b>Remove an employee</b></div>
                                <div class="card-body">
                                  <form method="post" action="">
                                    <div class="form-group">
                                      <div class="form-row">
                                        <div class="col-md-8">
                                           <label class="control-label"  for="userID">Employee name:</label>
                                          <select name ="userID" class="form-control">
                                          <?php
                                            $flag=0;
                                            $i = 1;

                                            $result = mysqli_query($conn, "SELECT * FROM users WHERE userType!=101");

                                            while($row = mysqli_fetch_array($result)){

                                              $userID = $row['userID'];
                                              echo "<label><option value = \"{$userID}\"/>{$row['fullName']}</label>";

                                              }

                                            ?>
                                          </select><br><br>
                                          </div><div>
                                        </div>
                                        <div class="col-md-8">
                                          <input name="remove" type="submit" value="Remove" class="btn btn-danger btn-block">
                                        </div>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                              </div>
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
    <?php include 'includes/sections/footer.php'; ?>
