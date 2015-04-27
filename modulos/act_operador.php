<?php 
	include_once('modulos/modelo.php');
	if (isset($_GET['id_operador'])) {
		$id_operador = $_GET['id_operador'];
		$operador = $consultasbd->select($tabla='tbl_operador',$campos='*',$where=' WHERE id_operador=\''.$id_operador.'\'');
		if (!$consultasbd->num_rows($operador)>0) { echo '<script>location.href = "?page=list_operadores";</script>'; }
		$operador = $consultasbd->fetch_array($operador);
		// consulta privilegios
		$sql_priv = $consultasbd->select($table='tbl_privilegios',$campos='*',$where='WHERE id_privilegio=\''.$operador['id_privilegio'].'\'');
		$res_priv = $consultasbd->fetch_array($sql_priv);
	} else if (isset($_POST['i_o']) && count($_POST)) {
		$id_operador = (!empty($_POST['i_o']))?$_POST['i_o']:'';
		$cedula = (!empty($_POST['txt_cedula']))?$_POST['txt_cedula']:'';
		$nombre = (!empty($_POST['txt_nombre']))?$_POST['txt_nombre']:'';
		$apellido = (!empty($_POST['txt_apellido']))?$_POST['txt_apellido']:'';
		$clave = (!empty($_POST['txt_password']))?$_POST['txt_password']:'';
		$operador = $consultasbd->select($tabla='tbl_operador',$campos='*',$where=' WHERE id_operador=\''.$id_operador.'\'');
		$operador = $consultasbd->fetch_array($operador);
		// consulta privilegios
		$sql_priv = $consultasbd->select($table='tbl_privilegios',$campos='*',$where='WHERE id_privilegio=\''.$operador['id_privilegio'].'\'');
		$res_priv = $consultasbd->fetch_array($sql_priv);
		if ($cedula == '' || $nombre == '' || $apellido == '') { echo '<script>alertify.error("<b>Cedula, Nombre o Apellido son obligatorios </b>");</script>'; }
		else {
			// validacion de cedula existente
			$sql_ced = $consultasbd->select($tabla='tbl_operador',$campos='cedula',$where='WHERE cedula<>\''.$operador['cedula'].'\'');
			if ($consultasbd->num_rows($sql_ced)>0){
				$tabla = 'tbl_operador';
				$set   = 'cedula=\''.$cedula.'\', nombre=\''.$nombre.'\',apellido=\''.$apellido.'\', fecha_modifica=\''.date('Y-m-d').'\'';
				$set  .= (!empty($clave))?', clave=\''.$clave.'\'':'';
				$where = ' WHERE id_operador=\''.$id_operador.'\'';
				$res   = $consultasbd->update($tabla,$set,$where);
				// auditoria
				$auditar_mnsj = "Actualizó operador. datos: (Nombre=>".$nombre.",id=>".$id_operador.")";
				$auditar_user = $_SESSION['id_operador'];
				$auditar_date = date('Y-m-d');
				$auditar_hour = date('H:m');
				$consultasbd->insert($tabla='tbl_auditoria',$campos='(id_operador,descripcion,hora,fecha_auditoria)',$values='\''.$auditar_user.'\',\''.$auditar_mnsj.'\',\''.$auditar_hour.'\',\''.$auditar_date.'\'');
				// FIN auditoria
				echo '<script>location.href="index.php?page=list_operadores&up=true";</script>';
			} else {
				echo '<script>alertify.error("<b>Cedula duplicada </b>");</script>';
			}
		}
	} else {
		echo '<script>location.href = "?page=list_operadores";</script>';
	}
?>
<div class="col-sm-9 col-md-10">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title"><b>Actualizaci&oacute;n&nbsp;de&nbsp;operador<i class="glyphicon glyphicon-star" style="float:right;"></i></b></h3>
    </div>
    <div class="panel-body">
    	<form action="?page=act_operador" method="POST" class="well" id="frm-act-oper" accept-charset="utf-8">
    		<div class="row">
    			<div class="col-lg-3">
    				<label for="txt_cedula">Cedula&nbsp;&nbsp;<i class="glyphicon glyphicon-credit-card"></i></label>
	    			<input type="text" name="txt_cedula" id="txt_cedula" class="form-control required" title="Cedula" value="<?php echo $operador['cedula']; ?>" />	
	    			<input type="hidden" name="i_o" value="<?php echo $id_operador; ?>" />
    			</div>
    		</div>
    		<br/>
	    	<div class="row">
	    		<div class="col-lg-6">
	    			<label for="txt_nombre">Nombre&nbsp;&nbsp;<i class="glyphicon glyphicon-user"></i></label>
	    			<input type="text" name="txt_nombre" id="txt_nombre" class="form-control required" title="Nombre" value="<?php echo strtoupper($operador['nombre']); ?>" />
	    		</div>
	    		<div class="col-lg-6">
	    			<label for="txt_apellido">Apellido&nbsp;&nbsp;<i class="glyphicon glyphicon-user"></i></label>
	    			<input type="text" name="txt_apellido" id="txt_apellido" class="form-control required" title="Apellido" value="<?php echo strtoupper($operador['apellido']); ?>" />
	    		</div>
	    	</div>
	    	<br/>
	    	<div class="row">
	    		<div class="col-lg-6">
	    			<label for="txt_privilegio">Privilegio&nbsp;&nbsp;<i class="glyphicon glyphicon-star"></i></label>
	    			<input type="text" name="txt_privilegio" id="txt_privilegio" class="form-control" title="Privilegio" disabled="disabled" value="<?php echo strtoupper($res_priv['privilegio']); ?>" />
	    		</div>
	    		<div class="col-lg-6">
	    			<label for="txt_password">Contrase&ntilde;a&nbsp;&nbsp;<i class="glyphicon glyphicon-lock"></i>&nbsp;&nbsp;<i class="text-info pull-right"><small>Omitir&nbsp;si&nbsp;no&nbsp;desea&nbsp;actualizar</small>&nbsp;<i class="glyphicon glyphicon-info-sign"></i></i></label>
	    			<input type="text" name="txt_password" id="txt_password" class="form-control" title="Clave de Acceso" />
	    		</div>
	    	</div>
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
		$('title').html('..:: Actualizaci&oacute;n de Operador ::..&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
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
			location.href = '?page=list_operadores';
		});
	});
</script>