<?php
$pharmacyId = $_GET['id'];
?>
<main>
    <div class="container-fluid px-4">
        <div class="card mb-4">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <i class="fas fa-table me-1"></i>
                        Dispensary
                    </div>
                    <div class="col-6" align="right">
                        <button type="button" class="btn btn-sm btn-primary" id="add_dispense_button">Dispense</button>
                    </div>
                </div>

            </div>
            <div class="card-body">
                <table id="dispensary">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Prescription ID</th>
                        <th>Patient</th>
                        <th>Date</th>
                        <th>Added By</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Prescription ID</th>
                        <th>Patient</th>
                        <th>Date</th>
                        <th>Added By</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php
                    if (isset($dbConnect)) {
                        echo getPharmacyStock($dbConnect, $pharmacyId);
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<script src="dispense.js"></script>
<div class="modal fade" id="dispenseModal" tabindex="-1" role="dialog" aria-labelledby="dispenseModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dispenseModal">Dispense</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <br>
            <form id="dispense_form">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="prescription_id">Prescription ID</label>
                            <input type="text" class="form-control" id="prescription_id" name="prescription_id" placeholder="Prescription" required>
                        </div>
                        <div class="form-group col-md-6">
                            <button type="button" name="search_prescription" id="search_prescription" class="btn btn-primary">
                                Search Prescription
                            </button>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Drug</th>
                                    <th>Dose</th>
                                    <th>Quantity</th>
                                    <th>Notes</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody id="dispensed_lines">

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Drug</th>
                                    <th>Dose</th>
                                    <th>Quantity</th>
                                    <th>Notes</th>
                                    <th></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" id="submit" name="submit" value="Save">
                    <button class="btn btn-primary hidden" id="dispense_loader" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                    <input type="hidden" name="dispense_pharmacy_id" id="dispense_pharmacy_id" value="<?php echo $pharmacyId ?>">
                    <input type="hidden" name="dispense_action" id="dispense_action" value="">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $(document).on("click", "#search_prescription", function (){
            var id = $("#prescription_id").val();
            var action = "get_prescription_by_id";
            $.ajax({
                url:"./dispense_actions",
                method: "get",
                data:{action:action, id:id},
                dataType: "JSON",
                success:function(response){
                    console.log(response)
                    if (response.success===true){
                        var drugs = ['<option value="">Select Drug</option>'];
                        for (var j = response.drugs.length - 1; j >= 0; j--) {
                            drugs.push(response.drugs[j].drug);
                        }
                        for (var i = response.data.prescription_lines.length - 1; i >= 0; i--) {
                            var collectedChecked = response.data.prescription_lines[i].collected == 1 ? 'checked' : '';
                            $('#dispensed_lines').append(
                                '<tr id="row_s_id'+i+'">'+
                                '<td>' +
                                '<input type="hidden" name="prescription_line_id[]" id="prescription_line_id'+i+'" value="'+response.data.prescription_lines[i].id+'">' +
                                '<select id="drug_id'+i+'" value="'+response.data.prescription_lines[i].drug_id+'" name="drug_id[]" class="form-control" readonly="">'+
                                drugs +
                                '</select>'+
                                '</td>'+
                                '<td><input type="text" class="form-control" id="dose'+i+'" name="dose[]" step="any" value="'+response.data.prescription_lines[i].dose+'" readonly></td>'+
                                '<td><input type="number" class="form-control" id="quantity'+i+'" name="quantity[]" step="any" max=""></td>'+
                                '<td><input class="form-control" id="notes'+i+'" name="notes[]" type="text" ></td>'+
                                '<td><button type="button" id="del" value="'+i+'" class="btn btn-danger" style="postion:relative">x</button></td>'+
                                '</tr>'
                            );
                            $('#drug_id'+i).val(response.data.prescription_lines[i].drug_id);
                        }
                    }
                },
                error:function (error){
                    console.log(error)
                    errorNotification()
                }
            });
        });
    })
</script>
