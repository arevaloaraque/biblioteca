<?php
	include_once('modulos/modelo.php');
	if (isset($_GET['id_tesis'])) {
		$id_tesis = $_GET['id_tesis'];
		$tesis = $consultasbd->select($tabla='tbl_tesis',$campos="*",$where=' WHERE id_tesis='.$id_tesis.';');
		$tesi = $consultasbd->fetch_array($tesis);
		if ($consultasbd->num_rows($tesis) == 0){
			echo '<script>location.href="index.php?page=tesis";</script>';
		}
		// datos de materia
		$res_materia = $consultasbd->select($tabla='tbl_materia',$campos='*',$where = ((!empty($tesi['id_materia']))?'WHERE id_materia=\''.$tesi['id_materia'].'\'':''));
		$fetch_materia = $consultasbd->fetch_array($res_materia);
		$materia = $fetch_materia['nombre_materia'];
		// datos de autor
		$res_autor = $consultasbd->select($tabla='tbl_autor_tesis',$campos='*',$where = ((!empty($tesi['id_autor_tesis']))?'WHERE id_autor_tesis=\''.$tesi['id_autor_tesis'].'\'':''));
		$fetch_autor = $consultasbd->fetch_array($res_autor);
		$autor = $fetch_autor['nombre'].' '.$fetch_autor['apellido'];

		$tesi['id_autor_tesis'] = $autor;
		$tesi['id_materia'] = $materia;
		$tesi['fecha_publicacion'] = date('d-m-Y',strtotime($tesi['fecha_publicacion']));

		// verificar status
		if ($tesi['status'] == 'f') {
			echo '<script>location.href="index.php?page=tesis";</script>';
		}
	} else if (isset($_POST['id_tesis_h'])){
		$id_tesis    = $_POST['id_tesis_h'];
		$materia 	 = $_POST['txt_materia'];
		$autor 		 = $_POST['txt_autor_tesis'];
		$titulo 	 = $_POST['txt_titulo'];
		$fecha 		 = $_POST['txt_fecha'];
		$mension	 = $_POST['txt_mension'];
		$tabla 		 = 'tbl_tesis';
		$set  		 = 'id_autor_tesis=\''.$autor.'\', id_materia=\''.$materia.'\', titulo=\''.$titulo.'\',';
		$set  		.= 'fecha_publicacion=\''.$fecha.'\', mension=\''.$mension.'\'';
		$where 		 = ' WHERE id_tesis=\''.$id_tesis.'\'';
		if (empty($_POST['id_tesis_h']) || empty($_POST['txt_autor_tesis']) || empty($_POST['txt_titulo']) || empty($_POST['txt_materia']) || empty($_POST['txt_fecha']) || empty($_POST['txt_mension'])) {
			echo '<script>location.href="index.php?page=actualizar_tesis&id_tesis='.$id_tesis.'&error=true";</script>';
		} else {
			$res = $consultasbd->update($tabla,$set,$where);
			// auditoria
			$auditar_mnsj = "Actualizó tesis. datos: (titulo=>".$titulo.",id=>".$id_tesis.")";
			$auditar_user = $_SESSION['id_operador'];
			$auditar_date = date('Y-m-d');
			$auditar_hour = date('H:m');
			$consultasbd->insert($tabla='tbl_auditoria',$campos='(id_operador,descripcion,hora,fecha_auditoria)',$values='\''.$auditar_user.'\',\''.$auditar_mnsj.'\',\''.$auditar_hour.'\',\''.$auditar_date.'\'');
			// FIN auditoria
			echo '<script>location.href="index.php?page=tesis&up=true";</script>';
		}
	} else {
		echo '<script>location.href="index.php?page=tesis";</script>';
	}

