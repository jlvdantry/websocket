var horas = 0;
var minutos = 0;
var segundos = 0;
var app_path = (location.pathname.search("chat/")!=-1?"":"");
var isActive;
window.onfocus=function(){isActive = true;};
window.onblur=function(){isActive = false;};

function Crear_Ventana(chatboxtitle) {
    var message;
    if($("#id_institucion").val()!=4){
        if($("#id_institucion").val()==6 || $("#id_institucion").val()==1)
            message = "Bienvenido a los servicios en linea de Locatel.<br />&#191;En que le puedo ayudar?";
        else if($("#id_institucion").val()==2)
            message = "Asesor&iacute;a psicol&oacute;gica de Locatel.<br />buen d&iacute;a, &#191;en qu&eacute; te puedo apoyar?";
        else if($("#id_institucion").val()==3)
            message = "Asesor&iacute;a jur&iacute;dica de Locatel.<br />buen d&iacute;a, &#191;en qu&eacute; te puedo apoyar?";
        else if($("#id_institucion").val()==5)
            message = "Asesor&iacute;a m&eacute;dica de Locatel.<br />buen d&iacute;a, &#191;en qu&eacute; te puedo apoyar?";
                
        var opt = 6;
        
    }else{
        message = "9-1-1 &#191;Cu&aacute;l es su emergencia?";
        var opt = 4;
    }
    
	var cadena= '<div class="chatboxhead">';
	cadena+= "<div class='chatboxtitle'><img src='"+app_path+"images/Locatel_User.png' style='margin:2px 4px 0 -4px;'/>"+chatboxtitle+"</div>";
	cadena+= '<div class="chatboxoptions">';
	if($("#id_conversacion").length!=6){	    
            cadena+= '<a href="javascript:void(0)" onclick="javascript:Transferencia(\''+chatboxtitle+'\')"><img src="'+app_path+'images/Locatel_Transferir.png" alt="Transferir Conversaci&oacute;n" title="Transferir Conversaci&oacute;n" border="0" style="margin:2px 4px 0 0;"/></a>';                    		
	}

	cadena+= '<a href="#" onclick="Cerrar_Ventana(\''+chatboxtitle+'\')" alt="Cerrar Conversaci&oacute;n" title="Cerrar Conversaci&oacute;n"><img id="c_'+chatboxtitle+'" name="c_'+chatboxtitle +'" src="'+app_path+'images/Locatel_Close.png" border="0" style="margin-top:2px;" /></a></div><br clear="all"/></div>';
	cadena+= "<div class='chatboxcontent'>";

	cadena+='<div class="chatboxmessage"><span class="chatboxmessagefrom"><img id="img_btn" src="'+app_path+'images/operador'+opt+'.png" style="margin:0 4px -4px -8px;" />'+$('#t_username').val()+'</span><span class="chatboxmessagecontent"><p style="margin: 4 auto;">'+message+'</p></span></div>';

	cadena+= '</div><div style="height:8px"> <div id="msg_escribiendo" name="msg_escribiendo" class="msg_aviso" style="display:none;">'+chatboxtitle+' esta escribiendo...</div><div id="fountainG" style="visibility: hidden; margin-top:-8px;"><div id="fountainG_1" class="fountainG"></div><div id="fountainG_2" class="fountainG"></div><div id="fountainG_3" class="fountainG"></div><div id="fountainG_4" class="fountainG"></div><div id="fountainG_5" class="fountainG"></div><div id="fountainG_6" class="fountainG"></div><div id="fountainG_7" class="fountainG"></div><div id="fountainG_8" class="fountainG"></div></div></div>';    
    
	cadena+= '<div class="chatboxinput">';
	cadena+= '<textarea id="t_'+chatboxtitle +'" name="t_'+chatboxtitle +'" maxlength="2499"';
	if($("#id_conversacion").length){cadena+= 'onpaste="return false;" ';}
	cadena+= 'class="chatboxtextarea" onkeydown="javascript:return checkChatBoxInputKey(event,\''+chatboxtitle+'\');"></textarea>';
	cadena+= '</div>';
	
	$(" <div />" ).attr("id","chatbox_"+chatboxtitle).addClass("chatbox").html(cadena).appendTo($( "body" ));
    $("#chatbox_"+chatboxtitle).css('top', '100px');
    
	$("#chatbox_"+chatboxtitle).css('bottom', '0px');
    $("#chatbox_"+chatboxtitle).css('right', '0px');
	$("#chatbox_"+chatboxtitle+" .chatboxtextarea").blur(function(){Remove_Focus(2,chatboxtitle)}).focus(function(){Remove_Focus(1,chatboxtitle)});

	$("#chatbox_"+chatboxtitle).show();
	window.focus();
    $('#t_'+chatboxtitle).focus();
	document.getElementById('chatAudio').play();
}

