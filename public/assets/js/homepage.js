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
});

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

    var form = document.createElement('form');
    form.setAttribute('method', 'post');
    form.setAttribute('action', "/buy"+id);
    form.setAttribute("asyn",true);

    document.body.appendChild(form);
    form.submit();



}




window.onload = function loadAll() {




};