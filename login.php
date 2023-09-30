<?php

$login = false;
$showError = false;

if (isset($_POST['login_admin'])) {
    include "config.php";
    $email_admin = $_POST['email_admin'];
    $pass_admin = $_POST['pass_admin'];


    $sql = "SELECT * FROM admin WHERE email_admin='$email_admin'";
    $result = mysqli_query($conn, $sql);


    if (mysqli_num_rows($result) == 1) {

        while ($row = mysqli_fetch_array($result)) {


            if ($row['pass_admin'] == $pass_admin) {
                $login = true;
                session_start();
                $_SESSION['loggedin_admin'] = true;
                header('location: index.php');
            } else {
                $showError = "Invalid credentials";
            }
        }
    } else {
        $showError = "Invalid credentials";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>

    </style>

</head>

<body>

    <?php

    if ($login) {
        echo '<div class="alert alert-success alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success!</strong> You logged in successfully
    </div>';
    }
    if ($showError) {
        echo '<div class="alert alert-danger alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Error!</strong> ' . $showError . '
    </div>';
    }

    ?>

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-3">
                        <!-- Nested Row within Card Body -->
                        <!-- <div class="row"> -->
                        <!-- <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> -->
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Welcome to Bonkers</h1>
                                </div>
                                <form method="post" action="" class="user">
                                    <div class="form-group">
                                        <input name="email_admin" type="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                                    </div>
                                    <div class="form-group">
                                        <input name="pass_admin" type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
                                    </div>

                                    <button type="submit" name="login_admin" class="btn btn-primary btn-user btn-block">
                                        Login
                                    </button>
                                </form>

                            </div>
                        </div>
                        <!-- </div> -->
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>