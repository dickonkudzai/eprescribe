(function($) {
    "use strict";
    $(document).on("click", "#add_consultation_button", function (){
        $('#consultationModal').modal("show");
        $("#loader").hide();
        $('#action').val("create_consultation");
    });

    $(document).on("click", ".delete_consultation", function (){
        const action = "delete_consultation";
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
                    url:"./consultations_actions",
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

    $(document).on("click", ".edit_consultation", function (){
        var id = $(this).attr("id");
        var action = "get_consultation_by_id";
        $.ajax({
            url:"./consultations_actions",
            method: "get",
            data:{action:action, id:id},
            dataType: "JSON",
            success:function(response){
                console.log(response)
                if (response.success===true){
                    $("#loader").hide();
                    $("#consultationModal").modal("show");
                    $("#weight").val(response.data.weight);
                    $("#bp").val(response.data.bp)
                    $("#temperature").val(response.data.temperature);
                    $("#condition_description").val(response.data.condition_description);
                    $("#condition_diagnosis").val(response.data.condition_diagnosis);
                    $("#id").val(response.data.id);
                    $("#action").val("update_consultation")
                }
            },
            error:function (error){
                console.log(error)
                errorNotification()
            }
        });
    });

    $(document).on("submit", "#consultation_form", function (event){
        event.preventDefault();
        const formData = $(this).serialize();
        console.log(formData);
        $("#loader").show();
        $("#submit").hide();
        $.ajax({
            url:"./consultations_actions",
            method:"post",
            data:formData,
            dataType:"JSON",
            success:function (response){
                console.log(response)
                $("#loader").hide();
                $("#submit").show();
                if (response.success==true){
                    $("#consultation_form")[0].reset()
                    $('#consultationModal').modal("hide");
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