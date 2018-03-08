
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <style>
                    @font-face{
                            font-family: hipsterish;
                            src: url(hipsterishfontnormal.ttf);
                        }
                        #title{
                            font-family: hipsterish;
                        }
                </style>
                <a class="navbar-brand" href="index.php" id="title"><font size="5">Burzillian Nation</font></a> <!-- INPUT LOGO OF BURZILLIAN -->
            </div>
            <!-- /.navbar-header -->

          <ul class="nav navbar-top-links navbar-right">

                <li class="dropdown">
                <style>
                #woo{
                    overflow: auto;
  max-height: 40vh;
}
  </style>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages" id="woo">
                        <li>
                           <?php
                           $sql = mysqli_query($conn,'SELECT * FROM message');
                        while($row = mysqli_fetch_array($sql)){
                            echo  "<a href='#'>";
                               echo "<div>";
                                    echo "<strong>";

                                        echo $row['fullName'];

                                    echo "</strong>";
                                   echo "<span class='pull-right text-muted'>
                                        <em>";

                                        echo $row['msgdate'];

                                    echo "</em>
                                    </span>
                                </div>";
                                echo "<div>";

                                        echo $row['message'];

                                    echo "</div> </a>";
                                }
                            ?>
                        </li>

                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li>
                          <p><i class="fa fa-user fa-fw"></i> <?php echo $_SESSION['name']; ?></p>
                        </li>
                        <?php if ($_SESSION['usertype']==101) {
                          echo "<li><a href='addnewaccount.php'><i class='fa fa-user-plus fa-fw'></i> Add New User</a>
                          </li>";
                          echo "<li><a href='deleteaccount.php'><i class='fa fa-user-times fa-fw'></i> Remove User</a>
                          </li>";
                        } ?>
                        <li><a href="message.php"><i class="fa fa-commenting fa-fw"></i> Leave message</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
            </ul>
            <!-- /.navbar-top-links -->

            <!-- SIDEBAR STARTS HERE -->
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <?php if ($_SESSION['usertype'] == 102): ?>
                          <li>
                              <a href="#"><i class="fa fa-sitemap fa-fw"></i> Inventory<span class="fa arrow"></span></a>
                              <ul class="nav nav-second-level">
                                  <li>
                                      <a href="rawmaterials.php">Raw Materials</a>
                                  </li>
                                  <li>
                                      <a href="inputphysical.php">Input Physical Count</a>
                                  </li>
                                  <li>
                                      <a href="converter.php">Add Conversion</a>
                                  </li>
                                  <li>
                                      <a href="convertvalue.php">Converter</a>
                                  </li>
                                  </ul>

                          <li>
                              <a href="#"><i class="fa fa-sitemap fa-fw"></i> Recipe<span class="fa arrow"></span></a>
                              <ul class="nav nav-second-level">
                                  <li>
                                      <a href="addIngredients.php">Add Ingredients</a>
                                  </li>
                                  <li>
                                      <a href="ingredientList.php">Ingredient List</a>
                                  </li>
                                  <li>
                                      <a href="recipeList.php">Recipe List</a>
                                  </li>
                                  <li>
                                      <a href="addRecipe.php">Add Recipe</a>
                                  </li>
                                  </ul>
                            </li>
                        <?php endif; ?>

                                <?php
                                  if ($_SESSION['usertype'] == 101) {
                                    echo "<li>
                                           <a href='#'><i class='fa fa-sitemap fa-fw'></i> Reports<span class='fa arrow'></span></a>
                                           <ul class='nav nav-second-level'>
                                               <li>
                                                   <a href='inventoryreport.php'>Historical Inventory Report</a>
                                               </li>
                                               <li>
                                                   <a href='salesreport.php'>Historical Sales Report</a>
                                               </li>
                                               <li>
                                                    <a href='changepricereport.php'>Historical Change Price Report</a>
                                                </li>

                                       </ul>
                                       </li>";
                                  }
                                 ?>
                                 <?php
                                  if ($_SESSION['usertype'] == 103) {
                                    echo "
                                           <li>
                                               <a href='addsalesorder.php'>Add Sales Order</a>
                                           </li>";
                                  }else if ($_SESSION['usertype']==102){
                                    echo "<li>
                                       <a href='#''><i class='fa fa-sitemap fa-fw'></i> Products<span class='fa arrow'></span></a>
                                       <ul class='nav nav-second-level'>
                                           <li>
                                               <a href='addProducts.php'>Add Products</a>
                                           </li>
                                           <li>
                                               <a href='viewProducts.php'>View Products</a>
                                           </li>

                                           <li>
                                               <a href='changeprice.php'>Change Product Price</a>
                                           </li>
                                       </ul>
                                   </li>";
                                  }
                                  ?>

                        <?php if ($_SESSION['usertype'] == 101) {
                            echo "<li>
                                <a href='#'><i class='fa fa-sitemap fa-fw'></i> Forecasting<span class='fa arrow'></span></a>
                                <ul class='nav nav-second-level'>
                                    <li>
                                        <a href='rawmaterialforecast.php'>Inventory and Sales Forecast</a>
                                    </li>



                            </ul>
                            </li>";
                        } ?>



            </div>
            <!-- /.navbar-static-side -->
            </nav>
