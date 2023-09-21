<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header('location: login.php');
    exit;
}

include "config.php";

if (isset($_POST["delete"])) {
    $id = mysqli_real_escape_string($conn, $_POST["del_id"]);
    $img = mysqli_real_escape_string($conn, $_POST["del_img"]);

    $sql = "DELETE FROM product WHERE p_id='$id'";

    $result = mysqli_query($conn, $sql) or die("Query Unsuccessful.");

    if ($result) {
        unlink("uploads/" . $img);
        $_SESSION['status'] = "Product Deleted Successfully.";
        header('Location: products.php');
    } else {
        $_SESSION['status'] = "Product Deletion Failed!";
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

    <title>Ecommerce</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

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
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <a href="add-pro.php" style="float:right;" type="submit" name="Add" class="btn btn-success">Add Product</a>
                    <h1 class="h3 mb-4 text-gray-800">List Products</h1>

                    <?php
                    if (isset($_SESSION['status']) && $_SESSION != '') {

                    ?>

                        <div class="alert alert-warning alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Hey! </strong><?php echo $_SESSION['status']; ?>
                        </div>

                    <?php
                        unset($_SESSION['status']);
                    }
                    include 'config.php';

                    $sql = "SELECT * FROM 
                    product AS p JOIN category AS c 
                    ON p.category_id = c.category_id";


                    $result = mysqli_query($conn, $sql) or die("Query Unsuccessful.");

                    if (mysqli_num_rows($result) > 0) {
                    ?>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Serial No.</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Image</th>
                                    <th>Category Name</th>
                                    <th>Sub Category Name</th>
                                    <th>Description</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>

                                        <td><?php echo $row['p_name']; ?></td>

                                        <td>Rs. <?php echo $row['p_price']; ?></td>

                                        <td><img src="<?php echo "uploads/" . $row['p_img']; ?>" alt="" height="200px" width="200px" style="object-fit: contain;"></td>

                                        <td><?php echo $row['category_name']; ?></td>
                                        <?php
                                            $sql1 = "SELECT * FROM subcategory WHERE id={$row['sub_category_id']}";


                                            $result1 = mysqli_query($conn, $sql1) or die("Query Unsuccessful.");
                                            while ($row1 = mysqli_fetch_assoc($result1)) {
                                        ?>

                                        <td><?php echo $row1['name']; ?></td>

                                        <?php

                                            }
                                        ?>

                                        <td><?php echo $row['p_desc']; ?></td>


                                        <td><a href="edit-pro.php?id=<?php echo $row['p_id']; ?>" class="btn btn-info">Edit</a></td>

                                        <td>
                                            <!-- Delete product -->
                                            <form action="" method="post">
                                                <input type="hidden" name="del_id" value="<?php echo $row['p_id']; ?>">
                                                <input type="hidden" name="del_img" value="<?php echo $row['p_img']; ?>">
                                                <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php
                            $i++;    
                            }


                                ?>
                            </tbody>
                        </table>

                    <?php } else {

                        echo "<tr><td> No Record Found</td></tr>";
                    } ?>

                </div>

                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Surajit Shaw 2023</span>
                    </div>
                </div>
            </footer>
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
                    <a class="btn btn-danger" href="login.php">Logout</a>
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