<?php include 'includes/sections/header.php';
      include 'includes/sections/navbar.php';
 ?>
        <div id="page-wrapper">
            <?php


                $flag=0;

   /*             if(empty($_POST['rmID'])){
    $rmID = '';
    $flag=1;
    } else
    $rmID = ($_POST['rmID']);*/

    if(empty($_POST['ingName'])){
    $ingName = '';
    $flag=1;
    } else
    $ingName = ($_POST['ingName']);




    $sql1 = " INSERT INTO ingredient(ingName)
            VALUES ('$ingName'); ";



        if($flag != 1){
    $result = mysqli_query($conn,$sql1);
        if (!$result){
          die('Invalid Input: ' . mysqli_error().$sql);
        }
        else{
          echo "<script> alert('Successfully Added');
                window.location.href='addrawmaterials.php';
                </script> ";
        }
    }


            ?>
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Add Ingredients</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Ingredients
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <!-- Start of form -->
                                    <form role="form" method="post">
                                        <div class="form-group">
                                          <!--  <label>Raw Material</label>

                                             <?php

                                                $query=mysqli_query($conn,'select * from inventory');

                                                while($row=mysqli_fetch_array($query)){
                                                    echo '<div class = "checkbox">';
             echo "<label><input name = \"rmID\" type = \"checkbox\" value = \"{$row['rmID']}\"/>{$row['rmName']}</label>";
             echo "</div>";
                                                    $_SESSION['type'] = $row['measurement'];
                                                    $_SESSION['val'] = $row['measurement_value'];
                                                }
                                                echo '</select>'
                                            ?>  -->
                                        </div>
                                        <div class="form-group">
                                            <label>Ingredient Name</label>
                                            <input type = "text" name = "ingName" class="form-control" value="">
                                        </div>
                                        <button name = "submit" type="submit" class="btn btn-default">Add Ingredient</button>
                                    </form>
                                    <br><br>
                                    Note: All ingredients added will not be added in the list until raw materials are set.
                                    <span id ="n"></span>
                                </div>
                                <!-- /.col-lg-12 (nested) -->
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
