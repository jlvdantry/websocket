cat > $0.cmd << fin
{
    if (\$1==par) {
       print \$2
    }
}
fin
DB_HOST=`cat .env | awk -v par=DB_HOST_CH -F = -f $0.cmd`
DB_DATABASE=`cat .env | awk -v par=DB_DATABASE_CH -F = -f $0.cmd`
DB_USERNAME=`cat .env | awk -v par=DB_USERNAME_CH -F = -f $0.cmd`
DB_PASSWORD=`cat .env | awk -v par=DB_PASSWORD_CH -F = -f $0.cmd`
echo $DB_HOST
echo $DB_DATABASE
export PGPASSWORD=$DB_PASSWORD
##DB_DATABASE=template1
##DB_USERNAME=postgres
##B_HOST=localhost
cat > $0.sql << fin
SELECT "ID_ESPERA","NOMBRE","STATUS","ATENCION",CURRENT_DATE ,"ENTRADA",DATEDIFF('SS',"ATENCION",CURRENT_DATE) SS FROM "CHAT_ESPERA" WHERE "STATUS"=1
AND DATEDIFF('SS',"ATENCION",CURRENT_DATE)<240;
select  '' as "ESPERA MAS ANTIGUA";
SELECT MIN("CHAT_ESPERA"."ID_ESPERA") FROM "CHAT_ESPERA" WHERE "STATUS"=1 AND "ID_INSTITUCION"=1 AND DATEDIFF('SS',"ATENCION",CURRENT_DATE)<240;
--SELECT * FROM CHAT_OPERADORES;
select '' as " OPERADOR DISPONIBLE";
SELECT * FROM (SELECT "ID_OPERADOR", "PSEUDONIMO" FROM "CHAT_OPERADORES" 
WHERE "STATUS"=1 AND "PERFIL"=1 AND "ID_INSTITUCION"=1 ORDER BY RANDOM()  ) as a limit 1;

fin
psql -h $DB_HOST -d $DB_DATABASE -U $DB_USERNAME  < $0.sql
rm $0.cmd
rm $0.sql

