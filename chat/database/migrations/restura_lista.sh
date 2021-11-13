sqlplus -s 'CHAT_LOCATEL/chatpr0d2014@(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.250.109.44)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = XE)))' << EOF
set linesize 200
column nombre format a30
column atencion format a30
Prompt Lista de espera
delete from chat_espera where status=1;
exit;
EOF
