(function($) {
    "use strict";
    $(document).on("click", "#add_pharmacy_button", function (){
        $('#pharmacyModal').modal("show");
        $("#loader").hide();
        $('#action').val("create_pharmacy");
    });

    $(document).on("click", ".delete_pharmacy", function (){
        const action = "delete_pharmacy";
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
                    url:"./pharmacy_actions",
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

    $(document).on("click", ".edit_pharmacy", function (){
        var id = $(this).attr("id");
        var action = "get_pharmacy_by_id";
        $.ajax({
            url:"./pharmacy_actions",
            method: "get",
            data:{action:action, id:id},
            dataType: "JSON",
            success:function(response){
                console.log(response)
                if (response.success===true){
                    $("#loader").hide();
                    $("#pharmacyModal").modal("show");
                    $("#pharmacy_address").val(response.data.pharmacy_address);
                    $("#pharmacy_name").val(response.data.pharmacy_name);
                    $("#id").val(response.data.id);
                    $("#action").val("update_pharmacy")
                }
            },
            error:function (error){
                console.log(error)
                errorNotification()
            }
        })
    })

    $(document).on("submit", "#pharmacy_form", function (event){
        event.preventDefault();
        const formData = $(this).serialize();
        console.log(formData);
        $("#loader").show();
        $("#submit").hide();
        $.ajax({
            url:"./pharmacy_actions",
            method:"post",
            data:formData,
            dataType:"JSON",
            success:function (response){
                console.log(response)
                $("#loader").hide();
                $("#submit").show();
                if (response.success==true){
                    $("#pharmacy_form")[0].reset()
                    $('#pharmcyModal').modal("hide");
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