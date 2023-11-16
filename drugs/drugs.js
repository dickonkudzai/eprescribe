(function($) {
    "use strict";
    $(document).on("click", "#add_drug_button", function (){
        $('#drugModal').modal("show");
        $("#loader").hide();
        $('#action').val("create_drug");
    });

    $(document).on("click", ".delete_drug", function (){
        const action = "delete_drug";
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
                    url:"./drugs_actions",
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

    $(document).on("click", ".edit_drug", function (){
        var id = $(this).attr("id");
        var action = "get_drug_by_id";
        $.ajax({
            url:"./drugs_actions",
            method: "get",
            data:{action:action, id:id},
            dataType: "JSON",
            success:function(response){
                console.log(response)
                if (response.success===true){
                    $("#loader").hide();
                    $("#drugModal").modal("show");
                    $("#drug_name").val(response.data.drug_name);
                    if (response.data.blocked==1)
                        $("#blocked").prop("checked", true)
                    $("#blocked").val(response.data.blocked)
                    if (response.data.controlled==1)
                        $("#controlled").prop("checked", true)
                    $("#controlled").val(response.data.controlled);
                    $("#id").val(response.data.id);
                    $("#action").val("update_drug")
                }
            },
            error:function (error){
                console.log(error)
                errorNotification()
            }
        });
    });

    $(document).on("submit", "#drug_form", function (event){
        event.preventDefault();
        const formData = $(this).serialize();
        console.log(formData);
        $("#loader").show();
        $("#submit").hide();
        $.ajax({
            url:"./drugs_actions",
            method:"post",
            data:formData,
            dataType:"JSON",
            success:function (response){
                console.log(response)
                $("#loader").hide();
                $("#submit").show();
                if (response.success==true){
                    $("#drug_form")[0].reset()
                    $('#drugModal').modal("hide");
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

    $(document).on("click", "#controlled", function (){
        if ($(this).prop('checked')) {
            $(this).val(1)
        }
        else {
            $(this).val(0)
        }
    })
    $(document).on("click", "#blocked", function (){
        if ($(this).prop('checked')) {
            $(this).val(1)
        }
        else {
            $(this).val(0)
        }
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