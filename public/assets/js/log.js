

function onclick2(){
    //console.log("EN LOG JS finaldfghjk");

    var validator = $('#form');



    //if(validEmail($("input[name='login']").val())){

    if(looksLikeEmail($("input[name='login']").val())){

            console.log("es un correo");
            validator.validate({
                // Specify validation rules

                rules: {
                    login: {
                        required: true,
                        email: true,

                    },
                    password:{
                        required: true,
                        minlength: 6
                    },

                },
                // Specify validation error messages
                messages: {

                    login: {
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
            console.log("es un username");
            validator.validate({
                // Specify validation rules
                rules: {
                    login: {
                        required: true,
                        alphanumeric:true,
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
                        alphanumeric: "Only letter and numbers*",
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
            $("input[name='login']").rules("remove");
            //alert(getvalues("myform"));
        }
    });


}

function looksLikeEmail(email){
    var re = /[@]/;
    return re.test(String(email));
}


/*function validEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());

}*/