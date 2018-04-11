<?php include 'includes/sections/header.php'; ?>

<?php
 if (!isset($_SESSION['userType']))
        header("Location:logout.php");
?>

<?php include 'includes/sections/navbar.php'; ?>



<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">

              <?php
              $query = "SELECT * FROM ingredient WHERE total = 0";
              if($res = mysqli_query($conn,$query)){
                ?>
                <!-- Ingredient warning side -->
                <div class="col-lg-6">
                      <div class="panel panel-yellow">
                        <div class="panel-heading">
                          <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-list-alt fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $res->num_rows; ?></div>
                                    <div>Ingredient Warnings!</div>
                                </div>
                            </div>
                        </div>
                        <a href="ingredientList.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                      </div>
                </div>
              <?php } ?>

                <?php
                $query = "SELECT discrepancy.discrepancyCount AS 'count',
                                 discrepancy.checkedDate AS 'date',
                                 ingredient.ingName AS 'ingName'
                          FROM discrepancy
                          JOIN ingredient ON discrepancy.ingID = ingredient.ingID
                          ORDER BY discrepancy.checkedDate DESC
                          LIMIT 5";
                if($res = mysqli_query($conn,$query)){
                 ?>
                <div class="col-lg-6">
                         <div class="panel panel-red">
                           <div class="panel-heading">
                             <div class="row">
                                   <div class="col-xs-3">
                                       <i class="fa fa-tasks fa-5x"></i>
                                   </div>
                                   <div class="col-xs-9 text-right">
                                       <div class="huge"><?php echo $res->num_rows; ?></div>
                                       <div>Discrepancy Warnings!</div>
                                   </div>
                               </div>
                           </div>
                           <a href="discrepancyTable.php">
                               <div class="panel-footer">
                                   <span class="pull-left">View Details</span>
                                   <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                   <div class="clearfix"></div>
                               </div>
                           </a>
                         </div>
                </div>
              <?php } ?>

            </div>

            <div class="row">
                <!-- Forecasting side -->
                <div class="col-lg-12">
                  <div class="panel panel-default">
                          <div class="panel-heading">
                              <i class="fa fa-bar-chart-o fa-fw"></i> Daily Sales
                          </div>
                          <!-- /.panel-heading -->
                          <div class="panel-body">
                              <div id="morris-area-chart"></div>
                          </div>
                          <!-- /.panel-body -->
                  </div>
                </div>
            </div>


</div>

<?php include 'includes/sections/footer.php'; ?>
