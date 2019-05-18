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

function updateProduct(id) {

    var title = document.getElementById("title").value;
    var description = document.getElementById("comment").value;
    var price = document.getElementById("price").value;
    var category = document.getElementById("category").value;

    var data = new Object();
    data.title = title;
    data.description = description;
    data.price = price;
    data.category = category;
    data.id = id;

    var obj= JSON.stringify(data);

    //console.log(data);
    console.log(obj);
    //console.log(id);

    var form = document.createElement('form');
    form.setAttribute('method', 'post');
    //form.setAttribute('target', '_blank');
    form.setAttribute('enctype',"multipart/form-data");
    form.setAttribute('action', '/product_update'+obj);
    form.setAttribute('asyn',true);
    //form.setAttribute('data', JSON.stringify(data));

    document.body.appendChild(form);
    form.submit();

    document.body.removeChild(form);
    //location.reload();

    /*$.ajax({
        async : true,
        type : "POST",
        url: '/product_update'+id,
        contentType: 'application/json',
        data: {data: obj},

        statusCode: {
            200: function () {

                console.log("all gucci gaaanggangangangang")
            },

            404: function () {
                alert("Data not found");
            },

            500: function () {
                console.log("OOF")
            }
        }
    });*/

}



function showInfo(id){

    $("#productModal").modal('show');
    loadProduct(id);

    $("#updateProductBtn").click(function () {
        updateProduct(id);
    });
}

