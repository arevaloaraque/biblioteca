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
			    	<select name="txt_autor" id="txt_autor" class="chosen-select form-control" data-placeholder="Seleccione autor">
			    	</select>
			  	</div>
			  	<div class="form-group col-lg-4">
			    	<label for="txt_editorial">Editorial</label>
			    	<select name="txt_editorial" id="txt_editorial" class="form-control">
			    	</select>
			  	</div>
			  	<div class="form-group col-lg-4">
			    	<label for="txt_materia">Materia</label>
			    	<select name="txt_materia" id="txt_materia" class="form-control">
			    	</select>
			  	</div>
			</div>
			<div class="row">
			  	<div class="form-group col-lg-6">
			    	<label for="txt_edicion">Edici&oacute;n</label>
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

<div id="dialog" title="Nuevo Autor">
  <p id="contentdialog">
	<div class="form-group">
		<label for="txt_nombre">Nombre autor:</label>
		<input type="text" class="form-control" id="txt_nombre" name="txt_nombre" placeholder="Ingrese nombre autor">
	</div>
	<div class="form-group">
		<label for="txt_apellido">Apellido autor</label>
		<input type="text" class="form-control" id="txt_apellido" name="txt_apellido" placeholder="Ingrese apellido autor">
	</div>
	<button class="btn btn-danger pull-right" id="btn-new-autor">Guardar&nbsp;&nbsp;<i class="glyphicon glyphicon-save"></i></button>
  </p>
</div>
<script src="librerias/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="librerias/jquery-ui/jquery-ui.min.css">
<link rel="stylesheet" type="text/css" href="plugins/dataTables/css/datatables.css">
<script src="plugins/dataTables/js/jquery.dataTables.js" type="text/javascript"></script>
<script src="plugins/dataTables/js/datatables.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="plugins/chosen_v1.4.0/chosen.css">
<script src="plugins/chosen_v1.4.0/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript" >
	var select_autor 	 = function () {};
	var select_editorial = function () {};
	var select_materia   = function () {};
	$(document).on('ready',function(){
		select_autor = function () {
			$.ajax({
				url: 'modulos/response_ajax.php',
				method: 'POST',
				data: {'function':'get_data','tabla':'tbl_autor'},
				success: function (resp) {
					if (resp != '') {
						var data = JSON.parse(resp);
						var html = '<option value="">Seleccione Autor</option>';
						for (var i = 0; i < data.length; i++) {
							html += '<option value="'+data[i].id_autor+'">'+data[i].nombre.toUpperCase()+' '+data[i].apellido.toUpperCase()+'</option>';
						};
						$('#txt_autor').html(html);
						$('#txt_autor').trigger("chosen:updated");
					}
				}
			});
		};
		select_editorial = function () {
			$.ajax({
				url: 'modulos/response_ajax.php',
				method: 'POST',
				data: {'function':'get_data','tabla':'tbl_editorial'},
				success: function (resp) {
					if (resp != '') {
						var data = JSON.parse(resp);
						var html = '<option value="">Seleccione Editorial</option>';
						for (var i = 0; i < data.length; i++) {
							html += '<option value="'+data[i].id_editorial+'">'+data[i].nombre.toUpperCase()+' '+data[i].ciudad.toUpperCase()+'</option>';
						};
						$('#txt_editorial').html(html);
						$('#txt_editorial').trigger("chosen:updated");
					}
				}
			});
		};
		select_materia = function () {
			$.ajax({
				url: 'modulos/response_ajax.php',
				method: 'POST',
				data: {'function':'get_data','tabla':'tbl_materia'},
				success: function (resp) {
					if (resp != '') {
						var data = JSON.parse(resp);
						var html = '<option value="">Seleccione Materia</option>';
						for (var i = 0; i < data.length; i++) {
							html += '<option value="'+data[i].id_materia+'">'+data[i].nombre_materia.toUpperCase()+'</option>';
						};
						$('#txt_materia').html(html);
						$('#txt_materia').trigger("chosen:updated");
					}
				}
			});
		};
		$('#menu-item li.active').removeClass('active');
	    $('#liRecursos').addClass('active');
	    // title page
		$('title').html('..:: Listado General de Libros ::..&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
		valuesTitle();
		// creacion de la ventana de dialogo
		 $( "#dialog" ).dialog();
		 $( ".ui-dialog" ).css({'border':'2px solid #000'});
		 $( ".ui-dialog" ).hide();
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

	    // convertir selects a chosen
	    $('#txt_autor').chosen({no_results_text:'<a class="crear_recurso_autor" title="Registrar nuevo autor" >Crear!</a>',width:"100%"});
	    $('#txt_editorial').chosen({no_results_text:'<a class="crear_recurso_editorial" title="Registrar nueva editorial" >Crear!</a>',width:"100%"});
	    $('#txt_materia').chosen({no_results_text:'<a class="crear_recurso_materia" title="Registrar nueva materia" >Crear!</a>',width:"100%"});
	    // crear recurso
	    $(document).on( "click",".crear_recurso_autor",function() {
	    	valor = $(".chosen-search input").val();
	    	$('.ui-dialog').fadeIn();
	    	$('#modalwindow').modal('hide');
	    });
	    // mostrar ventana modal para registro de libro
	    $('#add-libro').click(function(e){
	    	select_autor();
	    	select_editorial();
	    	select_materia();
	    	$('#modalwindow').modal('show');
	        $('.modal-title').html('Registro de nuevo libro&nbsp;&nbsp;<i class="glyphicon glyphicon-book"></i>');
	        $('.modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>');
	    });

	    // validacion de nuevo autor
	    $('#btn-new-autor').click(function(){
	    	if ($('#txt_nombre').val() == '') {
	    		$('#txt_nombre').focus();
	    		alertify.error('<b>Nombre autor es obligatorios</b>');
	    		return false;
	    	} else if ($('#txt_apellido').val() == '') {
	    		$('#txt_apellido').focus();
	    		alertify.error('<b>Apellido autor es obligatorios</b>');
	    		return false;
	    	} else {
	    		$.post('modulos/response_ajax.php',{'nombre':$('#txt_nombre').val(), 'apellido':$('#txt_apellido').val(), 'function':'insertar_autor_libro'}, function(data){
					if (data == 0) {
						alertify.error('<b>Por favor, no alterar contenido HTML</b>');
					}
	    		});
	    		$('.ui-dialog').fadeOut();
	    		alertify.success('Todo esta bien!');
	    		$('#modalwindow').modal('show');
	    	}
	    });
	});
</script>