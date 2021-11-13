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
delete from "CHAT_OPERADORES" where "LOGIN"='jlvdantry';
Insert into "CHAT_OPERADORES" ("ID_OPERADOR","NOMBRE","PSEUDONIMO","LOGIN","PASS","INICIO","SALIDA","IP","PERFIL","STATUS","ID_INSTITUCION","HOST","NAVEGADOR") values 
((select max("ID_OPERADOR")+1 from "CHAT_OPERADORES"),'Jose Luis vasquez','D_jlv','jlvdantry','6443e3eabf4618647f62b16bb9c33cdd',to_timestamp('05/11/21 09:11:14.431000000','DD/MM/RR HH24:MI:SS.FF'),to_timestamp('05/11/21 10:28:46.901000000','DD/MM/RR HH24:MI:SS.FF'),'187.189.198.3',1,0,1,null,null);
delete from "CHAT_OPERADORES" where "LOGIN"='supervisor';
Insert into "CHAT_OPERADORES" ("ID_OPERADOR","NOMBRE","PSEUDONIMO","LOGIN","PASS","INICIO","SALIDA","IP","PERFIL","STATUS","ID_INSTITUCION","HOST","NAVEGADOR") 
values 
((select max("ID_OPERADOR")+1 from "CHAT_OPERADORES"),
	'Supervisor','D_supervisor','supervisor','6443e3eabf4618647f62b16bb9c33cdd',to_timestamp('05/11/21 09:11:14.431000000','DD/MM/RR HH24:MI:SS.FF'),to_timestamp('05/11/21 10:28:46.901000000','DD/MM/RR HH24:MI:SS.FF'),'187.189.198.3',4,0,1,null,null);
fin
psql -h $DB_HOST -d $DB_DATABASE -U $DB_USERNAME  < $0.sql
rm $0.cmd
rm $0.sql

