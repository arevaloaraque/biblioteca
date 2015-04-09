<?php
	include_once('modulos/modelo.php');
	if (isset($_GET['id_libro'])) {
		$id_libro = $_GET['id_libro'];
	}
	$libros = $consultasbd->select($tabla='tbl_libros',$campos="*",$where=' WHERE id_libro='.$id_libro.';');
	$libro = $consultasbd->fetch_array($libros);
	if ($consultasbd->num_rows($libros) == 0){
		echo '<script>location.href="index.php?page=libros";</script>';
	}

?>
<div class="col-sm-9 col-md-10">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title"><b>Actualizaci&oacute;n&nbsp;de&nbsp;libros<i class="glyphicon glyphicon-book" style="float:right;"></i></b></h3>
    </div>
    <div class="panel-body">
    	<br/><br/>
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
    <div class="panel-footer text-center">
      <div class="btn-group">
          <p><i class="text-muted">BibloWeb v1.0</i></p>
      </div>
    </div>
  </div>
</div>


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
		<button class="btn btn-danger pull-right" id="btn-new-cancel">Cancelar&nbsp;&nbsp;<i class="glyphicon glyphicon-remove"></i></button>
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
	    $('#liRecursos').addClass('active');
	    // title page
		$('title').html('..:: Actualizaci&oacute;n de Libros ::..&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
		valuesTitle();
		// creacion de la ventana de dialogo
		$( "#dialog" ).dialog();
		$( ".ui-dialog" ).css({'border':'2px solid #000'});
		$( ".ui-dialog" ).hide();
		$("#btn-new-cancel").click(function(){
			$( ".ui-dialog" ).hide();
		});

		select_autor();
    	select_editorial();
    	select_materia();
	    // convertir selects a chosen
	    $('#txt_autor').chosen({no_results_text:'<a class="crear_recurso_autor" title="Registrar nuevo autor" >Crear!</a>',width:"100%"});
	    $('#txt_editorial').chosen({no_results_text:'<a class="crear_recurso_editorial" title="Registrar nueva editorial" >Crear!</a>',width:"100%"});
	    $('#txt_materia').chosen({no_results_text:'<a class="crear_recurso_materia" title="Registrar nueva materia" >Crear!</a>',width:"100%"});
	    // crear recurso
	    $(document).on( "click",".crear_recurso_autor",function() {
	    	$('#txt_autor').trigger("chosen:updated");
	    	valor = $("#txt_autor_chosen .chosen-search input").val();
	    	$('.ui-dialog').fadeIn();
	    	$('#capa_editorial').hide();
	    	$('#capa_materia').hide();
	    	$('#capa_autor').show();
	    	$("#txt_nombre").val(valor);
	    	$('#txt_apellido').val('');
	    });
	    $(document).on( "click",".crear_recurso_editorial",function() {
	    	$('#txt_ciudad_editorial').val('');
	    	$('#txt_editorial').trigger("chosen:updated");
	    	valor = $("#txt_editorial_chosen .chosen-search input").val();
	    	$('.ui-dialog').fadeIn();
	    	$('#capa_materia').hide();
	    	$('#capa_autor').hide();
	    	$('#capa_editorial').show();
	    	$("#txt_nombre_editorial").val(valor);
	    });
	    $(document).on( "click",".crear_recurso_materia",function() {
	    	$('#txt_materia').trigger("chosen:updated");
	    	valor = $("#txt_materia_chosen .chosen-search input").val();
	    	$('.ui-dialog').fadeIn();
	    	$('#capa_autor').hide();
	    	$('#capa_editorial').hide();
	    	$('#capa_materia').show();
	    	$("#txt_nombre_materia").val(valor);
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

	});
</script>