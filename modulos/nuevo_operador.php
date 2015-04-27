<?php 
	include_once('modulos/modelo.php');
	$cedula = '';
	$nombre = '';
	$apellido = '';
	$error_ced = 0;
	$Clave = '';
	if (isset($_POST) && count($_POST)) {
		$cedula = (!empty($_POST['txt_cedula']))?$_POST['txt_cedula']:'';
		$nombre = (!empty($_POST['txt_nombre']))?$_POST['txt_nombre']:'';
		$apellido = (!empty($_POST['txt_apellido']))?$_POST['txt_apellido']:'';
		$clave = (!empty($_POST['txt_password']))?$_POST['txt_password']:'';
		// consulta cedula
		$sql_ced = $consultasbd->select($table='tbl_operador',$campos='*',$where='WHERE cedula=\''.$cedula.'\'');
		$res_ced = $consultasbd->fetch_array($sql_ced);
		if ($consultasbd->num_rows($sql_ced)>0) { echo '<script>alertify.error("<b>Cedula duplicada </b>");</script>'; $error_ced = 1; }
		else {
			// consulta privilegios
			$sql_priv = $consultasbd->select($table='tbl_privilegios',$campos='*',$where='WHERE privilegio=\'BIBLIOTECARIO\'');
			$res_priv = $consultasbd->fetch_array($sql_priv);
			if ($cedula == '' || $nombre == '' || $apellido == '' || $clave == '') { echo '<script>alertify.error("<b>Todos los campos son obligatorios </b>");</script>'; }
			else { 
				$tabla = 'tbl_operador';
				$campos= '(id_privilegio,nombre,apellido,cedula,password,fecha_creacion)';
				$values= '\''.$res_priv['id_privilegio'].'\',\''.$nombre.'\',\''.$apellido.'\',\''.$cedula.'\',\''.$clave.'\',\''.date('Y-m-d').'\'';
				$res   = $consultasbd->insert($tabla,$campos,$values);
				// auditoria
				$auditar_mnsj = "Registro Operador. datos: (Nombre=>".$nombre.",id=>".$id_operador.")";
				$auditar_user = $_SESSION['id_operador'];
				$auditar_date = date('Y-m-d');
				$auditar_hour = date('H:m');
				$consultasbd->insert($tabla='tbl_auditoria',$campos='(id_operador,descripcion,hora,fecha_auditoria)',$values='\''.$auditar_user.'\',\''.$auditar_mnsj.'\',\''.$auditar_hour.'\',\''.$auditar_date.'\'');
				// FIN auditoria
				echo '<script>location.href="index.php?page=list_operadores&in=true";</script>';
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
    	<form action="?page=nuevo_operador" method="POST" class="well" id="frm-new-oper" accept-charset="utf-8">
    		<div class="row">
    			<div class="col-lg-3">
    				<label for="txt_cedula">Cedula&nbsp;&nbsp;<i class="glyphicon glyphicon-credit-card"></i></label>
	    			<input type="text" name="txt_cedula" id="txt_cedula" class="form-control required" title="Cedula" value="<?=$cedula?>" />	
    			</div>
    		</div>
    		<br/>
	    	<div class="row">
	    		<div class="col-lg-6">
	    			<label for="txt_nombre">Nombre&nbsp;&nbsp;<i class="glyphicon glyphicon-user"></i></label>
	    			<input type="text" name="txt_nombre" id="txt_nombre" class="form-control required" title="Nombre" value="<?=$nombre?>" />
	    		</div>
	    		<div class="col-lg-6">
	    			<label for="txt_apellido">Apellido&nbsp;&nbsp;<i class="glyphicon glyphicon-user"></i></label>
	    			<input type="text" name="txt_apellido" id="txt_apellido" class="form-control required" title="Apellido" value="<?=$apellido?>" />
	    		</div>
	    	</div>
	    	<br/>
	    	<div class="row">
	    		<div class="col-lg-6">
	    			<label for="txt_privilegio">Privilegio&nbsp;&nbsp;<i class="glyphicon glyphicon-star"></i></label>
	    			<input type="text" name="txt_privilegio" id="txt_privilegio" class="form-control required" title="Privilegio" value="BIBLIOTECARIO" disabled="disabled" />
	    		</div>
	    		<div class="col-lg-6">
	    			<label for="txt_password">Contrase&ntilde;a&nbsp;&nbsp;<i class="glyphicon glyphicon-lock"></i>&nbsp;&nbsp;<i class="text-info pull-right"></i></label>
	    			<input type="password" name="txt_password" id="txt_password" class="form-control required" title="Clave de Acceso" value="<?=$clave?>" />
	    		</div>
	    	</div>
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
				$("#frm-new-oper").submit();
			}
		});
	});
</script>