function Crear_Ventana_Cliente(chatboxtitle){
    var message;    
    var opt;
    if($("#id_inst").val()!=4){
        if($("#id_inst").val()==6)
            message = "Bienvenido a los servicios en linea de Locatel.<br />&#191;En que le puedo ayudar?";
        else if($("#id_inst").val()==2)
            message = "Asesor&iacute;a psicol&oacute;gica de LOCATEL.<br />buen d&iacute;a, &#191;en qu&eacute; te puedo apoyar?";
        else if($("#id_inst").val()==3)
            message = "Asesor&iacute;a jur&iacute;dica de LOCATEL.<br />buen d&iacute;a, &#191;en qu&eacute; te puedo apoyar?";
        else if($("#id_inst").val()==5)
            message = "Asesor&iacute;a m&eacute;dica de LOCATEL.<br />buen d&iacute;a, &#191;en qu&eacute; te puedo apoyar?";
                
        opt=1;
    }else{
        message = "9-1-1 &#191;Cu&aacute;l es su emergencia?";
        opt=4;
    }
    
	var cadena= '<div class="chatboxhead">';
	cadena+= "<div class='chatboxtitle'><img src='"+app_path+"images/Locatel_User.png' style='margin:-2px 4px 0 -4px;'/>"+chatboxtitle+"</div>";
	cadena+= '<div class="chatboxoptions">';
	cadena+= '<a href="#" onclick="Cerrar_Ventana_Cliente(\''+chatboxtitle+'\')" alt="Cerrar Conversaci&oacute;n" title="Cerrar Conversaci&oacute;n"><img id="c_'+chatboxtitle+'" name="c_'+chatboxtitle +'" src="'+app_path+'images/Locatel_Close.png" border="0" style="margin-top:1px;" /></a></div><br clear="all"/></div>';
	
	cadena+= "<div id='msg_final'; class='chatboxcontent'>";

    if($("#id_conversacion").length){
	cadena+='<div class="chatboxmessage"><br/><br/><span class="chatboxmessagefrom"><img id="img_btn" src="'+app_path+'images/operador'+opt+'.png" style="margin:0px 5px 0px -7px;" />'+chatboxtitle+'</span><span class="chatboxmessagecontent"><p align="left">'+message+'</p></span></div>';
	}

	cadena+= '</div><div id="fountainG" style="visibility: hidden"><div id="fountainG_1" class="fountainG"></div><div id="fountainG_2" class="fountainG"></div><div id="fountainG_3" class="fountainG"></div><div id="fountainG_4" class="fountainG"></div><div id="fountainG_5" class="fountainG"></div><div id="fountainG_6" class="fountainG"></div><div id="fountainG_7" class="fountainG"></div><div id="fountainG_8" class="fountainG"></div></div>';
    cadena+= '<div id="msg_escribiendo" name="msg_escribiendo" class="msg_aviso" style="display:none;">'+chatboxtitle+' esta escribiendo...</div>';
    cadena+= '<div class="chatboxinput">';
	cadena+= '<textarea align="center" id="t_'+chatboxtitle +'" name="t_'+chatboxtitle +'" maxlength="2499"';
	if($("#id_conversacion").length){cadena+= 'onpaste="return false;" ';}
	cadena+= 'class="chatboxtextarea" onkeydown="javascript:return checkChatBoxInputKey(event,\''+chatboxtitle+'\');"></textarea>';
	cadena+= '</div><a href="javascript:void(0);" onclick="Enviar_Mensaje(\''+chatboxtitle+'\');"><img id="i_'+chatboxtitle +'" name="i_'+chatboxtitle +'" src="'+app_path+'images/enviar_in.png" class="send" onmouseover="Boton_Rojo(i_'+chatboxtitle +')" onmouseout="Boton_Negro(i_'+chatboxtitle +')"  border="0" /></a>';

	$(" <div />" ).attr("id","chatbox_"+chatboxtitle).addClass("chatbox").html(cadena).appendTo($("#vtn_chat"));
	$("#chatbox_"+chatboxtitle+" .chatboxtextarea").blur(function(){Remove_Focus(2,chatboxtitle)}).focus(function(){Remove_Focus(1,chatboxtitle)});
	$("#chatbox_"+chatboxtitle).click(function() {
		if ($('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display') != 'none') {
			$("#chatbox_"+chatboxtitle+" .chatboxtextarea").focus();
		}
	});

	$("#chatbox_"+chatboxtitle).show();
	window.focus();
    $('#t_'+chatboxtitle).focus();
	document.getElementById('chatAudio').play();
}

