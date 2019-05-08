

$(document).ready(function(){
    console.log("antes");

    var validator = $('#form');
    if(validEmail($(input["login"]))){

        validator.validate({
            // Specify validation rules

            rules: {
                email: {
                    required: true,
                    email: true
                },
                password:{
                    required: true,
                    minlength: 6
                },

            },
            // Specify validation error messages
            messages: {

                email: {
                    required: "This field is required*",
                    email: "Please enter a valid email*",
                },
                password: {
                    required: "This field is required*",
                    minlength: "Password must be at least 6 characters*",
                }
            },
            errorClass:"invalid",
            //Funcion para mostrar el error
            errorPlacement: function(error, element) {

                element.before(error);
            },

            // Make sure the form is submitted to the destination defined
            // in the "action" attribute of the form when valid

        });
    }else{
        validator.validate({
            // Specify validation rules
            login: {
                username: {
                    required: true,
                    alphanumeric: true,
                    maxlength: 20,

                },
                password:{
                    required: true,
                    minlength: 6
                },

            },
            // Specify validation error messages
            messages: {

                login:{
                    required: "This field is required*",
                    alphanumeric: "Only letters and numbers*",
                    maxlength: "Max length 20 characters*"
                },
                password: {
                    required: "This field is required*",
                    minlength: "Password must be at least 6 characters*",
                }
            },
            errorClass:"invalid",
            //Funcion para mostrar el error
            errorPlacement: function(error, element) {

                element.before(error);
            },

            // Make sure the form is submitted to the destination defined
            // in the "action" attribute of the form when valid

        });
    }



    validator.on('submit', function(e) {
        var isvalid = validator.valid();
        if (isvalid) {
            form.submit();
        }else{
            e.preventDefault();
            alert(getvalues("myform"));
        }
    });


});

function validEmail(emailAddress) {
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(emailAddress);
}