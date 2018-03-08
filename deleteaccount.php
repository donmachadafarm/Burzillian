<?php
include 'includes/sections/header.php';

if ($_SESSION['usertype']!=101)
       header("Location:logout.php");

if (isset($_POST['submit'])){

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
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                      <thead>
                                        <tr>
                                          <th>User ID</th>
                                          <th>Username</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                  <?php

                                  $sql1 = "SELECT * FROM users WHERE usertype != '101'";
                                  $query1 = mysqli_query($conn,$sql1);

                                  while ($result = mysqli_fetch_array($query1,MYSQLI_ASSOC)) {


                                   ?>
                                        <tr>
                                          <td><?php echo $result['userID']; ?></td>
                                          <td><?php echo $result['username']; ?></td>
                                        </tr>
                                  <?php } ?>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                              </div>
                              <div class="card card-register mx-auto mt-5">
                                <div class="card-header">Remove an employee</div>
                                <div class="card-body">
                                  <form method="post" action="#.php">
                                    <div class="form-group">
                                      <div class="form-row">
                                        <div class="col-md-12">
                                          <label for="exampleInputName">Username</label>
                                          <input name="username" class="form-control" id="exampleInputName" type="text" aria-describedby="nameHelp" placeholder="Enter first name" required>
                                        </div>
                                      </div>
                                    </div>
                                    <button name="remove" type="submit" class="btn btn-danger btn-block">Remove User</button>
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
