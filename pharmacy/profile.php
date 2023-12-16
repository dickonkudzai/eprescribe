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
        <h1 class="mt-4">Pharmacy - </h1>
        <div class="card">
            <div class="card-header border-bottom">
                <ul class="nav nav-tabs card-header-tabs" id="cardTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="overview-tab" href="#overview" data-bs-toggle="tab" role="tab" aria-controls="overview" aria-selected="true">Overview</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="stock-tab" href="#stock" data-bs-toggle="tab" role="tab" aria-controls="stock" aria-selected="false">Stock</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="stock-tab" href="#dispenser" data-bs-toggle="tab" role="tab" aria-controls="stock" aria-selected="false">Dispense</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="cardTabContent">
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                        <h5 class="card-title">Pharmacy Overview</h5>
                        <p class="card-text">...</p>
                    </div>
                    <div class="tab-pane fade" id="stock" role="tabpanel" aria-labelledby="consultation-tab">
                        <h1 class="mt-4">Stock</h1>
                        <div>
                            <?php
                                include "./stock.php";
                            ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="dispenser" role="tabpanel" aria-labelledby="stock-tab">
                        <h1 class="mt-4">Dispenser</h1>
                        <div>
                            <?php
                            include "./dispense.php";
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
include "../includes/footer.php";
?>
<script src="pharmacy.js"></script>