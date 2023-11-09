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
        <h1 class="mt-4">Patient - </h1>
        <div class="card">
            <div class="card-header border-bottom">
                <ul class="nav nav-tabs card-header-tabs" id="cardTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="overview-tab" href="#overview" data-bs-toggle="tab" role="tab" aria-controls="overview" aria-selected="true">Overview</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="consultation-tab" href="#consultation" data-bs-toggle="tab" role="tab" aria-controls="consultation" aria-selected="false">Consultations</a>
                    </li>
                    <li class="nav-item" >
                        <a class="nav-link" id="prescription-tab" href="#prescription" data-bs-toggle="tab" role="tab" aria-controls="prescription" aria-selected="false">Prescriptions</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="cardTabContent">
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                        <h5 class="card-title">Patient Overview</h5>
                        <p class="card-text">...</p>
                    </div>
                    <div class="tab-pane fade" id="consultation" role="tabpanel" aria-labelledby="consultation-tab">
                        <h5 class="card-title">Consulations</h5>
                        <p class="card-text">...</p>
                    </div>
                    <div class="tab-pane fade" id="prescription" role="tabpanel" aria-labelledby="prescription-tab">
                        <h5 class="card-title">Prescriptions</h5>
                        <p class="card-text">...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
include "../includes/footer.php";
?>
<script src="patient.js"></script>

<div class="modal fade" id="patientModal" tabindex="-1" role="dialog" aria-labelledby="patientModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="patientModal">Patient</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <br>
            <form id="patient_form">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last name" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="national_id">National ID</label>
                            <input type="text" class="form-control" id="national_id" name="national_id" placeholder="231547896C75" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Address" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="email@email.com" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="mobile_number">Mobile Number</label>
                            <input type="text" class="form-control" id="mobile_number" name="mobile_number" placeholder="0777777777" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" id="submit" name="submit" value="Save">
                    <button class="btn btn-primary hidden" id="loader" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="action" id="action" value="">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>