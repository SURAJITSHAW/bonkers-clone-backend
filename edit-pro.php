<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header('location: login.php');
    exit;
}

include 'config.php';
if (isset($_POST["edit"])) {
    $id = $_GET["id"];
    $name = $_POST["p_name"];
    $price = $_POST["p_price"];
    $desc = $_POST["p_desc"];
    $category = $_POST["category_id"];
    $subcategory = $_POST["sub_category_id"];

    $img_new = $_FILES["p_img"]["name"];
    $img_old = $_POST["img_old"];

    if ($img_new != null) {
        $update_file = $_FILES["p_img"]["name"];
    } else {

        $update_file = $img_old;
    }

    // Update
    $sql1 = "UPDATE product SET p_name='$name', p_price='$price',p_img='$update_file', category_id='$category', sub_category_id='$subcategory', p_desc='$desc' WHERE p_id='$id'";

    $result1 = mysqli_query($conn, $sql1) or die("Query Unsuccessful.");

    if ($result1) {

        if ($_FILES["p_img"]["name"] != null) {
            move_uploaded_file($_FILES['p_img']['tmp_name'], "uploads/" . $_FILES["p_img"]["name"]);
            unlink("uploads/" . $img_old);
        }

        $_SESSION['status'] = "Updated successfully";
        header('Location: products.php');
    } else {
        $_SESSION['status'] = "Updatation failed";
        header('Location: products.php');
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

    <title>Edit Product</title>

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
        /* Add a border around the image */
        img.preview-image {
            border-left: 2px solid #007BFF;
            /* You can choose any color you like */
            border-radius: 5px;
            /* Rounds the corners */
            max-width: 100%;
            /* Ensure the image doesn't exceed its container width */
            height: auto;
            /* Maintain the aspect ratio */
            margin-bottom: 10px;
            /* Add some spacing below the image */
        }
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
                    <h1 class="h3 mb-4 text-gray-800">Edit Product</h1>

                </div>
                <!-- /.container-fluid -->

                <?php

                $id = $_GET['id'];
                include 'config.php';

                $sql = "SELECT * FROM product WHERE p_id = '$id'";
                $result = mysqli_query($conn, $sql) or die("Query Unsuccessful.");

                if (mysqli_num_rows($result) > 0) {
                    $i = 1;
                    foreach ($result as $row) {

                ?>
                        <form class="post-form" action="" method="post" enctype="multipart/form-data">

                            <p>Name</p>
                            <input value='<?php echo $row["p_name"]; ?>' required type="text" name="p_name" />
                            <p>Price</p>
                            <input value='<?php echo $row["p_price"]; ?>' required type="text" name="p_price" />


                            <p>Image</p>
                            <img width="200px" class="preview-image" src="<?php echo "uploads/" . $row["p_img"]; ?>" alt=""><br>
                            <input type="file" name="p_img" />
                            <input value='<?php echo $row["p_img"]; ?>' type="hidden" name="img_old" />


                            <p>Details</p>
                            <textarea rows="7" name="p_desc"><?php echo $row["p_desc"]; ?></textarea>


                            <p>Category</p>
                            <select name="category_id" required>

                                <?php
                                

                                $sql1 = "SELECT * FROM category";
                                $result1 = mysqli_query($conn, $sql1) or die("Query Unsuccessful.");

                                while ($row1 = mysqli_fetch_assoc($result1)) {
                                    if ($row['category_id'] == $row1['category_id']) {
                                        $select = "selected";
                                    } else {
                                        $select = "";
                                    }

                                    echo "<option {$select} value={$row1['category_id']}>{$row1['category_name']}</option>";
                                } ?>
                            </select>

                            <p>Sub Category</p>
                            <select name="sub_category_id" required>

                                <?php
                                

                                $sql2 = "SELECT * FROM subcategory WHERE category_id ={$row['category_id']}";
                                $result2 = mysqli_query($conn, $sql2) or die("Query Unsuccessful.");

                                while ($row2 = mysqli_fetch_assoc($result2)) {
                                    if ($row['sub_category_id'] == $row2['id']) {
                                        $select = "selected";
                                    } else {
                                        $select = "";
                                    }

                                    echo "<option {$select} value={$row2['id']}>{$row2['name']}</option>";
                                } ?>
                            </select>




                            <p><input required class="submit btn btn-success" name="edit" type="submit" value="Edit" /></p>
                        </form>
                <?php
                $i++;
                    }
                } else {
                    echo "No products available";
                }

                ?>






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