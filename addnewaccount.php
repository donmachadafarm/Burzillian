<?php
include 'includes/sections/header.php';
if ($_SESSION['userType']!=101)
       header("Location:logout.php");
if (isset($_POST['submit'])){
  // $message=NULL;
  //  if (empty($_POST['username'])){
  //   $userName=FALSE;
  //   $message.='<p>You forgot to enter the username!';
  //  }else
    $userName=$_POST['username'];
  //  if (empty($_POST['password'])){
  //   $password=FALSE;
  //   $message.='<p>You forgot to enter the password!';
  //  }else if($_POST['password'] != $_POST['password']){
  //  $message.='<p>Password does not match!';
  //  }
  //  else
    if($_POST['password'] != $_POST['cpassword']){
      $message = 'Password does not match';
    }else{
     $password=md5($_POST['password']);
    }
  //  if (empty($_POST['fullname'])){
  //   $fullName=FALSE;
  //   $message.='<p>You forgot to enter the fullname!';
  //  }else
    $fullName=$_POST['fullname'];
  // if (empty($_POST['contactno'])){
  //   $contactNo=FALSE;
  //   $message.='<p>You forgot to enter your contact number!';
  //  }else
    $contactNo=$_POST['contactno'];
  //  if (empty($_POST['address'])){
  //   $address=FALSE;
  //   $message.='<p>You forgot to enter the address!';
   // }else
  $address=$_POST['address'];
  $userType = $_POST['userType'];
  $query = "SELECT userID FROM users where userName = '$userName'";
  $result=mysqli_query($conn,$query);
  if ($row = mysqli_fetch_array($result)){
  $message = "Username already exists!";
  }
  if(!isset($message)){
  $query="insert into users (userName,password,fullName,address,contactNo,userType) values ('{$userName}','{$password}','{$fullName}','{$address}','{$contactNo}','{$userType}')";
    if (mysqli_query($conn,$query)) {
      // $message="<b><p>Username: {$userName}<br>Fullname: {$fullName}<br>Contact Number: {$contactNo}<br>Address: {$address}<br> SUCCESSFUL! </b>";

      echo "<script>
        alert('Account of {$fullName} is created');
      </script>";
    }else {
      echo "<script> alert('Failed to Add account!');
          </script>";
    }
  }else{
    echo "<script> alert('{$message}');
          </script>";
  }
}/*End of main Submit conditional*/
include 'includes/sections/navbar.php';
?>


            <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Add New User</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
 <div class="form-group">
    <p class="form-control-static">
<label>Username:</label></br> <input type="text" name="username" class="form-control" required>
</br>
<label>Password: </label></br><input type="password" name="password" class="form-control" required>
</br>
<label>Confirm Password: </label> </br><input type="password" name="cpassword" class="form-control" maxlength="30">
</br>
<label>Fullname: </label> </br><input type="text" name="fullname" class="form-control" required>
</br>
<label>Contact Number: </label></br> <input type="number" name="contactno" class="form-control" required>
</br>
<label>Address: </label> </br><input type="text" name="address" class="form-control" required>
    </p>
<label>User Type: </label>
<select class="form-control" name="userType" required>
  <option value="102" selected>Kitchen Staff</option>
  <option value="103">Cashier</option>
</select><br>
<input type="submit" name="submit" value="Add User" class="btn btn-success"/></div>
</form>
<?php
// if (isset($message)){
//  echo '<font color="red">'.$message. '</font>';
// }
?>



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
    <?php include 'includes/sections/footer.php'; ?>
