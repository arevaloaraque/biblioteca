<?php 
	include_once('modulos/modelo.php');
	$cedula = '';
	$nombre = '';
	$apellido = '';
	$error_ced = 0;
	$denominacion = '';
	if (isset($_POST) && count($_POST)) {
		$cedula = (!empty($_POST['txt_cedula']))?$_POST['txt_cedula']:'';
		$nombre = (!empty($_POST['txt_nombre']))?$_POST['txt_nombre']:'';
		$apellido = (!empty($_POST['txt_apellido']))?$_POST['txt_apellido']:'';
		$denominacion = (!empty($_POST['txt_denominacion']))?$_POST['txt_denominacion']:'';
		// consulta cedula
		$sql_ced = $consultasbd->select($table='tbl_usuario',$campos='*',$where='WHERE cedula=\''.$cedula.'\'');
		$res_ced = $consultasbd->fetch_array($sql_ced);
		if ($consultasbd->num_rows($sql_ced)>0) { echo '<script>alertify.error("<b>Cedula duplicada </b>");</script>'; $error_ced = 1; }
		else {
			if ($cedula == '' || $nombre == '' || $apellido == '' || $denominacion == '') { echo '<script>alertify.error("<b>Todos los campos son obligatorios </b>");</script>'; }
			else { 
				$sql_den = $consultasbd->select($tabla='tbl_denominacion',$campos='id_denominacion',$where='WHERE id_denominacion=\''.$denominacion.'\'');
				if (!$consultasbd->num_rows($sql_den)>0) { echo '<script>alertify.error("<b>Denominaci&oacute;n incorrecta </b>");</script>'; }
				else {
					$tabla = 'tbl_usuario';
					$campos= '(id_denominacion,nombre,apellido,cedula,fecha_creacion)';
					$values= '\''.$denominacion.'\',\''.$nombre.'\',\''.$apellido.'\',\''.$cedula.'\',\''.date('Y-m-d').'\'';
					$res   = $consultasbd->insert($tabla,$campos,$values);
					$id = $consultasbd->fetch_array($consultasbd->max_id($tabla='tbl_usuario',$id='id_usuario'));
					// auditoria
					$auditar_mnsj = "Registro Usuario. datos: (Nombre=>".$nombre.",id=>".$id['id'].")";
					$auditar_user = $_SESSION['id_operador'];
					$auditar_date = date('Y-m-d');
					$auditar_hour = date('H:m');
					$consultasbd->insert($tabla='tbl_auditoria',$campos='(id_operador,descripcion,hora,fecha_auditoria)',$values='\''.$auditar_user.'\',\''.$auditar_mnsj.'\',\''.$auditar_hour.'\',\''.$auditar_date.'\'');
					// FIN auditoria
					echo '<script>location.href="index.php?page=list_usuarios&in=true";</script>';
				}
			}
		}
	}
?>
<div class="col-sm-9 col-md-10">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title"><b>Registro&nbsp;de&nbsp;operador<i class="glyphicon glyphicon-star" style="float:right;"></i></b></h3>
    </div>
    <div class="panel-body">
    	<form action="?page=nuevo_usuario" method="POST" class="well" id="frm-nuevo-user" accept-charset="utf-8">
    		<div class="row">
    			<div class="col-lg-3">
    				<label for="txt_cedula">Cedula&nbsp;&nbsp;<i class="glyphicon glyphicon-credit-card"></i></label>
	    			<input type="text" name="txt_cedula" id="txt_cedula" class="form-control required" title="Cedula" value="<?php echo $cedula; ?>" />	
    			</div>
    			<div class="col-lg-6 col-lg-offset-3">
	    			<?php 
	    				$sql_den = $consultasbd->select($tabla='tbl_denominacion');
	    			?>
	    			<label for="txt_privilegio">Denominaci&oacute;n&nbsp;&nbsp;<i class="glyphicon glyphicon-list"></i></label>
	    			<select name="txt_denominacion" id="txt_denominacion" class="form-control required" title="Denominaci&oacute;n">
	    			    <option></option>
	    			    <?php 
	    			    	while ($res_den = $consultasbd->fetch_array($sql_den)) { 
	    			    		if ($denominacion == $res_den['id_denominacion']) {
	    			    			echo '<option value="'.$res_den['id_denominacion'].'" selected="selected">'.$res_den['denominacion'].'</option>';
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
	    			<input type="text" name="txt_nombre" id="txt_nombre" class="form-control required" title="Nombre" value="<?php echo $nombre; ?>" />
	    		</div>
	    		<div class="col-lg-6">
	    			<label for="txt_apellido">Apellido&nbsp;&nbsp;<i class="glyphicon glyphicon-user"></i></label>
	    			<input type="text" name="txt_apellido" id="txt_apellido" class="form-control required" title="Apellido" value="<?php echo $apellido; ?>" />
	    		</div>
	    	</div>
	    	<br/>
	    	<br/>
	    	<div class="row">
	    		<div class="col-lg-12 text-right">
	    			<div class="pull-right">
	    				<button type="button" class="btn btn-default" id="btn-cancel">Cancelar</button>
	    				<button type="button" class="btn btn-danger" id="btn-submit">Guardar</button>
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
		$('title').html('..:: Registro de Operador ::..&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
		valuesTitle();
		if ('<?php echo $error_ced ?>' == 0) { $("#txt_cedula").focus(); };
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
				$("#frm-nuevo-user").submit();
			}
		});
		$('#btn-cancel').on('click',function(){
			location.href = '?page=list_usuarios';
		});
	});
</script>