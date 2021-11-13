<br><br>
<div class="container" style="border:0px solid red; margin-left:15px" align="left">
	<div id="lista" style="border:0px solid green; font-family:Tahoma, Geneva, sans-serif; font-size:12px;">
		<?php
        /*$cat = $_GET['cat'];
		$operador = $_GET['operador'];
		$op = ($_GET['op']==""?0:$_GET['op']);*/

        include_once('../adodb/adodb.inc.php');
        include_once('Sentencias.php');
        $query = new Sentencias();
        $rs = $query->Consultar($query,"*","CHAT_CATEGORIAS","STATUS=1 AND ID_INSTITUCION=".$_GET['inst'],"ID_CATEGORIA");
        echo "<ul class='arbol'>";
        while (!$rs->EOF) {
            $des = $rs->fields['DESCRIPCION'];
            $des=preg_replace( "/\r|\n/", "", $des );
            $des = preg_replace('~\R~u', "<br><br>", $des);
            $des = preg_replace('~(*BSR_ANYCRLF)\R~', "<br><br>", $des);
            echo "<li style='list-style:none;margin-left: -20px;padding-top:3px;'>";
            echo "<a href='#' onClick=\"Nodo_Drill(".$rs->fields['ID_CATEGORIA'].",0,'c".$rs->fields['ID_CATEGORIA']."')\">";
            echo "<img id='i" . $rs->fields['ID_CATEGORIA'] . "' src='images/collapsed.gif' /> </a>";
            /*$param1 = $rs->fields['ID_CATEGORIA'];
            $attr = " oncontextmenu = \" menu_click_der_1($param1,'genesis'); return false;\" ";*/
            echo "<img id='f" . $rs->fields['ID_CATEGORIA'] . "' src='images/root.png' /> <a href='#' class='lnk' $attr >".$des."</a>";
            echo "<div id='c" . $rs->fields['ID_CATEGORIA'] . "'></div>";
            echo "</li>";
            $rs->MoveNext();
        }
        echo "</ul>";
        ?>
    </div>
</div>