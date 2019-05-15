

$(document).ready(function(){
    $("select.product").change(function() {
       $(this).children("option:selected").val();

    });

    $('input[type="file"]'). change(function(e){


    });

    var validator = $("#form");

    validator.validate({

        rules: {

            title: {
                required: true
            },
            description: {
                required: true,
                minlength: 20

            },
            price: {
                required: true,
                number: true

            },
          /*  product_image:{
                required: true,
                extension: "jpg|png"

            },*/
            category:{
                required: true,
            }


        },
        // Specify validation error messages
        messages: {
            title: {
                required: "This field is required"

            },
            description:{
                required: "This field is required",
                minlength: "Min length 20 characters"
            },
            price: {
                required: "This field is required",
                rangeMax: "Please enter a valid range"
            },
           /* product_image:{
                required: "Please enter an image",
                extension:"Please enter an JPG o PNG image"

            },*/
            category:{
                required: "Please select a product"

            }

        },

        //Funcion para mostrar el error
        errorPlacement: function(error, element) {
            element.after(error);
        },

        // Make sure the form is submitted to the destination defined
        // in the "action" attribute of the form when valid
        submitHandler: function(form) {
            form.submit();
        }
    });

});
