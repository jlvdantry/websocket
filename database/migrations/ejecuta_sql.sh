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
--select count(*) from "CHAT_AYUDA"
select ch."ID_AYUDA", ch."ID_CATEGORIA", ch."DESCRIPCION", ch."TIPO", ch."FINAL", ch."STATUS", (SELECT COUNT(*) FROM "CHAT_AYUDA" WHERE "ID_CATEGORIA"=2 AND "TIPO"=ch."ID_AYUDA") as HIJOS from "CHAT_AYUDA" ch  where ch."ID_CATEGORIA"=2 and ch."TIPO"=0 and ch."STATUS"=1 and ch."VISUALIZAR" in(1,3)  order by ch."ID_AYUDA"

fin
psql -h $DB_HOST -d $DB_DATABASE -U $DB_USERNAME  < $0.sql
rm $0.cmd
rm $0.sql

