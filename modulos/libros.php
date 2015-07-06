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
    	<button data-toggle="tooltip" data-placement="top" title="Actualizar tabla" class='btn btn-info' id='add-libro' onclick="location.href = 'index.php?page=libros';"><i class="glyphicon glyphicon-refresh"></i></button>
    	<br/><br/>
    	<?php //if ($consultasbd->num_rows($libros) > 0): ?>
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
			  			<th class='text-center col-lg-1'>Acci&oacute;nes</th>
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
			  		<tr id="<?php echo $libro['id_libro']; ?>">
			  			<td class='text-center'><?php echo $libro['id_libro']; ?></td>
			  			<td class='text-center autor_libro'><?php echo strtoupper($libro['id_autor']); ?></td>
			  			<td class='text-center editorial_libro'><?php echo strtoupper($libro['id_editorial']); ?></td>
			  			<td class='text-center materia_libro'><?php echo strtoupper($libro['id_materia']); ?></td>
			  			<td class='descripcion_libro'><?php echo strtoupper($libro['descripcion']); ?></td>
			  			<td class='text-center fecha_libro'><?php echo $libro['fecha_publicacion']; ?></td>
			  			<td class='text-center'>
			  				<?php if (trim($libro['status']) == 'f'): ?>
			  					<button class="btn btn-success">Prestado&nbsp;&nbsp;<i class="glyphicon glyphicon-remove"></i></button>
			  				<?php else: ?>
			  				<button id="edit-<?php echo $libro['id_libro']; ?>" class="edit-libro text-info btn" data-toggle="tooltip" data-placement="top" title="Actualizar libro"><i class="glyphicon glyphicon-edit"></i></button>
			  				<button id="del-<?php echo $libro['id_libro']; ?>" class="del-libro text-danger btn" data-toggle="tooltip" data-placement="top" title="Eliminar libro"><i class="glyphicon glyphicon-trash"></i></button>
			  				<?php endif; ?>
			  			</td>
			  		</tr>
			  	<?php } ?>
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

<!-- Generated markup by the plugin -->
<div class="tooltip top" role="tooltip">
  <div class="tooltip-arrow"></div>
  <div class="tooltip-inner">
    
  </div>
</div>

