<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header('location: login.php');
    exit;
}

include "config.php";

if (isset($_POST["submit"])) {
    $name = mysqli_real_escape_string($conn, $_POST["p_name"]);
    $price = mysqli_real_escape_string($conn, $_POST["p_price"]);
    $img = mysqli_real_escape_string($conn, $_FILES["p_img"]["name"]);
    $desc = mysqli_real_escape_string($conn, $_POST["p_desc"]);
    $category = mysqli_real_escape_string($conn, $_POST["category_id"]);

    // Add single quotes around values in the SQL query
    $sql = "INSERT INTO product(p_name, p_price,p_img, p_desc, category_id) VALUES ('$name', '$price', '$img', '$desc', '$category')";

    $result = mysqli_query($conn, $sql) or die("Query Unsuccessful.");

    if ($result) {
        move_uploaded_file($_FILES['p_img']['tmp_name'], "uploads/" . $_FILES["p_img"]["name"]);
        $_SESSION['status'] = "Product Created Successfully.";
        header('Location: products.php');
    } else {
        $_SESSION['status'] = "Product Creation Failed!";
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
                    <h1 class="h3 mb-4 text-gray-800">Add Product</h1>

                </div>
                <!-- /.container-fluid -->


                <form class="post-form" action="" method="post" enctype="multipart/form-data">


                    <p>Name</p>
                    <input required type="text" name="p_name" />

                    <p>Price</p>
                    <input required type="text" name="p_price" />


                    <p>Image</p>
                    <input required type="file" name="p_img" />

                    <p>Description</p>
                    <textarea rows="7" name="p_desc" required></textarea>

                    <p>Category</p>
                    <select id="category_id" name="category_id" required>
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


                    <p>Subcategory</p>
                    <select id="subcategory" name="sub_category_id" required disabled>
                        <option value="" selected disabled>Select a category first</option>
                    </select>



                    <p><input required class="submit btn btn-success" name="submit" type="submit" value="Add Product" /></p>
                </form>

                <script>
                    // Get references to the category and subcategory select elements
                    const categorySelect = document.getElementById('category_id'); // Adjust the ID as needed
                    const subcategorySelect = document.getElementById('subcategory');

                    // Add an event listener to the category select element
                    categorySelect.addEventListener('change', () => {
                        const selectedCategoryID = categorySelect.value;

                        // Disable the subcategory select while loading data
                        subcategorySelect.disabled = true;

                        // Clear existing subcategory options
                        subcategorySelect.innerHTML = '<option value="" selected disabled>Loading subcategories...</option>';

                        // Make an AJAX request to fetch subcategories based on the selected category
                        fetch('get_subcategories.php?category_id=' + selectedCategoryID)
                            .then(response => response.json())
                            .then(data => {
                                // Populate the subcategory select with the fetched subcategories
                                subcategorySelect.innerHTML = '<option value="" selected disabled>Select a subcategory</option>';
                                data.forEach(subcategory => {
                                    subcategorySelect.innerHTML += `<option value="${subcategory.id}">${subcategory.name}</option>`;
                                });

                                // Enable the subcategory select
                                subcategorySelect.disabled = false;
                            })
                            .catch(error => {
                                console.error('Error fetching subcategories:', error);
                                subcategorySelect.innerHTML = '<option value="" selected disabled>Error loading subcategories</option>';
                            });
                    });
                </script>



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