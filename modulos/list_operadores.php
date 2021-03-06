<?php 
	include_once('modulos/modelo.php');
	if ($_SESSION['id_operador'] == '2'):
		echo '<script>location.href="?page=404";</script>';
	endif;
	$operadores = $consultasbd->select($tabla='tbl_operador');
?>
<div class="col-sm-9 col-md-10">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title"><b>Listado&nbsp;general&nbsp;de&nbsp;operadores<i class="glyphicon glyphicon-star" style="float:right;"></i></b></h3>
    </div>
    <div class="panel-body">
    	<button class='pull-right btn btn-primary' id='add-operador' onclick="location.href='?page=nuevo_operador';">Agregar&nbsp;&nbsp;<i class="glyphicon glyphicon-plus"></i></button>
    	<button data-toggle="tooltip" data-placement="top" title="Actualizar tabla" onClick="location.href='?page=list_operadores';" class='btn btn-info'><i class="glyphicon glyphicon-refresh"></i></button>
    	<br/><br/>
    	<?php //if ($consultasbd->num_rows($libros) > 0): ?>
      	<div class="table-responsive">
			<table class='table table-bordered table-striped table-hover datatable dataTable' id="datatable" style='border-radius:5px;'>
			  <thead>
			  		<tr class="danger">
			  			<th class='col-lg-1 text-center'>Id Operador</th>
			  			<th class='col-lg-2 text-center'>Nombre</th>
			  			<th class='col-lg-2 text-center'>Apellido</th>
			  			<th class='col-lg-1 text-center'>Cedula</th>
			  			<th class='col-lg-2 text-center'>Fecha Creaci&oacute;n</th>
			  			<th class='col-lg-2 text-center'>Fecha Ult. Modificaci&oacute;n</th>
			  			<th class='col-lg-1 text-center'>Privilegio</th>
			  			<th class='text-center col-lg-1'>Acci&oacute;nes</th>
			  		</tr>
			  </thead>
			  <tbody>
			  	<?php while ($datos = $consultasbd->fetch_array($operadores)) { ?>
			  	<?php
			  		// consulta privilegios
					$sql_priv = $consultasbd->select($table='tbl_privilegios',$campos='*',$where='WHERE id_privilegio=\''.$datos['id_privilegio'].'\'');
					$res_priv = $consultasbd->fetch_array($sql_priv);
					//if (trim($res_priv['privilegio']) != "ADMINISTRADOR"){
			  	?>
			  		<tr id="<?php echo $datos['id_operador']; ?>">
			  			<td class='text-center'><?php echo $datos['id_operador']; ?></td>
			  			<td class='text-center nombre_oper'><?php echo strtoupper($datos['nombre']); ?></td>
			  			<td class='text-center apellido_oper'><?php echo strtoupper($datos['apellido']); ?></td>
			  			<td class='text-center'><?php echo strtoupper($datos['cedula']); ?></td>
			  			<td class='text-center'><?php echo (!empty($datos['fecha_creacion'])?date('d-m-Y',strtotime($datos['fecha_creacion'])):'<i>NO DISPONIBLE</i>'); ?></td>
			  			<td class='text-center'><?php echo (!empty($datos['fecha_modifica'])?date('d-m-Y',strtotime($datos['fecha_modifica'])):'<i>NO DISPONIBLE</i>'); ?></td>
			  			<td class='text-center'><?php echo $res_priv['privilegio']; ?></td>
			  			<td class='text-center'>
			  				<button id="edit-<?php echo $datos['id_operador']; ?>" class="edit-oper text-info btn" data-toggle="tooltip" data-placement="top" title="Actualizar datos del operador"><i class="glyphicon glyphicon-edit"></i></button>
			  				<button id="del-<?php echo $datos['id_operador']; ?>" class="del-oper text-danger btn" data-toggle="tooltip" data-placement="top" title="Eliminar operador"><i class="glyphicon glyphicon-trash"></i></button>
			  			</td>
			  		</tr>
			  	<?php }//} ?>
			  </tbody>
			</table>
		</div>
		<?php //else: ?>

		<?php //endif; ?>
    </div>
    <div class="panel-footer text-center">
      <div class="btn-group">
          <p><i class="text-muted">BibloWeb v1.0</i></p>
      </div>
    </div>
  </div>
</div>
<link rel="stylesheet" type="text/css" href="plugins/dataTables/css/datatables.css">
<script src="plugins/dataTables/js/jquery.dataTables.js" type="text/javascript"></script>
<script src="plugins/dataTables/js/datatables.js" type="text/javascript"></script>
<script type="text/javascript" charset="utf-8">
	$(document).on('ready',function(){
		// Configuracion datatable
	    $('#datatable').dataTable({
	      "AaSorting": [[0, "asc"]],
	      "sPaginationType": "bs_normal",
	    }); 
	    $('.datatable').each(function(){
	      var datatable = $(this);
	      // SEARCH - Add the placeholder for Search and Turn this into in-line form control
	      var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
	      search_input.attr({'placeholder':'Buscar Operador','id':'btn_search_table'});
	      search_input.addClass('form-control input-sm');
	      // LENGTH - Inline-Form control
	      var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
	      length_sel.addClass('form-control input-sm');
	    });
		$('#menu-item li.active').removeClass('active');
	    $('#liUsuarios').addClass('active');
	    // title page
		$('title').html('..:: Listado General de Operadores ::..&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
		valuesTitle();
		$(document).on('click','.del-oper',function(){
			var id = $(this).attr('id').substring(4,$(this).attr('id').length);
			var mensaje = "¿Realmente desea eliminar al operador \""+$('#'+id+' .nombre_oper').text()+" "+$('#'+id+' .apellido_oper').text()+"\"?<br/>&nbsp;Este proceso es irreversible";
	        alertify.confirm(mensaje, function (e) {
	            if (e) {
	                $.ajax({
	                    type: 'POST',
	                    dataType: 'json',
	                    data: {'campo':'id_operador','val':id,'function':'eliminar','tabla':'tbl_operador'},
	                    url: 'modulos/response_ajax.php',
	                    success: function (resp) {
	                        if (resp == 0) { alertify.error('<b>Error al eliminar libro!</b>'); }
	                        else if(resp == 1){ $("#"+id).fadeOut(); alertify.success('<b>Libro eliminado con exito!</b>'); }
	                    },
	                    error: function (xhr, ajaxOptions, thrownError) {
	                        //console.log(xhr.status);
	                        //console.log(thrownError);
	                    },
	                });
	            }
	        });
		});
		$(document).on('click','.edit-oper',function(){
			var id = $(this).attr('id').substring(5,$(this).attr('id').length);
			location.href = '?page=act_operador&id_operador='+id;
		})
	});
</script>
<?php 
	if (isset($_GET['up'])) {
		echo '<script>alertify.success("<b>Actualizado con exito</b>");</script>';
	}
	if (isset($_GET['in'])) {
		echo '<script>alertify.success("<b>Registrado con exito</b>");</script>';
	}
?>