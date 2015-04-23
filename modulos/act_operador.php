<?php 
	include_once('modulos/modelo.php');
	if (isset($_GET['id_operador'])) {
		$id_operador = $_GET['id_operador'];
		$operador = $consultasbd->select($tabla='tbl_operador',$campos='*',$where=' WHERE id_operador=\''.$id_operador.'\'');
		$operador = $consultasbd->fetch_array($operador);

		// consulta privilegios
		$sql_priv = $consultasbd->select($table='tbl_privilegios',$campos='*',$where='WHERE id_privilegio=\''.$operador['id_privilegio'].'\'');
		$res_priv = $consultasbd->fetch_array($sql_priv);
	}
?>
<div class="col-sm-9 col-md-10">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title"><b>Actualizaci&oacute;n&nbsp;de&nbsp;operador<i class="glyphicon glyphicon-star" style="float:right;"></i></b></h3>
    </div>
    <div class="panel-body">
    	<form action="?page=act_operador" method="POST" class="well" accept-charset="utf-8">
    		<div class="row">
    			<div class="col-lg-3">
    				<label for="txt_cedula">Cedula&nbsp;&nbsp;<i class="glyphicon glyphicon-credit-card"></i></label>
	    			<input type="text" name="txt_cedula" id="txt_cedula" class="form-control" title="Cedula" value="<?php echo $operador['cedula']; ?>" />	
    			</div>
    		</div>
    		<br/>
	    	<div class="row">
	    		<div class="col-lg-6">
	    			<label for="txt_nombre">Nombre&nbsp;&nbsp;<i class="glyphicon glyphicon-user"></i></label>
	    			<input type="text" name="txt_nombre" id="txt_nombre" class="form-control" title="Nombre" value="<?php echo $operador['nombre']; ?>" />
	    		</div>
	    		<div class="col-lg-6">
	    			<label for="txt_apellido">Apellido&nbsp;&nbsp;<i class="glyphicon glyphicon-user"></i></label>
	    			<input type="text" name="txt_apellido" id="txt_apellido" class="form-control" title="Apellido" value="<?php echo $operador['apellido']; ?>" />
	    		</div>
	    	</div>
	    	<br/>
	    	<div class="row">
	    		<div class="col-lg-6">
	    			<label for="txt_privilegio">Privilegio&nbsp;&nbsp;<i class="glyphicon glyphicon-star"></i></label>
	    			<input type="text" name="txt_privilegio" id="txt_privilegio" class="form-control" title="Privilegio" value="<?php echo $res_priv['privilegio']; ?>" />
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
	    				<button type="button" class="btn btn-muted">Cancelar</button>
	    				<button type="submit" class="btn btn-danger">Actualizar</button>
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