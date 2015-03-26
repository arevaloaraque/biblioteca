<?php 

	session_start();

	class Functions {

		public function __construct($consultasbd) {
			$this->consultasbd = $consultasbd;
		}

		public function consultar_recurso () {
			sleep(.7);
			$tipo_recurso = array('libro'=>'tbl_libros','tesis'=>'tbl_tesis','material'=>'tbl_material');
			$prefx  = substr($_POST['tipo_recurso'], 0,1); 
			if ($prefx == 'l') {
				$where  = ' WHERE'.((!empty($_POST['txt_codigo'.$prefx]))?(' id_'.$_POST['tipo_recurso'].'=\''.$_POST['txt_codigo'.$prefx].'\' '):(' '));
				if (!empty($_POST['txt_codigo'.$prefx]) && !empty($_POST['txt_descripcion'.$prefx])):
					$where .= ' AND ';
				endif;
				$where .= ((!empty($_POST['txt_descripcion'.$prefx]))?(' descripcion ILIKE\'%'.$_POST['txt_descripcion'.$prefx].'%\''):(''));
				$result = $this->consultasbd->select($tipo_recurso[$tabla=$_POST['tipo_recurso']],$campos='*',$where);
			} else if ($prefx == 't') {
				$where  = ' WHERE'.((!empty($_POST['txt_codigo'.$prefx]))?(' id_'.$_POST['tipo_recurso'].'=\''.$_POST['txt_codigo'.$prefx].'\' '):(' '));
				if (!empty($_POST['txt_codigo'.$prefx]) && !empty($_POST['txt_descripcion'.$prefx])) {
					$where .= ' AND ';
				}
				$where .= ((!empty($_POST['txt_descripcion'.$prefx]))?(' titulo ILIKE\'%'.$_POST['txt_descripcion'.$prefx].'%\''):(''));
				$result = $this->consultasbd->select($tipo_recurso[$tabla=$_POST['tipo_recurso']],$campos='*',$where);
			} else if ($prefx == 'm') {
				$sql = 'select * from tbl_material as tbl_mat left outer join tbl_tipo_material tbl_tipo on tbl_mat.id_tipo=tbl_tipo.id_tipo_material';
				$where  = ' WHERE'.((!empty($_POST['txt_codigo'.$prefx]))?(' id_'.$_POST['tipo_recurso'].'=\''.$_POST['txt_codigo'.$prefx].'\' '):(' '));
				if (!empty($_POST['txt_codigo'.$prefx]) && !empty($_POST['txt_descripcion'.$prefx])) {
					$where .= ' AND ';
				}
				$where .= ((!empty($_POST['txt_descripcion'.$prefx]))?(' descripcion_tipo ILIKE\'%'.$_POST['txt_descripcion'.$prefx].'%\''):(''));
				$result = $this->consultasbd->query($sql.$where);
			}
			
			if ($this->consultasbd->num_rows($result) > 0) {
				$response = array();
				if ($prefx == 'l') {
					while($array = $this->consultasbd->fetch_array($result)) {
						// datos de autor
						$res_autor = $this->consultasbd->select($tabla='tbl_autor',$campos='*',$where = ((!empty($array['id_autor']))?'WHERE id_autor=\''.$array['id_autor'].'\'':''));
						$fetch_autor = $this->consultasbd->fetch_array($res_autor);
						$autor = $fetch_autor['nombre'].' '.$fetch_autor['apellido'];
						// datos de editorial
						$res_editorial = $this->consultasbd->select($tabla='tbl_editorial',$campos='*',$where = ((!empty($array['id_editorial']))?'WHERE id_editorial=\''.$array['id_editorial'].'\'':''));
						$fetch_editorial = $this->consultasbd->fetch_array($res_editorial);
						$editorial = $fetch_editorial['nombre'].' '.$fetch_editorial['ciudad'];
						// datos de materia
						$res_materia = $this->consultasbd->select($tabla='tbl_materia',$campos='*',$where = ((!empty($array['id_materia']))?'WHERE id_materia=\''.$array['id_materia'].'\'':''));
						$fetch_materia = $this->consultasbd->fetch_array($res_materia);
						$materia = $fetch_materia['nombre_materia'];

						$array['id_autor'] = $autor;
						$array['id_editorial'] = $editorial;
						$array['id_materia'] = $materia;
						$array['fecha_publicacion'] = date('d-m-Y',strtotime($array['fecha_publicacion']));
						$response[] = $array;
					}
				} else if ($prefx == 't') {
					while($array = $this->consultasbd->fetch_array($result)) {
						// datos de materia
						$res_materia = $this->consultasbd->select($tabla='tbl_materia',$campos='*',$where = ((!empty($array['id_materia']))?'WHERE id_materia=\''.$array['id_materia'].'\'':''));
						$fetch_materia = $this->consultasbd->fetch_array($res_materia);
						$materia = $fetch_materia['nombre_materia'];
						// datos de autor
						$res_autor = $this->consultasbd->select($tabla='tbl_autor_tesis',$campos='*',$where = ((!empty($array['id_autor_tesis']))?'WHERE id_autor_tesis=\''.$array['id_autor_tesis'].'\'':''));
						$fetch_autor = $this->consultasbd->fetch_array($res_autor);
						$autor = $fetch_autor['nombre'].' '.$fetch_autor['apellido'];
						$mension = $fetch_autor['mension'];

						$array['id_autor_tesis'] = $autor;
						$array['id_materia'] = $materia;
						$array['mension'] = $mension;
						$array['fecha_publicacion'] = date('d-m-Y',strtotime($array['fecha_publicacion']));
						$response[] = $array;
					}
				} else if ($prefx == 'm') {
					while($array = $this->consultasbd->fetch_array($result)) {
						
						$response[] = $array;
					}
				}
				echo json_encode($response);
			} else {
				echo json_encode(0);
			}
		}

		public function insertar_autor_libro () {
			$nombre   = (isset($_POST['nombre']))?$_POST['nombre']:'';
			$apellido = (isset($_POST['apellido']))?$_POST['apellido']:'';
			$res = $this->consultasbd->insert($tabla='tbl_autor',$campos='(nombre,apellido)',$values='\''.$nombre.'\''.','.'\''.$apellido.'\'');
			if ($res) {
				$res = $this->consultasbd->max_id($tabla='tbl_autor',$id='id_autor');
				$dat = $this->consultasbd->fetch_array($res);
				// auditoria
				$auditar_mnsj = "Registró nuevo autor. datos: (nombre=>".$nombre.",apellido=>".$apellido.",id=>".$dat['id'].")";
				$auditar_user = $_SESSION['id_operador'];
				$auditar_date = date('Y-m-d');
				$auditar_hour = date('H:m');
				$this->consultasbd->insert($tabla='tbl_auditoria',$campos='(id_operador,descripcion,hora,fecha_auditoria)',$values='\''.$auditar_user.'\',\''.$auditar_mnsj.'\',\''.$auditar_hour.'\',\''.$auditar_date.'\'');
				// FIN auditoria
				echo $dat['id'];
			} else {
				echo '';
			}
		}

		public function insertar_editorial () {
			$nombre_editorial = $_POST['nombre_editorial'];
			$ciudad_editorial = $_POST['ciudad_editorial'];
			$res = $this->consultasbd->insert($tabla='tbl_editorial',$campos='(nombre,ciudad)',$values='\''.$nombre_editorial.'\''.','.'\''.$ciudad_editorial.'\'');
			if ($res) {
				$res = $this->consultasbd->max_id($tabla='tbl_editorial',$id='id_editorial');
				$dat = $this->consultasbd->fetch_array($res);
				// auditoria
				$auditar_mnsj = "Registró nueva editorial. datos: (nombre editorial=>".$nombre_editorial.",ciudad=>".$ciudad_editorial.",id=>".$dat['id'].")";
				$auditar_user = $_SESSION['id_operador'];
				$auditar_date = date('Y-m-d');
				$auditar_hour = date('H:m');
				$this->consultasbd->insert($tabla='tbl_auditoria',$campos='(id_operador,descripcion,hora,fecha_auditoria)',$values='\''.$auditar_user.'\',\''.$auditar_mnsj.'\',\''.$auditar_hour.'\',\''.$auditar_date.'\'');
				// FIN auditoria
				echo $dat['id'];
			} else {
				echo '';
			}
		}

		public function insertar_materia () {
			$nombre_materia = $_POST['nombre_materia'];
			$res = $this->consultasbd->insert($tabla='tbl_materia',$campos='(nombre_materia)',$values='\''.$nombre_materia.'\'');
			if ($res) {
				$res = $this->consultasbd->max_id($tabla='tbl_materia',$id='id_materia');
				$dat = $this->consultasbd->fetch_array($res);
				// auditoria
				$auditar_mnsj = "Registró nueva materia. datos: (nombre materia=>".$nombre_materia.",id=>".$dat['id'].")";
				$auditar_user = $_SESSION['id_operador'];
				$auditar_date = date('Y-m-d');
				$auditar_hour = date('H:m');
				$this->consultasbd->insert($tabla='tbl_auditoria',$campos='(id_operador,descripcion,hora,fecha_auditoria)',$values='\''.$auditar_user.'\',\''.$auditar_mnsj.'\',\''.$auditar_hour.'\',\''.$auditar_date.'\'');
				// FIN auditoria
				echo $dat['id'];
			} else {
				echo '';
			}
		}

		public function insertar_libro () {
			$autor 		 = $_POST['txt_autor'];
			$descripcion = $_POST['txt_descripcion'];
			$edicion	 = $_POST['txt_edicion'];
			$editorial   = $_POST['txt_editorial'];
			$fecha 		 = $_POST['txt_fecha'];
			$materia 	 = $_POST['txt_materia'];
			$tabla 		 = 'tbl_libros';
			$campos		 = '(id_autor,id_editorial,id_materia,edicion,fecha_publicacion,descripcion)';
			$values	 	 = '\''.$autor.'\',\''.$editorial.'\',\''.$materia.'\',\''.$edicion.'\',\''.$fecha.'\',\''.$descripcion.'\'';
			$res = $this->consultasbd->insert($tabla,$campos,$values);
			if ($res) {
				$res = $this->consultasbd->max_id($tabla='tbl_libros',$id='id_libro');
				$dat = $this->consultasbd->fetch_array($res);
				// auditoria
				$auditar_mnsj = "Registró nueva libro. datos: (descripcion=>".$descripcion.",id=>".$dat['id'].")";
				$auditar_user = $_SESSION['id_operador'];
				$auditar_date = date('Y-m-d');
				$auditar_hour = date('H:m');
				$this->consultasbd->insert($tabla='tbl_auditoria',$campos='(id_operador,descripcion,hora,fecha_auditoria)',$values='\''.$auditar_user.'\',\''.$auditar_mnsj.'\',\''.$auditar_hour.'\',\''.$auditar_date.'\'');
				// FIN auditoria
				echo $dat['id'];
			} else {
				echo 0;
			}
		}

		public function get_data() {
			$tabla = $_POST['tabla'];
			$res = $this->consultasbd->select($tabla=$tabla);
			if ($this->consultasbd->num_rows($res)>0) {
				$data = array();
				while ($detalle = $this->consultasbd->fetch_array($res)) {
					$data[] = $detalle;
				}
				echo json_encode($data);
			}
		}

		public function eliminar() {
			$tabla = $_POST['tabla'];
			$campo = $_POST['campo'];
			$valor = $_POST['val'];
			$res = $this->consultasbd->delete($tabla,$campo,$valor);
			if ($res) {
				// auditoria
				$auditar_mnsj = "Eliminó registro. datos: (tabla=>".$tabla.",campo=>".$campo.",valor=>".$valor.")";
				$auditar_user = $_SESSION['id_operador'];
				$auditar_date = date('Y-m-d');
				$auditar_hour = date('H:m');
				$this->consultasbd->insert($tabla='tbl_auditoria',$campos='(id_operador,descripcion,hora,fecha_auditoria)',$values='\''.$auditar_user.'\',\''.$auditar_mnsj.'\',\''.$auditar_hour.'\',\''.$auditar_date.'\'');
				// FIN auditoria
				echo 1;
			} else {
				echo 0;
			}
		}

	}
	
	include_once('modelo.php');

	if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		if (isset($_POST) && count($_POST) > 0) {
			$functions = new Functions($consultasbd);
			if (isset($_POST['function'])) {
				if (method_exists('Functions',$_POST['function'])){
					$functions->$_POST['function']();
				}else {
					echo 0;
				}				
			} else {
				echo 0;
			}
		} else {
			echo json_encode(1);
		}
	} else {
		header('location: ../index.php?page=404');
	}
?>