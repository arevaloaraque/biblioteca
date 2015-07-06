<?php
	include_once('modulos/modelo.php');
	if (isset($_GET['id_material'])) {
		$id_material = $_GET['id_material'];
		$materiales = $consultasbd->query($sql = 'select * from tbl_material as tbl_mat left outer join tbl_tipo_material tbl_tipo on tbl_mat.id_tipo=tbl_tipo.id_tipo_material WHERE tbl_mat.id_material=\''.$id_material.'\'');
		$material = $consultasbd->fetch_array($materiales);
		if ($consultasbd->num_rows($materiales) == 0){
			echo '<script>location.href="index.php?page=materiales";</script>';
		}

		// verificar status
		if ($material['status'] == 'f') {
			echo '<script>location.href="index.php?page=materiales";</script>';
		}
	} else if (isset($_POST['id_material_h'])){
		$id_material    = $_POST['id_material_h'];
		$nombre  	    = $_POST['txt_nombre'];
		$tipo_material  = $_POST['txt_tipo_material'];
		$tabla 		 = 'tbl_material';
		$set  		 = 'id_tipo=\''.$tipo_material.'\', nombre=\''.$nombre.'\'';
		$where 		 = ' WHERE id_material=\''.$id_material.'\'';
		if (empty($_POST['id_material_h']) || empty($_POST['txt_nombre']) || empty($_POST['txt_tipo_material'])) {
			echo '<script>location.href="index.php?page=actualizar_material&id_material='.$id_material.'&error=true";</script>';
		} else {
			$res = $consultasbd->update($tabla,$set,$where);
			// auditoria
			$auditar_mnsj = "Actualizó material. datos: (nombre=>".$nombre.",id=>".$id_material.")";
			$auditar_user = $_SESSION['id_operador'];
			$auditar_date = date('Y-m-d');
			$auditar_hour = date('H:m');
			$consultasbd->insert($tabla='tbl_auditoria',$campos='(id_operador,descripcion,hora,fecha_auditoria)',$values='\''.$auditar_user.'\',\''.$auditar_mnsj.'\',\''.$auditar_hour.'\',\''.$auditar_date.'\'');
			// FIN auditoria
			echo '<script>location.href="index.php?page=materiales&up=true";</script>';
		}
	} else {
		echo '<script>location.href="index.php?page=materiales";</script>';
	}

?>
<div class="col-sm-9 col-md-10">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title"><b>Actualizaci&oacute;n&nbsp;de&nbsp;material<i class="glyphicon glyphicon-floppy-disk" style="float:right;"></i></b></h3>
    </div>
    <div class="panel-body">
    	<br/><br/>
    	<form class="form" id="form-edit-material" method="POST" action="index.php?page=actualizar_material">
    		<input type="hidden" name="id_material_h" value="<?php echo $id_material; ?>" />
      		<div class="row">
			  	<div class="form-group col-lg-6">
			    	<label for="txt_nombre">Nombre</label>
			    	<input type="text" name="txt_nombre" id="txt_nombre" class="form-control required" maxlength="30" title="Nombre" value="<?php echo strtoupper($material['nombre']); ?>" />
			  	</div>
			  	<div class="form-group col-lg-6">
			    	<label for="txt_tipo_material">Tipo Material</label>
			    	<select name="txt_tipo_material" id="txt_tipo_material" class="chosen-select form-control required" data-placeholder="Seleccione tipo" title="Tipo material">
			    	</select>
			  	</div>
			</div>
			<div class="row">
				<div class="form-group col-lg-12">
					<div class="pull-right">
				    	<button type="reset" class="btn btn-muted" id="btn-cancel-form">Cancelar&nbsp;&nbsp;<i class="glyphicon glyphicon-remove"></i></button>
				    	<button type="submit" class="btn btn-danger" id="btn-send-form">Guardar&nbsp;&nbsp;<i class="glyphicon glyphicon-save"></i></button>
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

<div id="dialog" title="Agregando">
  <p id="contentdialog">
	<div id="capa_tipo_material">
		<div class="form-group">
			<label for="txt_descrip_material">Tipo Material:</label>
			<input type="text" class="form-control" id="txt_descrip_material" name="txt_descrip_material" placeholder="Descripci&oacute;n tipo material">
		</div>
		<button class="btn btn-danger pull-right" id="btn-new-tipo-material">Guardar&nbsp;&nbsp;<i class="glyphicon glyphicon-save"></i></button>
		<button class="btn btn-muted pull-right" id="btn-new-cancel">Cancelar&nbsp;&nbsp;<i class="glyphicon glyphicon-remove"></i></button>
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
						selected = '';
						for (var i = 0; i < data.length; i++) {
							if ('<?php echo $material["descripcion_tipo"] ?>'.toUpperCase() == data[i].descripcion_tipo.toUpperCase()){
								selected = 'selected="selected"';
							} else {
								selected = '';
							}
							html += '<option value="'+data[i].id_tipo_material+'" '+selected+'>'+data[i].descripcion_tipo.toUpperCase()+'</option>';
						};
						$('#txt_tipo_material').html(html);
						$('#txt_tipo_material').trigger("chosen:updated");
					}
				}
			});
		};
		select_tipo_material();
		$('#menu-item li.active').removeClass('active');
	    $('#liRecursos').addClass('active');
	    // title page
		$('title').html('..:: Listado General de Materiales ::..&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
		valuesTitle();
		// creacion de la ventana de dialogo
		 $( "#dialog" ).dialog();
		 $( ".ui-dialog" ).css({'border':'2px solid #000'});
		 $( ".ui-dialog" ).hide();
		 $("#btn-new-cancel").click(function(){
			$( ".ui-dialog" ).hide();
		});
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

	    // validacion de nuevo material
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
	    // validacion de formulaio de nueva tesis
	    $(document).on('click','#btn-send-form',function(e){
	    	e.preventDefault();
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
	    		$('#form-edit-material').submit();
	    	}
	    });

	    $(document).on('click','#btn-cancel-form',function(e){
	    	e.preventDefault();
	    	location.href = 'index.php?page=materiales';
	    });
	});
</script>
<?php 
	if (isset($_GET['error'])) {
		echo '<script>alertify.error("<b>Todos los campos son obligatorios</b>");</script>';
	}
?>