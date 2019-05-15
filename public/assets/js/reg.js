

$(document).ready(function(){



    var validator = $('#form');
    validator.validate({
        // Specify validation rules


        rules: {
            // The key name on the left side is the name attribute
            // of an input field. Validation rules are defined
            // on the right side
            name: {
                required: true,
                alphanumeric: true
            },
            username: {
                required: true,
                alphanumeric: true,
                maxlength: 20,

            },
            email: {
                required: true,
                email: true
            },
            date:{
                date: true,
            },
            phonenumber:{
                required: true,
                pattern: /[0-9]{3}[ ][0-9]{3}[ ][0-9]{3}/,
                minlength : 9,

            },
            password:{
                required: true,
                minlength: 6
            },
            c_password:{
                required: true,
                equalTo: $('input[name=password]'),

            }


        },
        // Specify validation error messages
        messages: {
            name: {
                required: "This field is required*",
                alphanumeric: "Only letters and numbers*",
            },
            username:{
                required: "This field is required*",
                alphanumeric: "Only letters and numbers*",
                maxlength: "Max length 20 characters*"
            },
            email: {
                required: "This field is required*",
                email: "Please enter a valid email*",
            },
            date: {
                date:"Please enter a valid date*",
            },
            phonenumber: {
                required: "This field is required*",
                pattern: "Please follow the format xxx xxx xxx, only numbers*",
                minlength:"Minimum length of 9 characters*"
            },
            password: {
                required: "This field is required*",
                minlength: "Password must be at least 6 characters*",
            },
            c_password: {
                required: "This field is required*",
                equalTo: "Password doesn't match*",
            },
        },
        errorClass:"invalid",
        //Funcion para mostrar el error
        errorPlacement: function(error, element) {

            element.before(error);
        },

        // Make sure the form is submitted to the destination defined
        // in the "action" attribute of the form when valid

    });

   validator.on('submit', function(e) {
        var isvalid = validator.valid();
        if (isvalid) {
            form.submit();
        }else{
            e.preventDefault();
            //alert(getvalues("myform"));
        }
    });

});
