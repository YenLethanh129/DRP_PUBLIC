$(document).ready(function () {
    $("#sign-up-form").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            username: {
                required: true,
                maxlength: 100
            },
            password: {
                required: true,
                minlength: 7,
                maxlength: 255,
                containUppercaseAndNumber: true
            },
            repassword: {
                required: true,
                equalTo: "#password"
            }
        },
        messages: {
            email: {
                required: "Please enter your email!",
                email: "Please enter a valid email address!"
            },
            username: {
                required: "Please enter your login name!",
                maxlength: "Username cannot exceed 100 characters."
            },
            password: {
                required: "Please enter your password!",
                minlength: "Password must be at least 6 characters long.",
                maxlength: "Password cannot exceed 255 characters.",
                containUppercaseAndNumber: "Password must contain at least one uppercase letter and one number."
            },
            repassword: {
                required: "Please enter your re-password!",
                equalTo: "Passwords do not match!"
            }
        },
        errorElement: 'div',
        errorPlacement: function(error, element) {
            error.addClass('error-message');
            error.insertAfter(element);
        }
    });


    $.validator.addMethod("containUppercaseAndNumber", function(value, element) {
        return this.optional(element) || /^(?=.*[A-Z])(?=.*\d).*$/.test(value);
    }, "Password must contain at least one uppercase letter and one number.");
});
