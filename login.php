<?php include 'includes/sections/header.php'; ?>

<center>
<img id="logo" src="images/logo.jpg" width=200></center>
<style>
#logo{
  position: relative;
  top: 80px;
}
</style>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                       <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="username" type="text" autofocus maxlength="30" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="" maxlength="20">
                                </div>
                                <input type="submit" name="submit" value="Login" class="btn btn-lg btn-success btn-block"/>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php


if (isset($_SESSION['badlogin'])){
if ($_SESSION['badlogin']>=3)
       header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/block.php");
}

if (isset($_POST['submit'])){

$message=NULL;

 if (empty($_POST['username'])){
  $_SESSION['username']=FALSE;
  $message.='<div id="note"><p>You forgot to enter your username!';
 } else {
  $_SESSION['username']=$_POST['username'];
 }

 if (empty($_POST['password'])){
  $_SESSION['password']=FALSE;
  $message.='<div id="note"><p>You forgot to enter your password!';
 } else {
  $_SESSION['password']=$_POST['password'];
 }
    $myusername = $_POST['username'];
      $mypassword = md5($_POST['password']);
      $sql = "SELECT * FROM users WHERE username = '$myusername' and password = '$mypassword'";
      $result = mysqli_query($conn,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
  /** Proceed to dashboard of kitchen employee **/
if ($row["userType"]==102) {
       $_SESSION['userType']=102;
       $_SESSION['name']=$row["fullName"];
       $_SESSION['userid']=$row["userID"];
       header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/index.php");
}
// Proced to dashboard of cashier employee
if ($row["userType"]==103) {
       $_SESSION['userType']=103;
       $_SESSION['name']=$row["fullName"];
       $_SESSION['userid']=$row["userID"];
       header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/index.php");
}
/** Proceed to dashboard of admin **/
else if ($row["userType"]==101)
{      $_SESSION['userType']=101;
       $_SESSION['name']=$row["fullName"];
       $_SESSION['userid']=$row["userID"];
       header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/index.php");

} else {
 $message.='<div id="note"><p>Incorrect username or password. Please try again.</p></div>';
if (isset($_SESSION['badlogin']))
  $_SESSION['badlogin']++;
else
  $_SESSION['badlogin']=1;

}
}/*End of main Submit conditional*/

if (isset($message)){
 echo '<font color="red">'.$message. '</font>';
}

?>

<style>

#note{
  position: absolute;
  left: 100%;
}


</style>
<?php include 'includes/sections/footer.php'; ?>
