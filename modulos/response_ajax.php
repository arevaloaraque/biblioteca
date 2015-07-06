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
				$result = $this->consultasbd->select($tipo_recurso[$tabla=$_POST['tipo_recurso']],$campos='*');
			} else if ($prefx == 't') {
				$where  = ' WHERE'.((!empty($_POST['txt_codigo'.$prefx]))?(' id_'.$_POST['tipo_recurso'].'=\''.$_POST['txt_codigo'.$prefx].'\' '):(' '));
				if (!empty($_POST['txt_codigo'.$prefx]) && !empty($_POST['txt_descripcion'.$prefx])) {
					$where .= ' AND ';
				}
				$where .= ((!empty($_POST['txt_descripcion'.$prefx]))?(' titulo ILIKE\'%'.$_POST['txt_descripcion'.$prefx].'%\''):(''));
				$result = $this->consultasbd->select($tipo_recurso[$tabla=$_POST['tipo_recurso']],$campos='*');
			} else if ($prefx == 'm') {
				$sql = 'select * from tbl_material as tbl_mat left outer join tbl_tipo_material tbl_tipo on tbl_mat.id_tipo=tbl_tipo.id_tipo_material';
				$where  = ' WHERE'.((!empty($_POST['txt_codigo'.$prefx]))?(' id_'.$_POST['tipo_recurso'].'=\''.$_POST['txt_codigo'.$prefx].'\' '):(' '));
				if (!empty($_POST['txt_codigo'.$prefx]) && !empty($_POST['txt_descripcion'.$prefx])) {
					$where .= ' AND ';
				}
				$where .= ((!empty($_POST['txt_descripcion'.$prefx]))?(' descripcion_tipo ILIKE\'%'.$_POST['txt_descripcion'.$prefx].'%\''):(''));
				$result = $this->consultasbd->query($sql);
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

						$array['id_autor_tesis'] = $autor;
						$array['id_materia'] = $materia;
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

		public function insertar_tesis () {
			$materia 	 = $_POST['txt_materia'];
			$autor 		 = $_POST['txt_autor_tesis'];
			$titulo 	 = $_POST['txt_titulo'];
			$fecha 		 = $_POST['txt_fecha'];
			$mension	 = $_POST['txt_mension'];
			$tabla 		 = 'tbl_tesis';
			$campos		 = '(id_materia,id_autor_tesis,titulo,fecha_publicacion,mension)';
			$values	 	 = '\''.$materia.'\',\''.$autor.'\',\''.$titulo.'\',\''.$fecha.'\''.',\''.$mension.'\'';
			$res = $this->consultasbd->insert($tabla,$campos,$values,$type='insert');
			if ($res) {
				$res = $this->consultasbd->max_id($tabla='tbl_tesis',$id='id_tesis');
				$dat = $this->consultasbd->fetch_array($res);
				// auditoria
				$auditar_mnsj = "Registró nueva tesis. datos: (titulo=>".$titulo.",id=>".$dat['id'].")";
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

		public function insertar_material () {
			$nombre 	   = $_POST['txt_nombre'];
			$tipo_material = $_POST['txt_tipo_material'];
			$tabla 		 = 'tbl_material';
			$campos		 = '(id_tipo,nombre)';
			$values	 	 = '\''.$tipo_material.'\',\''.$nombre.'\'';
			$res = $this->consultasbd->insert($tabla,$campos,$values,$type='insert');
			if ($res) {
				$res = $this->consultasbd->max_id($tabla,$id='id_material');
				$dat = $this->consultasbd->fetch_array($res);
				// auditoria
				$auditar_mnsj = "Registró nuevo material. datos: (nombre=>".$nombre.",id=>".$dat['id'].")";
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

		public function insertar_autor_tesis() {
			$nombre   = (isset($_POST['nombre']))?$_POST['nombre']:'';
			$apellido = (isset($_POST['apellido']))?$_POST['apellido']:'';
			$res = $this->consultasbd->insert($tabla='tbl_autor_tesis',$campos='(nombre,apellido)',$values='\''.$nombre.'\''.','.'\''.$apellido.'\'');
			if ($res) {
				$res = $this->consultasbd->max_id($tabla='tbl_autor_tesis',$id='id_autor_tesis');
				$dat = $this->consultasbd->fetch_array($res);
				// auditoria
				$auditar_mnsj = "Registró nuevo autor de tesis. datos: (nombre=>".$nombre.",apellido=>".$apellido.",id=>".$dat['id'].")";
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

		public function insertar_tipo_material() {
			$tipo_material = (isset($_POST['tipo_material']))?$_POST['tipo_material']:'';
			$res = $this->consultasbd->insert($tabla='tbl_tipo_material',$campos='(descripcion_tipo)',$values='\''.$tipo_material.'\'');
			if ($res) {
				$res = $this->consultasbd->max_id($tabla='tbl_tipo_material',$id='id_tipo_material');
				$dat = $this->consultasbd->fetch_array($res);
				// auditoria
				$auditar_mnsj = "Registró nuevo tipo de material. datos: (descripcion tipo=>".$tipo_material.")";
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

		public function status_user_prestamo () {
			sleep(1.5);
			$id_usuario = $_POST['id_usuario'];
			$id_recurso 	= $_POST['id_recurso'];
			$tipo_recurso = $_POST['recurso'];
			$tabla_tmp = '';
			$id_nov = ['libro'=>'id_novedad','tesis'=>'id_novedad_tesis','material'=>'id_novedad_material'];
			$prefix = ['libro'=>'','tesis'=>'_tesis','material'=>'_material'];
			if ($tipo_recurso=='libro'){$tabla_tmp='tbl_libros';}elseif($tipo_recurso=='tesis'){$tabla_tmp='tbl_tesis';}else{$tabla_tmp='tbl_material';}
			$user = $this->consultasbd->select('tbl_usuario',$campos='*',$where=' WHERE id_usuario=\''.$id_usuario.'\'');
			// verificacion de usuario
			if ($this->consultasbd->num_rows($user)>0) {
				$recurso = $this->consultasbd->select($tabla_tmp,$campos='*',$where=' WHERE id_'.$tipo_recurso.'=\''.$id_recurso.'\' AND status=true');
				// verificacion de recurso. disponibilidad
				if ($this->consultasbd->num_rows($recurso)>0) {
					$prestamos_user = $this->consultasbd->select('tbl_prestamo_'.$tipo_recurso,$campos='*',$where=' WHERE id_usuario=\''.$id_usuario.'\' AND status=true');
					// verificacion de prestamos actuales del usuario. limite 2
					if ($this->consultasbd->num_rows($prestamos_user)<2) {
						// verificacion de novedades
						if ($this->consultasbd->num_rows($prestamos_user)==1){
							$prestamos_user = $this->consultasbd->fetch_array($prestamos_user);
							$novedades = $this->consultasbd->select($tabla='tbl_novedad_'.$tipo_recurso,$campos='*',$where='WHERE '.$id_nov[$_POST['recurso']].'=\''.$prestamos_user['id_prestamo'.$prefix[$tipo_recurso]].'\'');
							if ($this->consultasbd->fetch_array($novedades)>0) {
								$data = ['mensj'=>'<b><i class="glyphicon glyphicon-thumbs-down"></i>&nbsp;Error</b>&nbsp;<span id="mensj">No se puede realizar el prestamo. El usuario posee novedades</span>','type'=>'alert-danger'];
							} else {
								$data = ['mensj'=>'','type'=>'alert-success'];
								$data = ['mensj'=>'<b><i class="glyphicon glyphicon-thumbs-up"></i>&nbsp;Busqueda exitosa</b>&nbsp;<span id="mensj">Verifique los datos y presione <b>PROCESAR PRESTAMO</b>. Este proceso es irreversible</span>','type'=>'alert-success'];
							}
						} else {
							$data = ['mensj'=>'','type'=>'alert-success'];
							$data = ['mensj'=>'<b><i class="glyphicon glyphicon-thumbs-up"></i>&nbsp;Busqueda exitosa</b>&nbsp;<span id="mensj">Verifique los datos y presione <b>PROCESAR PRESTAMO</b>. Este proceso es irreversible</span>','type'=>'alert-success'];
						}
					} else {
						$data = ['mensj'=>'<b><i class="glyphicon glyphicon-thumbs-down"></i>&nbsp;Error</b>&nbsp;<span id="mensj">Limite de prestamos alcanzados. Solo se permiten 2 prestamos por categoria</span>','type'=>'alert-danger'];
					}
				} else {
					$data = ['mensj'=>'<b><i class="glyphicon glyphicon-thumbs-down"></i>&nbsp;Error</b>&nbsp;<span id="mensj">'.ucfirst($tipo_recurso).' no disponible</span>','type'=>'alert-danger'];
				}
			} else {
				$data = ['mensj'=>'<b><i class="glyphicon glyphicon-thumbs-down"></i>&nbsp;Error</b>&nbsp;<span id="mensj">No existe el usuario</span>','type'=>'alert-danger'];
			}
			echo json_encode($data);
		}

		public function verificar_novedades () {
			$tablas = ['libro'=>'tbl_novedad_libro','tesis'=>'tbl_novedad_tesis','material'=>'tbl_novedad_material'];
			$ids = ['libro'=>'id_novedad','tesis'=>'id_novedad_tesis','material'=>'id_novedad_material'];
			$id_prestamo = $_POST['id_prestamo'];
			$prestamo = $this->consultasbd->select($tabla=$tablas[$_POST['recurso']],$campos='*',$where='WHERE '.$ids[$_POST['recurso']].'=\''.$id_prestamo.'\'');
			if ($this->consultasbd->num_rows($prestamo)>0) {
				echo json_encode(false);
			} else {
				echo json_encode(true);
			}
		}

		public function entrega_prestamo () {
			$tablas = ['libro'=>'tbl_prestamo_libro','tesis'=>'tbl_prestamo_tesis','material'=>'tbl_prestamo_material'];
			$recurso = ['libro'=>'tbl_libros','tesis'=>'tbl_tesis','material'=>'tbl_material'];
			$ids = ['libro'=>'id_prestamo','tesis'=>'id_prestamo_tesis','material'=>'id_prestamo_material'];
			$id_prestamo = $_POST['id_prestamo'];
			$prestamo = $this->consultasbd->select($tabla=$tablas[$_POST['recurso']],$campos='*',$where=' WHERE '.$ids[$_POST['recurso']].'=\''.$id_prestamo.'\' AND status=true');
			if (is_resource($prestamo)){ 
				$this->consultasbd->update($tabla=$tablas[$_POST['recurso']],$set='status=false',$where=' WHERE '.$ids[$_POST['recurso']].'=\''.$id_prestamo.'\'');
				// auditoria
				$auditar_mnsj = "Realizo devolucion de ".$_POST['recurso'].". datos: (Id prestamo=>".$id_prestamo.")";
				$auditar_user = $_SESSION['id_operador'];
				$auditar_date = date('Y-m-d');
				$auditar_hour = date('H:m');
				$this->consultasbd->insert($tabla='tbl_auditoria',$campos='(id_operador,descripcion,hora,fecha_auditoria)',$values='\''.$auditar_user.'\',\''.$auditar_mnsj.'\',\''.$auditar_hour.'\',\''.$auditar_date.'\'');
				// FIN auditoria
				// cambiar status del recurso
				$datos_prestamo = $this->consultasbd->fetch_array($prestamo);
				$this->consultasbd->update($tabla=$recurso[$_POST['recurso']],$set='status=true',$where=' WHERE id_'.$_POST['recurso'].'=\''.$datos_prestamo['id_'.$_POST['recurso']].'\'');
				echo json_encode(true);
			} else {

			}
		}

		public function registrar_novedad() {
			sleep(.7);
			$id_novedad = array('libro'=>'id_novedad','tesis'=>'id_novedad_tesis','material'=>'id_novedad_material');
			$idx_prestamo = array('libro'=>'id_prestamo','tesis'=>'id_prestamo_tesis','material'=>'id_prestamo_material');
			$recurso = (isset($_POST['recurso']))?$_POST['recurso']:'';
			$descripcion = $_POST['descripcion']; $id_prestamo = $_POST['id_prestamo'];
			$res = $this->consultasbd->insert($tabla='tbl_novedad_'.$recurso,$campos='(descripcion,'.$idx_prestamo[$recurso].',fecha_novedad)',$values='\''.$descripcion.'\''.','.'\''.$id_prestamo.'\',\''.date('Y-m-d'.'\'').'');
			if ($res) {
				$res = $this->consultasbd->max_id($tabla='tbl_novedad_'.$recurso,$id=$id_novedad[$recurso]);
				$dat = $this->consultasbd->fetch_array($res);
				// auditoria
				$auditar_mnsj = "Registró novedad en prestamo de ".$recurso.". datos: (descripcion =>".$descripcion.")";
				$auditar_user = $_SESSION['id_operador'];
				$auditar_date = date('Y-m-d');
				$auditar_hour = date('H:m');
				$this->consultasbd->insert($tabla='tbl_auditoria',$campos='(id_operador,descripcion,hora,fecha_auditoria)',$values='\''.$auditar_user.'\',\''.$auditar_mnsj.'\',\''.$auditar_hour.'\',\''.$auditar_date.'\'');
				// FIN auditoria
				echo true;
			} else {
				echo '';
			}
		}

		public function set_novedades() {
			$id_novedad = array('libro'=>'id_novedad','tesis'=>'id_novedad_tesis','material'=>'id_novedad_material');
			$recurso = (isset($_POST['recurso']))?$_POST['recurso']:'';
			$id_prestamo = $_POST['id_prestamo']; $descripcion = $_POST['descripcion'];
			$descripcion_entrega = $_POST['descripcion_entrega'];
			$idx_prestamo = array('libro'=>'id_prestamo','tesis'=>'id_prestamo_tesis','material'=>'id_prestamo_material');
			$tabla = 'tbl_novedad_'.$recurso;
			$set   = 'status=false, descripcion_final=\''.$descripcion_entrega.'\'';
			$where = 'WHERE '.$idx_prestamo[$recurso].'=\''.$id_prestamo.'\'';
			$res   = $this->consultasbd->update($tabla,$set,$where);
			// auditoria
			$auditar_mnsj = "Actualizó novedades. datos: (Descripcion entrega=>".$descripcion_entrega.",id_prestamo=>".$id_prestamo.")";
			$auditar_user = $_SESSION['id_operador'];
			$auditar_date = date('Y-m-d');
			$auditar_hour = date('H:m');
			$this->consultasbd->insert($tabla='tbl_auditoria',$campos='(id_operador,descripcion,hora,fecha_auditoria)',$values='\''.$auditar_user.'\',\''.$auditar_mnsj.'\',\''.$auditar_hour.'\',\''.$auditar_date.'\'');
			// FIN auditoria
			if ($res) {
				echo true;
			} else {
				echo '';
			}
		}
		public function get_novedades() {
			$id_novedad = array('libro'=>'id_novedad','tesis'=>'id_novedad_tesis','material'=>'id_novedad_material');
			$recurso = (isset($_POST['recurso']))?$_POST['recurso']:'';
			$id_prestamo = $_POST['id_prestamo'];
			$idx_prestamo = array('libro'=>'id_prestamo','tesis'=>'id_prestamo_tesis','material'=>'id_prestamo_material');
			$res = $this->consultasbd->select($tabla='tbl_novedad_'.$recurso,$campos='*',$where='WHERE '.$idx_prestamo[$recurso].'=\''.$id_prestamo.'\'');
			if ($this->consultasbd->num_rows($res)>0) {
				$data = array();
				while ($detalle = $this->consultasbd->fetch_array($res)) {
					$data[] = $detalle;
				}
				echo json_encode($data);
			} else {
				echo '';
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
			echo json_encode(0);
		}
	} else {
		header('location: ../index.php?page=404');
	}
?>