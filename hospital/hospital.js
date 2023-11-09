(function($) {
    "use strict";
    $(document).on("click", "#add_hospital_button", function (){
        $('#hospitalModal').modal("show");
        $("#loader").hide();
        $('#action').val("create_hospital");
    });

    $(document).on("submit", "#doctors_map_form", function (event){
        event.preventDefault();
        const formData = $(this).serialize();
        console.log(formData);
        $("#maploader").show();
        $("#map_submit").hide();
        $.ajax({
            url:"./hospital_actions",
            method:"post",
            data:formData,
            dataType:"JSON",
            success:function (response){
                console.log(response)
                $("#maploader").hide();
                $("#map_submit").show();
                if (response.success==true){
                    $("#hospital_form")[0].reset()
                    $('#hospitalModal').modal("hide");
                }
                notificationMessage(response)
            },
            error:function(error){
                $("#maploader").hide();
                $("#map_submit").show();
                console.log(error);
                errorNotification()
            }
        });
    });

    $(document).on("click", ".link_doctor_to_hospital", function (){
        const action = "get_mapped_doctors";
        const hospital_id = $(this).attr("id");
        $.ajax({
            url:"./hospital_actions",
            method:"get",
            data:{action:action, hospital_id:hospital_id},
            dataType:"JSON",
            success:function (response){
                if (response.success===true){
                    $("#mapDoctorToHospitalModal").modal("show");
                    $("#maploader").hide();
                    console.log(response.data)
                    var doctor_id = [];
                    for (var i = response.data.length - 1; i >= 0; i--) {
                        doctor_id.push(response.data[i]['doctor_id'])
                    }
                    $("#map_action").val("map_doctors_to_hospital");
                    $("#map_hospital_id").val(hospital_id);
                    $('#doctors').selectpicker('val', doctor_id);
                    $('#doctors').selectpicker('render');
                }
                else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Failed to retrieve mappings!'
                    });
                }
            },
            error: function (error){
                console.log(error)
                errorNotification()
            }
        });
    });

    $(document).on("click", ".delete_hospital", function (){
        const action = "delete_hospital";
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
                    url:"./hospital_actions",
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

    $(document).on("click", ".edit_hospital", function (){
        var id = $(this).attr("id");
        var action = "get_hospital_by_id";
        $.ajax({
            url:"./hospital_actions",
            method: "get",
            data:{action:action, id:id},
            dataType: "JSON",
            success:function(response){
                console.log(response)
                if (response.success===true){
                    $("#loader").hide();
                    $("#hospitalModal").modal("show");
                    $("#hospital_name").val(response.data.hospital_name);
                    $("#address").val(response.data.address)
                    $("#mobile_number").val(response.data.mobile_number);
                    $("#email").val(response.data.email);
                    $("#mobile_number").val(response.data.mobile_number);
                    $("#id").val(response.data.id);
                    $("#action").val("update_hospital")
                }
            },
            error:function (error){
                console.log(error)
                errorNotification()
            }
        });
    });

    $(document).on("submit", "#hospital_form", function (event){
        event.preventDefault();
        const formData = $(this).serialize();
        console.log(formData);
        $("#loader").show();
        $("#submit").hide();
        $.ajax({
            url:"./hospital_actions",
            method:"post",
            data:formData,
            dataType:"JSON",
            success:function (response){
                console.log(response)
                $("#loader").hide();
                $("#submit").show();
                if (response.success==true){
                    $("#hospital_form")[0].reset()
                    $('#hospitalModal').modal("hide");
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