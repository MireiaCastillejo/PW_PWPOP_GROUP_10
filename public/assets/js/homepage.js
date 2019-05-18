$(document).ready(function(){
    $("#searchBtn").click(function(){
        $("#searchModal").modal({show: true});
    });

    $('.carousel').carousel({
        interval: false
    });
    $('.carousel1').carousel({
        interval: false
    });

    $("#loadMore").on('click', function (e) {
        e.preventDefault();
        $(".moreBox:hidden").slice(0, 6).slideDown();
        if ($(".moreBox:hidden").length == 0) {
            $("#loadMore").fadeOut('slow');
        }
    });


    $('#searchButton').click(function () {
        console.log("update modal abierto");

    })


});

/*Le pasamos el ID para poder ir al product review del buyer */
function productreview(data){
    console.log(data);
    location.href ="/product_review_buyer"+data;
}
function logout(data){

location.href ="/logout";
}


var valor = true

function like(id) {
    var uno = document.getElementById(id);
    valor?uno.innerText = "❤":uno.innerText = "❤";
    valor=!valor

    var form = document.createElement('form');
    form.setAttribute('method', 'post');
    form.setAttribute('action', "/"+id);
    form.setAttribute("asyn",true);

    document.body.appendChild(form);
  form.submit();



}

function buy(id) {
    console.log(id);



    var form = document.createElement('form');
    form.setAttribute('method', 'post');
    form.setAttribute('action', "/buy"+id);
    form.setAttribute("asyn",true);

    document.body.appendChild(form);
    form.submit();


}

function send(id){
    //send email
    var formemail = document.createElement('form');
    formemail.setAttribute('method', 'post');
    formemail.setAttribute('action', "/emailToOwner"+id);
    formemail.setAttribute("asyn",true);

    document.body.appendChild(formemail);
    formemail.submit();

    document.body.removeChild(formemail);

    buy(id);
}



window.onload = function loadAll() {




};