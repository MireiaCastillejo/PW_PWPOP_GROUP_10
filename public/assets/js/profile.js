$(document).ready(function(){

    console.log("loaded page");

    $("#deleteButton").click(function(){
        //$("#deleteModal").modal({show: true});
        console.log("modal abierto");
    });

    $("#updateButton").click(function() {
        //$("#updateModal").modal({show: true});
        console.log("modal abierto");
    });
});

        /*var validator = $('#form');
        validator.validate({
            // Specify validation rules
            rules: {
                // The key name on the left side is the name attribute
                // of an input field. Validation rules are defined
                // on the right side
                name: {
                    alphanumeric: true
                },
                username: {
                    alphanumeric: true,
                    maxlength: 20,

                },
                email: {
                    email: true
                },
                date:{
                    date: true,
                },
                phonenumber:{
                    pattern: /[0-9]{3}[ ][0-9]{3}[ ][0-9]{3}/,
                    minlength : 9,

                },
                password:{
                    minlength: 6
                },
                c_password:{
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
    })
})*/

    /*
user = 'user1';
function loadData() {

    console.log(user);

    var get = $.ajax({
        async : true,
        type : 'get',
        url: '/profile/update',
        dataType: 'json',

        statusCode: {
            200: function () {

                console.log("Data found");
                console.log(get.responseJSON.res.username);

                $("#userName").text(get.responseJSON.res.username);

            },
            404: function () {
                alert("Data not found");
            }
        }
    });
}

window.onload = function () {
    loadData();
}*/