?>
<div class="col-sm-9 col-md-10">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title"><b>Actualizaci&oacute;n&nbsp;de&nbsp;tesis<i class="glyphicon glyphicon-book" style="float:right;"></i></b></h3>
    </div>
    <div class="panel-body">
    	<br/><br/>
    	<form class="form" id="form-edit-tesis" method="POST" action="index.php?page=actualizar_tesis">
    		<input type="hidden" name="id_tesis_h" value="<?php echo $id_tesis; ?>" />
      		<div class="row">
			  	<div class="form-group col-lg-6">
			    	<label for="txt_materia">Materia</label>
			    	<select name="txt_materia" id="txt_materia" class="form-control required" data-placeholder="Seleccione materia" title="Materia">
			    	</select>
			  	</div>
			  	<div class="form-group col-lg-6">
			    	<label for="txt_autor_tesis">Autor tesis</label>
			    	<select name="txt_autor_tesis" id="txt_autor_tesis" class="chosen-select form-control required" data-placeholder="Seleccione autor" title="Autor">
			    	</select>
			  	</div>
			</div>
			<div class="row">
			  	<div class="form-group col-lg-6">
			    	<label for="txt_mension">Mensi&oacute;n</label>
			    	<input type="text" name="txt_mension" id="txt_mension" class="form-control required" title="Mensi&oacute;n" value="<?php echo $tesi['mension']; ?>" />
			  	</div>
			  	<div class="form-group col-lg-6">
			    	<label for="txt_fecha">Fecha Publicaci&oacute;n</label>
			    	<input type="text" name="txt_fecha" id="txt_fecha" class="form-control required" title="Fecha Publicaci&oacute;n" value="<?php echo $tesi['fecha_publicacion']; ?>" />
			  	</div>
			</div>
			<div class="row">
				<div class="form-group col-lg-12">
			    	<label for="txt_titulo">Titulo</label>
			    	<textarea name="txt_titulo" maxlength="30" id="txt_titulo" class="form-control required" title="Titulo"><?php echo $tesi["titulo"]; ?></textarea>
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
		select_autor = function () {
			$.ajax({
				url: 'modulos/response_ajax.php',
				method: 'POST',
				data: {'function':'get_data','tabla':'tbl_autor_tesis'},
				success: function (resp) {
					if (resp != '') {
						var data = JSON.parse(resp);
						var html = '<option value=""></option>';
						var selected = '';
						for (var i = 0; i < data.length; i++) {
							if ('<?php echo $tesi["id_autor_tesis"] ?>'.toUpperCase() == data[i].nombre.toUpperCase()+' '+data[i].apellido.toUpperCase()) {
								selected = 'selected="selected"';
							} else {
								selected = '';
							}
							html += '<option value="'+data[i].id_autor_tesis+'" '+selected+'>'+data[i].nombre.toUpperCase()+' '+data[i].apellido.toUpperCase()+'</option>';
						};
						$('#txt_autor_tesis').html(html);
						$('#txt_autor_tesis').trigger("chosen:updated");
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
							if ('<?php echo $tesi["id_materia"] ?>'.toUpperCase() == data[i].nombre_materia.toUpperCase()) {
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
		$('title').html('..:: Actualizaci&oacute;n de tesis ::..&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
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
	    $('#txt_autor_tesis').chosen({no_results_text:'<a class="crear_recurso_autor" title="Registrar nuevo autor" >Crear!</a>',width:"100%"});
	    $('#txt_materia').chosen({no_results_text:'<a class="crear_recurso_materia" title="Registrar nueva materia" >Crear!</a>',width:"100%"});
	    // crear recurso
	    $(document).on( "click",".crear_recurso_autor",function() {
	    	valor = $("#txt_autor_tesis_chosen .chosen-search input").val();
	    	$('#txt_autor_tesis').trigger("chosen:updated");
	    	$('.ui-dialog').fadeIn();
	    	$('#capa_materia').hide();
	    	$('#capa_autor').show();
	    	$("#txt_nombre").val(valor);
	    	$('#txt_apellido').val('');
	    	$('#modalwindow').modal('hide');
	    });
	    $(document).on( "click",".crear_recurso_materia",function() {
	    	valor = $("#txt_materia_chosen .chosen-search input").val();
	    	$('#txt_materia').trigger("chosen:updated");
	    	$('.ui-dialog').fadeIn();
	    	$('#capa_autor').hide();
	    	$('#capa_materia').show();
	    	$("#txt_nombre_materia").val(valor);
	    	$('#modalwindow').modal('hide');
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
	    		$.post('modulos/response_ajax.php',{'nombre':$('#txt_nombre').val(), 'apellido':$('#txt_apellido').val(), 'function':'insertar_autor_tesis'}, function(data){
					if (data != '') {
						html = '<option value="'+data+'">'+$('#txt_nombre').val().toUpperCase()+' '+$('#txt_apellido').val().toUpperCase()+'</option>';
						$('#txt_autor_tesis option:eq(0)').after(html);
						$('#txt_autor_tesis option[value='+data+']').attr('selected','selected');
						$('#txt_autor_tesis').trigger("chosen:updated");
					}
	    		});
	    		$('.ui-dialog').fadeOut();
	    		$('#capa_editorial').hide();
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
	    // validacion de formulaio de nueva tesis
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
	    		$('#form-edit-tesis').submit();
	    	}
	    });

	    $(document).on('click','#btn-cancel-form',function(e){
	    	e.preventDefault();
	    	location.href = 'index.php?page=tesis';
	    });
	});
</script>
<?php 
	if (isset($_GET['error'])) {
		echo '<script>alertify.error("<b>Todos los campos son obligatorios</b>");</script>';
	}
?>