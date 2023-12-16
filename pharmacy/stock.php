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
                        Stocks
                    </div>
                    <div class="col-6" align="right">
                        <button type="button" class="btn btn-sm btn-primary" id="add_stock_button">Add Stock</button>
                    </div>
                </div>

            </div>
            <div class="card-body">
                <table id="stocks">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Drug</th>
                        <th>Expiry</th>
                        <th>Quantity</th>
                        <th>Added By</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Drug</th>
                        <th>Expiry</th>
                        <th>Quantity</th>
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
<script src="stock.js"></script>

<div class="modal fade" id="addStockModal" tabindex="-1" role="dialog" aria-labelledby="addStockModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStockModal">Stock</h5>
                <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <br>
            <form id="stock_form">
                <div class="modal-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Drug</th>
                                    <th>Expiry Date</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody id="stock_lines">

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Drug</th>
                                    <th>Expiry Date</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                                </tfoot>
                            </table>
                            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                                <h1 class="h3 mb-0 text-gray-800"></h1>
                                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" align="right" id="add_stock_line_button"><i class="fas fa-calendar-plus fa-sm text-white-50"></i> Add</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" id="stock_submit" name="stock_submit" value="Save">
                    <button class="btn btn-primary hidden" id="stock_loader" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                    <input type="hidden" name="stock_pharmacy_id" id="stock_pharmacy_id" value="<?php echo $pharmacyId ?>">
                    <input type="hidden" name="stock_action" id="stock_action" value="">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        let counts = 0;
        let rowCount = 0;

        $(document).on('click', '#add_stock_line_button', function(){
            rowCount = $('#stock_lines tr').length;
            if (rowCount<1) {
                counts = counts + 1;
            }
            else{
                counts = rowCount + 1;
            }
            add_stock_line(counts);
        });
        $(document).on('click', '#del', function()
        {
            const row_s_id = $(this).attr("value");
            if ($("#stock_line_id"+row_s_id).val()!=="") {
                const action = "delete_stock_line_by_id";
                const id = $(this).attr("id");
                const stock_line_id = $("#stock_line_id"+row_s_id).val();
                console.log(stock_line_id);
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
                            url:"./stock_actions",
                            method: "get",
                            data:{action:action, id:stock_line_id},
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
        function add_stock_line(counts = '')
        {
            let html = '';
            counts ++;
            html += '<tr id="row_s_id'+counts+'">';
            html += '<td>';
            html += '<input type="hidden" id="stock_line_id'+counts+'" name="stock_line_id[]" value=""><select id="drug_id'+counts+'" name="drug_id[]" class="form-control"><?php echo getDrugsSelect($dbConnect);?></select>';
            html += '</td>';
            html += '<td>';
            html += '<input type="date" class="form-control" id="expiry_date'+counts+'" name="expiry_date[]" required>';
            html += '</td>';
            html += '<td>';
            html += '<input type="number" step="any" class="form-control" id="quantity'+counts+'" name="quantity[]" required>';
            html += '</td>';
            html += '<td>';
            html += '<button type="button" id="del" value="'+counts+'" class="btn btn-danger" style="postion:relative">x</button>'
            html += '</td>';
            html += '</tr>';

            $('#stock_lines').append(html);
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