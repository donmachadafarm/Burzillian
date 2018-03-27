<?php include 'includes/sections/header.php';
      include 'includes/sections/navbar.php';

      if (!isset($_SESSION['userType']) || $_SESSION['userType']!=102){
        echo "<script>window.location='logout.php'</script>";
      }
 ?>

  <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Change Product Price</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            <!-- /.row -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Price List
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Product</th>
                                            <th>Price</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sql = "SELECT * from product";
                                            $result = mysqli_query($conn,$sql);
                                            while($row = mysqli_fetch_array($result)):;
                                            ?>

                                        <tr>
                                            <td><?php echo $row['prodID']?></td>
                                            <td><?php echo $row['prodName']?></td>
                                            <td><?php echo $row['price']?></td>

                                        </tr>
                                     <?php endwhile ?>


                                    </tbody>

                                </table>



                            </div>
                            <!-- /.table-responsive -->

                                                     <form name="form1" id="form1" action="" class="form-signin" method="post">


                                                    <p class="form-control-static">
                                                    <label>Choose Product: </label>
													<select name ="prodID" class="form-control">
													<?php
														$flag=0;
														$i = 1;

														$result = mysqli_query($conn,'SELECT * FROM product');
														while($row = mysqli_fetch_array($result)){

															$prodName = $row['prodName'];
															$prodID = $row['prodID'];
															echo "<label><option value = \"{$prodID}\"/>{$row['prodName']}</label>";
													}
													?>
													</select>

                                                        </br>
                                                        <label>New Price: </label></br><input type="text" name="new_price" class="form-control" value="<?php if (isset($_POST['new_price'])) echo $_POST['new_price']; ?>"/>
                                                        </br>
                                                        </p>
                                                        <input type="submit" name="submit" value="Change Price" class="btn btn-default"/></div>
                                                        <br><br>
                      </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->

                            </div>



                                                 <?php


if (isset($_POST['submit'])){

$message=NULL;
	$date = date('Y-m-d');
	$prodID=$_POST['prodID'];
	$sql1 = "SELECT * from product WHERE prodID = '$prodID'";
    $result = mysqli_query($conn,$sql1);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $old_price = $row['price'];


 if (empty($_POST['new_price'])){
  $new_price=FALSE;
  $message.='<p>You forgot to enter the new price!';

 }else
  $new_price=$_POST['new_price'];

if(!isset($message)){
$query="insert into price_list (old_price,new_price,date_edited, product_id) values ('$old_price','$new_price','$date','$prodID')";
$result=mysqli_query($conn,$query);
$query1 = "UPDATE product SET price = $new_price WHERE prodID = '$prodID'";
$result1=mysqli_query($conn,$query1);
}


}/*End of main Submit conditional*/

if (isset($message)){
 echo '<font color="red">'.$message. '</font>';

}

?>
                                    </div></div></form></div></div><!--End Modal-->
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <?php include 'includes/sections/footer.php'; ?>
