delete from CHAT_LOCATEL.CHAT_OPERADORES where LOGIN='supervisor';
Insert into CHAT_LOCATEL.CHAT_OPERADORES (ID_OPERADOR,NOMBRE,PSEUDONIMO,LOGIN,PASS,INICIO,SALIDA,IP,PERFIL,STATUS,ID_INSTITUCION,HOST,NAVEGADOR) values (
	(select max(id_operador)+1 from CHAT_LOCATEL.CHAT_OPERADORES),'Supervisor','D_supervisor','supervisor','6443e3eabf4618647f62b16bb9c33cdd',to_timestamp('05/11/21 09:11:14.431000000','DD/MM/RR HH24:MI:SS.FF'),to_timestamp('05/11/21 10:28:46.901000000','DD/MM/RR HH24:MI:SS.FF'),'187.189.198.3',4,0,1,null,null);
