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
Prompt promedio
select id_conversacion,avg(datediff('SS',SENT,RECEIVED)) promedio
from CHAT_MENSAJES_NEW 
where TO_CHAR(SENT,'YYYY-MM-DD')=TO_CHAR(sysdate,'YYYY-MM-DD')
group by id_conversacion
order by avg(datediff('SS',SENT,RECEIVED)) desc;
exit;
EOF
