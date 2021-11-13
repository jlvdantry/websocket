sqlplus -s 'CHAT_LOCATEL/chatpr0d2014@(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.250.109.44)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = XE)))' << EOF
set linesize 200
column nombre format a30
column atencion format a30
column entrada format a30
alter session set NLS_DATE_FORMAT = 'yyyy-mm-dd HH24:mi:ss';
Prompt Lista de espera
select id_espera,nombre,status,atencion,current_date ,entrada,datediff('SS',atencion,current_date) SS from chat_espera where status=1
and datediff('SS',ATENCION,current_date)<240;
Prompt Espera mas antigua
select MIN(CHAT_ESPERA.ID_ESPERA) from CHAT_ESPERA where STATUS=1 AND ID_INSTITUCION=1 and datediff('SS',ATENCION,current_date)<240;
--select * from CHAT_OPERADORES;
Prompt Operador disponible
select * from (SELECT ID_OPERADOR, PSEUDONIMO FROM CHAT_OPERADORES WHERE STATUS=1 and PERFIL=1 AND ID_INSTITUCION=1 ORDER BY dbms_random.value) where rownum=1;
--delete from chat_espera where status=1;
--select id_espera, status from chat_espera;
--update CHAT_LOCATEL.CHAT_OPERADORES  set status=0 where login='jlvdantry';
exit;
EOF
