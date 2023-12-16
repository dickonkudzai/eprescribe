<?php
include "../includes/header.php";
include "../includes/sidebar.php";
include "../config/utilities.php";
require_once '..\config\Config.php';
use \config\Config;
$config = new Config();
$postData = $_POST;
$getData = $_GET;
$dbConnect = $config->databaseConnection();


?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Reports</h1>
        <div class="card mb-4">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <i class="fas fa-table me-1"></i>
                        Prescriptions Report
                    </div>
                </div>

            </div>
            <div class="card-body">
                <form action="prescription_export.php" method="POST">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="from_date">From Date</label>
                                <input type="date" class="form-control" id="from_date" name="from_date" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="to_date">To Date</label>
                                <input type="date" class="form-control" id="to_date" name="to_date" required>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" id="generate_report">Generate Report</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>