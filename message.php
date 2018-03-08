<?php include 'includes/sections/header.php';
      include 'includes/sections/navbar.php';
?>



<?php
    $flag=0;

    if(empty($_POST['name'])){
    $name = '';
    $flag=1;
    } else
    $name = ($_POST['name']);

    if(empty($_POST['message'])){
    $message = '';
    $flag=1;
    } else
    $message = ($_POST['message']);

    $sql1 = " INSERT INTO message(fullName, message, msgdate)
            VALUES ('$name', '$message', (NOW())); ";



        if($flag != 1){
    $result = mysqli_query($conn,$sql1);
        if (!$result){
          die('Invalid Input: ' . mysqli_error().$sql);
        }
        else{
          echo "<script> alert('Successfully Added');
                window.location.href='message.php';
                </script> ";
        }
    }
?>
  <div id="page-wrapper">

 <form class="form-signin" action='' method="POST">

   <br>
   <h2>Add Message:</h2>
   <hr>
        <label class="control-label"  for="rmName">Name: </label><br>
        <input type="text" id="rmName" name="name" placeholder="" class="form-control"><br><br>

         <label class="control-label"  for="measurement_value">Message: </label><br>
        <input id="textbox" type="text" id="measurement_value" name="message" placeholder="" class="input-xlarge form-control"><br><br>

        <button type="submit" class="btn btn-success" value="submit">Send</button>
        </form>
        </div>
        <!-- /#page-wrapper -->

<style>
    #textbox{
        width: 500px;
        height:100px;
    }

</style>

    </div>
    <!-- /#wrapper -->
    <?php include 'includes/sections/footer.php'; ?>
