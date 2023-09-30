<?php
include "config.php";

if (isset($_POST["submit"])) {
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $category_id = mysqli_real_escape_string($conn, $_POST["category_id"]);
    $nameUpper = strtoupper($name);
    $nameLower = strtolower($name);

    // Add single quotes around values in the SQL query
    $sql = "INSERT INTO subcategory(category_id, name, slug) VALUES('$category_id', '$nameUpper', '$nameLower')";

    $result = mysqli_query($conn, $sql) or die("Query Unsuccessful.");

    if ($result) {
        $_SESSION['status'] = "SubCategory Created Successfully.";
        header('Location: sub-category.php');
    } else {
        $_SESSION['status'] = "SUbCategory Creation Failed!";
        header('Location: sub-category.php');
    }
}
?>


<?php
session_start();
if (!isset($_SESSION['loggedin_admin']) || $_SESSION['loggedin_admin'] != true) {
    header('location: login.php');
    exit;
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

    <title>SB Admin 2 - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        form {
            padding: 40px;
        }

        input,
        textarea,
        select {
            margin-bottom: 20px;
            font-size: medium;
            border: 1px solid grey;
            border-radius: 10px;
            padding: 12px 20px;
        }

        p {
            margin-bottom: 5px;
        }

        /* Apply these styles to your textarea element */
        textarea {
            width: 50%;
            /* Makes the textarea expand to the container width */
            padding: 10px;
            /* Adds some padding inside the textarea */
            border: 1px solid #ccc;
            /* Adds a border */
            border-radius: 5px;
            /* Rounds the corners */
            font-size: 16px;
            /* Sets the font size */
            line-height: 1.4;
            /* Adjusts line height for readability */
        }

        /* Style the textarea when it's focused (clicked) */
        textarea:focus {
            border-color: #007BFF;
            /* Change border color on focus */
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            /* Add a subtle shadow */
        }

        /* Style the textarea when it's disabled */
        textarea:disabled {
            background-color: #f2f2f2;
            /* Change background color when disabled */
            cursor: not-allowed;
            /* Change cursor style */
        }

        /* Add more styles as needed */
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include "sidebar.php" ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include "topbar.php" ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->


                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Add Sub Category</h1>

                </div>
                <!-- /.container-fluid -->


                <form class="post-form" action="" method="post">


                    <p>Sub Category Name</p>
                    <input required type="text" name="name" />

                    <p>Choose Category</p>
                    <select name="category_id" required>
                        <option value="" selected disabled>Select Category</option>
                        <?php
                        include 'config.php';

                        $sql = "SELECT * FROM category";
                        $result = mysqli_query($conn, $sql) or die("Query Unsuccessful.");

                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <option value="<?php echo $row['category_id']; ?>"><?php echo $row['category_name']; ?></option>

                        <?php } ?>
                    </select>

                    <p><input required class="submit btn btn-success" name="submit" type="submit" value="Add Sub Category" /></p>
                </form>



            </div>
            <!-- End of Main Content -->



            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <!-- <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Surajit Shaw 2023</span>
                </div>
            </div>
        </footer> -->
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
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

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>