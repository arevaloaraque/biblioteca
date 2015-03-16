<?php 

	class Functions {

		public function __construct($consultasbd) {
			$this->consultasbd = $consultasbd;
		}

		public function consultar_recurso () {
			$tipo_recurso = array('libro'=>'tbl_libros','tesis'=>'tbl_tesis','material'=>'tbl_material');
			$prefx  = substr($_POST['tipo_recurso'], 0,1); 
			if ($prefx == 'l') {
				$where  = ' WHERE'.(!empty($_POST['txt_codigo'.$prefx]))?(' id_'.$_POST['tipo_recurso'].'='.$_POST['txt_codigo'.$prefx]):(' ');
				$where .= (!empty($_POST['txt_descripcion'.$prefx]))?(' descripcion ILIKE\'%'.$_POST['txt_descripcion'.$prefx].'%\''):('');
			} else if ($prefx == 't') {

			} else if ($prefx == 'm') {

			}

			$result = $this->consultasbd->select($tipo_recurso[$tabla=$_POST['tipo_recurso']],$campos='*',$where='');
			
			if ($this->consultasbd->num_rows($result) > 0) {

				$array = $this->consultasbd->fetch_array($result);
				echo json_encode([$array]);
			} else {
				echo json_encode(0);
			}
		}

	}
	
	include_once('modelo.php');

	if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'):
		if (isset($_POST) && count($_POST) > 0):
			$functions = new Functions($consultasbd);
			$functions->$_POST['function']();
			exit();
		else:
			echo json_encode(1);
		endif;
	else:
		echo json_encode(0);
	endif;
?>