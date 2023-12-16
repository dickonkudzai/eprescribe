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
        <h1 class="mt-4">Drugs</h1>
        <div class="card mb-4">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <i class="fas fa-table me-1"></i>
                        Drugs
                    </div>
                    <div class="col-6" align="right">
                        <button type="button" class="btn btn-sm btn-primary" id="add_drug_button">Add Drug</button>
                    </div>
                </div>

            </div>
            <div class="card-body">
                <table id="drugs">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Blocked</th>
                        <th>Controlled</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Blocked</th>
                        <th>Controlled</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php echo getDrugs($dbConnect)?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<?php
include "../includes/footer.php";
?>
<script src="drugs.js"></script>

<div class="modal fade" id="drugModal" tabindex="-1" role="dialog" aria-labelledby="drugModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="drugModal">Drug</h5>
                <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <br>
            <form id="drug_form">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="hospital_name">Drug Name</label>
                            <input type="text" class="form-control" id="drug_name" name="drug_name" placeholder="Drug name" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" id="blocked" name="blocked" type="checkbox" value="1">
                                <label class="form-check-label" form="blocked">Blocked</label>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" id="controlled" name="controlled" type="checkbox" value="1">
                                <label class="form-check-label" form="controlled">Controlled</label>
                            </div>
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
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>