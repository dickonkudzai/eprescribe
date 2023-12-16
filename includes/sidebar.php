<?php
?>
<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="../home/index">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <div class="sb-sidenav-menu-heading">Admin</div>
                <a class="nav-link" href="../users/index">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Users
                </a>
                <a class="nav-link" href="../hospital/index">
                    <div class="sb-nav-link-icon"><i class="fas fa-hospital"></i></div>
                    Hospitals
                </a>
                <a class="nav-link" href="../patient/index" >
                    <div class="sb-nav-link-icon"><i class="fas fa-hospital-user"></i></div>
                    Patient
                </a>
                <a class="nav-link" href="../drugs/index" >
                    <div class="sb-nav-link-icon"><i class="fas fa-medkit"></i></div>
                    Drugs
                </a>
                <a class="nav-link" href="../pharmacy/index" >
                    <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                    Pharmacy
                </a>
                <a class="nav-link" href="../prescriptions/index">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Prescriptions
                </a>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseReports" aria-expanded="false" aria-controls="pagesCollapseReports">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Reports
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="pagesCollapseReports" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="../reports/prescriptions_report">Prescription Report</a>
                        <a class="nav-link" href="../reports/drugs_report">Drugs Report</a>
                    </nav>
                </div>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            <?php echo $_SESSION['username']?>
        </div>
    </nav>
</div>
<div id="layoutSidenav_content">
