(function($) {
    "use strict";
    $(document).on("click", "#add_prescription_button", function (){
        $('#prescriptionModal').modal("show");
        $("#prescription_loader").hide();
        $('#prescription_action').val("create_prescription");
    });

    $(document).on("click", ".delete_prescription", function (){
        const action = "delete_prescription";
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
                    url:"./prescriptions_actions",
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

    $(document).on("click", ".edit_prescription", function (){
        var id = $(this).attr("id");
        var action = "get_prescription_by_id";
        $.ajax({
            url:"./prescriptions_actions",
            method: "get",
            data:{action:action, id:id},
            dataType: "JSON",
            success:function(response){
                console.log(response)
                if (response.success===true){
                    $("#prescription_loader").hide();
                    $("#prescriptionModal").modal("show");
                    $("#prescription_patient_id").val(response.data.patient_id);
                    $("#prescription_id").val(response.data.id);
                    $("#prescription_action").val("update_prescription");
                    var drugs = ['<option value="">Select Drug</option>'];
                    for (var j = response.drugs.length - 1; j >= 0; j--) {
                        drugs.push(response.drugs[j].drug);
                    }
                    for (var i = response.data.prescription_lines.length - 1; i >= 0; i--) {
                        var collectedChecked = response.data.prescription_lines[i].collected == 1 ? 'checked' : '';
                    	$('#prescription_lines').append(
                    		'<tr id="row_s_id'+i+'">'+
                    			'<td>' +
                                    '<input type="hidden" name="prescription_line_id[]" id="prescription_line_id'+i+'" value="'+response.data.prescription_lines[i].id+'">' +
                    				'<select id="drug_id'+i+'" value="'+response.data.prescription_lines[i].drug_id+'" name="drug_id[]" class="form-control">'+
                                        drugs +
                    				'</select>'+
                    			'</td>'+
                    			'<td><input type="text" class="form-control" id="dose'+i+'" name="dose[]" step="any" value="'+response.data.prescription_lines[i].dose+'"></td>'+
                    			'<td><div class="form-check" id="collected_check'+i+'"><input class="form-check-input" id="collected'+i+'" name="collected[]" type="checkbox" value="1" '+collectedChecked+'></div></td>'+
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

    $(document).on("submit", "#prescription_form", function (event){
        event.preventDefault();
        const formData = $(this).serialize();
        console.log(formData);
        $("#loader").show();
        $("#submit").hide();
        $.ajax({
            url:"./prescriptions_actions",
            method:"post",
            data:formData,
            dataType:"JSON",
            success:function (response){
                console.log(response)
                $("#prescription_loader").hide();
                $("#prescription_submit").show();
                if (response.success===true){
                    $("#prescription_form")[0].reset()
                    $('#prescriptionModal').modal("hide");
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