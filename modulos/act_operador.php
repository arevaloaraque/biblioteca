<?php 
	include_once('modulos/modelo.php');
	if (isset($_GET['id_operador'])) {
		$id_operador = $_GET['id_operador'];
		$operador = $consultasbd->select($tabla='tbl_operador',$campos='*',$where=' WHERE id_operador=\''.$id_operador.'\'');
		$operador = $consultasbd->fetch_array($operador);
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
	    			<input type="text" name="txt_cedula" id="txt_cedula" class="form-control" title="Cedula" />	
    			</div>
    		</div>
    		<br/>
	    	<div class="row">
	    		<div class="col-lg-6">
	    			<label for="txt_nombre">Nombre&nbsp;&nbsp;<i class="glyphicon glyphicon-user"></i></label>
	    			<input type="text" name="txt_nombre" id="txt_nombre" class="form-control" title="Nombre" />
	    		</div>
	    		<div class="col-lg-6">
	    			<label for="txt_apellido">Apellido&nbsp;&nbsp;<i class="glyphicon glyphicon-user"></i></label>
	    			<input type="text" name="txt_apellido" id="txt_apellido" class="form-control" title="Apellido" />
	    		</div>
	    	</div>
	    	<br/>
	    	<div class="row">
	    		<div class="col-lg-6">
	    			<label for="txt_privilegio">Privilegio&nbsp;&nbsp;<i class="glyphicon glyphicon-star"></i></label>
	    			<input type="text" name="txt_privilegio" id="txt_privilegio" class="form-control" title="Privilegio" />
	    		</div>
	    		<div class="col-lg-6">
	    			<label for="txt_password">Contrase&ntilde;a&nbsp;&nbsp;<i class="glyphicon glyphicon-lock"></i></label>
	    			<input type="text" name="txt_password" id="txt_password" class="form-control" title="Clave de Acceso" />
	    		</div>
	    	</div>
	    	<br/>
    	</form>
    </div>
    <div class="panel-footer text-center">
      <div class="btn-group">
          <p><i class="text-muted">BibloWeb v1.0</i></p>
      </div>
    </div>
  </div>
</div>