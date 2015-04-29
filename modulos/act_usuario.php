<?php 
	include_once('modulos/modelo.php');
	if (isset($_GET['id_usuario'])) {
		$id_usuario = $_GET['id_usuario'];
		$usuario = $consultasbd->select($tabla='tbl_usuario',$campos='*',$where=' WHERE id_usuario=\''.$id_usuario.'\'');
		if (!$consultasbd->num_rows($usuario)>0) { echo '<script>location.href = "?page=list_usuarios";</script>'; }
		$usuario = $consultasbd->fetch_array($usuario);
		// consulta denominacion
		$sql_den = $consultasbd->select($table='tbl_denominacion',$campos='*',$where='WHERE id_denominacion=\''.$usuario['id_denominacion'].'\'');
		$res_den = $consultasbd->fetch_array($sql_den);
	} else if (isset($_POST['i_u']) && count($_POST)) {
		$id_usuario = (!empty($_POST['i_u']))?$_POST['i_u']:'';
		$cedula = (!empty($_POST['txt_cedula']))?$_POST['txt_cedula']:'';
		$nombre = (!empty($_POST['txt_nombre']))?$_POST['txt_nombre']:'';
		$apellido = (!empty($_POST['txt_apellido']))?$_POST['txt_apellido']:'';
		$denominacion = (!empty($_POST['txt_denominacion']))?$_POST['txt_denominacion']:'';
		$usuario = $consultasbd->select($tabla='tbl_usuario',$campos='*',$where=' WHERE id_usuario=\''.$id_usuario.'\'');
		// validacion de usuario
		if ($consultasbd->num_rows($usuario)>0) {
			$usuario = $consultasbd->fetch_array($usuario);
			// consulta denominacion
			$sql_den = $consultasbd->select($table='tbl_denominacion',$campos='*',$where='WHERE id_denominacion=\''.$denominacion.'\'');
			// validacion de denominacion
			if ($consultasbd->num_rows($sql_den)>0) { 
				$res_den = $consultasbd->fetch_array($sql_den);
				if ($cedula == '' || $nombre == '' || $apellido == '') { echo '<script>alertify.error("<b>Todos los campos son obligatorios </b>");</script>'; }
				else { 
					if ($cedula != $usuario['cedula']){
						// validacion de cedula existente
						$sql_ced = $consultasbd->select($tabla='tbl_usuario',$campos='cedula',$where='WHERE cedula=\''.$cedula.'\'');
						//var_dump($consultasbd->fetch_array($sql_ced));exit();
						if ($consultasbd->num_rows($sql_ced)>0){
							echo '<script>alertify.error("<b>Cedula duplicada </b>");</script>';
						} else {
							$tabla = 'tbl_usuario';
							$set   = 'cedula=\''.$cedula.'\', nombre=\''.$nombre.'\',apellido=\''.$apellido.'\', fecha_modifica=\''.date('Y-m-d').'\',id_denominacion=\''.$denominacion.'\'';
							$where = ' WHERE id_usuario=\''.$id_usuario.'\'';
							$res   = $consultasbd->update($tabla,$set,$where);
							// auditoria
							$auditar_mnsj = "Actualizó usuario. datos: (Nombre=>".$nombre.",id=>".$id_usuario.")";
							$auditar_user = $_SESSION['id_operador'];
							$auditar_date = date('Y-m-d');
							$auditar_hour = date('H:m');
							$consultasbd->insert($tabla='tbl_auditoria',$campos='(id_operador,descripcion,hora,fecha_auditoria)',$values='\''.$auditar_user.'\',\''.$auditar_mnsj.'\',\''.$auditar_hour.'\',\''.$auditar_date.'\'');
							// FIN auditoria
							echo '<script>location.href="index.php?page=list_usuarios&up=true";</script>';
						}
					} else {
						$tabla = 'tbl_usuario';
						$set   = 'cedula=\''.$cedula.'\', nombre=\''.$nombre.'\',apellido=\''.$apellido.'\', fecha_modifica=\''.date('Y-m-d').'\',id_denominacion=\''.$denominacion.'\'';
						$where = ' WHERE id_usuario=\''.$id_usuario.'\'';
						$res   = $consultasbd->update($tabla,$set,$where);
						// auditoria
						$auditar_mnsj = "Actualizó usuario. datos: (Nombre=>".$nombre.",id=>".$id_usuario.")";
						$auditar_user = $_SESSION['id_operador'];
						$auditar_date = date('Y-m-d');
						$auditar_hour = date('H:m');
						$consultasbd->insert($tabla='tbl_auditoria',$campos='(id_operador,descripcion,hora,fecha_auditoria)',$values='\''.$auditar_user.'\',\''.$auditar_mnsj.'\',\''.$auditar_hour.'\',\''.$auditar_date.'\'');
						// FIN auditoria
						echo '<script>location.href="index.php?page=list_usuarios&up=true";</script>';
					}
				}
			}
		}
	} else {
		echo '<script>location.href = "?page=list_usuarios";</script>';
	}
