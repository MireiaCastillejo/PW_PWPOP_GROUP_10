
window.load=function () {
    loadData();
    console.log("HOLAAA");
};

function loadData() {


    $.ajax({

        async : true,
        type : 'get',
        url: '/prueba',
        dataType: 'json',

        statusCode: {
            200: function (data) {

console.log(data);
               // var image = "/uploads/" + data['res']['productfoto'];
                document.getElementById("title").innerHTML = data['res']['title'];
                document.getElementById("description").innerHTML = data['res']['despcription'];
                document.getElementById("price").innerHTML = data['res']['price'];
                document.getElementById("category").innerHTML = data['res']['category'];


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
