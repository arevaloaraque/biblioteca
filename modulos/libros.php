<?php
	include_once('modulos/modelo.php');
	$libros = $consultasbd->select($tabla='tbl_libros');
?>
<div class="col-sm-9 col-md-10">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title"><b>Listado&nbsp;general&nbsp;de&nbsp;libros<i class="glyphicon glyphicon-book" style="float:right;"></i></b></h3>
    </div>
    <div class="panel-body">
    	<button class='pull-right btn btn-primary' id='add-libro'>Agregar&nbsp;&nbsp;<i class="glyphicon glyphicon-plus"></i></button>
    	<br/><br/>
    	<?php if ($consultasbd->num_rows($libros) > 0): ?>
      	<div class="table-responsive">
			<table class='table table-bordered table-striped table-hover datatable dataTable' id="datatable" style='border-radius:5px;'>
			  <thead>
			  		<tr class="danger">
			  			<th class='col-lg-1 text-center'>C&oacute;digo</th>
			  			<th class='col-lg-2 text-center'>Autor</th>
			  			<th class='col-lg-2 text-center'>Editorial</th>
			  			<th class='col-lg-2 text-center'>Materia</th>
			  			<th class='col-lg-3'>Descripci&oacute;n</th>
			  			<th class='col-lg-1 text-center'>Fecha</th>
			  			<th class='text-center col-lg-1'>Acci&oacute;n(s)</th>
			  		</tr>
			  </thead>
			  <tbody>
			  	<?php while ($libro = $consultasbd->fetch_array($libros)) { ?>
			  	<?php 
			  		// datos de autor
					$res_autor = $consultasbd->select($tabla='tbl_autor',$campos='*',$where = ((!empty($libro['id_autor']))?'WHERE id_autor=\''.$libro['id_autor'].'\'':''));
					$fetch_autor = $consultasbd->fetch_array($res_autor);
					$autor = $fetch_autor['nombre'].' '.$fetch_autor['apellido'];
					// datos de editorial
					$res_editorial = $consultasbd->select($tabla='tbl_editorial',$campos='*',$where = ((!empty($libro['id_editorial']))?'WHERE id_editorial=\''.$libro['id_editorial'].'\'':''));
					$fetch_editorial = $consultasbd->fetch_array($res_editorial);
					$editorial = $fetch_editorial['nombre'].' '.$fetch_editorial['ciudad'];
					// datos de materia
					$res_materia = $consultasbd->select($tabla='tbl_materia',$campos='*',$where = ((!empty($libro['id_materia']))?'WHERE id_materia=\''.$libro['id_materia'].'\'':''));
					$fetch_materia = $consultasbd->fetch_array($res_materia);
					$materia = $fetch_materia['nombre_materia'];

					$libro['id_autor'] = $autor;
					$libro['id_editorial'] = $editorial;
					$libro['id_materia'] = $materia;
					$libro['fecha_publicacion'] = date('d-m-Y',strtotime($libro['fecha_publicacion']));
			  	?>
			  		<tr>
			  			<td class='text-center'><?php echo $libro['id_libro']; ?></td>
			  			<td class='text-center'><?php echo strtoupper($libro['id_autor']); ?></td>
			  			<td class='text-center'><?php echo strtoupper($libro['id_editorial']); ?></td>
			  			<td class='text-center'><?php echo strtoupper($libro['id_materia']); ?></td>
			  			<td><?php echo strtoupper($libro['descripcion']); ?></td>
			  			<td class='text-center'><?php echo $libro['fecha_publicacion']; ?></td>
			  			<td class='text-center'></td>
			  		</tr>
			  	<?php } ?>
			  </tbody>
			</table>
		</div>
		<?php else: ?>

		<?php endif; ?>
    </div>
    <div class="panel-footer text-center">
      <div class="btn-group">
          <p><i class="text-muted">BibloWeb v1.0</i></p>
      </div>
    </div>
  </div>
</div>

<!-- Ventana Modal, Información General de Tarea -->
<div class="modal fade" id="modalwindow">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
      	<form class="form">
      		<div class="row">
			  	<div class="form-group col-lg-4">
			    	<label for="txt_autor">Autor</label>
			    	<span class="pull-right">&nbsp;+</span>
			    	<select name="txt_autor" id="txt_autor" class="form-control">
			    		<option value="">Seleccione Autor</option>
			    	</select>
			  	</div>
			  	<div class="form-group col-lg-4">
			    	<label for="txt_editorial">Editorial&nbsp;+</label>
			    	<select name="txt_editorial" id="txt_editorial" class="form-control">
			    		<option value="">Seleccione Editorial</option>
			    	</select>
			  	</div>
			  	<div class="form-group col-lg-4">
			    	<label for="txt_materia">Materia&nbsp;+</label>
			    	<select name="txt_materia" id="txt_materia" class="form-control">
			    		<option value="">Seleccione Materia</option>
			    	</select>
			  	</div>
			</div>
			<div class="row">
			  	<div class="form-group col-lg-6">
			    	<label for="txt_edicion">edicion</label>
			    	<input type="text" name="txt_edicion" id="txt_edicion" class="form-control" />
			  	</div>
			  	<div class="form-group col-lg-6">
			    	<label for="txt_fecha">Fecha Publicaci&oacute;n</label>
			    	<input type="text" name="txt_fecha" id="txt_fecha" class="form-control" />
			  	</div>
			</div>
			<div class="row">
				<div class="form-group col-lg-12">
			    	<label for="txt_descripcion">Descripci&oacute;n</label>
			    	<textarea name="txt_descripcion" id="txt_descripcion" class="form-control"></textarea>
			  	</div>
			</div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<link rel="stylesheet" type="text/css" href="plugins/dataTables/css/datatables.css">
<script src="plugins/dataTables/js/jquery.dataTables.js" type="text/javascript"></script>
<script src="plugins/dataTables/js/datatables.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="plugins/chosen/chosen.css">
<script src="plugins/chosen/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript" >
	// Configuracion datatable
    $('#datatable').dataTable({
      "AaSorting": [[0, "asc"]],
      "sPaginationType": "bs_normal",
      ajax: "data.json"
    }); 
    $('.datatable').each(function(){
      var datatable = $(this);
      // SEARCH - Add the placeholder for Search and Turn this into in-line form control
      var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
      search_input.attr({'placeholder':'Buscar Libro','id':'btn_search_table'});
      search_input.addClass('form-control input-sm');
      // LENGTH - Inline-Form control
      var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
      length_sel.addClass('form-control input-sm');
    });
    $('#btn_search_table').attr('title','Filtrar resultado');
    $('#btn_search_table').tooltip();

    // agregar libro
    // consulta de avances en la tarea
    $('#add-libro').click(function(e){
    	$('#modalwindow').modal('show');
        $('.modal-title').html('Registro de nuevo libro&nbsp;&nbsp;<i class="glyphicon glyphicon-book"></i>');
        $('.modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>');
    });
</script>