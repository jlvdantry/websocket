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
select * from "CHAT_USUARIOS" order by "ID_USUARIO" desc limit 2;
select * from "CHAT_ESPERA" order by "ID_ESPERA" desc limit 4;
--ALTER TABLE "CHAT_ESPERA" ALTER COLUMN "ATENCION" SET DEFAULT now();
--ALTER TABLE "CHAT_ESPERA" ALTER COLUMN "ENTRADA" SET DEFAULT now();
fin
psql -h $DB_HOST -d $DB_DATABASE -U $DB_USERNAME  < $0.sql
rm $0.cmd
rm $0.sql

