<?php include 'includes/sections/header.php';
      include 'includes/sections/navbar.php';

      if (!isset($_SESSION['usertype']) || $_SESSION['usertype']!=102){
        echo "<script>window.location='logout.php'</script>";
      }
 ?>

  <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Add New Menu Item</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          Fill in the following forms to add new item to menu.
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">

                                    <form role="form" action="" method="post">

                                        <div class="form-group">
                                            <label>Enter Product Name</label>
                                            <input name = "productname" class="form-control" placeholder="Enter product name">
                                        </div>


                                        <div class="form-group">
                                            <label>Select Product Type</label>
                                            <select name = "producttype" class="form-control">
                                              <option value="food" selected>Food</option>
                                              <option value="drink">Drink</option>
                                              <option value="others">Others</option>
                                            </select>
                                        </div>

                                           <div class="form-group">
                                            <label>Enter Price</label>
                                            <input type = "number" name = "price" class="form-control" placeholder="Enter product price">
                                        </div>

                                        <button type="submit" name = "submit" class="btn btn-default">Add Product</button>
                                        <button type="reset" class="btn btn-default">Reset Form</button>

                                    </form>

                                    <?php
    //require 'Connect.php';
    $flag=0;

    if(empty($_POST['productname'])){
    $productname = '';
    $flag=1;
    } else
    $productname = ($_POST['productname']);

    if(empty($_POST['producttype'])){
    $producttype = '';
    $flag=1;
    } else
    $producttype = ($_POST['producttype']);

    if(empty($_POST['price'])){
    $price = '';
    $flag=1;
    } else
    $price = ($_POST['price']);

    $sql1 = " INSERT INTO product(prodName, prodType, price)
            VALUES ('$productname', '$producttype', '$price'); ";



        if($flag != 1){
    $result = mysqli_query($conn,$sql1);
        if (!$result){
          die('Invalid Input: ' . mysqli_error().$sql);
        }
        else{
          echo "<script> alert('Successfully Added');
                window.location.href='addRecipe.php';
                </script> ";
        }
    }

?>
                                </div>
                                <!-- /.col-lg-6 (nested) -->


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
    <!-- /#wrapper -->

<?php include 'includes/sections/footer.php'; ?>
