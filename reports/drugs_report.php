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
                        Blocked Drugs Report
                    </div>
                </div>

            </div>
            <div class="card-body">
                <form action="drugs_export.php" method="POST">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="blocked">Filter</label>
                                <select id="blocked" name="blocked" class="form-control">
                                    <option value="all">All</option>
                                    <option value="1">Blocked</option>
                                    <option value="0">Not Blocked</option>
                                </select>
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