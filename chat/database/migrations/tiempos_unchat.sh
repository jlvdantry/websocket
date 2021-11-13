sqlplus -s 'CHAT_LOCATEL/chatpr0d2014@(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.250.109.44)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = XE)))' << EOF
set linesize 200
set pagesize 200
set nowrap
column nombre format a30
column inicio format a30
column SENT format a30
column RECEIVED format a30
column inicio format a30
column fin format a30
column too format a20
column fromm format a20
column MESSAGE format a40
Prompt conversacion
select ID_CONVERSACION, ID_USUARIO, ID_OPERADOR, INICIO, FIN from CHAT_CONVERSACIONES where id_conversacion=679770;
Prompt mensajes
select SENT,RECEIVED,FROMM,TOO 
,datediff('SS',SENT,RECEIVED) as "Diff seg", MESSAGE
from CHAT_MENSAJES_NEW where id_conversacion in
(select ID_CONVERSACION from CHAT_CONVERSACIONES where id_conversacion=679756) order by sent;
Prompt promedio
select avg(datediff('SS',SENT,RECEIVED))  Promedio
from CHAT_MENSAJES_NEW where id_conversacion in
(select ID_CONVERSACION from CHAT_CONVERSACIONES where id_conversacion=679756) order by sent;
exit;
EOF
