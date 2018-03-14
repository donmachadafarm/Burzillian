<?php include 'includes/sections/header.php';
      include 'includes/sections/navbar.php';

      if (!isset($_SESSION['usertype']) || $_SESSION['usertype']!=102){
        echo "<script>window.location='logout.php'</script>";
      }
 ?>
          <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Recipe List</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <!--php code-->

                        <?php
                            $query=mysqli_query($conn,"select *
                                                from recipe R, product P
                                                where p.prodID = r.prodID");

                            echo '<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Recipe Name</th>
                                        <th style = "width: 200px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>';

                                while($row=mysqli_fetch_array($query)){
                                    echo '<tr class="recipe">';
                                        echo "<td>{$row['prodName']}</td>";
                                        echo '<td style = "display: flex; justify-content: space-around;">';
                                                echo "<a href = viewRecipe.php?view=".$row['recipeID'].">View</a>";

                                        echo'</td>
                                        </tr>';

                                }

                            echo '</tbody>
                                </table>';
                        ?>

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
    <!-- /#wrapper -->
    <?php include 'includes/sections/footer.php'; ?>
