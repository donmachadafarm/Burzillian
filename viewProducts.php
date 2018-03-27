<?php include 'includes/sections/header.php';
      include 'includes/sections/navbar.php';

            if (!isset($_SESSION['userType']) || $_SESSION['userType']!=102){
        echo "<script>window.location='logout.php'</script>";
      }
 ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Product List</h1>
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
                                        <th>Product Name</th>
                                        <th>Type</th>
                                        <th>Price</th>

                                    </tr>
                                </thead>
                                <tbody>

                                <?php
    $flag=0;
    $i = 1;

        $result = mysqli_query($conn,'SELECT *
                                FROM product');


        while($row = mysqli_fetch_array($result)){

        $prodName = $row['prodName'];
        $prodType = $row['prodType'];
        $price = $row['price'];

            echo '<tr class="odd gradeX">';
            echo '<td>';
            echo $prodName;
            echo '<td>';
            echo $prodType;
            echo '<td>';
            echo $price;
            echo'</td>';
            echo '</tr>';


        }


        echo '<br /><br />';

?>
</tbody></table>

     </div></center></div></div></div>
             <!-- &nbsp&nbsp&nbsp    Note: Update button is for adding quantity to existing raw materials.<br><br><br><br><br> -->
                  </div>
<?php include 'includes/sections/footer.php'; ?>
