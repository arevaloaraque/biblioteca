<?php 
	include_once('modelo.php');

	class Functions {

		public function consultar_recurso () {
			$tipo_recurso = array('libro'=>'tbl_libros','tesis'=>'tbl_tesis','material'=>'tbl_material');
			
			$consultasbd->select($tipo_recurso[$tabla=$_POST['tipo_recurso']],$campos='*',$where='');
		}

	}

	if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'):
		if (isset($_POST) && count($_POST) > 0):
			$functions = new Functions;
			$functions->$_POST['function']();
			exit();
		else:
			echo json_encode(1);
		endif;
	else:
		echo json_encode(0);
	endif;
?>