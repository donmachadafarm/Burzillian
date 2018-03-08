<?php include 'includes/sections/header.php'; ?>

<?php
 if (!isset($_SESSION['usertype']))
        header("Location:logout.php");
?>

<?php include 'includes/sections/navbar.php'; ?>



<div id="page-wrapper">
<!--
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header" id="header"><font color="#d84141"><B>Burzillian Nation</B></font><style>
                        @font-face{
                            font-family: bromello;
                            src: url(bromello.ttf);
                        }
                        @font-face{
                            font-family: hipsterish;
                            src: url(hipsterishfontnormal.ttf);
                        }
                        #header{
                            font-family: hipsterish;
                        }
                    </style></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!--
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"></font></div>
                                    <div><font face="hipsterish" size="5">Check Sales Reports</font></div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left"><a href="http://localhost/Burzillian/startbootstrap-sb-admin-2-gh-pages/burzilliandb/salesreport.php">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"></div>
                                    <div><font face="hipsterish" size="5">View Inventory Report</font></div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left"><a href="http://localhost/Burzillian/startbootstrap-sb-admin-2-gh-pages/burzilliandb/inventoryreport.php">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-shopping-cart fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"></div>
                                    <div><font face="hipsterish" size="5">New Orders</font></div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left"><a href="http://localhost/Burzillian/startbootstrap-sb-admin-2-gh-pages/burzilliandb/rawmaterials.php">Add Raw Materials</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-support fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"></div>
                                    <div><font face="hipsterish" size="5">Available Products</font></div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left"><a href="http://localhost/Burzillian/startbootstrap-sb-admin-2-gh-pages/burzilliandb/viewProducts.php">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <hr>

<!--
<div class="bestseller" id="bestseller">
<font face="hipsterish" size="6"><B>&nbspBEST SELLERS</B></font>
<?php

    $query = mysqli_query($conn,"select prodName, sum(quantity) as 'quantity' from receipt group by prodName order by quantity DESC");

    $num = 1;
    while($row = mysqli_fetch_array($query)){

            echo "<div style=\" font-family: arial;\">";
            echo "<font size='3' color='#20536b'>";
            echo "&nbsp";
            echo $num;
            echo ". ";
            echo $row['prodName'];
            echo "<br>";
            echo "</B>";
            echo "</font>";
            $num++;

    }



?>
</div>


<div class="alert" id="div1">

<font face="hipsterish" size="6"><B>NOTIFICATION</B></font>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $("button").click(function(){
        $("#div2").empty(".test");
    });
});
</script>
<div id="div2">
<?php


    $check = mysqli_query($conn,'SELECT * FROM inventory');

    while($row = mysqlii_fetch_array($check)){
        $quantity = $row['quantity'];
        $rmName = $row['rmName'];

        if($quantity < 0){
            $quantity = 0;
        }

        if($quantity < 5){
            echo "<p class='test'>";
            echo "<font size='3' color='#20536b'>";
            echo '<B>Inventory Alert!</B><br>';
            echo 'Running low for ';
            echo $rmName;
            echo "<br>";
            echo $quantity;
            echo " left.";
            echo "<br>";
            echo "______________________________";
            echo "</p>";

        }
    }
     echo "<button>Clear</button>";

?>
</div>

</div>

<style>
#bestseller{
  border: 2px solid #aeaeae;
  background-color: #ffffff;
  width: 350px;
  height: 220px;
  position : relative;
  padding-bottom: 20%;
}

#div1{
  border: 2px solid #aeaeae;
  background-color: #ffffff;
  width: 350px;
  height: 220px;
  position : absolute;
  left: 105%;
  top: -2px;
  padding-top: 1px;
  overflow: auto;
  max-height: 100vh;
  width: 95%;

}

/*.wrapper > div{
    border: 3px solid #ddb9b3;
  bottom: 0px;
  width: 50px;
  position : absolute;
  background-color: #e4cac4;
  margin: 10px;
  display : inline-block;

 }*/

</style>-->


    </div> -->
    <!-- /#wrapper -->

<?php include 'includes/sections/footer.php'; ?>
