<?php
	error_reporting(1);
	$ruta = dirname(__FILE__);
	include_once("adodb/adodb-errorhandler.inc.php");
	$ruta = dirname(__FILE__)."/logs/error.log";
	define('ADODB_ERROR_LOG_TYPE', 3);
	define('ADODB_ERROR_LOG_DEST', $ruta);
                                $ADODB_QUOTE_FIELDNAMES = 'UPPER';

	class bada 
	{
		public function Conectar(){
			$cstr ="(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.250.109.44)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = XE)))";
			$db = ADONewConnection('postgres');
			$db->charSet = 'AL32UTF8';
			@$db->Connect('localhost', 'postgres', '888aDantryR','chat');
                        return $db;
		}

                public function Creausuario($db,$user){
                                $sql='insert into "CHAT_USUARIOS" ("NOMBRE","CORREO") values (\''.$user->nombre.'\',\''.$user->correo.'\')';
                                try {
                                        $rs=false;
					@$db->execute($sql);
					$sql='select lastval() as seq';
					$rs=@$db->execute($sql);
                                        milog(__METHOD__." entro ".print_r(gettype($rs),true));
                                        if (gettype($rs)!='boolean') {
						if ($rs->RecordCount()>0) {
						     return $rs->fields['seq'];
						}
                                        } else { return false; }
                                } catch (Exception $e) {
					     milog('Excepción capturada: ',  $e->getMessage(),);
                                            return false;
					}
                                return false;
                }

                public function CreaListaEspera($db,$user){
                                $sql='insert into "CHAT_ESPERA" ("NOMBRE","CORREO","STATUS","ID_INSTITUCION") values (\''.$user->nombre.'\',\''.$user->correo.
                                               '\',1,'.$user->inst.')';
                                try {
                                        $rs=false;
					@$db->execute($sql);
					$sql='select lastval() as seq';
					$rs=@$db->execute($sql);
                                        milog(__METHOD__." entro ".print_r(gettype($rs),true));
                                        if (gettype($rs)!='boolean') {
						if ($rs->RecordCount()>0) {
						     return $rs->fields['seq'];
						}
                                        } else { return false; }
                                } catch (Exception $e) {
					    milog('Excepción capturada: ',  $e->getMessage(),);
                                            return false;
					}
                                return false;
                }

                public function cierraConversacion($user,$db){
                                $sql_ope='update "CHAT_OPERADORES" set  "STATUS"='.OPE_ENPAUSA.' where "ID_OPERADOR"='.$user->idOpe.";";
                                $sql='update "CHAT_CONVERSACIONES" set  "FIN"=localtimestamp where "ID_CONVERSACION"='.$user->idConv;
                                try {
                                        $rs=false;
					if (@$db->Execute($sql_ope.$sql) === false) {
					 milog(__METHOD__.$db->ErrorMsg());
					}
                                } catch (Exception $e) {
                                            milog(__METHOD__.' Excepción capturada: ',  $e->getMessage(),);
                                            return false;
                                        }
                                return false;
                }

                public function OperadorIniciaSesion($user,$db){
                                $sql='update "CHAT_OPERADORES" set  "STATUS"='.OPE_ENPAUSA.' where "ID_OPERADOR"='.$user->idOpe;
                                try {
                                        $rs=false;
                                        if (@$db->Execute($sql) === false) {
                                         milog(__METHOD__.$db->ErrorMsg());
                                        }
                                } catch (Exception $e) {
                                            milog(__METHOD__.' Excepción capturada: '.  $e->getMessage());
                                            return false;
                                        }
                                return false;
                }

                public function OperadorTerminaSesion($user,$db){
                                $sql='update "CHAT_OPERADORES" set  "STATUS"='.OPE_LOGOUT.' where "ID_OPERADOR"='.$user->idOpe;
                                try {
                                        $rs=false;
                                        if (@$db->Execute($sql) === false) {
                                         milog(__METHOD__.$db->ErrorMsg());
                                        }
                                } catch (Exception $e) {
                                            milog(__METHOD__.' Excepción capturada: '.  $e->getMessage());
                                            return false;
                                        }
                                return false;
                }

                public function OperadorEnEspera($user,$db){
                                $sql='update "CHAT_OPERADORES" set  "STATUS"='.LISTAESPERA.' where "ID_OPERADOR"='.$user->idOpe;
                                try {
                                        $rs=false;
                                        if (@$db->Execute($sql) === false) {
                                         milog(__METHOD__.$db->ErrorMsg());
                                        }
                                } catch (Exception $e) {
                                            milog(__METHOD__.' Excepción capturada: '.  $e->getMessage());
                                            return false;
                                        }
                                return false;
                }




                public function MensajeRecibido($user,$db){
                                $sql='update "CHAT_MENSAJES_NEW" set  "RECEIVED"=localtimestamp, "RECD"=1 where "ID_MENSAJE_NEW"='.$user->idMen;
                                try {
                                        $rs=false;
                                        if (@$db->Execute($sql) === false) {
                                         milog(__METHOD__.$db->ErrorMsg());
                                        }
                                } catch (Exception $e) {
                                            milog(__METHOD__.' Excepción capturada: ',  $e->getMessage());
                                            return false;
                                        }
                                return false;
                }


                public function EnConversacion($opera,$ciu,$db){
                                try {
                                        if ($ciu->id_espera!="") {
						$sql='update "CHAT_ESPERA" set "STATUS"=2, "ATENCION"=localtimestamp where "ID_ESPERA"='.$ciu->id_espera;
						$rs=false;
						if (@$db->Execute($sql) === false) {
						 milog(__METHOD__.$db->ErrorMsg());
						}
                                        }
                                        $sql_ope='update "CHAT_OPERADORES" set  "STATUS"='.ENCONVERSACION.' where "ID_OPERADOR"='.$opera->idOpe.";";
					$sql='insert into "CHAT_CONVERSACIONES" ("ID_USUARIO","ID_OPERADOR","ID_ESPERA","ID_INSTITUCION") values ('.
					      $ciu->id.','.$opera->idOpe.','.($ciu->id_espera!='' ? $ciu->id_espera : 'null').','.$ciu->inst.');';
                                        $rs=false;
                                        @$db->execute($sql_ope.$sql);
                                        $sql='select lastval() as seq';
                                        $rs=@$db->execute($sql);
                                        milog(__METHOD__." entro ".print_r(gettype($rs),true));
                                        if (gettype($rs)!='boolean') {
                                                if ($rs->RecordCount()>0) {
                                                     return $rs->fields['seq'];
                                                }
                                        } else { return false; }

                                } catch (Exception $e) {
                                            milog('Excepción capturada: ',  $e->getMessage(),);
                                            return false;
                                        }
                                return false;
                }

                public function enviaMensaje($envia,$recibe,$db,$men){
                                try {
                                        $sql='insert into "CHAT_MENSAJES_NEW" ("ID_CONVERSACION","FROMM","TOO","MESSAGE") values ('.
                                              $envia->idConv.',\''.$envia->nombre.'\',\''.$recibe->nombre.'\',\''.$men.'\');';
                                        $rs=false;
                                        @$db->execute($sql);
                                        $sql='select lastval() as seq';
                                        $rs=@$db->execute($sql);
                                        milog(__METHOD__." entro ".print_r(gettype($rs),true));
                                        if (gettype($rs)!='boolean') {
                                                if ($rs->RecordCount()>0) {
                                                     return $rs->fields['seq'];
                                                }
                                        } else { return false; }

                                } catch (Exception $e) {
                                            milog('Excepción capturada: ',  $e->getMessage(),);
                                            return false;
                                        }
                                return false;
                }



		public function Consultar($obj, $campos, $tabla, $criterios, $orden, $extra=""){
			if($criterios!="")
				$criterios=" where ".$criterios;

			if($orden!="")
				$orden=" order by ".$orden;


			$ADODB_COUNTRECS = true;
			$ADODB_LANG='es';
			$sql = "select " .$campos. " from " .$tabla. " " .$criterios. " " .$orden." ". $extra;
			$db = $obj->Conectar();
			$rs = $db->Execute($sql);
			$db->Close();
			return $rs;
		}

		public function Actualizar($obj, $datos, $tabla, $criterios){
			if($criterios!="") $criterios=" where ".$criterios;
			$sql = "UPDATE " .$tabla. " SET " .$datos. " " .$criterios;
			$db = $obj->Conectar();
			return $db->_query($sql);
		}

		////////////////// Funciones de (des)fragmentacion

				public function chkFrag($obj){
					//$ADODB_COUNTRECS = true;
					//$ADODB_LANG='es';
					$sql = "select OBJECT_SCHEMA_NAME(ips.object_id) AS schema_name,
		       				OBJECT_NAME(ips.object_id) AS object_name,
		       				i.name AS index_name,
		       				i.type_desc AS index_type, ips.avg_fragmentation_in_percent,
		       				ips.avg_page_space_used_in_percent,
		       				ips.page_count,
		       				ips.alloc_unit_type_desc
							FROM sys.dm_db_index_physical_stats(DB_ID(), default, default, default, 'SAMPLED')AS ips
							INNER JOIN sys.indexes AS i
							ON ips.object_id = i.object_id
		   					AND
		   					ips.index_id = i.index_id
		   					ORDER BY page_count DESC;";
					$db = $obj->Conectar();
					$rs = $db->Execute($sql);
					$db->Close();
					return $rs;
				}

				public function desFrag($obj, $campoID, $tabla){
					//$ADODB_COUNTRECS = true;
					//$ADODB_LANG='es';
					$sql = "DBCC INDEXDEFRAG (" .$obj. ",'" .$tabla. " '," .$campoID. ")";
					$db = $obj->Conectar();
					$rs = $db->Execute($sql);
					$db->Close();
					return $rs;
				}

		public function Iniciar_Transaccion($obj){$db = $obj->Conectar();$db->StartTrans();return $db;}
		public function Finalizar_Transaccion($obj){return $obj->CompleteTrans();}
	}
?>