<!-- Ventana Modal, Agregar nuevo libro -->
<div class="modal fade" id="modalwindow">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true" class="text-danger"><small>[&times;]</small></span><span class="sr-only"></span></button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
      	<form class="form" id="form-new-libro">
      		<div class="row">
			  	<div class="form-group col-lg-4">
			    	<label for="txt_autor">Autor</label>
			    	<select name="txt_autor" id="txt_autor" class="chosen-select form-control required" data-placeholder="Seleccione autor" title="Autor">
			    	</select>
			  	</div>
			  	<div class="form-group col-lg-4">
			    	<label for="txt_editorial">Editorial</label>
			    	<select name="txt_editorial" id="txt_editorial" class="form-control required" data-placeholder="Seleccione editorial" title="Editorial">
			    	</select>
			  	</div>
			  	<div class="form-group col-lg-4">
			    	<label for="txt_materia">Materia</label>
			    	<select name="txt_materia" id="txt_materia" class="form-control required" data-placeholder="Seleccione materia" title="Materia">
			    	</select>
			  	</div>
			</div>
			<div class="row">
			  	<div class="form-group col-lg-6">
			    	<label for="txt_edicion">Edici&oacute;n</label>
			    	<input type="text" name="txt_edicion" id="txt_edicion" class="form-control required" title="Edici&oacute;n" />
			  	</div>
			  	<div class="form-group col-lg-6">
			    	<label for="txt_fecha">Fecha Publicaci&oacute;n</label>
			    	<input type="text" name="txt_fecha" id="txt_fecha" class="form-control required" title="Fecha Publicaci&oacute;n" />
			  	</div>
			</div>
			<div class="row">
				<div class="form-group col-lg-12">
			    	<label for="txt_descripcion">Descripci&oacute;n</label>
			    	<textarea name="txt_descripcion" maxlength="60" id="txt_descripcion" class="form-control required" title="Descripci&oacute;n"></textarea>
			  	</div>
			</div>
			<input type="hidden" name="function" value="insertar_libro" />
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="dialog" title="Agregando">
  <p id="contentdialog">
  	<div id="capa_autor" style="display:none;">
		<div class="form-group">
			<label for="txt_nombre">Nombre autor:</label>
			<input type="text" class="form-control" id="txt_nombre" name="txt_nombre" placeholder="Ingrese nombre autor">
		</div>
		<div class="form-group">
			<label for="txt_apellido">Apellido autor</label>
			<input type="text" class="form-control" id="txt_apellido" name="txt_apellido" placeholder="Ingrese apellido autor">
		</div>
		<button class="btn btn-danger pull-right" id="btn-new-autor">Guardar&nbsp;&nbsp;<i class="glyphicon glyphicon-save"></i></button>
	</div>
	<div id="capa_editorial" style="display:none;">
		<div class="form-group">
			<label for="txt_nombre_editorial">Nombre editorial:</label>
			<input type="text" class="form-control" id="txt_nombre_editorial" name="txt_nombre_editorial" placeholder="Ingrese nombre editorial">
		</div>
		<div class="form-group">
			<label for="txt_ciudad_editorial">Ciudad editorial</label>
			<input type="text" class="form-control" id="txt_ciudad_editorial" name="txt_ciudad_editorial" placeholder="Ingrese ciudad editorial">
		</div>
		<button class="btn btn-danger pull-right" id="btn-new-editorial">Guardar&nbsp;&nbsp;<i class="glyphicon glyphicon-save"></i></button>
	</div>
	<div id="capa_materia" style="display:none;">
		<div class="form-group">
			<label for="txt_nombre_materia">Nombre materia:</label>
			<input type="text" class="form-control" id="txt_nombre_materia" name="txt_nombre_materia" placeholder="Ingrese nombre materia">
		</div>
		<button class="btn btn-danger pull-right" id="btn-new-materia">Guardar&nbsp;&nbsp;<i class="glyphicon glyphicon-save"></i></button>
	</div>
  </p>
</div>
<script src="librerias/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="librerias/jquery-ui/jquery-ui.min.css">
<link rel="stylesheet" type="text/css" href="plugins/dataTables/css/datatables.css">
<script src="plugins/dataTables/js/jquery.dataTables.js" type="text/javascript"></script>
<script src="plugins/dataTables/js/datatables.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="plugins/chosen_v1.4.0/chosen.css">
<script src="plugins/chosen_v1.4.0/chosen.jquery.js" type="text/javascript"></script>
<style type="text/css">
	.ui-datepicker-year {
		color: #000;
	}
