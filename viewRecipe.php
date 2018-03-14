<?php include 'includes/sections/header.php';
      include 'includes/sections/navbar.php';

      if (!isset($_SESSION['usertype']) || $_SESSION['usertype']!=102){
        echo "<script>window.location='logout.php'</script>";
      }
 ?>
      <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- php code -->
                        <?php
                            $id = $_GET['view'];
                            $query = mysqli_query($conn,"select * FROM recipe WHERE recipeID = '$id'");
                            $sql = mysqli_query($conn,"select * FROM recipeing WHERE recipeID = '$id'");

                            while($row=mysqli_fetch_array($query)){
                                echo '<a style= "float:right;margin-top:20px;" href="recipeList.php">go back to recipe list</a><br>';
                                echo '<div class="panel-body">';


                                echo '<table  class=\'table table-striped table-bordered table-hover\' >
                                <thead>
                                    <tr>
                                        <th style = "text-align:center" >Ingredients</th>
                                        <th style = "text-align:center" >Measurement</th>
                                    </tr>
                                </thead>
                                <tbody>';

                                    while($ing=mysqli_fetch_array($sql)){
                                        $ingID = $ing['ingID'];
                                        $mId = $ing['measureID'];
                                        $val = $ing['measureVal'];
                                        $query1 = mysqli_query($conn,"select * FROM ingredient WHERE ingID = $ingID");
                                            while($rowIng=mysqli_fetch_array($query1)){
                                                    echo '<tr>';
                                                        echo "<td style= \"text-align:center\">{$rowIng['ingName']}</td>";

                                                        $query2 = mysqli_query($conn,"select * FROM converter WHERE convertID = $mId");

                                                        while($rowMes=mysqli_fetch_array($query2)){
                                                            echo "<td style= \"text-align:center\">{$val}&nbsp;{$rowMes['convert_from']}</td>";
                                                        }

                                                    echo '</tr>';
                                            }
                                    }
                                echo '</tbody>
                                </table>';

                                echo '<h4>Instruction:</h4> ';
                                echo $row['instruction'];
                            }
                        ?>

                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    <div class = "col-lg-12">

                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <?php include 'includes/sections/footer.php'; ?>
