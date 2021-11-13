export NLS_LANG=.AL32UTF8
sqlplus -s 'CHAT_LOCATEL/chatpr0d2014@(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.250.109.44)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = XE)))' << EOF
SET ECHO ON;
SET TERM ON;
WHENEVER SQLERROR EXIT FAILURE ROLLBACK;
SET DEFINE OFF;
spool chat/database/migrations/insert_tema.log 
@chat/database/migrations/insert_tema.sql
spool off
spool chat/database/migrations/insert_subtema.log 
@chat/database/migrations/insert_subtema.sql
spool off
spool chat/database/migrations/insert_operadors.log 
@chat/database/migrations/insert_operadores.sql
spool off
spool chat/database/migrations/insert_instituciones.log 
@chat/database/migrations/insert_instituciones.sql
spool off
spool chat/database/migrations/insert_categorias.log 
@chat/database/migrations/insert_categorias.sql
spool off
spool chat/database/migrations/insert_ayuda.log 
@chat/database/migrations/insert_ayuda.sql
spool off
exit;
EOF
