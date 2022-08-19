<?php
session_start();
if (!isset($_SESSION['username'])) {
    $_SESSION['errorMsg'] = 'Login first';
    header("location: ../../pages/login.php");
}
if (isset($_POST['logout'])) {
    session_unset();
    // session_destroy();
    $_SESSION['successMsg'] = 'Logout successfully';
    header("location: ../../pages/login.php");
}
echo $_GET['msg'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>দৈনিক জাককানইবি-সংবাদ</title>
    <link rel="shortcut icon" href="./images/logo/Logo1.png" type="image/x-icon">
    <link rel="stylesheet" href="./../dist/css/admin_home.css">
    <link rel="stylesheet" href="./../../bootstrap/css/bootstrap.min.css">
    <script src="./../../bootstrap/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <h1>welcome to admin page</h1>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
        <input type="submit" value="log out" name="logout">
    </form>
</body>

</html>