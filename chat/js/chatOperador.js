/*window.onunload = function(){Cerrar_Sesion2();}
$(window).bind('unload', function(){Cerrar_Sesion2();});
window.addEventListener('unload', Cerrar_Sesion2, false);*/

var req_fifo=Array();
var eleID=Array();
var i=0;
var connection=null;

function ajax(url,myid,metodo,tprest){
    eleID[i]=myid;

    if (window.XMLHttpRequest)
      req_fifo[i] = new XMLHttpRequest();
    else if (window.ActiveXObject)
      req_fifo[i] = new ActiveXObject("Microsoft.XMLHTTP");

    var posicion = url.indexOf("?");
    var conector = (posicion >= 0?"&":"?");
    var mtd = (metodo==2?"POST":"GET");
    var myAleatorio = parseInt(Math.random()*999999999999999);

	url = url + conector + "sid=" + myAleatorio;

    req_fifo[i].abort();
    req_fifo[i].onreadystatechange = function(index){ return function(){GotAsyncData(index); };}(i);
    req_fifo[i].open(mtd, url, true);
    req_fifo[i].setRequestHeader('Content-Type','charset=iso-8859-1');
    req_fifo[i].send(null);
    i++;
    if(tprest == 'rest'){

    }else{
    	clone();
    }
}

function EntroOperador(id){
        connection = new WebSocket('wss://chat_socket.soluint.com:/ws/');
	connection.onopen = function () {
                        var msg = {
                            msg: 'IniciaSessionOperador',
                            date: Date.now(),
                            nombre: $('#t_username').val()
                        };
                         connection.send(JSON.stringify(msg))
        };

        connection.onerror = function () {
               console.log('error');
        };

        connection.onmessage = function () {
                              console.log("mensaje:", event.data);
                              resp=JSON.parse(event.data);
                              switch (resp.msg) {
                                  case 'Te estan escribiendo':
                                       escribiendo();
                                       break;
                                  case 'Encontro cliente':
                                       abreconversacion(resp);
                                       break;
                                  case 'Mensaje enviado':
                                       recibirmensaje(resp);
                                       break;
                                  case 'Mensaje recibido':
                                       mensajerecibido(resp)
                                       break;
                                  default:
                                       console.log('Mensaje no progamado '+event.data);
                              }
        };
}

                window.recibirmensaje= function  (resp) {
                        Verificar_Mensajes_Nuevos(resp,1);
                        var msg = {
                            msg: 'Mensaje recibido',
                            date: Date.now(),
                            id:  $('#id_cliente').val(),
                            date_recibido: resp.date
                        };
                         connection.send(JSON.stringify(msg))
                }


function escribiendo(resp){
				$('#fountainG').css("visibility","visible");
                                $("#msg_escribiendo").show(100);
                                setTimeout(function() { $("#msg_escribiendo").hide(); $('#fountainG').css("visibility","hidden") }, 1000);
}

function mensajerecibido(resp){
                            obj = document.getElementById('ban'+resp.date_recibido);
                            if (typeof(obj) != 'undefined' && obj != null){
                                obj.src = app_path+"images/recibido.png";
                                obj.alt = "Mensaje Recibido";
                                obj.title = "Mensaje Recibido";
                            }
}

function abreconversacion(resp){
        Crear_Ventana(resp);
}

