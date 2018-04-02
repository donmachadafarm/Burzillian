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
                <!-- Forecasting side -->
                <div class="col-lg-12">
                  <div class="panel panel-info">
                      <div class="panel-heading">
                          Forecast
                      </div>
                      <div class="panel-body">
                          forecast body
                      </div>
                  </div>
                </div>
            </div>
            <div class="row">

              <?php
              $query = "SELECT * FROM ingredient WHERE total = 0";
              if($res = mysqli_query($conn,$query)){
                ?>
                <!-- Ingredient warning side -->
                <div class="col-lg-6">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            Ingredient warning
                        </div>
                        <div class="panel-body">
                        <?php
                          while($row = mysqli_fetch_array($res)){
                              echo "<div class='alert alert-danger'>Ingredient ".$row['ingName']." count is 0</div>";
                          }
                        ?>
                        </div>
                    </div>
                  </div>
                <?php } ?>


                <?php
                $query = "SELECT discrepancy.discrepancyCount AS 'count', discrepancy.checkedDate AS 'date', ingredient.ingName AS 'ingName'
                          FROM discrepancy
                          INNER JOIN ingredient discrepancy.ingID ON ingredient.ingID
                          ORDER BY discrepancy.checkedDate DESC
                          LIMIT 5";
                if($res = mysqli_query($conn,$query)){
                 ?>
                <!-- Discrepancy side -->
                <div class="col-lg-6">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            Discrepancies
                        </div>
                        <div class="panel-body">
                        <?php
                          while ($row = mysqli_fetch_array($res)) {
                              echo "<div class='alert alert-danger'>Discrepancy on ".$row['ingName']." checked on ".$row['date']."</div>";
                          }
                         ?>
                        </div>
                    </div>
                </div>
              <?php } ?>

            </div>
</div>

<?php

    // Discrepancies part

    // Forecasting part


?>


<?php include 'includes/sections/footer.php'; ?>
