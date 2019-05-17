$(document).ready(function() {

    $("#deleteButton").click(function () {
        $("#productModal").modal('hide');
    });
});

function loadProduct(id) {

    $.ajax({
        async : true,
        type : 'get',
        url: '/product_review'+id,
        dataType: 'json',

        statusCode: {
            200: function (data) {

                console.log(data['res']);
                //console.dir(JSON.parse(data).responseText);
                var image = "/uploads/products/" + data['res']['product_image'];
                document.getElementById("productImage").src = image;
                document.getElementById("title").value = data['res']['title'];
                document.getElementById("comment").value = data['res']['description'];
                document.getElementById("price").value = data['res']['price'];
                document.getElementById("category").value = data['res']['category'];

               /* document.getElementById("newName").placeholder = data['res']['name'];
                document.getElementById("newEmail").placeholder = data['res']['email'];
                document.getElementById("newPhone").placeholder = data['res']['phonenumber'];*/
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

    $("#productModal").modal('show');
    loadProduct(id);
}

