(function($) {
    "use strict";
    $(document).on("click", "#add_dispense_button", function (){
        $('#dispenseModal').modal("show");
        $("#dispense_loader").hide();
        $('#dispense_action').val("create_stock");
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