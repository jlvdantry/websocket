<?php 
	$cat = $_POST['cat'];
	$op = ($_POST['op']==""?0:$_POST['op']);

	include_once('../adodb/adodb.inc.php');
	include_once('Sentencias.php');
	$query = new Sentencias();	
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
	/*echo "<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />".$cat."<br />".array_search($cat, $a_categorias)."<br />".$tabla."<br />".$criterios;
	exit();*/
	$rs = $query->Consultar($query,"*",$tabla,$criterios,'ID_'.$orden);
	if($_POST['final']==0){
		echo "<div id='ayuda' style='margin-top:50px; z-index:1; width:300px; float:left' align='left'>";
		echo "<ul>";
		echo "<li class='treeviewFolderPrin' style='margin-left: 8px; margin-top:10px;padding: 0.2em;'><a href='#' onclick=\"drespuestas.innerHTML=''; Ajax_Dinamico('ayuda2.php','Principal','cat=categorias&ur=categorias&op=');\" style='color:black;'><u>Categor&iacute;as</u></a></li>";

		if($_POST['cat']!="categorias"){
			echo "<li class='treeviewFolderLi' style='margin-left: 15px;padding: 0.2em;'><a href='#' onclick=\"drespuestas.innerHTML=''; Ajax_Dinamico('ayuda2.php','Principal','cat=".$cat."&ur=".$nav."&op=');\">".$cat."</a></li>";
		}
		while(!$rs->EOF){
			$nav = $_POST['ur']."->".$rs->fields['DESCRIPCION'];
			$nav = str_replace('á','a',$nav);
			$nav = str_replace('é','e',$nav);
			$nav = str_replace('í','i',$nav);
			$nav = str_replace('ó','o',$nav);
			$nav = str_replace('ú','u',$nav);

			if($_POST['cat']!="categorias")
				$url = "cat=".$cat.($rs->fields['FINAL']==1?"&final=1":"&final=0")."&op=".$rs->fields['ID_AYUDA']."&ur=".$nav;
			else
				$url = "cat=".str_replace(' ','_',$rs->fields['DESCRIPCION']).($rs->fields['FINAL']==1?"&final=1":"&final=0")."&ur=".$rs->fields['DESCRIPCION']."&op=";

			$div = ($rs->fields['FINAL']==1?"drespuestas":"Principal");

			echo "<li class='treeviewFolderLi' style='margin-left: 28px;padding: 0.2em;'><a href='#' onclick=\"document.getElementById('drespuestas').innerHTML=''; Ajax_Dinamico('ayuda2.php','".$div."','".$url."');\">".$rs->fields['DESCRIPCION']."</a></li>";
			$rs->MoveNext();
		}
		echo "</ul>";
		echo "<br /><br /></div><div id='drespuestas' style='margin-top:50px; float:left; width:650px; text-align:justify; font-size:12px; font-weight:bold; color:#133575; z-index:200;'></div>";
	}else{
		$descripcion = $rs->fields['DESCRIPCION'];
		$descripcion = str_replace('\r\n','<br />',$descripcion);
		echo "<br /><br /><div id='txtrespuesta'>$descripcion</div><br />";
	}
	
?>