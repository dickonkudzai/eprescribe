(function($) {
    "use strict";
    $(document).on("click", "#add_stock_button", function (){
        $('#addStockModal').modal("show");
        $("#stock_loader").hide();
        $('#stock_action').val("create_stock");
    });

    $(document).on("click", ".delete_stock", function (){
        const action = "delete_stock";
        const id = $(this).attr("id");
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
                    data:{action:action, id:id},
                    dataType: "JSON",
                    success:function(response){
                        console.log(response)
                        notificationMessage(response)
                    },
                    error:function (error){
                        console.log(error)
                        errorNotification()
                    }
                });
            }
        });
    });

    $(document).on("click", ".edit_stock", function (){
        var id = $(this).attr("id");
        var action = "get_stock_by_id";
        $.ajax({
            url:"./stock_actions",
            method: "get",
            data:{action:action, id:id},
            dataType: "JSON",
            success:function(response){
                console.log(response)
                if (response.success===true){
                    $("#stock_loader").hide();
                    $("#stockModal").modal("show");
                    $("#stock_pharmacy_id").val(response.data.pharmacy_id);
                    $("#stock_id").val(response.data.id);
                    $("#stock_action").val("update_prescription");
                    var drugs = ['<option value="">Select Drug</option>'];
                    for (var j = response.drugs.length - 1; j >= 0; j--) {
                        drugs.push(response.drugs[j].drug);
                    }
                    for (var i = response.data.stock_lines.length - 1; i >= 0; i--) {
                        $('#stock_lines').append(
                            '<tr id="row_s_id'+i+'">'+
                            '<td>' +
                            '<input type="hidden" name="stock_line_id[]" id="stock_line_id'+i+'" value="'+response.data.stock_lines[i].id+'">' +
                            '<select id="drug_id'+i+'" value="'+response.data.stock_lines[i].drug_id+'" name="drug_id[]" class="form-control">'+
                            drugs +
                            '</select>'+
                            '</td>'+
                            '<td><input type="date" class="form-control" id="expiry_date'+i+'" name="expiry_date[]" step="any" value="'+response.data.stock_lines[i].expiry_date+'"></td>'+
                            '<td><input type="number" step="any" class="form-control" id="quantity'+i+'" name="quantity[]" step="any" value="'+response.data.stock_lines[i].quantity+'"></td>'+
                            '<td><button type="button" id="del" value="'+i+'" class="btn btn-danger" style="postion:relative">x</button></td>'+
                            '</tr>'
                        );
                        $('#drug_id'+i).val(response.data.stock_lines[i].drug_id);
                    }
                }
            },
            error:function (error){
                console.log(error)
                errorNotification()
            }
        });
    });

    $(document).on("submit", "#stock_form", function (event){
        event.preventDefault();
        const formData = $(this).serialize();
        console.log(formData);
        $("#loader").show();
        $("#submit").hide();
        $.ajax({
            url:"./stock_actions",
            method:"post",
            data:formData,
            dataType:"JSON",
            success:function (response){
                console.log(response)
                $("#stock_loader").hide();
                $("#stock_submit").show();
                if (response.success===true){
                    $("#stock_form")[0].reset()
                    $('#stockModal').modal("hide");
                }
                notificationMessage(response)
            },
            error:function(error){
                $("#loader").hide();
                $("#submit").show();
                console.log(error);
                errorNotification()
            }
        });
    });

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

    function errorNotification(){
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!'
        });
    }

})(jQuery); // End of use strict