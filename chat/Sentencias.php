<?php
	error_reporting(1);
	include_once("../adodb/adodb-errorhandler.inc.php");
	$ruta = dirname(__FILE__);
	//$ruta = 'C:\wamp\www\locatel\chat\logs\error.log';
	$ruta = '/var/www/html/web_chat_locatel/chat_locatel/chat/logs/error.log';

	define('ADODB_ERROR_LOG_TYPE', 3);
	define('ADODB_ERROR_LOG_DEST', $ruta);

	class Sentencias
	{
		public function Conectar(){
			//echo "entro a conectar\n";
			$cstr ="(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.250.109.44)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = XE)))";
			$db = ADONewConnection('postgres');
			//echo "paso ADONewConnection\n";
			$db->charSet = 'AL32UTF8';
			//echo "paso charset\n";
			//$db->debug = true;
			//echo "paso debug\n";
			$conectado = $db->Connect('localhost', 'postgres', '888aDantryR','chat');
			//echo "que pasotes ADONewConnection\n";
			//$conectado = $db->Connect('10.27.1.23', 'chat_locatel', 'pruebas', 'orcl');
			return $db;
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
