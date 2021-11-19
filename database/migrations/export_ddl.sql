########################################################
## Archivo creado  - jueves-noviembre-04-2021   
########################################################
########################################################
##  DDL for Sequence SEQ_CHAT_ID_CONVERSACION
########################################################

   DB::statement(' CREATE SEQUENCE  "SEQ_CHAT_ID_CONVERSACION"  MINVALUE 0 MAXVALUE 99999999999999 INCREMENT BY 1 START WITH 679643  
;');
########################################################
##  DDL for Sequence SEQ_CHAT_ID_ESPERA
########################################################

   DB::statement(' CREATE SEQUENCE  "SEQ_CHAT_ID_ESPERA"  MINVALUE 0 MAXVALUE 99999999999999 INCREMENT BY 1 START WITH 552381  
;');
########################################################
##  DDL for Sequence SEQ_CHAT_ID_MENSAJE
########################################################

   DB::statement(' CREATE SEQUENCE  "SEQ_CHAT_ID_MENSAJE"  MINVALUE 0 MAXVALUE 99999999999999 INCREMENT BY 1 START WITH 9107029  
;');
########################################################
##  DDL for Sequence SEQ_CHAT_ID_RECHAZO
########################################################

   DB::statement(' CREATE SEQUENCE  "SEQ_CHAT_ID_RECHAZO"  MINVALUE 0 MAXVALUE 99999999999999 INCREMENT BY 1 START WITH 25412  
;');
########################################################
##  DDL for Sequence SEQ_CHAT_ID_USUARIO
########################################################

   DB::statement(' CREATE SEQUENCE  "SEQ_CHAT_ID_USUARIO"  MINVALUE 0 MAXVALUE 99999999999999 INCREMENT BY 1 START WITH 649664  
;');
########################################################
##  DDL for Table CHAT_ASUNTO
########################################################

  DB::statement(' CREATE TABLE "CHAT_ASUNTO" ("ID_TEMA" int, "ID_SUBTEMA" int, "ID_ASUNTO" int, "DESCRIPCION" VARCHAR2(87), "STATUS" int)
;');

########################################################
##  DDL for Table CHAT_AUTORIZACION
########################################################

  DB::statement(' CREATE TABLE "CHAT_AUTORIZACION" ("TOKEN" VARCHAR2(18), "STATUS" int, "ID_CONVERSACION" int, "ID_ESPERA" int)
;');
########################################################
##  DDL for Table CHAT_AYUDA
########################################################

  DB::statement(' CREATE TABLE "CHAT_AYUDA" ("ID_AYUDA" numeric, "ID_CATEGORIA" int, "DESCRIPCION" VARCHAR2(4000), "TIPO" int, "FINAL" int, "STATUS" int, "VISUALIZAR" int)
;');
########################################################
##  DDL for Table CHAT_CALIDAD
########################################################

  DB::statement(' CREATE TABLE "CHAT_CALIDAD" ("ID_CONVERSACION" int, "ID_TEMA" int, "ID_SUBTEMA" int, "ID_ASUNTO" int, "RESPUESTA" int, "COMENTARIO" int, "FECHA" DATE, "OPERADOR" int, "INICIO" VARCHAR2(20), "FIN" VARCHAR2(20), "DURACION" VARCHAR2(20))
;');
########################################################
##  DDL for Table CHAT_CATEGORIAS
########################################################

  DB::statement(' CREATE TABLE "CHAT_CATEGORIAS" ("ID_CATEGORIA" int, "DESCRIPCION" VARCHAR2(100), "STATUS" int, "ID_INSTITUCION" int)
;');
########################################################
##  DDL for Table CHAT_CONVERSACIONES
########################################################

  DB::statement(' CREATE TABLE "CHAT_CONVERSACIONES" ("ID_CONVERSACION" numeric, "ID_USUARIO" numeric, "ID_OPERADOR" int, "INICIO" TIMESTAMP (6), "FIN" TIMESTAMP (6), "MSG_OP" TIMESTAMP (6), "MSG_US" TIMESTAMP (6), "IP" VARCHAR2(20), "NAVEGADOR" VARCHAR2(20), "VERSION" VARCHAR2(20), "SO" VARCHAR2(20), "DISPOSITIVO" int, "VENTANA" int, "ID_ESPERA" numeric, "TEMA" int, "ID_INSTITUCION" int, "TRANSFER" int)
;');
########################################################
##  DDL for Table CHAT_ESPERA
########################################################

  DB::statement(' CREATE TABLE "CHAT_ESPERA" ("ID_ESPERA" numeric, "NOMBRE" VARCHAR2(250), "CORREO" VARCHAR2(50), "TEMA" int, "IP" VARCHAR2(20), "ENTRADA" TIMESTAMP (6), "ATENCION" TIMESTAMP (6), "STATUS" int, "ID_INSTITUCION" int)
;');
########################################################
##  DDL for Table CHAT_INSTITUCIONES
########################################################

  DB::statement(' CREATE TABLE "CHAT_INSTITUCIONES" ("ID_INSTITUCION" int, "DESCRIPCION" VARCHAR2(100), "STATUS" int)
;');
########################################################
##  DDL for Table CHAT_MENSAJES
########################################################

  DB::statement(' CREATE TABLE "CHAT_MENSAJES" ("ID_MENSAJE" numeric, "ID_CONVERSACION" numeric, "FROMM" VARCHAR2(50), "TOO" VARCHAR2(50), "MESSAGE" VARCHAR2(2500), "SENT" TIMESTAMP (6), "RECD" int, "RECEIVED" TIMESTAMP (6))
;');
########################################################
##  DDL for Table CHAT_MENSAJES_NEW
########################################################

  DB::statement(' CREATE TABLE "CHAT_MENSAJES_NEW" ("ID_MENSAJE_NEW" numeric, "ID_CONVERSACION" numeric, "FROMM" VARCHAR2(50), "TOO" VARCHAR2(50), "MESSAGE" VARCHAR2(2500), "SENT" TIMESTAMP (6), "RECD" int, "RECEIVED" TIMESTAMP (6))
;');
########################################################
##  DDL for Table CHAT_OPERADORES
########################################################

  DB::statement(' CREATE TABLE "CHAT_OPERADORES" ("ID_OPERADOR" int, "NOMBRE" VARCHAR2(250), "PSEUDONIMO" VARCHAR2(20), "LOGIN" VARCHAR2(20), "PASS" VARCHAR2(32), "INICIO" TIMESTAMP (6), "SALIDA" TIMESTAMP (6), "IP" VARCHAR2(20), "PERFIL" int, "STATUS" int, "ID_INSTITUCION" int, "HOST" VARCHAR2(20), "NAVEGADOR" VARCHAR2(30))
;');
########################################################
##  DDL for Table CHAT_RECHAZOS
########################################################

  DB::statement(' CREATE TABLE "CHAT_RECHAZOS" ("ID_RECHAZO" numeric, "NOMBRE" VARCHAR2(250), "CORREO" VARCHAR2(50), "IP" VARCHAR2(20), "FECHA_HORA" TIMESTAMP (6))
;');
########################################################
##  DDL for Table CHAT_SUBTEMA
########################################################

  DB::statement(' CREATE TABLE "CHAT_SUBTEMA" ("ID_TEMA" int, "ID_SUBTEMA" int, "DESCRIPCION" VARCHAR2(68), "STATUS" int)
;');
########################################################
##  DDL for Table CHAT_TEMA
########################################################

  DB::statement(' CREATE TABLE "CHAT_TEMA" ("ID_TEMA" int, "DESCRIPCION" VARCHAR2(26), "STATUS" int, "ID_INSTITUCION" int)
;');
########################################################
##  DDL for Table CHAT_TOTALES
########################################################

  DB::statement(' CREATE TABLE "CHAT_TOTALES" ("FECHA" VARCHAR2(10), "HORA" VARCHAR2(2), "CONVERSACION" int, "RECHAZO" int, "ID_INSTITUCION" int)
;');
########################################################
##  DDL for Table CHAT_USUARIOS
########################################################

v
q
  DB::statement(' CREATE TABLE "CHAT_USUARIOS" ("ID_USUARIO" numeric, "NOMBRE" VARCHAR2(100), "CORREO" VARCHAR2(50))
;');
########################################################
##  DDL for Table TABLE1
########################################################

  DB::statement(' CREATE TABLE "TABLE1" ("COLUMN1" VARCHAR2(20))
;');
########################################################
##  DDL for View V_CHAT_ESTADISTICAS
########################################################

  DB::statement(' CREATE OR REPLACE VIEW "V_CHAT_ESTADISTICAS" ("CHAT", "FECHA", "TOTAL") AS SELECT inst.DESCRIPCION as CHAT, TO_CHAR(cnv.INICIO,"YYYY-MM-DD") AS FECHA, COUNT(*) AS TOTAL
FROM CHAT_CONVERSACIONES cnv
INNER JOIN CHAT_INSTITUCIONES inst ON cnv.ID_INSTITUCION = inst.ID_INSTITUCION
GROUP BY inst.DESCRIPCION, TO_CHAR(cnv.INICIO,"YYYY-MM-DD")
;');
########################################################
##  DDL for View V_CHAT_MONITOREO
########################################################

  DB::statement(' CREATE OR REPLACE VIEW "V_CHAT_MONITOREO" ("CVE", "CHAT", "TOTAL", "ABANDONO", "ESPERA", "DISPONIBLE", "PAUSA", "CONVERSACION", "OPERADORES", "SUPERVISORES") AS SELECT CVE, CHAT, SUM(CONVERSACIONES) AS TOTAL, SUM(ABANDONO) AS ABANDONO, SUM(ESPERA) AS ESPERA, SUM(DISPONIBLE) AS DISPONIBLE, SUM(PAUSA) AS PAUSA, SUM(OCUPADO) AS CONVERSACION, SUM(OPERADORES) AS OPERADORES, SUM(SUPERVISORES) AS SUPERVISORES
FROM(
  SELECT inst.ID_INSTITUCION as CVE, inst.DESCRIPCION AS CHAT, COUNT(*) AS CONVERSACIONES, 0 AS ABANDONO, 0 AS ESPERA, 0 AS DISPONIBLE, 0 AS PAUSA, 0 AS OCUPADO, 0 AS OPERADORES, 0 AS SUPERVISORES
  FROM CHAT_CONVERSACIONES cht
  INNER JOIN CHAT_INSTITUCIONES inst ON inst.ID_INSTITUCION = cht.ID_INSTITUCION
  WHERE TO_CHAR(cht.FIN,"YYYY-MM-DD")=TO_CHAR(sysdate,"YYYY-MM-DD")
  GROUP BY inst.ID_INSTITUCION, inst.DESCRIPCION
  UNION ALL
  SELECT inst.ID_INSTITUCION, inst.DESCRIPCION, 0, COUNT(*), 0, 0, 0, 0, 0, 0
  FROM CHAT_ESPERA chte
  INNER JOIN CHAT_INSTITUCIONES inst ON inst.ID_INSTITUCION = chte.ID_INSTITUCION
  WHERE TO_CHAR(chte.ENTRADA,"YYYY-MM-DD")=TO_CHAR(sysdate,"YYYY-MM-DD") AND chte.STATUS=0
  GROUP BY inst.ID_INSTITUCION, inst.DESCRIPCION
  UNION ALL
  SELECT inst.ID_INSTITUCION, inst.DESCRIPCION, 0, 0, COUNT(*), 0, 0, 0, 0, 0
  FROM CHAT_ESPERA chte
  INNER JOIN CHAT_INSTITUCIONES inst ON inst.ID_INSTITUCION = chte.ID_INSTITUCION
  WHERE TO_CHAR(chte.ENTRADA,"YYYY-MM-DD")=TO_CHAR(sysdate,"YYYY-MM-DD") AND chte.STATUS=1
  GROUP BY inst.ID_INSTITUCION, inst.DESCRIPCION
  UNION ALL
  SELECT inst.ID_INSTITUCION, inst.DESCRIPCION, 0, 0, 0, COUNT(*), 0, 0, 0, 0
  FROM CHAT_OPERADORES chto
  INNER JOIN CHAT_INSTITUCIONES inst ON inst.ID_INSTITUCION = chto.ID_INSTITUCION
  WHERE chto.STATUS=1 and chto.perfil=1
  GROUP BY inst.ID_INSTITUCION, inst.DESCRIPCION
  UNION ALL
  SELECT inst.ID_INSTITUCION, inst.DESCRIPCION, 0, 0, 0, 0, COUNT(*), 0, 0, 0
  FROM CHAT_OPERADORES chto
  INNER JOIN CHAT_INSTITUCIONES inst ON inst.ID_INSTITUCION = chto.ID_INSTITUCION
  WHERE chto.STATUS=3 and chto.perfil=1
  GROUP BY inst.ID_INSTITUCION, inst.DESCRIPCION
  UNION ALL
  SELECT inst.ID_INSTITUCION, inst.DESCRIPCION, 0, 0, 0, 0, 0, COUNT(*),0, 0
  FROM CHAT_OPERADORES chto
  INNER JOIN CHAT_INSTITUCIONES inst ON inst.ID_INSTITUCION = chto.ID_INSTITUCION
  WHERE chto.STATUS=2 and chto.perfil=1
  GROUP BY inst.ID_INSTITUCION, inst.DESCRIPCION
  UNION ALL
  SELECT inst.ID_INSTITUCION, inst.DESCRIPCION, 0, 0, 0, 0, 0, 0, COUNT(*), 0
  FROM CHAT_OPERADORES chto
  INNER JOIN CHAT_INSTITUCIONES inst ON inst.ID_INSTITUCION = chto.ID_INSTITUCION
  WHERE chto.STATUS in (1,2,3) and chto.perfil=1
  GROUP BY inst.ID_INSTITUCION, inst.DESCRIPCION
  UNION ALL
  SELECT inst.ID_INSTITUCION, inst.DESCRIPCION, 0, 0, 0, 0, 0, 0, 0, COUNT(*)
  FROM CHAT_OPERADORES chto
  INNER JOIN CHAT_INSTITUCIONES inst ON inst.ID_INSTITUCION = chto.ID_INSTITUCION
  WHERE chto.STATUS=1 and chto.perfil=2
  GROUP BY inst.ID_INSTITUCION, inst.DESCRIPCION  
)
GROUP BY CVE, CHAT
ORDER BY 1
;');
########################################################
##  DDL for View V_CHAT_SIRILO
########################################################

  DB::statement(' CREATE OR REPLACE VIEW "V_CHAT_SIRILO" ("AREA", "SERVICIO", "OPCION1", "OPCION2", "FECHA", "MEDIO", "USUARIO", "ID_LLAMADA") 
AS SELECT 'Chat' AS AREA, ins.DESCRIPCION AS SERVICIO, '' AS OPCION1, '' AS OPCION2, INICIO AS FECHA, 'Chat' AS MEDIO, 'Chat' AS USUARIO, '0' AS ID_LLAMADA
FROM CHAT_LOCATEL.CHAT_CONVERSACIONES tl
INNER JOIN CHAT_LOCATEL.CHAT_INSTITUCIONES ins ON tl.ID_INSTITUCION = ins.ID_INSTITUCION
;');
########################################################
##  DDL for Index OPERADORES_PK
########################################################

  DB::statement(' CREATE UNIQUE INDEX "OPERADORES_PK" ON "CHAT_OPERADORES" ("ID_OPERADOR")
;');
########################################################
##  DDL for Index CHAT_TOTALES_PK
########################################################

  DB::statement(' CREATE UNIQUE INDEX "CHAT_TOTALES_PK" ON "CHAT_TOTALES" ("FECHA", "HORA", "ID_INSTITUCION")
;');
########################################################
##  DDL for Index CHAT_TEMA_PK
########################################################

  DB::statement(' CREATE UNIQUE INDEX "CHAT_TEMA_PK" ON "CHAT_TEMA" ("ID_TEMA")
;');
########################################################
##  DDL for Index CHAT_PK
########################################################

  DB::statement(' CREATE UNIQUE INDEX "CHAT_PK" ON "CHAT_MENSAJES" ("ID_MENSAJE")
;');
########################################################
##  DDL for Index CHAT_MENSAJES_NEW_INDEX2
########################################################

  DB::statement(' CREATE INDEX "CHAT_MENSAJES_NEW_INDEX2" ON "CHAT_MENSAJES_NEW" ("TOO", "RECD", "ID_CONVERSACION" DESC, "SENT")
;');
########################################################
##  DDL for Index CHAT_MENSAJES_INDEX2
########################################################

  DB::statement(' CREATE INDEX "CHAT_MENSAJES_INDEX2" ON "CHAT_MENSAJES" ("TOO", "RECD", "ID_CONVERSACION" DESC, "SENT")
;');
########################################################
##  DDL for Index CHAT_MENSAJES_NEW_PK
########################################################

  DB::statement(' CREATE UNIQUE INDEX "CHAT_MENSAJES_NEW_PK" ON "CHAT_MENSAJES_NEW" ("ID_MENSAJE_NEW")
;');
########################################################
##  DDL for Index CHAT_SUBTEMA_PK
########################################################

  DB::statement(' CREATE UNIQUE INDEX "CHAT_SUBTEMA_PK" ON "CHAT_SUBTEMA" ("ID_SUBTEMA")
;');
########################################################
##  DDL for Index USUARIOS_PK
########################################################

  DB::statement(' CREATE UNIQUE INDEX "USUARIOS_PK" ON "CHAT_USUARIOS" ("ID_USUARIO")
;');
########################################################
##  DDL for Index CHAT_AUTORIZACION_PK
########################################################

  DB::statement(' CREATE UNIQUE INDEX "CHAT_AUTORIZACION_PK" ON "CHAT_AUTORIZACION" ("TOKEN")
;');
########################################################
##  DDL for Index CHAT_MENSAJES_INDEX3
########################################################

  DB::statement(' CREATE INDEX "CHAT_MENSAJES_INDEX3" ON "CHAT_MENSAJES" ("ID_CONVERSACION" DESC)
;');
########################################################
##  DDL for Index CHAT_MENSAJES_NEW_INDEX1
########################################################

  DB::statement(' CREATE INDEX "CHAT_MENSAJES_NEW_INDEX1" ON "CHAT_MENSAJES_NEW" ("TOO", "FROMM")
;');
########################################################
##  DDL for Index AYUDA_PK
########################################################

  DB::statement(' CREATE UNIQUE INDEX "AYUDA_PK" ON "CHAT_AYUDA" ("ID_AYUDA", "ID_CATEGORIA")
;');
########################################################
##  DDL for Index CHAT_MENSAJES_INDEX1
########################################################

  DB::statement(' CREATE INDEX "CHAT_MENSAJES_INDEX1" ON "CHAT_MENSAJES" ("TOO", "FROMM")
;');
########################################################
##  DDL for Index CHAT_MENSAJES_NEW_INDEX3
########################################################

  DB::statement(' CREATE INDEX "CHAT_MENSAJES_NEW_INDEX3" ON "CHAT_MENSAJES_NEW" ("ID_CONVERSACION" DESC)
;');
########################################################
##  DDL for Index CHAT_ASUNTO_PK
########################################################

  DB::statement(' CREATE UNIQUE INDEX "CHAT_ASUNTO_PK" ON "CHAT_ASUNTO" ("ID_ASUNTO")
;');
########################################################
##  DDL for Index CHAT_CALIDAD_PK
########################################################

  DB::statement(' CREATE UNIQUE INDEX "CHAT_CALIDAD_PK" ON "CHAT_CALIDAD" ("ID_CONVERSACION")
;');
########################################################
##  DDL for Index CATEGORIAS_PK
########################################################

  DB::statement(' CREATE UNIQUE INDEX "CATEGORIAS_PK" ON "CHAT_CATEGORIAS" ("ID_CATEGORIA")
;');
########################################################
##  DDL for Index CHAT_ESPERA_PK
########################################################

  DB::statement(' CREATE UNIQUE INDEX "CHAT_ESPERA_PK" ON "CHAT_ESPERA" ("ID_ESPERA")
;');
########################################################
##  DDL for Index CHAT_INSTITUCIONES_PK
########################################################

  DB::statement(' CREATE UNIQUE INDEX "CHAT_INSTITUCIONES_PK" ON "CHAT_INSTITUCIONES" ("ID_INSTITUCION")
;');
########################################################
##  DDL for Index RECHAZOS_PK
########################################################

  DB::statement(' CREATE UNIQUE INDEX "RECHAZOS_PK" ON "CHAT_RECHAZOS" ("ID_RECHAZO")
;');
########################################################
##  DDL for Index CONVERSACIONES_PK
########################################################

  DB::statement(' CREATE UNIQUE INDEX "CONVERSACIONES_PK" ON "CHAT_CONVERSACIONES" ("ID_CONVERSACION")
;');
########################################################
##  Constraints for Table CHAT_RECHAZOS
########################################################

  DB::statement(' ALTER TABLE "CHAT_RECHAZOS" ADD CONSTRAINT "RECHAZOS_PK" PRIMARY KEY ("ID_RECHAZO") USING INDEX
;'); 
  DB::statement(' ALTER TABLE "CHAT_RECHAZOS" MODIFY ("ID_RECHAZO" NOT NULL ENABLE)
;');
########################################################
##  Constraints for Table CHAT_MENSAJES_NEW
########################################################

  DB::statement(' ALTER TABLE "CHAT_MENSAJES_NEW" ADD CONSTRAINT "CHAT_MENSAJES_NEW_PK" PRIMARY KEY ("ID_MENSAJE_NEW") USING INDEX 
;');
  DB::statement(' ALTER TABLE "CHAT_MENSAJES_NEW" MODIFY ("ID_MENSAJE_NEW" NOT NULL ENABLE)
;');
########################################################
##  Constraints for Table CHAT_ASUNTO
########################################################

  DB::statement(' ALTER TABLE "CHAT_ASUNTO" ADD CONSTRAINT "CHAT_ASUNTO_PK" PRIMARY KEY ("ID_ASUNTO") USING INDEX 
;');
  DB::statement(' ALTER TABLE "CHAT_ASUNTO" MODIFY ("ID_ASUNTO" NOT NULL ENABLE)
;');
########################################################
##  Constraints for Table CHAT_SUBTEMA
########################################################

  DB::statement(' ALTER TABLE "CHAT_SUBTEMA" ADD CONSTRAINT "CHAT_SUBTEMA_PK" PRIMARY KEY ("ID_SUBTEMA") USING INDEX 
;');
  DB::statement(' ALTER TABLE "CHAT_SUBTEMA" MODIFY ("ID_SUBTEMA" NOT NULL ENABLE)
;');
########################################################
##  Constraints for Table CHAT_INSTITUCIONES
########################################################

  DB::statement(' ALTER TABLE "CHAT_INSTITUCIONES" ADD CONSTRAINT "CHAT_INSTITUCIONES_PK" PRIMARY KEY ("ID_INSTITUCION") USING INDEX 
;');
  DB::statement(' ALTER TABLE "CHAT_INSTITUCIONES" MODIFY ("ID_INSTITUCION" NOT NULL ENABLE) 
;');
########################################################
##  Constraints for Table CHAT_CONVERSACIONES
########################################################

  DB::statement(' ALTER TABLE "CHAT_CONVERSACIONES" ADD CONSTRAINT "CONVERSACIONES_PK" PRIMARY KEY ("ID_CONVERSACION") USING INDEX 
;');
  DB::statement(' ALTER TABLE "CHAT_CONVERSACIONES" MODIFY ("ID_CONVERSACION" NOT NULL ENABLE)
;');
########################################################
##  Constraints for Table CHAT_TOTALES
########################################################

  DB::statement(' ALTER TABLE "CHAT_TOTALES" ADD CONSTRAINT "CHAT_TOTALES_PK" PRIMARY KEY ("FECHA", "HORA", "ID_INSTITUCION") USING INDEX 
;');
  DB::statement(' ALTER TABLE "CHAT_TOTALES" MODIFY ("ID_INSTITUCION" NOT NULL ENABLE) 
;');
  DB::statement(' ALTER TABLE "CHAT_TOTALES" MODIFY ("HORA" NOT NULL ENABLE) 
;');
  DB::statement(' ALTER TABLE "CHAT_TOTALES" MODIFY ("FECHA" NOT NULL ENABLE)
;');
########################################################
##  Constraints for Table CHAT_CALIDAD
########################################################

  DB::statement(' ALTER TABLE "CHAT_CALIDAD" ADD CONSTRAINT "CHAT_CALIDAD_PK" PRIMARY KEY ("ID_CONVERSACION") USING INDEX 
;');
  DB::statement(' ALTER TABLE "CHAT_CALIDAD" MODIFY ("ID_CONVERSACION" NOT NULL ENABLE)
;');
########################################################
##  Constraints for Table CHAT_MENSAJES
########################################################

  DB::statement(' ALTER TABLE "CHAT_MENSAJES" ADD CONSTRAINT "CHAT_PK" PRIMARY KEY ("ID_MENSAJE") USING INDEX 
;');
  DB::statement(' ALTER TABLE "CHAT_MENSAJES" MODIFY ("ID_MENSAJE" NOT NULL ENABLE)
;');
########################################################
##  Constraints for Table CHAT_OPERADORES
########################################################

  DB::statement(' ALTER TABLE "CHAT_OPERADORES" ADD CONSTRAINT "OPERADORES_PK" PRIMARY KEY ("ID_OPERADOR") USING INDEX 
;');
  DB::statement(' ALTER TABLE "CHAT_OPERADORES" MODIFY ("ID_OPERADOR" NOT NULL ENABLE)
;');
########################################################
##  Constraints for Table CHAT_CATEGORIAS
########################################################

  DB::statement(' ALTER TABLE "CHAT_CATEGORIAS" ADD CONSTRAINT "CATEGORIAS_PK" PRIMARY KEY ("ID_CATEGORIA") USING INDEX 
;');
  DB::statement(' ALTER TABLE "CHAT_CATEGORIAS" MODIFY ("ID_CATEGORIA" NOT NULL ENABLE)
;');
########################################################
##  Constraints for Table CHAT_ESPERA
########################################################

  DB::statement(' ALTER TABLE "CHAT_ESPERA" ADD CONSTRAINT "CHAT_ESPERA_PK" PRIMARY KEY ("ID_ESPERA") USING INDEX 
;');
  DB::statement(' ALTER TABLE "CHAT_ESPERA" MODIFY ("ID_ESPERA" NOT NULL ENABLE)
;');
########################################################
##  Constraints for Table CHAT_TEMA
########################################################

  DB::statement(' ALTER TABLE "CHAT_TEMA" ADD CONSTRAINT "CHAT_TEMA_PK" PRIMARY KEY ("ID_TEMA") USING INDEX 
;');
  DB::statement(' ALTER TABLE "CHAT_TEMA" MODIFY ("ID_TEMA" NOT NULL ENABLE)
;');
########################################################
##  Constraints for Table CHAT_AUTORIZACION
########################################################

  DB::statement(' ALTER TABLE "CHAT_AUTORIZACION" ADD CONSTRAINT "CHAT_AUTORIZACION_PK" PRIMARY KEY ("TOKEN") USING INDEX 
;');
  DB::statement(' ALTER TABLE "CHAT_AUTORIZACION" MODIFY ("TOKEN" NOT NULL ENABLE)
;');
########################################################
##  Constraints for Table CHAT_USUARIOS
########################################################

  DB::statement(' ALTER TABLE "CHAT_USUARIOS" ADD CONSTRAINT "USUARIOS_PK" PRIMARY KEY ("ID_USUARIO") USING INDEX 
;');
  DB::statement(' ALTER TABLE "CHAT_USUARIOS" MODIFY ("ID_USUARIO" NOT NULL ENABLE)
;');
########################################################
##  Constraints for Table CHAT_AYUDA
########################################################

  DB::statement(' ALTER TABLE "CHAT_AYUDA" ADD CONSTRAINT "AYUDA_PK" PRIMARY KEY ("ID_AYUDA", "ID_CATEGORIA") USING INDEX 
;');
  DB::statement(' ALTER TABLE "CHAT_AYUDA" MODIFY ("ID_CATEGORIA" NOT NULL ENABLE)
;');
  DB::statement(' ALTER TABLE "CHAT_AYUDA" MODIFY ("ID_AYUDA" NOT NULL ENABLE)
;');
########################################################
##  Ref Constraints for Table CHAT_ASUNTO
########################################################

  DB::statement(' ALTER TABLE "CHAT_ASUNTO" ADD CONSTRAINT "CHAT_ASUNTO_FK1" FOREIGN KEY ("ID_TEMA") REFERENCES "CHAT_TEMA" ("ID_TEMA") 
;');
  DB::statement(' ALTER TABLE "CHAT_ASUNTO" ADD CONSTRAINT "CHAT_ASUNTO_FK2" FOREIGN KEY ("ID_SUBTEMA") REFERENCES "CHAT_SUBTEMA" ("ID_SUBTEMA") 
;');
########################################################
##  Ref Constraints for Table CHAT_AYUDA
########################################################

  DB::statement(' ALTER TABLE "CHAT_AYUDA" ADD CONSTRAINT "CHAT_AYUDA_FK1" FOREIGN KEY ("ID_CATEGORIA") REFERENCES "CHAT_CATEGORIAS" ("ID_CATEGORIA") 
;');
########################################################
##  Ref Constraints for Table CHAT_CALIDAD
########################################################

  DB::statement(' ALTER TABLE "CHAT_CALIDAD" ADD CONSTRAINT "CHAT_CALIDAD_FK1" FOREIGN KEY ("ID_TEMA") REFERENCES "CHAT_TEMA" ("ID_TEMA") 
;');
  DB::statement(' ALTER TABLE "CHAT_CALIDAD" ADD CONSTRAINT "CHAT_CALIDAD_FK2" FOREIGN KEY ("ID_SUBTEMA") REFERENCES "CHAT_SUBTEMA" ("ID_SUBTEMA") 
;');
  DB::statement(' ALTER TABLE "CHAT_CALIDAD" ADD CONSTRAINT "CHAT_CALIDAD_FK3" FOREIGN KEY ("ID_ASUNTO") REFERENCES "CHAT_ASUNTO" ("ID_ASUNTO") 
;');
  DB::statement(' ALTER TABLE "CHAT_CALIDAD" ADD CONSTRAINT "CHAT_CALIDAD_FK4" FOREIGN KEY ("ID_CONVERSACION") REFERENCES "CHAT_CONVERSACIONES" ("ID_CONVERSACION") 
;');
########################################################
##  Ref Constraints for Table CHAT_CONVERSACIONES
########################################################

  DB::statement(' ALTER TABLE "CHAT_CONVERSACIONES" ADD CONSTRAINT "CHAT_CONVERSACIONES_FK1" FOREIGN KEY ("ID_OPERADOR") REFERENCES "CHAT_OPERADORES" ("ID_OPERADOR") 
;');
  DB::statement(' ALTER TABLE "CHAT_CONVERSACIONES" ADD CONSTRAINT "CHAT_CONVERSACIONES_FK2" FOREIGN KEY ("ID_USUARIO") REFERENCES "CHAT_USUARIOS" ("ID_USUARIO") 
;');
  DB::statement(' ALTER TABLE "CHAT_CONVERSACIONES" ADD CONSTRAINT "CHAT_CONVERSACIONES_FK3" FOREIGN KEY ("ID_ESPERA") REFERENCES "CHAT_ESPERA" ("ID_ESPERA") 
;');
########################################################
##  Ref Constraints for Table CHAT_MENSAJES
########################################################

  DB::statement(' ALTER TABLE "CHAT_MENSAJES" ADD CONSTRAINT "CHAT_MENSAJES_FK1" FOREIGN KEY ("ID_CONVERSACION") REFERENCES "CHAT_CONVERSACIONES" ("ID_CONVERSACION") 
;');
########################################################
##  Ref Constraints for Table CHAT_MENSAJES_NEW
########################################################

  DB::statement(' ALTER TABLE "CHAT_MENSAJES_NEW" ADD CONSTRAINT "CHAT_MENSAJES_NEW_FK1" FOREIGN KEY ("ID_CONVERSACION") REFERENCES "CHAT_CONVERSACIONES" ("ID_CONVERSACION") 
;');
########################################################
##  Ref Constraints for Table CHAT_SUBTEMA
########################################################

  DB::statement(' ALTER TABLE "CHAT_SUBTEMA" ADD CONSTRAINT "CHAT_SUBTEMA_FK1" FOREIGN KEY ("ID_TEMA") REFERENCES "CHAT_TEMA" ("ID_TEMA") ;');
  DB::statement('ALTER TABLE "CHAT_ESPERA" ALTER COLUMN "ATENCION" SET DEFAULT now();');
  DB::statement('ALTER TABLE "CHAT_ESPERA" ALTER COLUMN "ENTRADA" SET DEFAULT now();');
