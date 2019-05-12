$(document).ready(function(){
    $("#searchBtn").click(function(){
        $("#searchModal").modal({show: true});
    });




});

function logout(data){
    location.href ="/";
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




window.onload = function loadAll() {




};