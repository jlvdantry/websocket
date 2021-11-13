<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src='js/jquery-1.9.1.min.js' type='text/javascript'></script>
<script>
$(document).ready(function(){setInterval(ajaxcall, 5000);});
function ajaxcall(){
	$.ajax({
		url: 'cron_resultados.php',
		success: function(data) {$('#Resultados').html(data);}
	});
}
</script>
</head>
<body>
<div id="Resultados"></div>
</body>
</html>