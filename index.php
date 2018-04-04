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
                            <h3>Ingredient warning</h3>
                        <?php
                          while($row = mysqli_fetch_array($res)){
                            echo "<div class='alert alert-danger alert-dismissable'>
                                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                    Ingredient ". $row['ingName'] . " count is now 0
                                  </div>";
                          }
                        ?>
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
                <!-- Discrepancy side -->
                <div class="col-lg-6">
                    <h3>Discrepancy</h3>
                        <?php
                          while ($row = mysqli_fetch_array($res)) {
                              echo "<div class='alert alert-danger alert-dismissable'>
                                      <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                      Discrepancies on ". $row['ingName'] . " as checked last " . $row['date'] . "
                                    </div>";
                          }
                         ?>
                </div>
              <?php } ?>

            </div>
</div>

<?php

    // Discrepancies part

    // Forecasting part


?>


<?php include 'includes/sections/footer.php'; ?>
