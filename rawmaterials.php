<?php include 'includes/sections/header.php';
      include 'includes/sections/navbar.php';

      if (!isset($_SESSION['userType']) || $_SESSION['userType']!=102){
        echo "<script>window.location='logout.php'</script>";
      }
 ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Raw Materials</h1>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Raw Material Name</th>
                                        <th>Type</th>
                                        <!-- <th>Quantity</th> -->
                                        <th>Measurement Value</th>
                                        <th>Measurement Type</th>

                                    </tr>
                                </thead>
                                <tbody>

                                <?php
    $flag=0;
    $i = 1;

        $result = mysqli_query($conn,'SELECT *
                                FROM inventory');


        while($row = mysqli_fetch_array($result)){

            $result2 = mysqli_query($conn,'SELECT * FROM ingredient');


            $rmName = $row['rmName'];

            $measurement_value = $row['measurementValue'];
            $measurement = $row['measurement'];
            $ingID = $row['ingID'];

            while($row2 = mysqli_fetch_array($result2)){
         if($ingID == $row2['ingID'])
            {
                $type = $row2['ingName'];
            }
        }

            echo '<tr class="odd gradeX">';
            echo '<td>';
            echo $rmName;
            echo '<td>';
            echo $type;
            // echo '<td>';
            // echo $quantity;
            echo '<td>';
            echo number_format($measurement_value,4);
            echo '<td>';
            echo $measurement;
            echo'</td>';
            echo '</tr>';


        }


        echo '<br /><br />';

?>
</tbody></table>

    <center><a href="modifyrawmaterials.php" class="btn btn-primary">Update Raw Materials</a>
    <a href="addrawmaterials.php" class="btn btn-primary">Add Raw Materials</a>

     </div></center></div></div></div>
             <!-- &nbsp&nbsp&nbsp    Note: Update button is for adding quantity to existing raw materials.<br><br><br><br><br> -->
                  </div>
<?php include 'includes/sections/footer.php'; ?>
