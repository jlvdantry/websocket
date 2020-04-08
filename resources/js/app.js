/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// Test
require('./bootstrap');

var dt = require( 'datatables.net' );
require('datatables.net-buttons');

// Global
var token = document.head.querySelector('meta[name="csrf-token"]');
var timercito;

// Funciones

/**
 * crearMensaje (tomado de Mi Unidad) xD
 */
window.crearMensaje = function (error,titulo,mensaje,tiempo=3500){
  var clase_mensaje = error==true?"alert-danger":"alert-success";
  var mensaje_alert = '<div class="alertaActivacion alert msj_js '+clase_mensaje+'">';
  mensaje_alert += '<strong id="mensaje_negritas" style="font-size:16px;">'+titulo+'</strong>';
  mensaje_alert += '<p id="mensaje" style="font-size:14px;">'+mensaje+'</p>';
  mensaje_alert += '</div>';
  $("body").append(mensaje_alert);
  $(".msj_js").show();
  setTimeout(function(){
    $(".msj_js").remove();
  }, tiempo);
}

/***
 * Estar validando la sesion
 */
function laSesion(){
  $.ajax({
    url: ubase+'/service/session/getSession',
    dataType: 'json',
    type: 'GET',
    success: function(data) {
        //
    },
    error: function(jqXHR, textStatus, errorThrown) {
      if(jqXHR.status === 401){
        crearMensaje(true,"Error","Tu sesión ha caducado");
      }
      if(jqXHR.status === 418){
        crearMensaje(true,"Error",data.mensaje||data.message);
      }
      $('#modal-logo').modal({
        backdrop: 'static',
        keyboard: false
      });
      clearInterval(timercito);
    }
  });
}

/**
 * Tokencin
 */
$.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

/* Aviso en la consola */
function antiXSS(){
  console.log("%c¡Detente!", "color: red; font-size:30px;");
  console.log("%cEsta función del navegador es solo para desarrolladores.", "color: red; font-size:15px;");
  console.log("%cSi alguien te indicó que copiaras y pegaras algo aquí para obtener acceso no autorizado a esta aplicación, se trata de un engaño. Si lo haces, esta persona podrá acceder a los datos de tu cuenta. Consulta https://es.wikipedia.org/wiki/Self-XSS para obtener más información.", "color: red; font-size:20px;");
}

$(document).ready(function(){
  timercito = setInterval(laSesion, 5*60*1000); // minutostimer * 60 * 1000
  //setInterval(antiXSS, 60000); // minutostimer * 60 * 1000
  antiXSS();
  $('.tooltiptable').tooltip({html:true, trigger:'manual'});

  $('.tooltiptable').on('click', function(e){
     var revisar = $(this);
    $.each($('.tooltiptable'), function( index, value ) {
      // console.log("Revisando: " + revisar.attr('id') + " tt actual: " + $(value).attr('id'));
      if($(value).attr('id')!==revisar.attr('id')){
        $(value).tooltip('hide');
      }
    });
    revisar.tooltip('toggle');
  });

  /**
   * no enviar forms con enter
   */
  $('form input').keydown(function (e) {
    if (e.keyCode == 13) {
        e.preventDefault();
        e.stopPropagation();
        return false;
    }
  });

  /**
   * Mandar a login si la sesión caducó
   */
  $('#relogi').on('click', function(e){
    event.preventDefault();
    event.stopPropagation();
    location.href=uHome;
  });

});

// Validacion de formularios
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        event.preventDefault();
        event.stopPropagation();
        if (form.checkValidity() === true) {
          $('#btn-send').attr('disabled', true)
          form.submit();
        }else{
          console.log($( this ).find( ":invalid" ));
          crearMensaje(true,"Error","Por favor completa los campos marcados con rojo.");
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
