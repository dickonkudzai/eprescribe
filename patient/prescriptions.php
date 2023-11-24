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
                        Prescriptions
                    </div>
                    <div class="col-6" align="right">
                        <button type="button" class="btn btn-sm btn-primary" id="add_prescription_button">Add Prescription</button>
                    </div>
                </div>

            </div>
            <div class="card-body">
                <table id="prescriptions">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Patient</th>
                        <th>Added By</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Patient</th>
                        <th>Added By</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php
                    if (isset($dbConnect)) {
                        echo getPatientPrescriptions($dbConnect, $patientId);
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<script src="prescriptions.js"></script>

<div class="modal fade" id="prescriptionModal" tabindex="-1" role="dialog" aria-labelledby="prescriptionModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="prescriptionModal">Prescription</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <br>
            <form id="prescription_form">
                <div class="modal-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Drug</th>
                                    <th>Dose</th>
                                    <th>Collected</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody id="prescription_lines">

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Drug</th>
                                    <th>Dose</th>
                                    <th>Collected</th>
                                    <th></th>
                                </tr>
                                </tfoot>
                            </table>
                            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                                <h1 class="h3 mb-0 text-gray-800"></h1>
                                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" align="right" id="add_line_button"><i class="fas fa-calendar-plus fa-sm text-white-50"></i> Add</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" id="prescription_submit" name="prescription_submit" value="Save">
                    <button class="btn btn-primary hidden" id="prescription_loader" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                    <input type="hidden" name="prescription_id" id="prescription_id">
                    <input type="hidden" name="prescription_patient_id" id="prescription_patient_id" value="<?php echo $patientId ?>">
                    <input type="hidden" name="prescription_action" id="prescription_action" value="">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        let counts = 0;
        let rowCount = 0;

        $(document).on('click', '#add_line_button', function(){
            rowCount = $('#prescription_lines tr').length;
            if (rowCount<1) {
                counts = counts + 1;
            }
            else{
                counts = rowCount + 1;
            }
            add_prescription_line(counts);
        });
        $(document).on('click', '#del', function()
        {
            const row_s_id = $(this).attr("value");
            if ($("#prescription_line_id"+row_s_id).val()!=="") {
                const action = "delete_prescription_line_by_id";
                const id = $(this).attr("id");
                const prescription_line_id = $("#prescription_line_id"+row_s_id).val();
                console.log(prescription_line_id);
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url:"./prescriptions_actions",
                            method: "get",
                            data:{action:action, id:prescription_line_id},
                            dataType: "JSON",
                            success:function(response){
                                console.log(response)
                                $('#row_s_id'+row_s_id).remove();
                                counts --;
                                notificationMessage(response)
                            },
                            error:function (error){
                                console.log(error)
                                errorNotification()
                            }
                        });
                    }
                });
            }

        });
        function add_prescription_line(counts = '')
        {
            let html = '';
            counts ++;
            html += '<tr id="row_s_id'+counts+'">';
                html += '<td>';
                    html += '<input type="hidden" id="prescription_line_id'+counts+'" name="prescription_line_id[]" value=""><select id="drug_id'+counts+'" name="drug_id[]" class="form-control"><?php echo getDrugsSelect($dbConnect);?></select>';
                html += '</td>';
                html += '<td>';
                    html += '<input type="text" class="form-control" id="dose'+counts+'" name="dose[]" placeholder="100mg" required>';
                html += '</td>';
                html += '<td>';
                    html += '<div class="form-check" id="collected_check'+counts+'"><input class="form-check-input" id="collected'+counts+'" name="collected[]" type="checkbox" value="1"></div>';
                html += '</td>';
                html += '<td>';
                    html += '<button type="button" id="del" value="'+counts+'" class="btn btn-danger" style="postion:relative">x</button>'
                html += '</td>';
            html += '</tr>';

            $('#prescription_lines').append(html);
        }
        function notificationMessage(response){
            if (response.success===true){
                Swal.fire({
                    icon: 'success',
                    title: 'Good job!',
                    text: response.message
                }).then((response)=>{
                    window.location.reload();
                });
            }
            else{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: response.message
                });
            }

        }
    })
</script>