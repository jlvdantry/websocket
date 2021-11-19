<?php
	include_once('../adodb/adodb.inc.php');
	include_once('Sentencias.php');
	$query = new Sentencias();

	$id_categoria = $_POST['cat'];
	$padre = $_POST['padre'];
	$ventana = $_POST['vtn'];
	$persona = $_POST['usuario'];
	$tpr = $_POST['tpr'];

	$persona = str_replace('@','_',$persona);
	$persona = str_replace(' ','_',$persona);
	$persona = str_replace('.','_',$persona);
	$persona = str_replace(',','_',$persona);
	$persona = str_replace('-','_',$persona);
	$persona = str_replace('á','a',$persona);
	$persona = str_replace('é','e',$persona);
	$persona = str_replace('í','i',$persona);
	$persona = str_replace('ó','o',$persona);
	$persona = str_replace('ú','u',$persona);
	$persona = str_replace('Á','A',$persona);
	$persona = str_replace('É','E',$persona);
	$persona = str_replace('Í','I',$persona);
	$persona = str_replace('Ó','O',$persona);
	$persona = str_replace('Ú','U',$persona);
	$persona = str_replace('ñ','n',$persona);
	$persona = str_replace('Ñ','N',$persona);
	$persona = preg_replace('/[^A-Za-z0-9\_]/', '', $persona);
	$orden = ($id_categoria==3 && ($padre==174 || $padre==177 || $padre==183 || $padre==186 || $padre==196 || $padre==305 || $padre==346 || $padre==377 || $padre==398 || $padre==853 || $padre==860 || $padre==910 || $padre==934 || $padre==963 || $padre==1003 || $padre==1009 || $padre==1010 || $padre==1057 || $padre==1081 || $padre==1103 || $padre==1104 || $padre==1147 || $padre==1171 || $padre==1172 || $padre==1240 || $padre==1241)?" ch.\"DESCRIPCION\"":"ch.\"ID_AYUDA\"");

	$rs = $query->Consultar($query,"ch.\"ID_AYUDA\", ch.\"ID_CATEGORIA\", ch.\"DESCRIPCION\", ch.\"TIPO\", ch.\"FINAL\", ch.\"STATUS\", (SELECT COUNT(*) FROM \"CHAT_AYUDA\" WHERE \"ID_CATEGORIA\"=".$id_categoria." AND \"TIPO\"=ch.\"ID_AYUDA\") as \"HIJOS\"","\"CHAT_AYUDA\" ch","ch.\"ID_CATEGORIA\"=".$id_categoria." and ch.\"TIPO\"=".$padre." and ch.\"STATUS\"=1 and ch.\"VISUALIZAR\" in(1,3)",$orden);
	echo "<ul>";
	while (!$rs->EOF) {
		$ct = $rs->fields['ID_CATEGORIA'];
		$id = $rs->fields['ID_AYUDA'];
		$tp = $rs->fields['TIPO'];
		/*$attr = "";
		$attr .= " oncontextmenu = 'menu_click_der_3($ct,$id,$tp);return false;' ";*/
		$descripcion = str_replace('<ul>',' ',$rs->fields['DESCRIPCION']);
		$descripcion = str_replace('</ul>',' ',$descripcion);
		$descripcion = str_replace('<li>',' ',$descripcion);
		$descripcion = str_replace('</li>',' ',$descripcion);
		$descripcion = str_replace('<br />',' ',$descripcion);
		$descripcion = str_replace('<br>',' ',$descripcion);
		$descripcion = str_replace('<b>',' ',$descripcion);
		$descripcion = str_replace('\r\n',' ',$descripcion);
		if ($rs->fields['HIJOS']>0) {
			echo "<li style='list-style:none;margin-left: -20px;padding-top:3px;'>";
			echo "<a href='#' onClick=\"Nodo_Drill(".$rs->fields['ID_CATEGORIA'].",".$rs->fields['ID_AYUDA'].",'a_".$rs->fields['ID_CATEGORIA']."_".$rs->fields['ID_AYUDA']."');return false;\">";
			echo "<img id='ia".$rs->fields['ID_CATEGORIA']."_".$rs->fields['ID_AYUDA']."' src='images/collapsed.gif' /></a> ";
			//echo "<img id='fa".$rs->fields['ID_CATEGORIA']."_".$rs->fields['ID_AYUDA']."' src='images/".($rs->fields['STATUS'] == 0 ? "inactivo" : "activo").".png' /> <a href='#' class='lnk' $attr>".$rs->fields['DESCRIPCION']."</a>";
			echo "<img id='fa".$rs->fields['ID_CATEGORIA']."_".$rs->fields['ID_AYUDA']."' src='images/root.png' /> <a href='#' class='lnk' $attr>".$rs->fields['DESCRIPCION']."</a>";
			echo "<div id='a_".$rs->fields['ID_CATEGORIA']."_".$rs->fields['ID_AYUDA']."'></div></li>";
		} else {
			echo "<li style='list-style:none;margin-left: -20px;padding-top:3px;'>";
			echo "<a href='#'><img src='images/ninguno.png' /></a> ";
			//echo "<img src='images/" . ($rs->fields['STATUS'] == 0 ? "inactivo" : "activo") . ".png' /> <a href='#' onclick=\"Info_Ventana('".$descripcion."','".$persona."')\"><img src='images/paste.png' alt='Enviar Texto a la Conversación' title='Enviar Texto a la Conversación' /></a> <a href='#' class='lnk' $attr>".$rs->fields['DESCRIPCION']."</a>";

			if($tpr<2){
				if($rs->fields['ID_AYUDA']==1495)
					$descripcion = $rs->fields['DESCRIPCION'];
				else if($rs->fields['ID_AYUDA']==1504)
					$descripcion.=str_replace("_"," ",$persona)."?";
				else if($rs->fields['ID_AYUDA']==1510)
					$descripcion.=" ".$_POST['operador'];
				
				echo "<img src='images/info.png' /> ";
				echo "<a href='#' onclick=\"Info_Ventana('".$descripcion."','".$persona."')\"><img src='images/Paste.png' alt='Enviar Texto a la Conversación' title='Enviar Texto a la Conversación' /></a>";
			}

			if($ct==3 && $id==835){
				echo "<a href='http://10.27.1.19/consulta_informativos/' class='lnk' $attr target='_blank' style='font-weight:bold' alt='Abrir Consulta Informativos' title='Abrir Consulta Informativos'><img src='images/new_window.png' style='cursor:pointer; cursor:hand' /> ".$rs->fields['DESCRIPCION']."</a>";
			}else{
				if($tpr>=2)
					echo "<img src='images/info.png' /> ";

				echo "<a href='#' class='lnk' $attr>".preg_replace('"\b(https?://\S+)"', '<a href="$1" target="_blank">$1</a>', $rs->fields['DESCRIPCION'])."</a>";
				/*if(strpos($rs->fields['DESCRIPCION'],"locatel.cdmx.gob.mx/tramites/?tp")){
					echo " <a href='".$rs->fields['DESCRIPCION']."' target='_blank' alt='Abrir Enlace' title='Abrir Enlace'><img src='images/new_window.png' /></a> ";
				}
				echo "<font style='color:green'>".$rs->fields['DESCRIPCION']."</font>";*/
			}

			echo "<div id='a_" . $rs->fields['ID_CATEGORIA'] . "_" . $rs->fields['ID_AYUDA'] . "'></div>";
			echo "</li>";
		}
		$rs->MoveNext();
	}
	echo "</ul>";
	?>
