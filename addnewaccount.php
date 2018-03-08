<?php
include 'includes/sections/header.php';

if ($_SESSION['usertype']!=101)
       header("Location:logout.php");

$flag=0;
if (isset($_POST['submit'])){

$message=NULL;

 if (empty($_POST['username'])){
  $username=FALSE;
  $message.='<p>You forgot to enter the username!';
 }else
  $username=$_POST['username'];

 if (empty($_POST['password'])){
  $password=FALSE;
  $message.='<p>You forgot to enter the password!';
 }else if($_POST['password'] != $_POST['password']){
 $message.='<p>Password does not match!';
 }
 else
  $password=md5($_POST['password']);

 if (empty($_POST['fullname'])){
  $fullname=FALSE;
  $message.='<p>You forgot to enter the fullname!';
 }else
  $fullname=$_POST['fullname'];

if (empty($_POST['contactno'])){
  $contactno=FALSE;
  $message.='<p>You forgot to enter your contact number!';
 }else
  $contactno=$_POST['contactno'];

 if (empty($_POST['address'])){
  $address=FALSE;
  $message.='<p>You forgot to enter the address!';
 }else
  $address=$_POST['address'];


 $usertype = $_POST['usertype'];

$query = "SELECT userID FROM users where username = '$username'";
$result=mysqli_query($conn,$query);
if ($row = mysqli_fetch_array($result)){
$message = "<b><p>Username already exists!";

}

if(!isset($message)){

$query="insert into users (username,password,fullName,address,contactNo,usertype) values ('{$username}','{$password}','{$fullname}','{$address}','{$contactno}','{$usertype}')";
$result=mysqli_query($conn,$query);
$message="<b><p>Username: {$username}<br>Fullname: {$fullname}<br>Contact Number: {$contactno}<br>Address: {$address}<br> SUCCESSFUL! </b>";
$flag=1;

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
<label>Username:</label></br> <input type="text" name="username" class="form-control" value="<?php if (isset($_POST['username']) && !$flag) echo $_POST['username']; ?>"/>
</br>
<label>Password: </label></br><input type="password" name="password" class="form-control" value="<?php if (isset($_POST['password']) && !$flag) echo $_POST['password']; ?>"/>
</br>
<label>Confirm Password: </label> </br><input type="password" name="cpassword" class="form-control" maxlength="30">
</br>
<label>Fullname: </label> </br><input type="text" name="fullname" class="form-control" value="<?php if (isset($_POST['fullname']) && !$flag) echo $_POST['fullname']; ?>"/>
</br>
<label>Contact Number: </label></br> <input type="text" name="contactno" class="form-control" value="<?php if (isset($_POST['contactno']) && !$flag) echo $_POST['contactno']; ?>"/>
</br>
<label>Address: </label> </br><input type="text" name="address" class="form-control" value="<?php if (isset($_POST['address']) && !$flag) echo $_POST['address']; ?>"/>
    </p>
<label>Usertype: </label>
<select class="form-control" name="usertype" required>
  <option value="102" selected>Kitchen Staff</option>
  <option value="103">Cashier</option>
</select><br>
<input type="submit" name="submit" value="Add User" class="btn btn-success"/></div>
</form>
<?php

if (isset($message)){
 echo '<font color="red">'.$message. '</font>';

}
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
