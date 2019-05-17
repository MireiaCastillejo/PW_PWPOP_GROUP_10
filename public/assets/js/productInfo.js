$(document).ready(function() {

    $("#deleteButton").click(function () {
        $("#productModal").modal('hide');
    });
});

$( "#product" ).click(function() {
    console.log( "Handler for .click() called." );
});

function loadProduct(id) {

    $.ajax({
        async : true,
        type : 'get',
        url: '/product_review'+id,
        dataType: 'json',

        statusCode: {
            200: function (data) {

                //console.dir(JSON.parse(data).responseText);
                var image = "/uploads/products/" + data['res']['product_image'];
                document.getElementById("productImage").src = image;
                document.getElementById("title").innerHTML = data['res']['title'];
                document.getElementById("comment").innerHTML = data['res']['description'];
                document.getElementById("price").innerHTML = data['res']['price'] + "€";
                document.getElementById("category").innerHTML = data['res']['category'];
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

function showInfo(id){

    $("p").click(function() {
        var htmlString = $( this ).html();
        console.log(htmlString);
    });

    $("#productModal").modal('show');
    loadProduct(id);
}

