<?php

require_once("inc.headers.php");
require_once('functions/SupplierControllers.php');
require_once('functions/StocksControllers.php');
$conn = dbconnect();

$suppliers = get_suppliers($conn);
$inventory = get_inventory($conn);




if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (isset($_POST["add-stocks"])) {
      
      $conn = dbconnect();
      $item_name = htmlspecialchars(trim($_POST['item_name']));
      $category = htmlspecialchars(trim($_POST["category"]));
      $stock_quantity = htmlspecialchars(trim($_POST["stock_quantity"]));
      $unit_price = htmlspecialchars(trim($_POST["unit_price"]));
      $employee_id = htmlspecialchars(trim($user['employee_id']));
      $supplier_id = htmlspecialchars(trim($_POST["supplier_id"]));

      // Call function and check if it was successful
      if (insert_inventory($conn, $item_name, $category, $stock_quantity,$unit_price, $employee_id, $supplier_id)) {
          echo "<script>alert('New item added successfully.'); window.location = 'stocks-management.php';</script>";
      }
  } else {
      echo "<script>alert('Invalid request');</script>";
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Inventory Management</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

 <!-- ======= Header ======= -->
 <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">AQUA EVAN</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-bell"></i>
            <span class="badge bg-primary badge-number">4</span>
          </a><!-- End Notification Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
            <li class="dropdown-header">
              You have 4 new notifications
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-exclamation-circle text-warning"></i>
              <div>
                <h4>Lorem Ipsum</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>30 min. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-x-circle text-danger"></i>
              <div>
                <h4>Atque rerum nesciunt</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>1 hr. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-check-circle text-success"></i>
              <div>
                <h4>Sit rerum fuga</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>2 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-info-circle text-primary"></i>
              <div>
                <h4>Dicta reprehenderit</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>4 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>
            <li class="dropdown-footer">
              <a href="#">Show all notifications</a>
            </li>

          </ul><!-- End Notification Dropdown Items -->

        </li><!-- End Notification Nav -->

        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-chat-left-text"></i>
            <span class="badge bg-success badge-number">3</span>
          </a><!-- End Messages Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
            <li class="dropdown-header">
              You have 3 new messages
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-1.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>Maria Hudson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>4 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-2.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>Anna Nelson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>6 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-3.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>David Muldon</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>8 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="dropdown-footer">
              <a href="#">Show all messages</a>
            </li>

          </ul><!-- End Messages Dropdown Items -->

        </li><!-- End Messages Nav -->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?=ucfirst($user["firstname"])?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?=ucfirst($user["firstname"] . $user["lastname"] )?></h6>
              <span><?=ucfirst($_SESSION["role"])?></span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.php">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
      <a class="nav-link " href="index.php">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li><!-- End Dashboard Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-menu-button-wide"></i><span>Inventory Management </span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="components-nav" class="nav-content collapse show " data-bs-parent="#sidebar-nav">
        <li>
          <a href="stocks-management.php" class="active">
            <i class="bi bi-circle"></i><span>Stock Tracking</span>
          </a>
        </li>
        <li>
          <a href="components-accordion.html">
            <i class="bi bi-circle"></i><span>Usage & Refill Logs</span>
          </a>
        </li>
        <li>
          <a href="supplier-management.php">
            <i class="bi bi-circle"></i><span>Supplier Management</span>
          </a>
        </li>

      </ul>
    </li><!-- End Components Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-journal-text"></i><span>Order Management</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="forms-elements.html">
            <i class="bi bi-circle"></i><span>Delivery Orders</span>
          </a>
        </li>

      </ul>
    </li><!-- End Forms Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-layout-text-window-reverse"></i><span>Customer Management</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="tables-general.html">
            <i class="bi bi-circle"></i><span>Customer Details</span>
          </a>
        </li>
        <li>
          <a href="tables-data.html">
            <i class="bi bi-circle"></i><span>Order History</span>
          </a>
        </li>
      </ul>
    </li><!-- End Tables Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-bar-chart"></i><span>Payment Tracking</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="charts-chartjs.html">
            <i class="bi bi-circle"></i><span>Cash Payments</span>
          </a>
        </li>
        <li>
          <a href="charts-apexcharts.html">
            <i class="bi bi-circle"></i><span>Gcash Payments</span>
          </a>
        </li>
        <li>
          <a href="charts-echarts.html">
            <i class="bi bi-circle"></i><span>Credit Payments</span>
          </a>
        </li>
      </ul>
    </li><!-- End Charts Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-gem"></i><span>Sales Reports</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="icons-bootstrap.html">
            <i class="bi bi-circle"></i><span>Daily</span>
          </a>
        </li>
        <li>
          <a href="icons-remix.html">
            <i class="bi bi-circle"></i><span>Weekly</span>
          </a>
        </li>
        <li>
          <a href="icons-boxicons.html">
            <i class="bi bi-circle"></i><span>Monthly</span>
          </a>
        </li>
      </ul>
    </li><!-- End Icons Nav -->

    <li class="nav-heading">Account</li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="users-profile.php">
        <i class="bi bi-person"></i>
        <span>Profile</span>
      </a>
    </li><!-- End Profile Page Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" href="pages-faq.html">
        <i class="bi bi-question-circle"></i>
        <span>F.A.Q</span>
      </a>
    </li><!-- End F.A.Q Page Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" href="pages-contact.html">
        <i class="bi bi-envelope"></i>
        <span>Contact</span>
      </a>
    </li><!-- End Contact Page Nav -->

  </ul>

</aside><!-- End Sidebar-->

<main id="main" class="main">

<div class="pagetitle">
  <h1>Inventory Manangement</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.php">Home</a></li>
      <li class="breadcrumb-item">Inventory</li>
      <li class="breadcrumb-item active">Stock Tracking</li>
    </ol>
  </nav>
</div><!-- End Page Title -->
<section class="section">
      <!-- Large Modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-stock">
        New Item
    </button>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#largeModal">
        Add Stock
    </button>

    <div class="modal fade" id="add-stock" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Inventory</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <!-- Start form -->
            
              <h5 class="card-title">New Item Form</h5>

              <!-- Floating Labels Form -->
              <form class="row g-3" method="POST" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
                <div class="col-md-12">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="floatingName" disabled value="<?=htmlspecialchars(ucfirst($user["firstname"] ." " . $user["lastname"] ))?>">
                    <label for="floatingName">Employee Name</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="text" name="item_name" class="form-control" id="floatingItemName" placeholder="Item Name">
                    <label for="floatingItemName">Item Name</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating">
                    <select class="form-select" name="supplier_id" id="floatingSupplierName" aria-label="State">
                    <option selected>Select</option>
                      <?php foreach($suppliers as $supplier): ?>
                      <option value="<?=$supplier['supplier_id']?>"><?=$supplier['supplier_name']?></option>
                      <?php endforeach ?>
                    </select>
                    <label for="floatingSupplierName">Supplier Name</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="col-md-12">
                    <div class="form-floating">
                      <input type="number" name="unit_price" class="form-control" id="floatingUnitPrice" placeholder="Unit Price">
                      <label for="floatingUnitPrice">Unit Price</label>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-floating mb-3">
                    <select class="form-select" name="category" id="floatingCategory" aria-label="Category">
                      <option value="gallon" selected>Gallon</option>
                      <option value="bottle">Bottle</option>
                      <option value="filter">Filter</option>
                      <option value="supply">Supply</option>
                    </select>
                    <label for="floatingCategory">Category</label>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-floating">
                    <input type="number" name="stock_quantity" class="form-control" id="floatingStockQuantity" placeholder="Quantity">
                    <label for="floatingStockQuantity">Quantity</label>
                  </div>
                </div>
                <div class="text-center">
                  <button type="submit" name="add-stocks" class="btn btn-primary">Submit</button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
              </form><!-- End floating Labels Form -->


                   <!-- End form -->
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div> -->
            </div>
        </div>
    </div><!-- End Large Modal-->
    <div class="row">
        
        <div class="col-lg-2 col-md-3 col-sm-6 col-6">
            <!-- Card 1 -->
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">Bottle</h5>
                    <h1>
                      <?php
                        // $count = array_count_values(array_column($inventory, 'category'))['bottle'] ?? 0;
                        // echo $count;
                        $total_stock = 0;

                        for ($i = 0; $i < count($inventory); $i++) {  // Fix the loop condition
                            if ($inventory[$i]['category'] === 'bottle') {
                                $total_stock += $inventory[$i]['stock_quantity']; // Sum up stock
                            }
                        }

                        echo $total_stock;
                      ?>
                    </h1>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-lg-2 col-md-3 col-sm-6 col-6">
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">Gallon</h5>
                    <h1>
                      <?php
                        // $count = array_count_values(array_column($inventory, 'category'))['gallon'] ?? 0;
                        // echo $count;

                        $total_stock = 0;

                        for ($i = 0; $i < count($inventory); $i++) {  // Fix the loop condition
                            if ($inventory[$i]['category'] === 'gallon') {
                                $total_stock += $inventory[$i]['stock_quantity']; // Sum up stock
                            }
                        }

                        echo $total_stock;
                      ?>
                    </h1>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-lg-2 col-md-3 col-sm-6 col-6">
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">Filter</h5>
                    <h1>
                      <?php
                        // $count = array_count_values(array_column($inventory, 'category'))['filter'] ?? 0;
                        // echo $count;

                        $total_stock = 0;

                        for ($i = 0; $i < count($inventory); $i++) {  // Fix the loop condition
                            if ($inventory[$i]['category'] === 'gallon') {
                                $total_stock += $inventory[$i]['stock_quantity']; // Sum up stock
                            }
                        }

                        echo $total_stock;
                      ?>
                    </h1>
                </div>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="col-lg-2 col-md-3 col-sm-6 col-6">
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">Supply</h5>
                    <h1>
                      <?php
                        // $count = array_count_values(array_column($inventory, 'category'))['supply'] ?? 0;
                        // echo $count;

                        $total_stock = 0;

                        for ($i = 0; $i < count($inventory); $i++) {  // Fix the loop condition
                            if ($inventory[$i]['category'] === 'gallon') {
                                $total_stock += $inventory[$i]['stock_quantity']; // Sum up stock
                            }
                        }

                        echo $total_stock;
                      ?>
                    </h1>
                </div>
            </div>
        </div>

        <!-- Card 5 -->
        <div class="col-lg-2 col-md-3 col-sm-6 col-6">
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">Item</h5>
                    <h1>5</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-6 col-6">
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">Item</h5>
                    <h1>5</h1>
                </div>
            </div>
        </div>
        
    </div>
</section>


</main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; <?php $d=  new DateTime(); echo $d->format('Y') ?> <strong><span>AQUA EVAN</span></strong>. Water Refilling Station. All Rights Reserved.
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Developed by <a href="http://ric2thiss.github.io/"> Ric</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>