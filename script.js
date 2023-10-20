(function($) {
    "use strict";
    $(document).on("submit","#login_form", function (event){
        event.preventDefault();
        var formData = $(this).serialize();
        console.log(formData);
        $.ajax({
            url:"./authentication/authentication",
            method:"post",
            data:formData,
            dataType:"JSON",
            success:function (response){
                console.log(response)
                if (response.success==true){
                    $('#alert_success').css('display', 'inline').html(response.message);
                    window.location = "home/index"
                }
                else{
                    $('#alert_failed').css('display', 'inline').html(response.message);
                    window.setTimeout(function (){
                        $('#alert_failed').css('display', 'none');
                    }, 2000);
                }
            },
            error:function(error){
                console.log(error);
            }
        })
    })
})(jQuery); // End of use strict