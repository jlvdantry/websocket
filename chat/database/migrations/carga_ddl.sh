sqlplus -s 'CHAT_LOCATEL/chatpr0d2014@(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.250.109.44)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = XE)))' << EOF
spool chat/database/migrations/carga_dll.log 
@chat/database/migrations/drop_esquema.sql
@chat/database/migrations/export_ddl.sql
@chat/database/migrations/crea_diff_fechas.sql
spool off
exit;
EOF