function GotAsyncData(id){
    if (req_fifo[id].readyState != 4){}
    else if (req_fifo[id].readyState == 4 || req_fifo[id].readyState=="complete"){
         //alert(req_fifo[id].responseText);
		 if(req_fifo[id].responseText.search('redirect.')!=-1){
			document.getElementById(eleID[id]).innerHTML = req_fifo[id].responseText;
			document.getElementById('id_operador').value = document.getElementById('tid').value;
            document.getElementById('id_institucion').value = document.getElementById('id_institucion2').value;
			if(document.getElementById('tperfil').value==1){//Operador

				document.getElementById('ayuda').style.display = 'block';
				document.getElementById('t_username').value = document.getElementById('t_username2').value;
				ajax('info.php','centro',1);
                                EntroOperador();
				//$('#int_status').val(setInterval(ajaxcall, 3000));
                                ajaxcall();
			}else if(document.getElementById('tperfil').value==2){ //Supervisor
				ajax('menu_chat.php?perfil=2&inst='+document.getElementById('id_institucion').value,'centro',1);
				$('#int_status').val(setInterval(Status_Supervisor, 15000));
			}else if(document.getElementById('tperfil').value==3){ //Calidad
				ajax('menu_chat.php?perfil=3&inst='+document.getElementById('id_institucion').value,'centro',1);
				$('#int_status').val(setInterval(Status_Supervisor, 15000));
			}else if(document.getElementById('tperfil').value==4){ //Calidad
				ajax('menu_chat.php?perfil=4&inst='+document.getElementById('id_institucion').value,'centro',1);
			}
         }else if(req_fifo[id].responseText.search('Gral_Acumulado')!=-1 || req_fifo[id].responseText.search('Gral_X_Hora')!=-1){
                document.getElementById(eleID[id]).innerHTML = req_fifo[id].responseText;
                Fecha();
                Graficas_Lineales();
         }else
            document.getElementById(eleID[id]).innerHTML = req_fifo[id].responseText;

            req_fifo[id]=null;
		    eleID[id]=null;

	}return;
}

