(function($) {
    "use strict";
    $(document).on("click", "#add_patient_button", function (){
        $('#patientModal').modal("show");
        $("#loader").hide();
        $('#action').val("create_patient");
    });

    $(document).on("click", ".delete_patient", function (){
        const action = "delete_patient";
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
                    url:"./patient_actions",
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
                })

            }
        })
    })

    $(document).on("click", ".edit_patient", function (){
        var id = $(this).attr("id");
        var action = "get_patient_by_id";
        $.ajax({
            url:"./patient_actions",
            method: "get",
            data:{action:action, id:id},
            dataType: "JSON",
            success:function(response){
                console.log(response)
                if (response.success===true){
                    $("#loader").hide();
                    $("#patientModal").modal("show");
                    $("#first_name").val(response.data.first_name);
                    $("#last_name").val(response.data.last_name);
                    $("#address").val(response.data.address);
                    $("#email").val(response.data.email);
                    $("#national_id").val(response.data.national_id);
                    $("#mobile_number").val(response.data.mobile_number);
                    $("#id").val(response.data.id);
                    $("#action").val("update_patient")
                }
            },
            error:function (error){
                console.log(error)
                errorNotification()
            }
        })
    })

    $(document).on("submit", "#patient_form", function (event){
        event.preventDefault();
        const formData = $(this).serialize();
        console.log(formData);
        $("#loader").show();
        $("#submit").hide();
        $.ajax({
            url:"./patient_actions",
            method:"post",
            data:formData,
            dataType:"JSON",
            success:function (response){
                console.log(response)
                $("#loader").hide();
                $("#submit").show();
                if (response.success==true){
                    $("#patient_form")[0].reset()
                    $('#patientModal').modal("hide");
                }
                notificationMessage(response)
            },
            error:function(error){
                $("#loader").hide();
                $("#submit").show();
                console.log(error);
                errorNotification()
            }
        })
    })

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