function Remove_Focus(tp,chatboxtitle){
    if(tp==1){
        $('#chatbox_'+chatboxtitle+' .chatboxhead').removeClass('chatboxblink');
		$("#chatbox_"+chatboxtitle+" .chatboxtextarea").addClass('chatboxtextareaselected');
    }else if(tp==2){
        $("#chatbox_"+chatboxtitle+" .chatboxtextarea").removeClass('chatboxtextareaselected');
    }
}

function checkChatBoxInputKey(event,chatboxtitle) {
    var tecla = (document.all) ? event.keyCode : event.which;
    if (tecla==8 || tecla==0 || tecla==32) return;

	if(event.keyCode == 13 && event.shiftKey == 0){
	    Enviar_Mensaje(chatboxtitle);
	    $("#chatbox_"+chatboxtitle+" .chatboxtextarea").removeClass('chatboxtextareaselected');
		$('#chatbox_'+chatboxtitle+' .chatboxhead').removeClass('chatboxblink');
		//$("#chatbox_"+chatboxtitle+" .chatboxtextarea").addClass('chatboxtextareaselected');
		document.title = ($("#id_conversacion").length!=1?'Chat_Locatel':'LOCATEL');
        return false;
	}else
        Genera_Status();
}

function Genera_Status(){
    var msg;
    var id_conv;

    if($("#id_conversacion").length){
       id_conv = $("#id_conversacion").val();
       msg = "MSG_US";
    }else if($("#id_operador").length){
       id_conv = $("#id_conv_op").val();
       msg = "MSG_OP";
    }

    $.ajax({url: app_path+"escribiendo.php",type:"POST",data:({conversacion:id_conv,msg:msg}),success: function(data){}});
}

