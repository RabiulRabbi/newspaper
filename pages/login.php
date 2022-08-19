<?php
session_start();
include('./include/html_header.php');
$conn = mysqli_connect('localhost', 'root', '', 'newspaper');
if (!$conn) {
    echo "database connection error";
}

$msgErr = "";
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    // echo $username;

    $sql = "SELECT * FROM admin_login where username | email = '$username'";
    $result = mysqli_query($conn, $sql);
    if (!mysqli_num_rows($result) > 0) {
        echo "pai nai";
    } else {
        while ($row = mysqli_fetch_assoc($result)) {
            // echo $row['username'];
            if (($row['username'] == $username) | ($row['email'] == $username) && ($row['password'] == $password)) {
                // echo "login successful";
                $msg = "Login successful";
                $_SESSION['username'] = $username;
                header("location: ../admin/pages/home.php?msg=$msg");
            } else {
                $msgErr .= "wrong username/email & password";
                // $msgErr;
                // echo "";
            }
        }
    }
}

?>

<body>
    <section class="h-100 gradient-form" style="background-color: #eee;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-10">
                    <div class="card rounded-3 text-black">
                        <?php
                        //session err msg
                        if (isset($_SESSION['errorMsg'])) {
                            echo "
      <div class='alert alert-success alert-dismissible' role='alert'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h4><i class='icon fa fa-check'></i> Error!</h4>
        " . $_SESSION['errorMsg'] . "
      </div>
    ";
                            unset($_SESSION['errorMsg']);
                        }
                        //show logout successful message
                        if (isset($_SESSION['successMsg'])) {
                            echo "
      <div class='alert alert-success alert-dismissible' role='alert'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h4><i class='icon fa fa-check'></i> Success!</h4>
        " . $_SESSION['successMsg'] . "
      </div>
    ";
                            unset($_SESSION['successMsg']);
                        }
                        ?>
                        <div class="row g-0">
                            <div class="col-lg-6">
                                <div class="card-body p-md-5 mx-md-4">
                                    <div class="text-center">
                                        <img src="./images/logo/Logo1.png" style=" width: 185px;" alt="logo">
                                        <h4 class="mt-1 mb-5 pb-1">দৈনিক জাককানইবি-সংবাদ</h4>
                                        <?php
                                        if (!$msgErr == "") {
                                        ?>
                                            <h4 id="msgErr"><?php echo $msgErr ?></h4>
                                            <audio id="soundErr" src="./audio/invalid_sound.mp3" controls autoplay></audio>
                                        <?php
                                        }
                                        ?>
                                    </div>

                                    <form name="myForm" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data" onsubmit="return onsubmitFunc()">
                                        <h4 class="mb-4">Please login to your account</h4>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form2Example11">Username/Email <span style="color: red;" id="usernameErr"></span></label>
                                            <input type="text" id="form2Example11" name="username" class="form-control" oninput="validateUsername()" placeholder="User name or email address" />
                                        </div>
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form2Example22">Password <span style="color: red;" id="passwordErr"></span></label>
                                            <input type="password" id="form2Example22" name="password" class="form-control" oninput="validatePassword()" placeholder="Password" />
                                        </div>

                                        <div class="text-center pt-1 mb-5 pb-1">
                                            <!-- <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="button">Log in</button> -->
                                            <input class="login fa-lg gradient-custom-2 mb-3 " type="submit" value="Log in" name="login">
                                            <p><a style="text-decoration: none;" class="text-muted" href="#!">Forgot password?</a></p>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-center pb-4">
                                            <p class="mb-0 me-2">Don't have an account?</p>
                                            <button type="button" class="btn btn-outline-danger">Create new</button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                                <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                                    <h4 align="center" class="mb-4">__রেজিস্টার / লগইন প্যানেল__</h4>
                                    <h4 align="center" class="mb-4"> আপনাকে স্বাগতম</h4>
                                    <p class="small mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                        exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
<script>
    function validateUsername() {
        if (document.forms['myForm']['username'].value == "") {
            document.getElementById("usernameErr").innerHTML = "*Must be filled";
        } else {
            const val_username = "^[A-Za-z][A-Za-z0-9_]{4,6}$";
            const val_email = /^\w+@\w+\.\w{2,3}$/;
            if (!document.forms['myForm']['username'].value.match(val_username) && !document.forms['myForm']['username'].value.match(val_email)) {
                document.getElementById("usernameErr").innerHTML = "*Min 5-7 characters needed";
                return false;
            } else {
                document.getElementById("usernameErr").innerHTML = "Matched";
                return true;
            }
        }
    }

    function validatePassword() {
        if (document.forms['myForm']['password'].value == "") {
            document.getElementById("passwordErr").innerHTML = "*Must be filled";
        } else {
            const val = /[A-Za-z0-9]{5,}/;
            if (!document.forms['myForm']['password'].value.match(val)) {
                document.getElementById("passwordErr").innerHTML = "*Min 5 characters needed";
                return false;
            } else {
                document.getElementById("passwordErr").innerHTML = "Matched";
                return true;
            }
        }
    }

    function onsubmitFunc() {
        if (!validateUsername || !validatePassword) {
            return false;
        } else {
            return true;
        }
    }
</script>

</html>