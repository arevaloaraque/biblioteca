<?php
	include_once('modulos/modelo.php');
	if (isset($_GET['id_libro'])) {
		$id_libro = $_GET['id_libro'];
		$libros = $consultasbd->select($tabla='tbl_libros',$campos="*",$where=' WHERE id_libro='.$id_libro.';');
		$libro = $consultasbd->fetch_array($libros);
		if ($consultasbd->num_rows($libros) == 0){
			echo '<script>location.href="index.php?page=libros";</script>';
		}
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

		// verificar status
		if ($libro['status'] == 'f') {
			echo '<script>location.href="index.php?page=libros";</script>';
		}
	} else if (isset($_POST['id_libro_h'])){
		$id_libro    = $_POST['id_libro_h'];
		$autor 		 = $_POST['txt_autor'];
		$descripcion = $_POST['txt_descripcion'];
		$edicion	 = $_POST['txt_edicion'];
		$editorial   = $_POST['txt_editorial'];
		$fecha 		 = $_POST['txt_fecha'];
		$materia 	 = $_POST['txt_materia'];
		$tabla 		 = 'tbl_libros';
		$set  		 = 'id_autor=\''.$autor.'\', id_editorial=\''.$editorial.'\', id_materia=\''.$materia.'\',';
		$set  		.= 'edicion=\''.$edicion.'\', fecha_publicacion=\''.$fecha.'\', descripcion=\''.$descripcion.'\'';
		$where 		 = ' WHERE id_libro=\''.$id_libro.'\'';
		if (empty($_POST['id_libro_h']) || empty($_POST['txt_autor']) || empty($_POST['txt_descripcion']) || empty($_POST['txt_edicion']) || empty($_POST['txt_editorial']) || empty($_POST['txt_fecha']) || empty($_POST['txt_materia'])) {
			echo '<script>location.href="index.php?page=actualizar_libros&id_libro='.$id_libro.'&error=true";</script>';
		} else {
			$res = $consultasbd->update($tabla,$set,$where);
			// auditoria
			$auditar_mnsj = "Actualizó libro. datos: (descripcion=>".$descripcion.",id=>".$id_libro.")";
			$auditar_user = $_SESSION['id_operador'];
			$auditar_date = date('Y-m-d');
			$auditar_hour = date('H:m');
			$consultasbd->insert($tabla='tbl_auditoria',$campos='(id_operador,descripcion,hora,fecha_auditoria)',$values='\''.$auditar_user.'\',\''.$auditar_mnsj.'\',\''.$auditar_hour.'\',\''.$auditar_date.'\'');
			// FIN auditoria
			echo '<script>location.href="index.php?page=libros&up=true";</script>';
		}
	} else {
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
    	<form class="form" id="form-edit-libro" method="POST" action="index.php?page=actualizar_libros">
    		<input type="hidden" name="id_libro_h" value="<?php echo $id_libro; ?>" />
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
			    	<input type="text" name="txt_edicion" id="txt_edicion" class="form-control required" title="Edici&oacute;n" value="<?php echo $libro['edicion']; ?>" />
			  	</div>
			  	<div class="form-group col-lg-6">
			    	<label for="txt_fecha">Fecha Publicaci&oacute;n</label>
			    	<input type="text" name="txt_fecha" id="txt_fecha" class="form-control required" title="Fecha Publicaci&oacute;n" value="<?php echo $libro['fecha_publicacion']; ?>" />
			  	</div>
			</div>
			<div class="row">
				<div class="form-group col-lg-12">
			    	<label for="txt_descripcion">Descripci&oacute;n</label>
			    	<textarea name="txt_descripcion" maxlength="60" id="txt_descripcion" class="form-control required" title="Descripci&oacute;n"><?php echo $libro["descripcion"]; ?></textarea>
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
		<button class="btn btn-muted pull-right" id="btn-new-cancel">Cancelar&nbsp;&nbsp;<i class="glyphicon glyphicon-remove"></i></button>
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
		console.log('<?php echo $libro["id_autor"]; ?>');
		select_autor = function () {
			$.ajax({
				url: 'modulos/response_ajax.php',
				method: 'POST',
				data: {'function':'get_data','tabla':'tbl_autor'},
				success: function (resp) {
					if (resp != '') {
						var data = JSON.parse(resp);
						var html = '<option value=""></option>';
						var selected = '';
						for (var i = 0; i < data.length; i++) {
							if ('<?php echo $libro["id_autor"]; ?>'.toUpperCase() == data[i].nombre.toUpperCase()+' '+data[i].apellido.toUpperCase()){
								selected = 'selected="selected"';
							} else {
								selected = '';
							}
							html += '<option value="'+data[i].id_autor+'" '+selected+'>'+data[i].nombre.toUpperCase()+' '+data[i].apellido.toUpperCase()+'</option>';
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
						var selected = '';
						for (var i = 0; i < data.length; i++) {
							if ('<?php echo $libro["id_editorial"]; ?>'.toUpperCase() == data[i].nombre.toUpperCase()+' '+data[i].ciudad.toUpperCase()){
								selected = 'selected="selected"';
							} else {
								selected = '';
							}
							html += '<option value="'+data[i].id_editorial+'" '+selected+'>'+data[i].nombre.toUpperCase()+' '+data[i].ciudad.toUpperCase()+'</option>';
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
						var selected = '';
						for (var i = 0; i < data.length; i++) {
							if ('<?php echo $libro["id_materia"]; ?>'.toUpperCase() == data[i].nombre_materia.toUpperCase()) {
								selected = 'selected="selected"';
							} else {
								selected = '';
							}
							html += '<option value="'+data[i].id_materia+'" '+selected+'>'+data[i].nombre_materia.toUpperCase()+'</option>';
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

	    $(document).on('click','#btn-send-form',function(e){
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
	    		$('#form-edit-libro').submit();
	    	}
	    });

	    $(document).on('click','#btn-cancel-form',function(e){
	    	e.preventDefault();
	    	location.href = 'index.php?page=libros';
	    });
	});
</script>
<?php 
	if (isset($_GET['error'])) {
		echo '<script>alertify.error("<b>Todos los campos son obligatorios</b>");</script>';
	}
?>