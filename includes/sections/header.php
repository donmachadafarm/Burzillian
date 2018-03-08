<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="Shortcut Icon" type="image/ico" href="#">
    <title>Burzillian Nation</title>
    <?php include 'includes/plugins.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
        date_default_timezone_set('Asia/Manila');
    }
    ?>
  </head>
  <body>
