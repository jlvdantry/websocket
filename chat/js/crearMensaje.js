
window.crearMensaje = function (error,titulo,mensaje,tiempo=3500){
  return new Promise(function (resolve, reject) {
          $('#msgModal').remove();
          $('body').removeClass('modal-open');
          $('.modal-backdrop').remove();
          if (error==true) {
              var clase_mensaje = "alert-danger";
          } else {
                  if (error==false) {
                      var clase_mensaje = "alert-success";
                  } else {
                      var clase_mensaje = "alert-"+error;
                  }
          }

          var mensaje_alert = ' '+
                    '<div class="modal fade msj_js" id="msgModal" tabindex="-1" role="dialog" data-focus=false aria-labelledby="titleMsgModal" aria-hidden="true">'+
                      '<div class="modal-dialog" role="document">'+
                        '<div class="modal-content">'+
                          '<div class="modal-header pb-0">'+
                            '<h1 class="modal-title" id="titleMsgModal">'+titulo+'</h1>'+
                            '<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
                              '<span aria-hidden="true">&times;</span>'+
                            '</button>'+
                          '</div>'+
                          '<div id="bodyMsgModal" class="modal-body '+clase_mensaje+'">'+mensaje+'</div>'+
                          '<div class="modal-footer pt-0 d-none" id="d_siacepto" >'+
                                    '<button type="button" class="btn btn-02" data-dismiss="modal" id="siacepto" >Aceptar</button>'+
                          '</div>'+
                        '</div>'+
                      '</div>'+
                    '</div>';

          $("body").append(mensaje_alert);
              $('button[class="close"]').on('click', function(e) {
                     resolve();
              });
          $('#msgModal').modal('show');
          if (tiempo!=0) {
                  setTimeout(function(){
                    $('#msgModal').modal('hide');
                    resolve();
                  }, tiempo);
          }
   })
}

