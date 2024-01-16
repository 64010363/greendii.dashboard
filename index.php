<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "greendii_data";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query ข้อมูล CA electronic
    $sql_ca = "SELECT BlowingTimes FROM air_shower WHERE FactoryName = 'ca electronic'";
    $result_ca = $conn->query($sql_ca);

    // Fetch ข้อมูล CA electronic
    $totalBlowingTimeInSeconds_ca = 0;
    while ($row_ca = $result_ca->fetch(PDO::FETCH_ASSOC)) {
        $totalBlowingTimeInSeconds_ca += $row_ca['BlowingTimes'];
    }

    // Query ข้อมูล Greendii
    $sql_greendii = "SELECT BlowingTimes FROM air_shower WHERE FactoryName = 'greendii'";
    $result_greendii = $conn->query($sql_greendii);

    // Fetch ข้อมูล Greendii
    $totalBlowingTimeInSeconds_greendii = 0;
    while ($row_greendii = $result_greendii->fetch(PDO::FETCH_ASSOC)) {
        $totalBlowingTimeInSeconds_greendii += $row_greendii['BlowingTimes'];
    }

    // Query ข้อมูล Papitan construction
    $sql_papitan = "SELECT BlowingTimes FROM air_shower WHERE FactoryName = 'papitan construction'";
    $result_papitan = $conn->query($sql_papitan);

    // Fetch ข้อมูล Papitan construction
    $totalBlowingTimeInSeconds_papitan = 0;
    while ($row_papitan = $result_papitan->fetch(PDO::FETCH_ASSOC)) {
        $totalBlowingTimeInSeconds_papitan += $row_papitan['BlowingTimes'];
    }

    // Query ข้อมูล Hatakabb (Sim Tien Hor)
    $sql_hatakabb = "SELECT BlowingTimes FROM air_shower WHERE FactoryName = 'Hatakabb (Sim Tien Hor)'";
    $result_hatakabb = $conn->query($sql_hatakabb);

    // Fetch ข้อมูล Hatakabb (Sim Tien Hor)
    $totalBlowingTimeInSeconds_hatakabb = 0;
    while ($row_hatakabb = $result_hatakabb->fetch(PDO::FETCH_ASSOC)) {
        $totalBlowingTimeInSeconds_hatakabb += $row_hatakabb['BlowingTimes'];
    }

    // ปิดการเชื่อมต่อ
    $conn = null;

    // แปลงเวลาจากวินาทีเป็นชั่วโมงและนาที สำหรับ CA electronic
    $hours_ca = floor($totalBlowingTimeInSeconds_ca / 3600);
    $minutes_ca = floor(($totalBlowingTimeInSeconds_ca % 3600) / 60);

    // แปลงเวลาจากวินาทีเป็นชั่วโมงและนาที สำหรับ Greendii
    $hours_greendii = floor($totalBlowingTimeInSeconds_greendii / 3600);
    $minutes_greendii = floor(($totalBlowingTimeInSeconds_greendii % 3600) / 60);

    // แปลงเวลาจากวินาทีเป็นชั่วโมงและนาที สำหรับ Papitan construction
    $hours_papitan = floor($totalBlowingTimeInSeconds_papitan / 3600);
    $minutes_papitan = floor(($totalBlowingTimeInSeconds_papitan % 3600) / 60);

    // แปลงเวลาจากวินาทีเป็นชั่วโมงและนาที สำหรับ Hatakabb (Sim Tien Hor)
    $hours_hatakabb = floor($totalBlowingTimeInSeconds_hatakabb / 3600);
    $minutes_hatakabb = floor(($totalBlowingTimeInSeconds_hatakabb % 3600) / 60);

    // คืนค่า JSON
    echo json_encode([
        "ca_electronic" => ["hours" => $hours_ca, "minutes" => $minutes_ca],
        "greendii" => ["hours" => $hours_greendii, "minutes" => $minutes_greendii],
        "papitan_construction" => ["hours" => $hours_papitan, "minutes" => $minutes_papitan],
        "hatakabb" => ["hours" => $hours_hatakabb, "minutes" => $minutes_hatakabb]
    ]);

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard - SB Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.html">ENGINEERING KMITL</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Settings</a></li>
                        <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="#!">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            
                            <a class="nav-link" href="index.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            
                            
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="layout-static.html">Static Navigation</a>
                                    <a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>
                                </nav>
                            </div>
                         
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Authentication
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="login.html">Login</a>
                                            <a class="nav-link" href="register.html">Register</a>
                                            <a class="nav-link" href="password.html">Forgot Password</a>
                                        </nav>
                                    </div>
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                        Error
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="401.html">401 Page</a>
                                            <a class="nav-link" href="404.html">404 Page</a>
                                            <a class="nav-link" href="500.html">500 Page</a>
                                        </nav>
                                    </div>
                                </nav>
                            </div>
                            
                            <a class="nav-link" href="charts.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Charts
                            </a>
                            
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small"></div>
                        KMITL
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">ข้อมูลการใช้งาน Air shower </h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Greendii Company Limited</li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                <div class="card-body">CA electronic</div>
                                <div class="card-body">
                                    <?php
                                        if (!empty($hours_ca) || !empty($minutes_ca)) {
                                            echo "$hours_ca ชั่วโมง $minutes_ca นาที";
                                        } else {
                                            echo "No data available";
                                        }
                                    ?>
                                </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">Greendii</div>
                                    <div class="card-body">
                                            <?php
                                             if (!empty($hours_greendii) || !empty($minutes_greendii)) {
                                                    echo "$hours_greendii ชั่วโมง $minutes_greendii นาที";
                                                } else {
                                                    echo "No data available";
                                                }
                                            ?>

                                    </div>     
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">Papitan construction</div>
                                    <div class="card-body">
                                            <?php
                                             if (!empty($hours_papitan) || !empty($minutes_papitan)) {
                                                    echo "$hours_papitan ชั่วโมง $minutes_papitan นาที";
                                                } else {
                                                    echo "No data available";
                                                }
                                            ?>

                                    </div>    
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">Hatakabb (Sim Tien Hor)</div>
                                    <div class="card-body">
                                            <?php
                                             if (!empty($hours_hatakabb) || !empty($minutes_hatakabb)) {
                                            echo "$hours_hatakabb ชั่วโมง $minutes_hatakabb นาที";
                                                } else {
                                                    echo "No data available";
                                                }
                                            ?>

                                    </div>    
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row"> -->
                            <!-- <div class="col-xl-6">
                                <div class="card mb-4"> -->
                                    <!-- <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        Area Chart 
                                    </div> -->
                                    <!-- <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                                </div> -->
                            <!-- </div> -->
                            <!-- <div class="col-xl-6">
                                <div class="card mb-4"> -->
                                    <!-- <div class="card-header">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        Bar Chart 
                                    </div> -->
                                    <!-- <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                        </div> -->
                        
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Greendii Company Limited 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
