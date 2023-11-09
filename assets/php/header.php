<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Slovax E-Vaccination</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="assets/vendor/js/helpers.js"></script>

    <script src="assets/js/config.js"></script>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="index.php" class="app-brand-link">
              
              <span class="app-brand-text demo menu-text fw-bolder ms-2">slovax</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboard -->
            <li class="menu-item active">
              <a href="index.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
              </a>
            </li>

            <?php
            if (isset($_SESSION['userID'])) {
              ?>
              
       
            <?php
            if (isset($_SESSION['userID']) && $_SESSION['role'] === 'Admin') {
              ?>
                <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Admin</span>
            </li>
            <li class="menu-item">
              <a href="allchilds.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Account Settings">Child Details</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="vaccines.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Account Settings">List Of Vaccines</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="upcomingDateOfVaccine.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Account Settings">Date Of Vaccines</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="hospitals.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Account Settings">List Of hospitals</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="reports.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Authentications">Report of Vaccination</div>
              </a>
            </li>
            
            <li class="menu-item">
              <a href="appointments.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Authentications">Appointments Request</div>
              </a>
            </li>
                <?php
              }elseif ($_SESSION['role'] === 'Parent') {
                ?>
                <!-- Components -->
            <li class="menu-header small text-uppercase"><span class="menu-header-text">parent</span></li>
            <!-- Cards -->
            <li class="menu-item">
              <a href="allchilds.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Basic">Child Detail</div>
              </a>
            </li>
            
            <!-- User interface -->
            <li class="menu-item">
              <a href="upcomingDateOfVaccine.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-box"></i>
                <div data-i18n="User interface">Vaccine date</div>
              </a>
            </li>

            <!-- Extended components -->
            <li class="menu-item">
              <a href="appointments.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-copy"></i>
                <div data-i18n="Extended UI">Your Appointments</div>
              </a>
             
            </li>

            <li class="menu-item">
              <a href="reports.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-crown"></i>
                <div data-i18n="Boxicons">Vaccine Reports</div>
              </a>
            </li>
                <?php
              }elseif ($_SESSION['role'] === 'Hospital') {
                $hospitalId = $_SESSION['userID'];
            
                // Check hospital status
                $hospitalStatusQuery = $pdo->prepare("SELECT status FROM hospitals WHERE hospital_id = ?");
                $hospitalStatusQuery->execute([$hospitalId]);
                $hospitalStatus = $hospitalStatusQuery->fetchColumn();
            
                // Display the menu item only if the hospital status is 'approved'
                if ($hospitalStatus === 'Approved') {
                    ?>
                    <!-- Forms & Tables -->
                    <li class="menu-header small text-uppercase"><span class="menu-header-text">Hospital</span></li>
                    <!-- Forms -->
                    <li class="menu-item">
                        <a href="hospitalVaccines.php" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-detail"></i>
                            <div data-i18n="Form Elements">Vaccines</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="parentAppointments.php" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-detail"></i>
                            <div data-i18n="Form Layouts">Appointments</div>
                        </a>
                    </li>
                    <!-- Tables -->
                    <li class="menu-item">
                        <a href="reports.php" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-crown"></i>
                            <div data-i18n="Tables">Appointment Reports</div>
                        </a>
                    </li>
                    <!-- Misc -->
                    </li>
                    <?php
                }
            }
            
            
            ?>

              <?php
            }
            ?>
            
            
          </ul>
        </aside>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              

              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Place this tag where you want the button to render. -->
              
                <!-- User -->
                <?php
                            if (isset($_SESSION['userID'])) {
                              ?>
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <?php
                        if ($_SESSION['role'] === 'Hospital') {
                          ?>
                          <img src="assets/img/hospital.jpg" alt class="w-px-40 h-auto rounded-circle" />
                        <?php
                        }else {
                          ?>
                          <img src="assets/img/profile.jpg" alt class="w-px-40 h-auto rounded-circle" />
                          <?php
                        }
                        ?>
                      
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                            <?php
                        if ($_SESSION['role'] === 'Hospital') {
                          ?>
                          <img src="assets/img/hospital.jpg" alt class="w-px-40 h-auto rounded-circle" />
                        <?php
                        }else {
                          ?>
                          <img src="assets/img/profile.jpg" alt class="w-px-40 h-auto rounded-circle" />
                          <?php
                        }
                        ?>
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            
                              
                            <span class="fw-semibold d-block"><?php echo $_SESSION['username'] ?></span>
                            <small class="text-muted"><?php echo $_SESSION['role'] ?></small>
                            
                          </div>
                        </div>
                      </a>
                    </li>
                    
                    
                    
                    <li>
                      
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="logout.php">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Log Out</span>
                      </a>
                    </li>
                    
                    <?php
                    // $hospitalStatus = $_SESSION['status'];
                            }else{
                              ?><a href="login.php" class="btn btn-outline-primary me-2">login</a>
                              <a href="register.php" class="btn btn-primary">Register</a><?php
                            }
                            ?>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>
