<?php
	include_once('modulos/modelo.php');
	$materiales = $consultasbd->query($sql = 'select * from tbl_material as tbl_mat left outer join tbl_tipo_material tbl_tipo on tbl_mat.id_tipo=tbl_tipo.id_tipo_material');
?>
<div class="col-sm-9 col-md-10">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title"><b>Listado&nbsp;general&nbsp;de&nbsp;materiales<i class="glyphicon glyphicon-floppy-disk" style="float:right;"></i></b></h3>
    </div>
    <div class="panel-body">
    	<button class='pull-right btn btn-primary' id='add-material'>Agregar&nbsp;&nbsp;<i class="glyphicon glyphicon-plus"></i></button>
    	<button data-toggle="tooltip" data-placement="top" title="Actualizar tabla" class='btn btn-info' id='add-material' onclick="location.href = 'index.php?page=materiales';"><i class="glyphicon glyphicon-refresh"></i></button>
    	<br/><br/>
    	<?php //if ($consultasbd->num_rows($material) > 0): ?>
      	<div class="table-responsive">
			<table class='table table-bordered table-striped table-hover datatable dataTable' id="datatable" style='border-radius:5px;'>
			  <thead>
			  		<tr class="danger">
			  			<th class='col-lg-1 text-center'>C&oacute;digo</th>
			  			<th class='col-lg-3 text-center'>Nombre</th>
			  			<th class='col-lg-6'>Tipo Material</th>

			  			<th class='text-center col-lg-1'>Acci&oacute;nes</th>
			  		</tr>
			  </thead>
			  <tbody>
			  	<?php while ($material = $consultasbd->fetch_array($materiales)) { ?>
			  		<tr id="<?php echo $material['id_material']; ?>">
			  			<td class='text-center'><?php echo $material['id_material']; ?></td>
			  			<td class='text-center nombre_material'><?php echo strtoupper($material['nombre']); ?></td>
			  			<td class='descripcion_tipo'><?php echo strtoupper($material['descripcion_tipo']); ?></td>
			  			<td class='text-center'>
			  				<button id="edit-<?php echo $material['id_material']; ?>" class="edit-material text-info btn" data-toggle="tooltip" data-placement="top" title="Actualizar material"><i class="glyphicon glyphicon-edit"></i></button>
			  				<button id="del-<?php echo $material['id_material']; ?>" class="del-material text-danger btn" data-toggle="tooltip" data-placement="top" title="Eliminar material"><i class="glyphicon glyphicon-trash"></i></button>
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
      	<form class="form" id="form-new-material">
      		<div class="row">
			  	<div class="form-group col-lg-6">
			    	<label for="txt_nombre">Nombre</label>
			    	<input type="text" name="txt_nombre" id="txt_nombre" class="form-control required" title="Nombre" />
			  	</div>
			  	<div class="form-group col-lg-6">
			    	<label for="txt_tipo_material">Tipo Material</label>
			    	<select name="txt_tipo_material" id="txt_tipo_material" class="form-control required" data-placeholder="Seleccione tipo material" title="Tipo Material">
			    	</select>
			  	</div>
			</div>
			<input type="hidden" name="function" value="insertar_material" />
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
	<div id="capa_tipo_material">
		<div class="form-group">
			<label for="txt_descrip_material">Tipo Material:</label>
			<input type="text" class="form-control" id="txt_descrip_material" name="txt_descrip_material" placeholder="Descripci&oacute;n tipo material">
		</div>
		<button class="btn btn-danger pull-right" id="btn-new-tipo-material">Guardar&nbsp;&nbsp;<i class="glyphicon glyphicon-save"></i></button>
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
	var select_tipo_material 	 = function () {};
	$(document).on('ready',function(){
		$('[data-toggle="tooltip"]').tooltip();
		select_tipo_material = function () {
			$.ajax({
				url: 'modulos/response_ajax.php',
				method: 'POST',
				data: {'function':'get_data','tabla':'tbl_tipo_material'},
				success: function (resp) {
					if (resp != '') {
						var data = JSON.parse(resp);
						var html = '<option value=""></option>';
						for (var i = 0; i < data.length; i++) {
							html += '<option value="'+data[i].id_tipo_material+'">'+data[i].descripcion_tipo.toUpperCase()+'</option>';
						};
						$('#txt_tipo_material').html(html);
						$('#txt_tipo_material').trigger("chosen:updated");
					}
				}
			});
		};
		$('#menu-item li.active').removeClass('active');
	    $('#liRecursos').addClass('active');
	    // title page
		$('title').html('..:: Listado General de Materiales ::..&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
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
	      search_input.attr({'placeholder':'Buscar Material','id':'btn_search_table'});
	      search_input.addClass('form-control input-sm');
	      // LENGTH - Inline-Form control
	      var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
	      length_sel.addClass('form-control input-sm');
	    });
	    $('#btn_search_table').attr('title','Filtrar resultado');
	    $('#btn_search_table').tooltip();

	    // convertir selects a chosen
	    $('#txt_tipo_material').chosen({no_results_text:'<a class="crear_recurso_material" title="Registrar material" >Crear!</a>',width:"100%"});
	    // crear recurso
	    $(document).on( "click",".crear_recurso_material",function() {
	    	valor = $("#txt_tipo_material_chosen .chosen-search input").val();
	    	$('.ui-dialog').fadeIn();
	    	$('#txt_descrip_material').val(valor);
	    	$('#modalwindow').modal('hide');
	    });
	    // mostrar ventana modal para registro de libro
	    $('#add-material').click(function(e){
	    	select_tipo_material();
	    	$('#txt_nombre').val('');
	    	$('.ui-dialog').fadeOut();
	    	$('#modalwindow').modal('show');
	        $('.modal-title').html('Registro de nuevo material&nbsp;&nbsp;<i class="glyphicon glyphicon-floppy-disk"></i>');
	        $('.modal-footer').html('<button type="button" class="btn btn-primary" id="add-new-material">Guardar&nbsp;<i class="glyphicon glyphicon-ok"></i></button><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar&nbsp;<i class="glyphicon glyphicon-remove"></i></button>');
	    });

	    // validacion de nuevo autor
	    $('#btn-new-tipo-material').click(function(){
	    	if ($('#txt_descrip_material').val() == '') {
	    		$('#txt_descrip_material').focus();
	    		alertify.error('<b>Descripci&oacute;n tipo material es obligatorios</b>');
	    		return false;
	    	} else {
	    		$.post('modulos/response_ajax.php',{'tipo_material':$('#txt_descrip_material').val(), 'function':'insertar_tipo_material'}, function(data){
					if (data != '') {
						html = '<option value="'+data+'">'+$('#txt_descrip_material').val().toUpperCase()+'</option>';
						$('#txt_tipo_material option:eq(0)').after(html);
						$('#txt_tipo_material option[value='+data+']').attr('selected','selected');
						$('#txt_tipo_material').trigger("chosen:updated");
					}
	    		});
	    		$('.ui-dialog').fadeOut();
	    		$('#modalwindow').modal('show');
	    	}
	    });

	    // validacion de formulaio de nuevo material
	    $(document).on('click','#add-new-material',function(){
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
	    		$.post('modulos/response_ajax.php',$('#form-new-material').serialize(),function(data){
	    			data = parseInt(data)
	    			if (typeof(data) == 'number' && data > 0) {
	    				var tipo_material = $('#txt_tipo_material option:selected').text();
	    				var nombre 	 	  = $('#txt_nombre').val();
	    				var html = '<tr class="odd" id="'+data+'"><td class="text-center  sorting_1">'+data+'</td><td class="text-center ">'+nombre.toUpperCase()+'</td><td class="descripcion_tipo">'+tipo_material.toUpperCase()+'</td><td class="text-center"><button id="edit-'+data+'" class="edit-material text-info btn" data-toggle="tooltip" data-placement="top" title="Actualizar material"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;<button id="del-'+data+'" class="del-material text-danger btn" data-toggle="tooltip" data-placement="top" title="Eliminar material"><i class="glyphicon glyphicon-trash"></i></button></td></tr>';
			  			$('#datatable tbody').prepend(html); 
			  			$('#'+data).show(function(){$('#'+data).fadeIn();});
			  			$('#modalwindow').modal('hide');
	    				alertify.success('<b>Material guardado con exito</b>');
	    			} else {
	    				alertify.error('<b>Ocurrio un error</b>');
	    			}
	    		});
	    	}
	    });

		$(document).on('click','.del-material',function(){
			var id = $(this).attr('id').substring(4,$(this).attr('id').length);
			var mensaje = "¿Realmente desea eliminar el material \""+$('#'+id+' .descripcion_tipo').text()+"\"?<br/>&nbsp;Este proceso es irreversible";
            alertify.confirm(mensaje, function (e) {
                if (e) {
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        data: {'campo':'id_material','val':id,'function':'eliminar','tabla':'tbl_material'},
                        url: 'modulos/response_ajax.php',
                        success: function (resp) {
                            if (resp == 0) { alertify.error('<b>Error al eliminar libro!</b>'); }
                            else if(resp == 1){ $("#"+id).fadeOut(); alertify.success('<b>Material eliminado con exito!</b>'); }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            //console.log(xhr.status);
                            //console.log(thrownError);
                        },
                    });
                }
            });
		});

		$(document).on('click','.edit-material',function(){
			var id = $(this).attr('id').substring(5,$(this).attr('id').length);
			location.href = "index.php?page=actualizar_material&id_material="+id;
		});
	});
</script>
<?php 
	if (isset($_GET['up'])) {
		echo '<script>alertify.success("<b>Actualizada con exito</b>");</script>';
	}
?>