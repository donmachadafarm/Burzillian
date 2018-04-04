<?php include 'includes/sections/header.php';
      include 'includes/sections/navbar.php';

            if (!isset($_SESSION['userType']) || $_SESSION['userType']!=103){
        echo "<script>window.location='logout.php'</script>";
      }
 ?>

                <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><center>Burzillian Nation</h1></center>
                    </div>
                    <!-- /.col-lg-12 -->
</div></div>

                <header><center>
                   Golf Driving Range,
                   <br>Brgy. Don Jose,
                   <br>Sta. Rosa, Laguna
                   <br>
                  <?php echo date('m-d-Y');?>
                  </header><br></center>


                     <table  class='table table-striped table-bordered table-hover' >
                                <thead>
                                    <tr>
                                        <th>Raw Material</th>
                                        <th>Quantity</th>
                                        <th>Sub Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php

                                $name = [];
                                $quantity = [];
                                $subTotal_array = [];

                                $result1 = mysqli_query($conn, 'SELECT salesID FROM sales_order ORDER BY salesID ASC');
                                while($row = mysqli_fetch_array($result1)){
                                  $salesIDchecker = $row['salesID'];
                                }

                                  $result = mysqli_query($conn, 'SELECT sales_order.salesID, receipt.prodName, receipt.subTotal, receipt.quantity, sales_order.totalPrice, sales_order.cash, sales_order.cashChange
                                FROM sales_order
                                JOIN receipt ON sales_order.salesID = receipt.salesID
                                ORDER BY sales_order.salesID ASC');

                                while($row = mysqli_fetch_array($result)){
                                   $name = $row['prodName'];
                                   $quantity = $row['quantity'];
                                   $subTotal = $row['subTotal'];
                                   $totalPrice = $row['totalPrice'];
                                   $cash = $row['cash'];
                                   $cashChange = $row['cashChange'];
                                   $salesID = $row['salesID'];

                                if($salesID == $salesIDchecker){
                                echo '<tr">';
                                echo "<td>";
                                echo $name;
                                echo "</td>    ";
                                echo "<td>";
                                echo $quantity;
                                echo "</td>   ";
                                echo "<td>";
                                echo $subTotal;
                                echo "</td>    ";
                                echo '</tr>';
                              }
                                  }

                                echo " </tbody></table>";
echo "<center>";
echo "<B>Total:  $totalPrice";
  echo "<br>";
echo "\n\nCash:     $cash";
  echo "<br>";
echo "\nChange:     $cashChange";
  echo "<br>";

                                ?>

                        <br><br>
<center>
 <button type="button" class="btn btn-success" onclick="myFunction()">Print Receipt</button></center>

<script>
function myFunction() {
    window.print();
}
</script>

<?php include 'includes/sections/footer.php'; ?>
