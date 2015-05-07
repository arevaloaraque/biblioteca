<?php 
	include_once('modulos/modelo.php');
	if (isset($_GET['id_libro'])) {
		$id_libro = $_GET['id_libro'];
		$sql_libro = $consultasbd->select($tabla='tbl_libros',$campos='*',$where=' WHERE status=true');
		$datos_libro = $consultasbd->fetch_array($sql_libro);
	}
?>
<div class="col-sm-9 col-md-10">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title"><b>Registro&nbsp;Prestamo&nbsp;de&nbsp;Libro<i class="glyphicon glyphicon-transfer" style="float:right;"></i></b></h3>
    </div>
    <div class="panel-body">
    	<form action="?page=act_operador" method="POST" class="well" id="frm-act-oper" accept-charset="utf-8">
    		<div class="row">
    			<div class="col-lg-2">
    				<label for="txt_codigo_libro">Cod&iacute;go&nbsp;Libro&nbsp;&nbsp;<i class="glyphicon glyphicon-credit-card"></i></label>
	    			<input type="text" name="txt_codigo_libro" id="txt_codigo_libro" class="form-control required" title="Cod&iacute;go Libro" value="<?php echo $datos_libro['id_libro']; ?>" />	
    			</div>
    		</div>
    		<br/>
	    	<div class="row">
	    		<div class="col-lg-12">
	    			<label for="txt_descripcion">Descripci&oacute;n&nbsp;Libro&nbsp;&nbsp;<i class="glyphicon glyphicon-book"></i></label>
	    			<input type="text" name="txt_descripcion" id="txt_descripcion" class="form-control required" title="Descripcion Libro" value="<?php echo strtoupper($datos_libro['descripcion']); ?>" />
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