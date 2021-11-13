sqlplus -s 'CHAT_LOCATEL/chatpr0d2014@(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.250.109.44)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = XE)))' << EOF
spool inserta_jlv.log 
@chat/database/migrations/inserta_jlv.sql
@chat/database/migrations/inserta_supervisor.sql
spool off
exit;
EOF
