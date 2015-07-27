<?php 
/**
 * Función para detectar el sistema operativo, navegador y versión del mismo
 */
$info=detect(); 
/**
 * Funcion que devuelve un array con los valores:
 *	os => sistema operativo
 *	browser => navegador
 *	version => version del navegador
 */
function detect()
{
	$browser=array("IE","OPERA","MOZILLA","NETSCAPE","FIREFOX","SAFARI","CHROME");
	$os=array("WIN","MAC","LINUX");
 
	# definimos unos valores por defecto para el navegador y el sistema operativo
	$info['browser'] = "OTHER";
	$info['os'] = "OTHER";
 
	# buscamos el navegador con su sistema operativo
	foreach($browser as $parent)
	{
		$s = strpos(strtoupper($_SERVER['HTTP_USER_AGENT']), $parent);
		$f = $s + strlen($parent);
		$version = substr($_SERVER['HTTP_USER_AGENT'], $f, 15);
		$version = preg_replace('/[^0-9,.]/','',$version);
		if ($s)
		{
			$info['browser'] = $parent;
			$info['version'] = $version;
		}
	}
 
	# obtenemos el sistema operativo
	foreach($os as $val)
	{
		if (strpos(strtoupper($_SERVER['HTTP_USER_AGENT']),$val)!==false)
			$info['os'] = $val;
	}
 
	# devolvemos el array de valores
	return $info;
}

if ($info["os"] == "WIN"){
$hoy=(date("d-M-Y")); 
$name="bibloweb-". $hoy . "-backup"; 
$RESPALDO=$name . ".sql"; 
header("Pragma: cache"); 
header("Content-type: text/plain;"); 
header("Content-Disposition: attachment; filename=".urlencode($name).".sql"); 
ob_start(); 
$pg_dump="/usr/bin/pg_dump"; 
$comando="$pg_dump -c -F p -d bd_biblioteca -U biblioteca --no-owner > $RESPALDO"; 
exec($comando); 
readfile ($RESPALDO); 
unlink ($RESPALDO); 
}else {
	echo '<script>alert("Sistema Operativo no compatible");location.href="../";</script>';
}
?>