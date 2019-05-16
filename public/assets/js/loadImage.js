function loadData() {

    $.ajax({
        async : true,
        type : 'get',
        url: '/fetch',
        dataType: 'json',

        statusCode: {
            200: function (data) {

                date = data['res']['birthdate'];
                d = date.split(" ");
                birthdate = d[0];

                var image = "/uploads/" + data['res']['profileimage'];
                document.getElementById("profileImageLink").src = image;
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

$(document).ready(function () {
    loadData();
});