$(document).ready(function () {
    $("#login-form").validate({
        rules: {
            username: {
                required: true,
                maxlength: 100
            },
            password: {
                required: true,
                maxlength: 255
            }
        },
        messages: {
            username: {
                required: "Please enter your login name!",
                maxlength: "Username cannot exceed 100 characters."
            },
            password: {
                required: "Please enter your password!",
                maxlength: "Password cannot exceed 255 characters."
            }
        },
        errorElement: 'div',
        errorPlacement: function(error, element) {
            error.addClass('error-message');
            error.insertAfter(element);
        }
    });


});
