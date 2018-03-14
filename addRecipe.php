<?php include 'includes/sections/header.php';
      include 'includes/sections/navbar.php';
 ?>

        <div id="page-wrapper">
            <?php
            //     require 'Connect.php';
                $flag=0;


                //$rProd = $_POST['selectProduct'];

                if (isset($_POST['submit'])){
                $message=NULL;

                if (empty($_POST['selectProduct'])){
                $selectProduct=FALSE;
                $message.='<p>You forgot to enter the Recipe Name!';
                }else
                $selectProduct=$_POST['selectProduct'];

                if (empty($_POST['prodID'])){
                $prodID=FALSE;
                $message.='<p>You forgot to enter the Product ID!';
                }else
                $prodID=$_POST['prodID'];
            
                if (empty($_POST['mVal'])){
                $mVal=FALSE;
                $message.='<p>You forgot to enter the Measurement Value!';
                }else
                $mVal=$_POST['mVal'];
            
                if (empty($_POST['rInstruct'])){
                $rInstruct=NULL;
                 $message.='<p>You forgot to enter the Instructions!';
                }else
                $rInstruct=$_POST['rInstruct'];
                
                if(!isset($message)){

                /*$sql = mysqli_query($conn,'SELECT * from product ORDER BY prodID DESC');

                while($row = mysqli_fetch_array($sql)){
                    $rName = $row['prodName'];
                    $prodID = $row['prodID'];
                }*/

                $query=mysqli_query($conn, "insert into recipe (recipeName, instruction, prodID) values ('{$selectProduct}', '{$rInstruct}', '{$prodID}')");

                
                $nVal= array();
                $nType= array();

                  $rCheck = $_POST['checkbox'];
                $rIng = $_POST['selectMeasure'];
                
                foreach ($mVal as $index => $val){
                    if($val != NULL){
                        array_push($nVal, $val);
                        foreach ($rIng as $index2 => $typeId){
                            if($index == $index2){
                                array_push($nType, $typeId);
                            }
                        }
                    }
                }
                $query1 = mysqli_query($conn, "SELECT * FROM recipe WHERE recipeID = (SELECT MAX(recipeID) FROM recipe)");
            
                while($row=mysqli_fetch_array($query1)){
                   // if($row['recipeName'] == $rName){
                        //$rRcp = $row['recipeID'];
                        //echo $rRcp;
                        foreach($nVal as $index => $val){      

                            $convert = mysqli_query($conn, 'SELECT * FROM converter');

                            while($row = mysqli_fetch_array($convert))
                            {
                                if($nType[$index] == $row['convertID']){
                                    $new_val = $val*$row['convert_value'];
                                } 
                            }   

                            echo $rCheck[$index];
                            echo " // ";
                            echo $nType[$index];
                            echo " // ";
                            echo $val;
                            echo " // ";
                            echo $new_val;
                            echo "<br>";
                            $query2 = mysqli_query($conn, "INSERT INTO recipeing (recipeID,ingID, measureID, measureVal, converted_measurement) VALUES ((SELECT MAX(recipeID) FROM recipe),'{$rCheck[$index]}', '{$nType[$index]}', '{$val}', '{$new_val}')");
                        }
                    
                    //}
                }
                
                
                $message="<b><p style = 'color:green;'>Ingredient has been Successfuly Added!</p></b>";
                $flag=1;
                }
                

                }/*End of main Submit conditional*/

                if (isset($message)){
                echo '<font color="red">'.$message. '</font>';
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
                            Add Recipe
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <!-- Start of form -->
                                    <form role="form" method="post">
                                       <div class="form-group">
                                      <?php
        $sql = mysqli_query($conn,'SELECT * from product ORDER BY prodName ASC');

        while($row = mysqli_fetch_array($sql)){
            $selectProduct = $row['prodName'];
            $prodID = $row['prodID'];
        }
            echo "<input type ='hidden' name='selectProduct' value='$selectProduct'>";
            echo "<input type ='hidden' name='prodID' value='$prodID'>";
            echo "<label>Product Name: ";
            echo $selectProduct;
    ?>
                                        </div>
                                        <div class="form-group">
                                        <style>
                                            #textbox{
                                                width: 40%;
                                                height: 20%;
                                                padding:1%;

                                            }
                                        </style>
                                        
                                        </div>
                                        <div class="form-group">
                                            <label>Ingredients</label>

<div id="div1">
                                            <?php
                                           
                                            $sql=mysqli_query($conn, "select * from ingredient");
                                    
                                            
                                            while($row=mysqli_fetch_array($sql)){
                                                echo '<div class = "checkbox">';
                                                echo "<label><input name = \"checkbox[]\" type = \"checkbox\" value = \"{$row['ingID']}\"/>{$row['ingName']}</label><br>"; 
                                                echo "&nbsp";
                                                $sql1=mysqli_query($conn, "select * from converter");
                                                echo "<input name = \"mVal[]\" type = \"number\" value = \"\"/>&nbsp"; 
                                                echo "<select name= 'selectMeasure[]'>";
                                                    while($row=mysqli_fetch_array($sql1)){
                                                        echo "<option value = \"{$row['convertID']}\">{$row['convert_from']}</option>";
                                                    }
                                                echo "</select><br>";
                                                echo "</div>";
                                            }
                                            ?></div>
<style>
                                            #div1{
  
  padding-top: 1px;
  overflow: auto; 
  max-height: 40vh;
  width: 100%;

}</style>
                                        </div> 
                                         <div class="form-group">
                                            <label>Instructions</label>
                                            <textarea name = "rInstruct" class="form-control" rows="10" id="comment"></textarea>
                                        </div>
                                        <button name = "submit" type="submit" class="btn btn-default">Add Recipe</button>
                                    </form>
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


<?php include 'includes/sections/footer.php'; ?>
