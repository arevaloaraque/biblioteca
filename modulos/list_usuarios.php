<?php 
	include_once('modulos/modelo.php');
	$usuarios = $consultasbd->select($tabla='tbl_usuario');
?>
<div class="col-sm-9 col-md-10">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title"><b>Listado&nbsp;general&nbsp;de&nbsp;usuarios<i class="glyphicon glyphicon-star-empty" style="float:right;"></i></b></h3>
    </div>
    <div class="panel-body">
    	<button class='pull-right btn btn-primary' id='add-operador' onclick="location.href='?page=nuevo_usuario';">Agregar&nbsp;&nbsp;<i class="glyphicon glyphicon-plus"></i></button>
    	<button data-toggle="tooltip" data-placement="top" title="Actualizar tabla" onClick="location.href='?page=list_usuarios';" class='btn btn-info'><i class="glyphicon glyphicon-refresh"></i></button>
    	<br/><br/>
      	<div class="table-responsive">
			<table class='table table-bordered table-striped table-hover datatable dataTable' id="datatable" style='border-radius:5px;'>
			  <thead>
			  		<tr class="danger">
			  			<th class='col-lg-1 text-center'>Id Usuario</th>
			  			<th class='col-lg-1 text-center'>Denominaci&oacute;n</th>
			  			<th class='col-lg-1 text-center'>Cedula</th>
			  			<th class='col-lg-2 text-center'>Nombre</th>
			  			<th class='col-lg-2 text-center'>Apellido</th>
			  			<th class='col-lg-2 text-center'>Fecha Creaci&oacute;n</th>
			  			<th class='col-lg-2 text-center'>Fecha Ult. Modificaci&oacute;n</th>
			  			<th class='text-center col-lg-1'>Acci&oacute;nes</th>
			  		</tr>
			  </thead>
			  <tbody>
			  	<?php while ($datos = $consultasbd->fetch_array($usuarios)) { ?>
			  	<?php
			  		// consulta denominacion
					$sql_den = $consultasbd->select($table='tbl_denominacion',$campos='*',$where='WHERE id_denominacion=\''.$datos['id_denominacion'].'\'');
					$res_den = $consultasbd->fetch_array($sql_den);
					// consultar prestamos del usuario
					$sql_prestamos = $consultasbd->query("select * from tbl_prestamo_libro where id_usuario='".$datos['id_usuario']."' and status=true union all select * from tbl_prestamo_tesis where id_usuario='".$datos['id_usuario']."' and status=true union all select * from tbl_prestamo_material where id_usuario='".$datos['id_usuario']."' and status=true");
					$res_prestamos = $consultasbd->num_rows($sql_prestamos);
			  	?>
			  		<tr id="<?php echo $datos['id_usuario']; ?>">
			  			<td class='text-center'><?php echo $datos['id_usuario']; ?></td>
			  			<td class='text-center'><?php echo $res_den['denominacion']; ?></td>
			  			<td class='text-center'><?php echo $datos['cedula']; ?></td>
			  			<td class='text-center nombre_user'><?php echo strtoupper($datos['nombre']); ?></td>
			  			<td class='text-center apellido_user'><?php echo strtoupper($datos['apellido']); ?></td>
			  			<td class='text-center'><?php echo (!empty($datos['fecha_creacion'])?date('d-m-Y',strtotime($datos['fecha_creacion'])):'<i>NO DISPONIBLE</i>'); ?></td>
			  			<td class='text-center'><?php echo (!empty($datos['fecha_modifica'])?date('d-m-Y',strtotime($datos['fecha_modifica'])):'<i>NO DISPONIBLE</i>'); ?></td>
			  			<td class='text-center'>
			  				<button id="edit-<?php echo $datos['id_usuario']; ?>" class="edit-user text-info btn" data-toggle="tooltip" data-placement="top" title="Actualizar datos del usuario"><i class="glyphicon glyphicon-edit"></i></button>
			  				<button id="del-<?php echo $datos['id_usuario']; ?>" class="del-user<?php echo ($res_prestamos > 0)?' none':''; ?> text-danger btn" data-toggle="tooltip" data-placement="top" title="Eliminar usuario"><i class="glyphicon glyphicon-trash"></i></button>
			  			</td>
			  		</tr>
			  	<?php } ?>
			  </tbody>
			</table>
		</div>
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
	      search_input.attr({'placeholder':'Buscar Usuario','id':'btn_search_table'});
	      search_input.addClass('form-control input-sm');
	      // LENGTH - Inline-Form control
	      var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
	      length_sel.addClass('form-control input-sm');
	    });
		$('#menu-item li.active').removeClass('active');
	    $('#liUsuarios').addClass('active');
	    // title page
		$('title').html('..:: Listado General de Usuarios ::..&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
		valuesTitle();
		$(document).on('click','.del-user',function(){
			var id = $(this).attr('id').substring(4,$(this).attr('id').length);
			var mensaje = "¿Realmente desea eliminar al usuario \""+$('#'+id+' .nombre_user').text()+" "+$('#'+id+' .apellido_user').text()+"\"?<br/>&nbsp;Este proceso es irreversible";
	        if ($(this).hasClass("none")) {
		        alertify.alert("<b>\""+$('#'+id+' .nombre_user').text()+" "+$('#'+id+' .apellido_user').text()+"\" posee prestamos activos<br/>No puede ser eliminado</b>").set('label','Si, Entiendo!');
		    } else {
		    	alertify.confirm(mensaje, function (e) {
		            if (e) {
		                $.ajax({
		                    type: 'POST',
		                    dataType: 'json',
		                    data: {'campo':'id_usuario','val':id,'function':'eliminar','tabla':'tbl_usuario'},
		                    url: 'modulos/response_ajax.php',
		                    success: function (resp) {
		                        if (resp == 0) { alertify.error('<b>Error al eliminar usuario!</b>'); }
		                        else if(resp == 1){ $("#"+id).fadeOut(); alertify.success('<b>Usuario eliminado con exito!</b>'); }
		                    },
		                    error: function (xhr, ajaxOptions, thrownError) {
		                        //console.log(xhr.status);
		                        //console.log(thrownError);
		                    },
		                });
		            }
		        });
		    }
		});
		$(document).on('click','.edit-user',function(){
			var id = $(this).attr('id').substring(5,$(this).attr('id').length);
			location.href = '?page=act_usuario&id_usuario='+id;
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