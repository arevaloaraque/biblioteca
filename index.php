<!doctype html>
<html lang="es">
<head>
	<meta charset="utf-8" />
	<meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
	<title>..:: Biblioteca - Inicio ::..</title>
	<style type="text/css" src="librerias/bootstrap/css/bootstrap.min.css"></style>
</head>
<body>
	<?php 
		if (isset($_GET['page'])):
			if (file_exists('modulos/'.$_GET['page'].'.php')):
				echo 'existe';
			else:
				echo 'no existe';
			endif;
		else:
			echo 'no get';
		endif;
	?>
</body>
</html>