?>
<div class="col-sm-9 col-md-10">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title"><b>Actualizaci&oacute;n&nbsp;de&nbsp;usuario<i class="glyphicon glyphicon-star" style="float:right;"></i></b></h3>
    </div>
    <div class="panel-body">
    	<form action="?page=act_usuario" method="POST" class="well" id="frm-act-oper" accept-charset="utf-8">
    		<div class="row">
    			<div class="col-lg-3">
    				<label for="txt_cedula">Cedula&nbsp;&nbsp;<i class="glyphicon glyphicon-credit-card"></i></label>
	    			<input type="text" name="txt_cedula" id="txt_cedula" class="form-control required" title="Cedula" value="<?php echo $usuario['cedula']; ?>" />	
	    			<input type="hidden" name="i_u" value="<?php echo $id_usuario; ?>" />
    			</div>
    			<div class="col-lg-6 col-lg-offset-3">
	    			<?php 
	    				$sql_den = $consultasbd->select($tabla='tbl_denominacion');
	    			?>
	    			<label for="txt_privilegio">Denominaci&oacute;n&nbsp;&nbsp;<i class="glyphicon glyphicon-list"></i></label>
	    			<select name="txt_denominacion" class="form-control required">
	    			    <option>Seleccione denominacion</option>
	    			    <?php 
	    			    	while ($res_den = $consultasbd->fetch_array($sql_den)) { 
	    			    		if ($usuario['id_denominacion'] == $res_den['id_denominacion']) {
	    			    			echo '<option selected="selected" value="'.$res_den['id_denominacion'].'">'.$res_den['denominacion'].'</option>';
	    			    		} else {
	    			    			echo '<option value="'.$res_den['id_denominacion'].'">'.$res_den['denominacion'].'</option>';
	    			    		}
	    			    	}
	    			    ?>
	    			</select>
	    		</div>
    		</div>
    		<br/>
	    	<div class="row">
	    		<div class="col-lg-6">
	    			<label for="txt_nombre">Nombre&nbsp;&nbsp;<i class="glyphicon glyphicon-user"></i></label>
	    			<input type="text" name="txt_nombre" id="txt_nombre" class="form-control required" title="Nombre" value="<?php echo strtoupper($usuario['nombre']); ?>" />
	    		</div>
	    		<div class="col-lg-6">
	    			<label for="txt_apellido">Apellido&nbsp;&nbsp;<i class="glyphicon glyphicon-user"></i></label>
	    			<input type="text" name="txt_apellido" id="txt_apellido" class="form-control required" title="Apellido" value="<?php echo strtoupper($usuario['apellido']); ?>" />
	    		</div>
	    	</div>
	    	<br/>
	    	<br/>
	    	<div class="row">
	    		<div class="col-lg-12 text-right">
	    			<div class="pull-right">
	    				<button type="button" class="btn btn-default" id="btn-cancel">Cancelar</button>
	    				<button type="button" class="btn btn-danger" id="btn-submit">Actualizar</button>
	    			</div>
	    		</div>
	    	</div>
    	</form>
    </div>
    <div class="panel-footer text-center">
      <div class="btn-group">
          <p><i class="text-muted">BibloWeb v1.0</i></p>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" charset="utf-8">
	var validForm = true;
	$(document).on('ready',function(){
		$('#menu-item li.active').removeClass('active');
	    $('#liUsuarios').addClass('active');
	    // title page
		$('title').html('..:: Actualizaci&oacute;n de Usuario ::..&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
		valuesTitle();
		$('#btn-submit').on('click',function(){
			$.each($('.required'),function(index,value){
				if ($(this).val() == '') {
	    			alertify.error('<b>'+$(this).attr('title')+' es un campo obligatorio</b>');
	    			$(this).focus();
	    			validForm = false;
	    			return false;
	    		}
			});
			if (validForm) {
				$("#frm-act-oper").submit();
			}
		});
		$('#btn-cancel').on('click',function(){
			location.href = '?page=list_usuarios';
		});
	});
</script>