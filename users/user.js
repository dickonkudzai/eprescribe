(function($) {
    "use strict";
    $(document).on("click", "#add_user_button", function (){
        $('#userModal').modal("show");
        $("#loader").hide();
        $('#action').val("create_user");
    });

    $(document).on("click", ".delete_user", function (){
        const action = "delete_user";
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
                    url:"./user_actions",
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

    $(document).on("click", ".edit_user", function (){
        var id = $(this).attr("id");
        var action = "get_user_by_id";
        $.ajax({
            url:"./user_actions",
            method: "get",
            data:{action:action, id:id},
            dataType: "JSON",
            success:function(response){
                console.log(response)
                if (response.success===true){
                    $("#loader").hide();
                    $("#userModal").modal("show");
                    $("#first_name").val(response.data.first_name);
                    $("#last_name").val(response.data.last_name)
                    $("#username").val(response.data.username);
                    $("#role_id").val(response.data.role.role_id).prop('readonly', 'readonly');
                    $("#email").val(response.data.email);
                    $("#national_id").val(response.data.national_id);
                    $("#mobile_number").val(response.data.mobile_number);
                    $("#id").val(response.data.id);
                    $("#action").val("update_user")
                }
            },
            error:function (error){
                console.log(error)
                errorNotification()
            }
        })
    })

    $(document).on("submit", "#add_user_form", function (event){
        event.preventDefault();
        const formData = $(this).serialize();
        console.log(formData);
        $("#loader").show();
        $("#submit").hide();
        $.ajax({
            url:"./user_actions",
            method:"post",
            data:formData,
            dataType:"JSON",
            success:function (response){
                console.log(response)
                $("#loader").hide();
                $("#submit").show();
                if (response.success==true){
                    $("#add_user_form")[0].reset()
                    $('#userModal').modal("hide");
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