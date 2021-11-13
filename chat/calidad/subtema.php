<?php 
	include_once('../../adodb/adodb.inc.php');
	include_once('../Sentencias.php');
	$query = new Sentencias();
	$tipo = $_GET['tp'];
	$tm = $_GET['tema'];
		
	if($tipo==1){
		$rs_tema = $query->Consultar($query,"ID_SUBTEMA as ID,DESCRIPCION","CHAT_SUBTEMA","ID_TEMA=".$tm,"ID_SUBTEMA");	
		echo "<select id='cmbsubtema' class='select' style='width:120px' onchange=\"Subtema(2,'dasunto')\"><option value=0>Seleccione el Subtema</option>";
	}else{
		$stm = $_GET['subtema'];
		$rs_tema = $query->Consultar($query,"ID_ASUNTO as ID,DESCRIPCION","CHAT_ASUNTO","ID_TEMA=".$tm." AND ID_SUBTEMA=".$stm,"DESCRIPCION");
		echo "<select id='cmbasunto' class='select' style='width:120px'><option value=0>Seleccione el Asunto</option>";
	}
	
	while(!$rs_tema->EOF){
		echo "<option value=".$rs_tema->fields['ID'].">".$rs_tema->fields['DESCRIPCION']."</option>";
		$rs_tema->MoveNext();
	}
	echo "</select>";	
?>