function Enviar_Mensaje(chatboxtitle){
	var tipo=2;
	if($("#id_conversacion").length){
        if($("#conversacion").val()==0){
           $(chatboxtextarea).val("");
           return;
        }
        tipo=1
    }else{
        if($("#tusu_nom").val()==''){
           $(chatboxtextarea).val("");
           return;
        }
    }

    var chatboxtextarea = document.getElementById('t_'+chatboxtitle);
    message = chatboxtextarea.value;
    message = message.replace(/\'/g, "");
    message = message.replace(/\"/g, "");
	message = message.replace(/^\s+|\s+$/g,"");

	chatboxtextarea.value = "";
	chatboxtextarea.focus();
	chatboxtextarea.style.height = '50px';

	var id_conv="";
    var id_conv_op="";
    var id_opera="";
    var from = $('#t_username').val();

    if($("#id_conversacion").length)
        id_conv = $("#id_conversacion").val();
    else if($("#id_operador").length){
        id_opera = $("#id_operador").val();
        id_conv_op = $("#id_conv_op").val();
    }
    
    var img;
    if(tipo==1){
        img='usuario';
    }else{
        img='operador';
        if($("#id_institucion").length)
            img+=($("#id_institucion").val()==4?4:6);
        else if($("#id_inst").length)
            img+=($("#id_inst").val()==4?4:6);        
    }

	if (message != '') {
	   $('#fountainG').css("visibility","visible");
	   var color = (tipo==1?'color="#ff0000"':"");
	   var param = "action=sendchat&to="+chatboxtitle+"&message="+message+"&conversacion="+id_conv+"&conversacion_op="+id_conv_op+"&operador="+id_opera+"&from_de="+from;
	   $.ajax({
            url: app_path+'chat.php',
            cache:false,
            type: 'POST',
            data: param,
            //beforeSend: function(){},
            success: function(data){
                if(data>0 && data!=""){
                    message = message.replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/\"/g,"&quot;");
        			message = Verificar_Url(message);
        			$("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom"><img src="'+app_path+'images/'+img+'.png" style="margin:0 4px -4px -8px;"/><font '+color+'">'+from+'</font><img id="ban'+data+'" src="'+app_path+'images/no_recibido.gif" alt="Mensaje No Recibido" title="Mensaje No Recibido" style="cursor:hand; cursor:pointer; margin:0 4px -4px 4px;"/></span><span class="chatboxmessagecontent"><p style="margin: 4 0;">'+message+'</p></span></div>');
                    //if(id_conv_op!=""){
                        $('#msg_enviados').val(($('#msg_enviados').val()==""?data:$('#msg_enviados').val()+','+data));
                    //}
                    $("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);
                }
                writting=0;
            }
        });
        $('#fountainG').css("visibility","hidden");
	}
}

function Cerrar_Ventana(chatboxtitle) {
	if(chatboxtitle=="") return;

    var id_conv="";
    var id_conv_op="";
    var id_opera="";
    var from = $('#t_username').val();

    if($("#id_conversacion").length)
        id_conv = $("#id_conversacion").val();
    else if($("#id_operador").length){
        //$('#chatbox_'+chatboxtitle).remove();
        id_opera = $("#id_operador").val();
        id_conv_op = $("#id_conv_op").val();
    }

	var param = "action=closechat&chatbox="+chatboxtitle+"&conversacion="+id_conv+"&conversacion_op="+id_conv_op+"&operador="+id_opera+"&from_de="+from+'&inst='+$("#id_institucion").val();
    $.ajax({
		url: app_path+'chat.php',
		cache:false,
		type: 'POST',
		data: param,
		success: function(data){
			if($("#id_conversacion").length){
			//alert('aqui');
				var lop = document.getElementById('login_operador').value;
				/*document.getElementById('atras').style.display='block';
				document.getElementById('msg_modal').style.display='block';*/
				document.getElementById('t_'+lop).focus();
				document.getElementById('t_'+lop).style.display='none';
				document.getElementById('i_'+lop).style.display='none';
				document.getElementById('c_'+lop).style.display='none';
				document.getElementById('layout_chat').style.display='none';
				document.getElementById('conversacion').value=0;
				document.getElementById("msg_escribiendo").style.visibility = 'hidden';
				document.getElementById("fountainG").style.visibility = 'hidden';
                clearInterval(document.getElementById('int_conv').value);
			}else{
			   document.getElementById('dcalidad').innerHTML='';
			   document.getElementById('dcalidad').style.display='none';
			   document.getElementById('id_conv_op').value='';
			   document.getElementById('msg_enviados').value='';
			   var us_no = document.getElementById('tusu_nom');
               if (typeof(obj) != 'undefined' && obj != null){
                    document.getElementById('tusu_nom').value='';
               }

			   //clearInterval(document.getElementById('Interval_Conversacion').value);
			}
            $('#chatbox_'+chatboxtitle).remove();
			//clearInterval(document.getElementById('int_chartbeat_titulo').value);
			document.title = ($("#id_conversacion").length!=1?'Chat_Locatel':'LOCATEL');
    	}
	});
}

function Cerrar_Ventana_Cliente(chatboxtitle) {
    if(chatboxtitle=="") return;

    var id_conv="";
    var id_conv_op="";
    var id_opera="";
    var from = $('#t_username').val();

    if($("#id_conversacion").length)
        id_conv = $("#id_conversacion").val();
    else if($("#id_operador").length){
        id_opera = $("#id_operador").val();
        id_conv_op = $("#id_conv_op").val();
    }

	var param = "action=closechat&chatbox="+chatboxtitle+"&conversacion="+id_conv+"&conversacion_op="+id_conv_op+"&operador="+id_opera+"&from_de="+from+'&inst='+$("#id_inst").val();
    $.ajax({
		url: app_path+'chat.php',
		cache:false,
		type: 'POST',
		data: param,
		success: function(data){
			if($("#id_conversacion").length){
			    clearInterval(document.getElementById('int_conv').value);
                $("body").css("overflow","visible");
                document.getElementById('conversacion').value=0;
			    document.getElementById('msg_enviados').value='';

				var lop = document.getElementById('login_operador').value;
				//document.getElementById('t_'+lop).focus();
				document.getElementById('t_'+lop).style.display='none';
				document.getElementById('i_'+lop).style.display='none';
				document.getElementById('c_'+lop).style.display='none';
				document.getElementById('layout_chat').style.display='none';
				document.getElementById("msg_escribiendo").style.visibility = 'hidden';
				document.getElementById("fountainG").style.visibility = 'hidden';

                $(".chatboxcontent").append('<div style="color:#ff0000;" class="chatboxmessage"><p style="font-weight:bold">La sesi&oacuten fue terminada. Gracias por usar los servicios en linea.<br><br><button class="btn btn-info" type="button" onClick="nueva_sesion()">Volver a Iniciar sesi&oacuten</button></p></span></div>');
                $("body").css("overflow","visible");
                $("#chatbox_"+lop+" .chatboxcontent").scrollTop($("#chatbox_"+lop+" .chatboxcontent")[0].scrollHeight);
			}else{
			   document.getElementById('dcalidad').innerHTML='';
			   document.getElementById('dcalidad').style.display='none';
			   document.getElementById('id_conv_op').value='';
			   document.getElementById('msg_enviados').value='';
			   var us_no = document.getElementById('tusu_nom');
               if (typeof(obj) != 'undefined' && obj != null){
                    document.getElementById('tusu_nom').value='';
               }
               $('#chatbox_'+chatboxtitle).remove();
			   //clearInterval(document.getElementById('Interval_Conversacion').value);
			}

			document.title = ($("#id_conversacion").length!=1?'Chat_Locatel':'LOCATEL');
    	}
	});
}

function Verificar_Url(msg){	
	msg = msg.replace(/(https:\/\/[^\s]+)/gi,'<a href="$1" target="_blank">$1</a>');
    msg = msg.replace(/(http:\/\/[^\s]+)/gi,'<a href="$1" target="_blank">$1</a>');
	return msg;
}

function Verificar_Mensajes_Nuevos(chatboxtitle, tipo){
	var id_conv="";
	var msg;
    var tiempo;

    if($("#id_conversacion").length){
        id_conv = $("#id_conversacion").val();
    }else if($("#id_operador").length)
        id_conv = $("#id_conv_op").val();

    var color = (tipo==1?'color="#ff0000"':"");
    var color2 = 'color="#5c5c5c"';
    var img;
    
    if(tipo==1){
        img='usuario';
    }else{
        img='operador';
        if($("#id_institucion").length)
            img+=($("#id_institucion").val()==4?4:6);
        else if($("#id_inst").length)
            img+=($("#id_inst").val()==4?4:6);        
    }

    var param = "action=chatheartbeat&un="+document.getElementById('t_username').value+"&id_conv="+id_conv;
    $.ajax({
        url: app_path+'chat.php',
        cache:false,
        type: 'POST',
        data: param,
        //beforeSend: function() {$('#'+div).html(Cargando(0));},
        success: function(data){
            if(data!=""){
                msg = data.split('|');
                for(var i=0; i<msg.length;i++){
	                   $("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage"><font '+color+'"><span class="chatboxmessagefrom"><img src="'+app_path+'images/'+(tipo==1?'usuario':img)+'.png" style="margin:0 4px -4px -8px;"/>'+chatboxtitle+'</span><span class="chatboxmessagecontent"><p style="margin: 4 auto;">'+Verificar_Url(msg[i])+'</p></span></font></div>');

                    if($("#chatbox_"+chatboxtitle+" .chatboxcontent").length){
                        $("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);
                    }
                }
                $('#chatbox_'+chatboxtitle+' .chatboxhead').toggleClass('chatboxblink');

				if(isActive){
                    document.getElementById('chatAudio').play();
                }else if (("Notification" in window)) {
                    Notification.requestPermission(function (permission) {
                    var notification = new Notification('CHAT LOCATEL', {body: 'Tienes '+(msg.length>1?msg.length+' nuevos mensajes':' un nuevo mensaje')+'!!!', icon: app_path+'images/notificacion.png'});
                    setTimeout(notification.close.bind(notification), 5000);
                    notification.onclick = function(e){window.focus(); $('#t_'+chatboxtitle).focus();};
                    document.getElementById('chatAudio2').play();
                    });
                }else
                   document.getElementById('chatAudio').play();

				if(chatboxtitle!="" && id_conv!=""){
					document.title=chatboxtitle+' te envio un mensaje';
				}
            }
        }
    });
}

function Verificar_Mensajes_Recibidos_Usuario(){
var param = "action=chatheartbeat_status&msg="+document.getElementById('msg_enviados').value;
var cadena = "";
var st="";
var nm="";
var obj="";
$.ajax({
        url: app_path+'chat.php',
        cache:false,
        type: 'POST',
        data: param,
        success: function(data){
            if(data!=""){
                var datos = data.split(',');
                var estado;
                for(var i=0; i<datos.length; i++){
                    estado = datos[i].split('-');
                    if(estado.length>0){
                        st = estado[1];
                        nm = estado[0];
                        if(st==1 && nm!="" && document.getElementById('msg_enviados').value!=""){
                            obj = document.getElementById('ban'+nm);
                            if (typeof(obj) != 'undefined' && obj != null){
                                obj.src = app_path+"images/recibido.png";
                                obj.alt = "Mensaje Recibido";
                                obj.title = "Mensaje Recibido";
                            }
                        }
                    }
                }
            }
        }
});
}
/*function Boton_Negro(boton){boton.src=app_path+"images/enviar_in.png";}
function Boton_Rojo(boton){boton.src=app_path+"images/enviar_over.png";}*/
function Escribiendo(){
    var msg;
    var id_conv;

    if($("#id_conversacion").length){
       id_conv = $("#id_conversacion").val();
       msg = "MSG_OP";
    }else if($("#id_operador").length){
       id_conv = $("#id_conv_op").val();
       msg = "MSG_US";
    }

	$.ajax({
		type:"POST",
		url: app_path+'escribiendo_status.php',
		data: ({conversacion: id_conv, msg:msg}),
		success: function(data){
			if(data!="" && data<4){
		      //$('#msg_escribiendo').css("visibility","visible");
				$("#msg_escribiendo").show(100);
				$('#fountainG').css("visibility","visible");
			}else if(data=="esperando..." || data>=4){
			     //$('#msg_escribiendo').css("visibility","hidden");
				$("#msg_escribiendo").hide(100);
				$('#fountainG').css("visibility","hidden");
			}
		}
	});
}

function Transferencia(chatboxtitle){
    var inst = $('#id_institucion').val();
    var from = $('#t_username').val();
    var id_opera = $("#id_operador").val();
    var id_conv_op = $("#id_conv_op").val();    
    
    var s = '<br><select class="swal select" id="cmbtransfer" style="width:250px"><option value="0">Selecciona el Chat a Transferir</option>';    
    if(inst==1)
        s+='<option value="3">Jur&iacute;dico</option><option value="5">M&eacute;dico</option><option value="2">Psicolog&iacute;a</option><option value="4">9-1-1 CDMX</option>';
    else if(inst==2)
        s+= '<option value="1">Informativos</option><option value="3">Jur&iacute;dico</option><option value="5">M&eacute;dico</option><option value="4">9-1-1 CDMX</option>';
    else if(inst==3)
        s+='<option value="1">Informativos</option><option value="5">M&eacute;dico</option><option value="2">Psicolog&iacute;a</option><option value="4">9-1-1 CDMX</option>';
    else if(inst==4)
        s+='<option value="1">Informativos</option><option value="3">Jur&iacute;dico</option><option value="5">M&eacute;dico</option><option value="2">Psicolog&iacute;a</option>';
    else if(inst==5)
        s+='<option value="1">Informativos</option><option value="3">Jur&iacute;dico</option><option value="2">Psicolog&iacute;a</option><option value="4">9-1-1 CDMX</option>';
        
    s+='</select><br><br>';
    
swal({
    html: s,
    title: 'Transferencia de chat',
    confirmButtonColor: "#F13134",
    confirmButtonText: "Transferir",
    preConfirm: function() {
        return new Promise(function(resolve) {
            if($('#cmbtransfer').val()!=0)
                resolve($('#cmbtransfer').val());
        });
    }
    }).then(function(result)
    {
        $('.swal2-modal').css('overflow', '');
        var cmb = $('#cmbtransfer').val();
        var param = "para="+chatboxtitle+"&cve="+id_conv_op+"&op="+id_opera+"&de="+from+'&inst='+cmb;
        var trans = $('#cmbtransfer option:selected').text();
        
        $.ajax({
        	url: app_path+'transferencia.php',
        	cache:false,
        	type: 'POST',
        	data: param,
        	success: function(data){
        		if(data==1){
        		   $('#chatbox_'+chatboxtitle).remove();
        		   document.getElementById('dcalidad').innerHTML='';
        		   document.getElementById('dcalidad').style.display='none';
        		   document.getElementById('id_conv_op').value='';
        		   document.getElementById('msg_enviados').value='';
        		   var us_no = document.getElementById('tusu_nom');
                   if (typeof(obj) != 'undefined' && obj != null){document.getElementById('tusu_nom').value='';}
                   swal({type: "success", title: 'Conversaci&oacute;n Transferida al<br>Chat de ' + trans, showConfirmButton: true, confirmButtonColor: "#F13134"});
                }else swal({type: "error", title: 'Ha ocurrido un error!', showConfirmButton: true, confirmButtonColor: "#F13134"});
           }
        });
    });
}


function nueva_sesion(){
    $('#t_username').val('');
    $('#int_conv').val('');
    document.getElementById('msg_enviados').value='';
    $("#id_inst").val(1);
    Ajax_Dinamico('inicia_sesion.php','div_chat','');

}
