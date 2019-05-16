var userData = [];
$(document).ready(function(){

    $("#deleteButton").click(function(){
        //$("#deleteModal").modal({show: true});
        console.log("modal abierto");
    });

    $("#deleteButtonConfirm").click(function() {
        console.log("confirmar borrar");
        deleteAccount();
    });

    $("#updateButton").click(function() {
        //$("#updateModal").modal({show: true});
        console.log("update modal abierto");
        console.log(window.userData['res']['username']);

        var validator = $('#updateForm');
        validator.validate({
            // Specify validation rules

            rules: {
                // The key name on the left side is the name attribute
                // of an input field. Validation rules are defined
                // on the right side
                name: {
                    alphanumeric: true
                },
                email: {
                    email: true
                },
                birthdate:{
                    date: true,
                },
                phonenumber:{
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
                    alphanumeric: "Only letters and numbers*",
                },
                email: {
                    email: "Please enter a valid email*",
                },
                date: {
                    date:"Please enter a valid date*",
                },
                phonenumber: {
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
        });

        validator.on('submit', function(e) {
            var isvalid = validator.valid();

            if (isvalid) {

            form.submit();
        }else{
            e.preventDefault();
        }
    });


   // loadData();
});

function loadData() {

    $.ajax({
        async : true,
        type : 'get',
        url: '/fetch',
        dataType: 'json',

        statusCode: {
            200: function (data) {

                console.log("loadData from user");
                window.userData = data;
                console.log(window.userData);
                date = data['res']['birthdate'];
                d = date.split(" ");
                birthdate = d[0];

                var image = "/uploads/" + data['res']['profileimage'];
                document.getElementById("profileImage").src = image;
                document.getElementById("userName").innerHTML = data['res']['name'];
                document.getElementById("username").innerHTML = data['res']['username'];
                document.getElementById("userEmail").innerHTML = data['res']['email'];
                document.getElementById("userBirth").innerHTML = birthdate;
                document.getElementById("userPhone").innerHTML = data['res']['phonenumber'];

                document.getElementById("newName").placeholder = data['res']['name'];
                document.getElementById("newEmail").placeholder = data['res']['email'];
                document.getElementById("newPhone").placeholder = data['res']['phonenumber'];
            },

            404: function () {
                alert("Data not found");
            },

            500: function () {
                console.log("OOF")
            }
        }
    });
}


function deleteAccount() {

    console.log("user delete = " + user);

    $.ajax({

        async : true,
        type : 'get',
        url: '/update',
        data: {'username' : user},

        statusCode: {
            200: function (data) {
                console.log(data);
                window.location.href = '/';
            },

            404: function () {
                alert("Data not found");
            },

            500: function () {
                console.log("OOF")
            }
        }
    });
}

window.onload = function(){

    loadData();
}