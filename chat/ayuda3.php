<?php 
	$ins = $_GET['inst'];
	if($ins==2)
		exit();
		
	$cat = $_GET['cat'];
	$operador = $_GET['operador'];
	$op = ($_GET['op']==""?0:$_GET['op']);
	$persona = $_GET['usuario'];
	
	include_once('../adodb/adodb.inc.php');
	include_once('Sentencias.php');
	$query = new Sentencias();
	/*if($cat!="categorias"){
		$criterios = "TIPO=".$op." AND STATUS=1";
		$tmp = explode("_",$cat);
		$orden = strtoupper(substr($tmp[0], 0, -1));
	}else{
		$orden = "CATEGORIA";		
	}

	$rs = $query->Consultar($query,"*","chat_".strtolower($cat),$criterios,"ID_".$orden);*/
	
	if($cat!="categorias"){
		$a_categorias = array("","Emergencias","Servicios_Integrales","Informativos","Paginas_WEB");
		$criterios = " TIPO=".$op." AND STATUS=1"." AND ID_CATEGORIA=".array_search($cat, $a_categorias);
		$tabla = "CHAT_AYUDA";
		$orden = "AYUDA";
	}else{
		$tabla = "CHAT_CATEGORIAS";
		$criterios = "";
		$orden = "CATEGORIA";		
	}
	
	$rs = $query->Consultar($query,"*",$tabla,$criterios,'ID_'.$orden);
	
	if($_GET['final']==0){
		echo "<ul>";
		echo "<li class='treeviewFolderPrin' style='padding: 0.2em;'><a href='#' onclick=\"drespuestas.innerHTML=''; ajax('ayuda.php?cat=categorias&ur=categorias&operador=".$operador."&usuario=".$persona."&op=','ayuda',1);\" style='color:black;'><u>Categor&iacute;as</u></a></li>";

		if($_GET['cat']!="categorias")
		echo "<li class='treeviewFolderLi' style='margin-left: 10px; padding: 0.2em;'><a href='#' onclick=\"drespuestas.innerHTML='';ajax('ayuda.php?cat=".$cat."&ur=".$nav."&operador=".$operador."&usuario=".$persona."&op=','ayuda',1);\">".$cat."</a></li>";

		while(!$rs->EOF){
			$nav = $_GET['ur']."->".$rs->fields['DESCRIPCION'];
			$nav = str_replace('á','a',$nav);
			$nav = str_replace('é','e',$nav);
			$nav = str_replace('í','i',$nav);
			$nav = str_replace('ó','o',$nav);
			$nav = str_replace('ú','u',$nav);

			if($_GET['cat']!="categorias")
				$url = "ayuda.php?cat=".$cat.($rs->fields['FINAL']==1?"&final=1":"&final=0")."&op=".$rs->fields['ID_AYUDA']."&ur=".$nav."&operador=".$operador."&usuario=".$persona;
			else
				$url = "ayuda.php?cat=".str_replace(' ','_',$rs->fields['DESCRIPCION']).($rs->fields['FINAL']==1?"&final=1":"&final=0")."&ur=".$rs->fields['DESCRIPCION']."&operador=".$operador."&usuario=".$persona."&op=";

			$div = ($rs->fields['FINAL']==1?"drespuestas":"ayuda");

			echo "<li class='treeviewFolderLi' style='margin-left: 20px;padding: 0.2em;'><a href='#' onclick=\"document.getElementById('drespuestas').innerHTML=''; ajax('".$url."','".$div."',1);\">".$rs->fields['DESCRIPCION']."</a></li>";
			$rs->MoveNext();
		}
		echo "</ul><br /><br />";
	}else{
		$descripcion = $rs->fields['DESCRIPCION'];
		$descripcion = str_replace('\r\n','<br />',$descripcion);
		$descripcion2 = str_replace('<ul>',' ',$descripcion);
		$descripcion2 = str_replace('</ul>',' ',$descripcion2);
		$descripcion2 = str_replace('<li>',' ',$descripcion2);
		$descripcion2 = str_replace('</li>',' ',$descripcion2);
		$descripcion2 = str_replace('<br />',' ',$descripcion2);
		$descripcion2 = str_replace('\r\n',' ',$descripcion2);
		echo "<br /><br /><div id='txtrespuesta'>$descripcion</div><br />";
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

		echo "<textarea id='trespuesta' style='display:none'>$descripcion2</textarea>";
		echo "<div align='left'><a href='#' onclick=\"if(document.getElementById('t_".$persona."')){document.getElementById('t_".$persona."').value = document.getElementById('trespuesta').value}\"><img src='images/Paste.png' alt='Pegar texto en conversaci&oacute;n' title='Pegar texto en conversaci&oacute;n' /></a></div>";
	}
?>