function createXMLHttpRequest(){
    var xmlhttp = false;
    if (window.XMLHttpRequest)
        xmlhttp = new XMLHttpRequest();
    else if(window.ActiveXObject){
        try{xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");}
        catch (e){
            try{xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");}
            catch (e){xmlhttp = false;}
        }
    }
    return xmlhttp;
};

function ajaxcall(){
	var op = $('#id_operador').val();
	var conv = $('#id_conv_op').val();
	var stat = '';
	var id_institucion = $('#id_institucion').val();

	if(op!=-1){
		$.ajax({type:"GET",
				url: 'status.php',
				data: ({id_op: op, conv: conv, st:stat, espera:id_institucion}),
				success: function(data){
					$('#hold').html(data);
					if($('#tval').val()!=2){
						if($('#tval').val()==4){
							var path = location.pathname.split('/');
							if (path[path.length-1].indexOf('.html')>-1)
						  	    path.length = path.length - 1;

							var app = path[path.length-2];
							document.location.href='login.php';
						}else if($('#tval').val()!=0){
							$('#ayuda').html("");
							$('#drespuestas').html("");
							//pararReloj();
						}
					}else{

						if($('#tconv_status').length){$('#id_conv_op').val($('#tconv_status').val());}
						if($('#tval').val()==2)
						{
							Escribiendo();
							if($('#tusu_nom').val()!="" && $('#id_conv_op').val()!=""){
								if($('#chatbox_'+$('#tusu_nom').val()).length){}
								else{
								    Crear_Ventana($('#tusu_nom').val());
									Recuperar_Mensajes($('#id_conv_op').val(),$('#tusu_nom').val());
									//iniciaReloj();
									Conversacion_Categorias();
									if($('#ayuda').html()==""){
									    var us = $('#tusu_nom').val();
									    var inst = $('#id_institucion').val();
										$('#drespuestas').html("");
										$.ajax({type:"GET",url: 'ayuda.php',data: ({cat: "categorias", operador:op, usuario:us, inst:inst}),success: function(data){$('#ayuda').html(data)}});
									}
								}
							}

							Verificar_Mensajes_Nuevos($('#tusu_nom').val(),1);
							Verificar_Mensajes_Recibidos_Usuario();
							//muestraReloj();
						}
					}
				}
		});
	}
	if($('#tusu_nom').val()!="" && $('#id_conv_op').val()!=""){
		Verificar_Mensajes_Nuevos($('#tusu_nom').val(),1);
	}
}

function Conversacion_Categorias(){
	var conv = $('#id_conv_op').val();
	$('#dcalidad').html("");
	$.ajax({
		url: 'calidad.php',
		type:'POST',
		cache:false,
		data: ({conv:conv}),
		success: function(data) {
			$("#dcalidad").html(data);
			$('#dcalidad').show(200);
		}
	});
}

function Validar_Sesion(){
    var user = document.getElementById('username');
    var pass = document.getElementById('password');

    var msg = document.getElementById('Resultado');
    var url = 'valida_sesion_chat.php';

    if(trim(user.value)==''){
        msg.style.display = 'block';
		msg.innerHTML="Introduzca el usuario";
		user.focus();
		return;
    }else if(trim(pass.value)==''){
        msg.style.display = 'block';
		msg.innerHTML="Introduzca la contrase&ntilde;a";
		pass.focus();
		return;
    }

	msg.innerHTML="<img src='images/cargando_points.gif' style='margin-top:-25px' />";
	$('#submit').blur();

    url+='?us='+user.value+'&ps='+pass.value;
	ajax(url,'Resultado',1);
}

function Reporte_del_Dia(tipo){
	Activar();
	var ins = document.getElementById('id_institucion').value;
	Ajax_Dinamico('lista_del_dia.php','contenido','tp='+tipo+'&inst='+ins);
}

function trim(cadena){
	for(i=0; i<cadena.length; ){
		if(cadena.charAt(i)==" ")
			cadena=cadena.substring(i+1, cadena.length);
		else
			break;
	}

	for(i=cadena.length-1; i>=0; i=cadena.length-1){
		if(cadena.charAt(i)==" ")
			cadena=cadena.substring(0,i);
		else
			break;
	}

	return cadena;
}

function Cerrar_Sesion(){
	Limpiar_Intervalos();
	var op = document.getElementById('id_operador').value;
	$.ajax({
			type:"GET",
			url: 'close_chat.php',
			data: ({id_op: op}),
			success: function(data) {
				$('#centro').html(data);
				document.getElementById('id_operador').value=-1;

				var path = location.pathname.split('/');
				if (path[path.length-1].indexOf('.html')>-1)
				  path.length = path.length - 1;

				var app = path[path.length-2];
				//document.location.href='/newsite2013/'+app+'/admin_chat.php';
				document.location.href=($('#id_institucion').val()==4?'login.php?op=911':'login.php');
			}
	});
}

function Cerrar_Sesion2(){
	var op = document.getElementById('id_operador').value;
	$.ajax({
			type:"GET",
			url: 'close_chat.php',
			data: ({id_op: op})
	});
}

function Cambiar_Status(){
	var st = document.getElementById('tval').value;
	var op = document.getElementById('id_operador').value;
	var id_institucion = $('#id_institucion').val();

	st = (st==1?3:(st==3?1:st));
	if(st!=2) {
		ajax('status.php?st='+st+'&id_op='+op+'&espera='+id_institucion,'hold',1);
                        var msg = {
                            msg: 'Operadordisponible',
                            nombre:$('#t_username').val(),
                            date: Date.now()
                        };
                        connection.send(JSON.stringify(msg))
        }
}

function Listar_Operadores(tipo){
	Limpiar_Intervalos();
	if(tipo==1){
		$('#status_automatico').val(setInterval(function(){Status_Automatico_Operadores()},4000));
	}

    var ins = document.getElementById('id_institucion').value;
	var fch = document.getElementById('DTFecha');
	var perfil = $('#tp_perfil').val();
	var variables = 'fch='+fch.value;
	 $.ajax({
        url: 'status_operadores.php?inst='+ins+'&perfil='+perfil,
        cache:false,
        type: 'GET',
		data: variables,
        beforeSend: function() {$('#Principal').html("<center><br /><br /><br /><br /><img src='images//cargando2.gif' /></center>");},
        success: function(data){$('#Principal').html(data); Fecha();}
		//,error: function (request, status, error) {$('#'+div).html(request.responseText);}
    });
}

function Desactiva_Operador(id, nombre, perfil){
	//var mensaje = confirm("Deseas reactivar el operador "+nombre+"?");
	var ins = document.getElementById('id_institucion').value;
	swal({
	  title: 'Desea desactivar el operador '+nombre+'?',
	  type: 'warning',
	  showCancelButton: true,
  	  confirmButtonColor: '#449D44',
  	  cancelButtonColor: '#B61B1C',
	  confirmButtonText: 'S&iacute;',
	  cancelButtonText: 'No'
	}).then(function () {
	   $.ajax({
			url: 'descuelga_operador.php',
			data: ({id: id}),
			success: function(data) {
		        swal({title: 'Se desactiv&oacute; el operador '+nombre,type:'success',timer: 4000,confirmButtonColor: "#B61B1C",allowOutsideClick:false});
				$.ajax({
					url: 'status_operadores.php?fch=&inst='+ins+'&perfil='+perfil,
					success: function(data) {
						$("#Principal").html(data);
					}
				});
			}
		});
	});
}

function Conversacion_Tiempo_Real(id,tipo){
	//alert(tipo);
	if(tipo<=1){
		if(id!=$('#Interval_Conversacion').val() && $('#Interval_Conversacion').val()>0){
			clearInterval($('#Interval_id').val());
			$('#Interval_id').val("");
			$('#Interval_Conversacion').val(id);
		}else{
			$('#Interval_Conversacion').val(id);
		}
	}else{
		clearInterval($('#Interval_id').val());
		$('#Interval_id').val("");
		$('#Interval_Conversacion').val(id);
	}

$.ajax({
	url: 'conversacion_mensajes.php',
	data: ({id: id}),
	success: function(data) {
	Activar();
		//$("#conversacion_mensajes").html(data);
		$("#contenido").html(data);
			if(tipo==0){
				var id_Interval;
				id_Interval = setInterval(function(){Conversacion_Tiempo_Real(id,1)},10000);
				clearInterval($('#Interval_id').val());
				$('#Interval_id').val(id_Interval);
				//$('#conversacion_mensajes').css("height", "600");
				//$('#contenido').css('overflow-y', 'auto');
				//$('#contenido').animate({scrollTop: 0}, 'slow');
			}else if(tipo==1){
				//$('#sc_mensajes').animate({scrollTop: 0});
				$("#sc_mensajes").scrollTop($("#sc_mensajes").scrollHeight);
				//$('#sc_mensajes').animate({scrollTop: $(document).height()}, 'slow');
				//$('#conversacion_mensajes').scrollTop(400);
			}else{
				//$('#contenido').css("height", null);
				//$('#contenido').css('overflow-y', 'hidden');
				//$('#contenido').animate({scrollTop: 0}, 'slow');
			}
	}
});

}

function Lista_Espera_Tiempo_Real(){
var ins = document.getElementById('id_institucion').value;
	//Ajax_Dinamico_Sin('reporte_lista_espera.php','reporte_principal','');
	//Ajax_Dinamico_Sin('reporte_lista_espera.php','conversacion_mensajes','inst:'+ins);
	$.ajax({
        url: 'reporte_lista_espera.php?inst='+ins,
        cache:false,
        type: 'GET',
        success: function(data){
            $('#conversacion_mensajes').html(data);
            if(data.search('<h2>No hay usuarios en la lista de espera.</h2>')==-1){
                document.getElementById('EsperaAudioLista').play();
            }
        }
    });
}

function Mostrar_Conversacion(cve, fch){
	if(document.getElementById('op'+cve).style.display=='none' || document.getElementById('op'+cve).innerHTML==""){
		var op = document.getElementById('op_tot');
		var elementos = op.value.split('|');

		for(var i=0; i<elementos.length; i++)
			$("#op"+elementos[i]).hide(300);

		//document.getElementById('conversacion_mensajes').innerHTML="";
		$("#op"+cve).show(700);

		var url='operador_conversaciones.php?';
		var div = 'op'+cve;

		url+='op='+cve;
		url+='&fecha='+fch;
		ajax(url,div,1);
	}else if(document.getElementById('op'+cve).innerHTML!="")
		$("#op"+cve).hide(300);
		//document.getElementById('op'+cve).style.display='none';
}

function Consultar_X_Hora(){
	var ini = document.getElementById('DTFecha2');
	var fin = document.getElementById('DTFecha3');
    var ins = document.getElementById('id_institucion').value;
    var perfil = $('#tp_perfil').val();
	if(trim(ini.value)==""){
		alert('Falta la fecha de inicio');
		ini.focus();
		return;
	}

	if(trim(fin.value)==""){
		alert('Falta la fecha de fin');
		fin.focus();
		return;
	}

	var url='Gconversaciones.php?fini='+ini.value+'&ffin='+fin.value+'&op=X_Hora&inst='+ins+'&perfil='+perfil;
	ajax(url,'reporte_principal',1,'rest');
}

function Status_Automatico(perfil){
var ins = document.getElementById('id_institucion').value;
Limpiar_Intervalos();
 $.ajax({
        url: 'status_operadores.php?fch=&inst='+ins+"&perfil="+perfil,
        cache:false,
        type: 'GET',
        beforeSend: function() {$('#Principal').html("<center><br /><br /><br /><br /><img src='images//cargando2.gif' /></center>");},
        success: function(data){$('#Principal').html(data); Fecha(); $('#status_automatico').val(setInterval(function(){Status_Automatico_Operadores(perfil)},6000));}
		//,error: function (request, status, error) {$('#'+div).html(request.responseText);}
    });
    Lista_Espera_Tiempo_Real();
}

function Status_Automatico_Operadores(perfil){
var ins = document.getElementById('id_institucion').value;

	$.ajax({
			url: 'status_operadores_automatico.php?inst='+ins+"&perfil="+perfil,
			success: function(data) {
				if(data!=""){
					var status;
					var estados = ["desconectado","disponible","conversacion","pause","desconectado"];
					var perfiles = ["","op_","sp_","cd_"];
					var datos = data.split('|');
					for(var i=0; i<datos.length;i++){
						status = datos[i].split('@');
						$('#img_op_'+status[0]).attr("src","images/"+perfiles[status[3]]+estados[status[1]]+".png");
						$('#img_op_'+status[0]).attr("alt",estados[status[1]]);
						$('#img_op_'+status[0]).attr("title",estados[status[1]]);
					}
				}
			}
	});
	Lista_Espera_Tiempo_Real();
}

function Limpiar_Intervalos(){
clearInterval($('#Interval_id').val());
clearInterval($('#status_automatico').val());
clearInterval($('#Interval_espera').val());
}

function Graficas_Lineales() {
    var script   = document.createElement("script");
    script.type  = "text/javascript";
    script.src   = "https://www.google.com/jsapi";
    document.head.appendChild(script);

    var script2   = document.createElement("script");
    script2.type  = "text/javascript";
    script2.text = 'google.load("visualization", "1", {packages:["corechart"]});';
    document.head.appendChild(script2);

    var script3   = document.createElement("script");
    script3.type  = "text/javascript";
    script3.src   = "http://maps.google.com/maps/api/js?sensor=false";
    document.head.appendChild(script3);

    var titulo = document.getElementById('ttitulo').value;
    var datos = document.getElementById('tdatos');
    eval("var data = new google.visualization.arrayToDataTable(["+datos.value+"]);");
    var options = {
    chartArea: {'width': '70%', 'height': '70%'},
    hAxis : {'direction':'-1', 'slantedText':'true', 'slantedTextAngle':'90'},
    series: {0: { color: '#42A620' },1: { color: '#BF1E2E' }},
    backgroundColor: 'transparent',legend: 'top',
    pointSize: 5,};

    var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
    chart.draw(data, options);
}
function Alfanumerico(e, field)
{
	key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();

	letras = " abcdefghijklmnopqrstuvwxyz0123456789";
	especiales = [8,9];
	tecla_especial = false;
	for(var i in especiales) {
		if(key == especiales[i]) {
			tecla_especial = true;
			break;
		}
	}

	if(letras.indexOf(tecla) == -1 && !tecla_especial)
		return false;
}
function Total_Diario(periodo){
	var dperiodo = periodo.replace('-','');
	if($("#"+dperiodo+"").css('display') == 'block'){
		$("#"+dperiodo+"").hide(1000);
		return;
	}
    var ins = document.getElementById('id_institucion').value;
	$.ajax({
			url: 'total_diario.php?inst='+ins,
			data: ({periodo: periodo}),
			success: function(data) {
				$("#"+dperiodo+"").html(data);
				$("#"+dperiodo+"").show(1000);
			}
	});
}

function Ajax_Jquery(archivo, param, resultado){
	//var parametros = (param!=''?'?op='+param+'&inst='+$('#id_institucion').val():"?inst="+$('#id_institucion').val());
	var parametros = (param!=""?'?op='+param+'&inst='+$('#id_institucion').val()+'&perfil='+$('#tp_perfil').val():"?inst="+$('#id_institucion').val()+'&perfil='+$('#tp_perfil').val());
	//alert(parametros);
$.ajax({
	url:''+archivo+'.php'+parametros,
	type: "GET",
	beforeSend: function() {$('#'+resultado).html("<br /><br /><br /><br /><img src='images//cargando2.gif' />");},
	success: function(data) {
		$("#"+resultado).html(data);
		if(param!=""){
			Graficas_Lineales();
			Fecha();
		}
	}
});
}

function Ajax_Dinamico(url, div, param){
    $.ajax({
        url: url,
        cache:false,
        type: 'POST',
        data: param,
        beforeSend: function() {$('#'+div).html("<center><br /><br /><br /><br /><img src='images//cargando2.gif' /></center>");},
        success: function(data){$('#'+div).html(data);},
	error: function (request, status, error) {$('#'+div).html(request.responseText);Ocultar();}
    });
}

function Ajax_Dinamico_Sin(url, div, param){
    $.ajax({
        url: url,
        cache:false,
        type: 'GET',
        data: param,
        success: function(data){$('#'+div).html(data);}
    });
}

function Fecha(){
var perfil = $('#tp_perfil').val();
var today = new Date();
var year = today.getFullYear();
var day = today.getDate();
var mon = today.getMonth();
	$(function() {
		$( "#DTFecha" ).datepicker({
			dateFormat: 'yy-mm-dd',
            showOn: "button",
			changeMonth: true,
      		changeYear: true,
			buttonImage: "images/calendar.png",
			buttonImageOnly: true,
			buttonText: 'Seleccione la fecha',
			minDate: new Date(year-1, mon, day),
			maxDate: new Date(year, mon , day),
			beforeShow: function() {setTimeout(function(){$('.ui-datepicker').css('z-index', 99999999999999);}, 20);},
			onSelect: function(date) {(perfil<=2? Listar_Operadores(date):'')}
			//onSelect: function(date) {Listar_Operadores($('#tfch').val());}
		});
		$( "#DTFecha2" ).datepicker({
			dateFormat: 'yy-mm-dd',
            showOn: "button",
			changeMonth: true,
      		changeYear: true,
			buttonImage: "images/calendar.png",
			buttonImageOnly: true,
			buttonText: 'Seleccione la fecha',
			minDate: new Date(2014, 9, 1),
			maxDate: new Date(year, mon , day),
			beforeShow: function() {setTimeout(function(){$('.ui-datepicker').css('z-index', 99999999999999);}, 20);}
		});
        $( "#DTFecha3" ).datepicker({
			dateFormat: 'yy-mm-dd',
            showOn: "button",
			changeMonth: true,
      		changeYear: true,
			buttonImage: "images/calendar.png",
			buttonImageOnly: true,
			buttonText: 'Seleccione la fecha',
			minDate: new Date(2014, 9, 1),
			maxDate: new Date(year, mon , day),
			beforeShow: function() {setTimeout(function(){$('.ui-datepicker').css('z-index', 99999999999999);}, 20);}
		});
	});
}

function Activar()
{
	document.getElementById('back').style.display = 'block';
	document.getElementById('contenido').style.display = 'block';
}

function Ocultar() {
	document.getElementById('contenido').style.display = 'none';
	document.getElementById('back').style.display = 'none';
}

function Calidad(archivo, param, resultado){
	var parametros = (param!=""?'?'+param:"");
	var perfil = $('#tp_perfil').val();
	//alert(parametros);
$.ajax({
	url: archivo+parametros,
	type: "GET",
	beforeSend: function() {$('#'+resultado).html("<br /><br /><br /><br /><img src='images//cargando2.gif' />");},
	success: function(data) {
		$("#"+resultado).html(data);
		if(param!=""){
		    var today = new Date();
            var year = today.getFullYear();
            var day = today.getDate();
            var mon = today.getMonth();

            $(function() {
        		$( "#DTFecha" ).datepicker({
        			dateFormat: 'yy-mm-dd',
                    showOn: "button",
        			changeMonth: true,
              		changeYear: true,
        			buttonImage: "images/calendar.png",
        			buttonImageOnly: true,
        			buttonText: 'Seleccione la fecha',
        			minDate: new Date(year-1, mon, day),
        			maxDate: new Date(year, mon , day),
        			beforeShow: function() {setTimeout(function(){$('.ui-datepicker').css('z-index', 99999999999999);}, 20);},
        			onSelect: function(date){
        				if (perfil<=2) {
        					$('#tfch').val($('#DTFecha').val());
        					Calidad('calidad/conversaciones.php','fch='+$('#tfch').val()+'&tpr='+$('#tp_perfil').val()+'&inst='+$('#id_institucion').val(),'Principal');
        				}
        			}
        			//onSelect: function(date) {$('#tfch').val($('#DTFecha').val());Calidad('calidad/conversaciones.php','fch='+$('#tfch').val()+'&tpr='+$('#tp_perfil').val()+'&inst='+$('#id_institucion').val(),'Principal');}
        		});
        		$( "#DTFecha2" ).datepicker({
        			dateFormat: 'yy-mm-dd',
                    showOn: "button",
        			changeMonth: true,
              		changeYear: true,
        			buttonImage: "images/calendar.png",
        			buttonImageOnly: true,
        			buttonText: 'Seleccione la fecha',
        			minDate: new Date(year-1, mon, day),
        			maxDate: new Date(year, mon , day),
        			beforeShow: function() {setTimeout(function(){$('.ui-datepicker').css('z-index', 99999999999999);}, 20);}
        		});
        		$( "#DTFecha3" ).datepicker({
        			dateFormat: 'yy-mm-dd',
                    showOn: "button",
        			changeMonth: true,
              		changeYear: true,
        			buttonImage: "images/calendar.png",
        			buttonImageOnly: true,
        			buttonText: 'Seleccione la fecha',
        			minDate: new Date(year-1, mon, day),
        			maxDate: new Date(year, mon , day),
        			beforeShow: function() {setTimeout(function(){$('.ui-datepicker').css('z-index', 99999999999999);}, 20);}
        		});
			});
		}
	}
});
}

function Subtema(tp,div){
var tema = document.getElementById('cmbtema');
var subtema = document.getElementById('cmbsubtema');
var asunto = document.getElementById('cmbasunto');
var url = 'calidad/subtema.php?tp='+tp+'&tema='+tema.value+'&subtema='+subtema.value;
    $.ajax({
        url: url,
        cache:false,
        type: 'GET',
        beforeSend: function() {$('#'+div).html("<center><br /><br /><br /><br /><img src='images//no_recibido.gif' /></center>");},
        success: function(data){
            $('#'+div).html(data);
            if(tp==1){
                asunto.innerHTML = "<select id='cmbasunto' class='select' style='width:120px'><option value=0>Seleccione el Asunto</option></select>";
            }
        }
		//,error: function (request, status, error) {$('#'+div).html(request.responseText);}
    });
}

function Cambio(folio, tp){
    var tm = document.getElementById('cmbtema');
    var st = document.getElementById('cmbsubtema');
    var as = document.getElementById('cmbasunto');
    var rt = document.getElementById('cmbrespuesta');
    var cm = document.getElementById('cmbcomentario');
    var cnv = document.getElementById('id_cnv');
    var fch = document.getElementById('cnv_fecha');
    var op = document.getElementById('id_op');
    var ini = document.getElementById('hinicio');
    var fin = document.getElementById('hfin');
    var dur = document.getElementById('hduracion');
    var fl = document.getElementById('img_'+folio);

    /*if(cm.value==0){
        alert('Selecciona el comentario');
        cm.focus();
        return;
    }*/

    var param = "accion="+(tp==0?"Registrar":"Modificar")+"&id="+cnv.value+"&tema="+tm.value+"&subtema="+st.value+"&asunto="+as.value+"&respuesta="+rt.value+"&comentario="+cm.value;
    param+="&fecha="+fch.value+"&operador="+op.value+"&inicio="+ini.value+"&fin="+fin.value+"&duracion="+dur.value;
    $.ajax({
        url: "calidad/Insertar_Calidad.php",
        cache:false,
        type: 'POST',
        data: param,
        success: function(data){
            if(data==1){
                fl.src='images/revisado.png';
                alert('Datos Guardados!');
            }else{
                alert('Ha ocurrido un error, vuelva a intentar!');
            }
        }
    });
}

function Reporte_Calidad(){
    var fi = document.getElementById('DTFecha2');
    var ff = document.getElementById('DTFecha3');

    if(fi.value == "" || ff.value == ""){
        alert('Seleccione el rango de fechas');
        fi.focus();
        return;
    }

    var url = 'calidad/reporte_resultado.php?fi='+fi.value+'&ff='+ff.value;
    //alert(url);
    window.open(url);
}

function Status_Supervisor(){
var cve = document.getElementById('id_operador').value;
$.ajax({url: 'status_supervisor.php',
        type:"POST",
		data: "cve="+cve,
		success: function(data){
				if(data==0){
					var path = location.pathname.split('/');
					if (path[path.length-1].indexOf('.html')>-1)
				  	    path.length = path.length - 1;

					var app = path[path.length-2];
					document.location.href='login.php';
				}
        }
       });
}

function ChangeId(){
	var tpchat = $('#typeChat option:selected').val();
    var tpSeccion = $('#tp_seccion').val();
	//alert(tpchat);
	/*1.-Monitoreo
    2.-Conversaciones
    3.-Reportes Total
    4.-Reportes Acumulado
    5.-Reporte del dia y hora
    6.-Reporte de Calidad
    */
    $('#id_institucion').val(tpchat);
	/**********MONITOREO*************/
	if(tpSeccion==1)
	   Listar_Operadores($('#tfch').val());
	else if(tpSeccion==2)
	   CalidadConversaciones();
	else if (tpSeccion==3)
		Ajax_Jquery('total','','reporte_principal');
	else if (tpSeccion==4)
		Ajax_Jquery('Gconversaciones','Acumulado','reporte_principal');


}

function CalidadConversaciones() {
	$('#tfch').val($('#DTFecha').val());
	Calidad('calidad/conversaciones.php','fch='+$('#tfch').val()+'&tpr='+$('#tp_perfil').val()+'&inst='+$('#id_institucion').val(),'Principal');
}

function clone(){
  	$('#id_original').val($('#id_institucion').val());
}

function originalId(){
	$('#id_institucion').val($('#id_original').val());
}