</style>
<script type="text/javascript" >
	var select_autor 	 = function () {};
	var select_editorial = function () {};
	var select_materia   = function () {};
	$(document).on('ready',function(){
		$('[data-toggle="tooltip"]').tooltip();
		select_autor = function () {
			$.ajax({
				url: 'modulos/response_ajax.php',
				method: 'POST',
				data: {'function':'get_data','tabla':'tbl_autor'},
				success: function (resp) {
					if (resp != '') {
						var data = JSON.parse(resp);
						var html = '<option value=""></option>';
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
						var html = '<option value=""></option>';
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
						var html = '<option value=""></option>';
						for (var i = 0; i < data.length; i++) {
							html += '<option value="'+data[i].id_materia+'">'+data[i].nombre_materia.toUpperCase()+'</option>';
						};
						$('#txt_materia').html(html);
						$('#txt_materia').trigger("chosen:updated");
					}
				}
			});
		};
		$('#txt_fecha').datepicker({
			showOn: 'both',
			buttonImage: 'images/calendar.png',
			buttonImageOnly: true,
			changeYear: true
		});
		$('#txt_fecha').attr('readOnly',true);

		$.datepicker.regional['es'] = {
		      closeText: 'Cerrar',
		      prevText: '<<',
		      nextText: '>>',
		      currentText: 'Hoy',
		      monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		      monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
		      dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
		      dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
		      dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
		      weekHeader: 'Sm',
		      dateFormat: 'yy-mm-dd',
		      firstDay: 1,
		      isRTL: false,
		      showMonthAfterYear: false,
		      yearSuffix: ''
		 };
		 $.datepicker.setDefaults($.datepicker.regional['es']);
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
	    	valor = $("#txt_autor_chosen .chosen-search input").val();
	    	$('.ui-dialog').fadeIn();
	    	$('#capa_editorial').hide();
	    	$('#capa_materia').hide();
	    	$('#capa_autor').show();
	    	$("#txt_nombre").val(valor);
	    	$('#txt_apellido').val('');
	    	$('#modalwindow').modal('hide');
	    });
	    $(document).on( "click",".crear_recurso_editorial",function() {
	    	$('#txt_ciudad_editorial').val('');
	    	valor = $("#txt_editorial_chosen .chosen-search input").val();
	    	$('.ui-dialog').fadeIn();
	    	$('#capa_materia').hide();
	    	$('#capa_autor').hide();
	    	$('#capa_editorial').show();
	    	$("#txt_nombre_editorial").val(valor);
	    	$('#modalwindow').modal('hide');
	    });
	    $(document).on( "click",".crear_recurso_materia",function() {
	    	valor = $("#txt_materia_chosen .chosen-search input").val();
	    	$('.ui-dialog').fadeIn();
	    	$('#capa_autor').hide();
	    	$('#capa_editorial').hide();
	    	$('#capa_materia').show();
	    	$("#txt_nombre_materia").val(valor);
	    	$('#modalwindow').modal('hide');
	    });
	    // mostrar ventana modal para registro de libro
	    $('#add-libro').click(function(e){
	    	select_autor();
	    	select_editorial();
	    	select_materia();
	    	$('#txt_edicion').val('');
	    	$('#txt_fecha').val('');
	    	$('#txt_descripcion').val('');
	    	$('.ui-dialog').fadeOut();
	    	$('#modalwindow').modal('show');
	        $('.modal-title').html('Registro de nuevo libro&nbsp;&nbsp;<i class="glyphicon glyphicon-book"></i>');
	        $('.modal-footer').html('<button type="button" class="btn btn-primary" id="add-new-libro">Guardar&nbsp;<i class="glyphicon glyphicon-ok"></i></button><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar&nbsp;<i class="glyphicon glyphicon-remove"></i></button>');
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
					if (data != '') {
						html = '<option value="'+data+'">'+$('#txt_nombre').val().toUpperCase()+' '+$('#txt_apellido').val().toUpperCase()+'</option>';
						$('#txt_autor option:eq(0)').after(html);
						$('#txt_autor option[value='+data+']').attr('selected','selected');
						$('#txt_autor').trigger("chosen:updated");
					}
	    		});
	    		$('.ui-dialog').fadeOut();
	    		$('#capa_editorial').hide();
	    		$('#modalwindow').modal('show');
	    	}
	    });
	    // validacion de nueva editorial
	    $('#btn-new-editorial').click(function(){
	    	if ($('#txt_nombre_editorial').val() == '') {
	    		$('#txt_nombre_editorial').focus();
	    		alertify.error('<b>Nombre editorial es obligatorios</b>');
	    		return false;
	    	} else if ($('#txt_ciudad_editorial').val() == '') {
	    		$('#txt_ciudad_editorial').focus();
	    		alertify.error('<b>Ciudad editorial es obligatorios</b>');
	    		return false;
	    	} else {
	    		$.post('modulos/response_ajax.php',{'nombre_editorial':$('#txt_nombre_editorial').val(), 'ciudad_editorial':$('#txt_ciudad_editorial').val(), 'function':'insertar_editorial'}, function(data){
					if (data != '') {
						html = '<option value="'+data+'">'+$('#txt_nombre_editorial').val().toUpperCase()+' '+$('#txt_ciudad_editorial').val().toUpperCase()+'</option>';
						$('#txt_editorial option:eq(0)').after(html);
						$('#txt_editorial option[value='+data+']').attr('selected','selected');
						$('#txt_editorial').trigger("chosen:updated");
					}
	    		});
	    		$('.ui-dialog').fadeOut();
	    		$('#capa_autor').hide();
	    		$('#modalwindow').modal('show');
	    	}
	    });
		// validacion de nueva materia
	    $('#btn-new-materia').click(function(){
	    	if ($('#txt_nombre_materia').val() == '') {
	    		$('#txt_nombre_materia').focus();
	    		alertify.error('<b>Nombre materia es obligatorios</b>');
	    		return false;
	    	} else {
	    		$.post('modulos/response_ajax.php',{'nombre_materia':$('#txt_nombre_materia').val(), 'function':'insertar_materia'}, function(data){
					if (data != '') {
						html = '<option value="'+data+'">'+$('#txt_nombre_materia').val().toUpperCase()+'</option>';
						$('#txt_materia option:eq(0)').after(html);
						$('#txt_materia option[value='+data+']').attr('selected','selected');
						$('#txt_materia').trigger("chosen:updated");
					}
	    		});
	    		$('.ui-dialog').fadeOut();
	    		$('#capa_materia').hide();
	    		$('#modalwindow').modal('show');
	    	}
	    });
	    // validacion de formulaio de nuevo libro

	    $(document).on('click','#add-new-libro',function(){
	    	var band = true;
	    	$.each($('.required'),band = function(index,val){
	    		if ($(this).val() == '') {
	    			alertify.error('<b>'+$(this).attr('title')+' es un campo obligatorio</b>');
	    			$(this).focus();
	    			$(this).trigger('chosen:activate');
	    			band = 0;
	    			return false;
	    		}
	    	});
	    	if (band) { 
	    		$.post('modulos/response_ajax.php',$('#form-new-libro').serialize(),function(data){
	    			data = parseInt(data)
	    			if (typeof(data) == 'number' && data > 0) {
	    				var autor     	= $('#txt_autor option:selected').text();
	    				var editorial 	= $('#txt_editorial option:selected').text();
	    				var materia		= $('#txt_materia option:selected').text();
	    				var edicion 	= $('#txt_edicion').val(); $('#txt_edicion').val('');
	    				var fecha 		= $('#txt_fecha').val(); $('#txt_fecha').val('');
	    				var descripcion = $('#txt_descripcion').val(); $('#txt_descripcion').val('');
	    				var html = '<tr class="odd" id="'+data+'"><td class="text-center  sorting_1">'+data+'</td><td class="text-center ">'+autor+'</td><td class="text-center ">'+editorial+'</td><td class="text-center ">'+materia+'</td><td class="descripcion_libro">'+descripcion.toUpperCase()+'</td><td class="text-center ">'+fecha+'</td><td class="text-center"><button id="edit-'+data+'" class="edit-libro text-info btn" data-toggle="tooltip" data-placement="top" title="Actualizar libro"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button id="del-'+data+'" class="del-libro text-danger btn" data-toggle="tooltip" data-placement="top" title="Eliminar libro"><i class="glyphicon glyphicon-trash"></i></button></td></tr>';
			  			$('#datatable tbody').prepend(html); 
			  			$('#'+data).show(function(){$('#'+data).fadeIn();});
			  			$('#modalwindow').modal('hide');
	    				alertify.success('<b>Libro guardado con exito</b>');
	    			} else {
	    				alertify.error('<b>Ocurrio un error</b>');
	    			}
	    		});
	    	}
	    });

		$(document).on('click','.del-libro',function(){
			var id = $(this).attr('id').substring(4,$(this).attr('id').length);
			var mensaje = "¿Realmente desea eliminar el libro \""+$('#'+id+' .descripcion_libro').text()+"\"?<br/>&nbsp;Este proceso es irreversible";
            alertify.confirm(mensaje, function (e) {
                if (e) {
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        data: {'campo':'id_libro','val':id,'function':'eliminar','tabla':'tbl_libros'},
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

		$(document).on('click','.edit-libro',function(){
			var id = $(this).attr('id').substring(5,$(this).attr('id').length);
			location.href = "index.php?page=actualizar_libros&id_libro="+id;
		});
	});
</script>
<?php 
	if (isset($_GET['up'])) {
		echo '<script>alertify.success("<b>Actualizado con exito</b>");</script>';
	}
?>