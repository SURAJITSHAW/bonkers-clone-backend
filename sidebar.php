<?php
// Get the current page's filename
$current_page = basename($_SERVER['PHP_SELF']);
?>

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon">
            <img src="./img/bc.webp" height="60px" alt="">
        </div>
        <div class="sidebar-brand-text mx-3">Bonkers <br>Corner</div>
    </a>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?php echo ($current_page == 'category.php') ? 'active' : ''; ?>" style="margin-top:30px">
        <a class="nav-link" href="category.php">
            <span>Category</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <li class="nav-item <?php echo ($current_page == 'sub-category.php') ? 'active' : ''; ?>">
        <a class="nav-link" href="sub-category.php">
            <span>Sub Category</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <li class="nav-item <?php echo ($current_page == 'products.php') ? 'active' : ''; ?>">
        <a class="nav-link" href="products.php">
            <span>Products</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <li class="nav-item <?php echo ($current_page == 'orders.php') ? 'active' : ''; ?>">
        <a class="nav-link" href="orders.php">
            <span>Orders</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

</ul>