<?php
    $patientId = $_GET['id'];
?>
<main>
    <div class="container-fluid px-4">
        <div class="card mb-4">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <i class="fas fa-table me-1"></i>
                        Patients
                    </div>
                    <div class="col-6" align="right">
                        <button type="button" class="btn btn-sm btn-primary" id="add_consultation_button">Add Consultation</button>
                    </div>
                </div>

            </div>
            <div class="card-body">
                <table id="consultations">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Attended By</th>
                        <th>Weight</th>
                        <th>Temperature</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Attended By</th>
                        <th>Weight</th>
                        <th>Temperature</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                    <tbody>
                        <?php
                            if (isset($dbConnect)) {
                                echo getPatientConsultations($dbConnect, $patientId);
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<script src="consultations.js"></script>

<div class="modal fade" id="consultationModal" tabindex="-1" role="dialog" aria-labelledby="consultationModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hospitalModal">Consultation</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <br>
            <form id="consultation_form">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="weight">Weight <small>(kgs)</small></label>
                            <input type="number" step="any" class="form-control" id="weight" name="weight" placeholder="10.2" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="temperature">Temperature</label>
                            <input type="number" step="any" class="form-control" id="temperature" name="temperature" placeholder="36" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="bp">BP</label>
                            <input type="text" class="form-control" id="bp" name="bp" placeholder="36/36" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="bp">Condition Description</label>
                            <textarea type="text" class="form-control" id="condition_description" name="condition_description"></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="condition_diagnosis">Condition Diagnosis</label>
                            <textarea class="form-control" id="condition_diagnosis" name="condition_diagnosis"></textarea>
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
                    <input type="hidden" name="patient_id" id="patient_id" value="<?php echo $patientId ?>">
                    <input type="hidden" name="action" id="action" value="">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>