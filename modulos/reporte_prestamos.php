<?php
	include_once('modulos/modelo.php');
	$class_alert = array('warning','danger');
	if (count($_GET)==1 && count($_POST)==0) {
		$libros = $consultasbd->select($tabla='tbl_prestamo_libro',$campos='*',$where='');
		$tesis = $consultasbd->select($tabla='tbl_prestamo_tesis',$campos='*',$where='');
		$material = $consultasbd->select($tabla='tbl_prestamo_material',$campos='*',$where='');
	} else if (count($_POST)>0) {
		$from_date = $_POST['from-date'];
		$to_date = $_POST['to-date'];
		$libros = $consultasbd->select($tabla='tbl_prestamo_libro',$campos='*',$where=' WHERE fecha_prestamo>=\''.$from_date.'\' AND fecha_prestamo<=\''.$to_date.'\'');
		$tesis = $consultasbd->select($tabla='tbl_prestamo_tesis',$campos='*',$where=' WHERE fecha_prestamo>=\''.$from_date.'\' AND fecha_prestamo<=\''.$to_date.'\'');
		$material = $consultasbd->select($tabla='tbl_prestamo_material',$campos='*',$where=' WHERE fecha_prestamo>=\''.$from_date.'\' AND fecha_prestamo<=\''.$to_date.'\'');
	}
?>
<div class="col-sm-9 col-md-10">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title"><b>Reporte de Prestamos: Libro(s), Tesis, Material(es)<i class="glyphicon glyphicon-book" style="float:right;"></i></b></h3>
    </div>
    <div class="panel-body">
    	<br/>
		<div class="row">
			<div class="col-lg-12">
				<div class="well">
					<p><b>Filtro&nbsp;de&nbsp;Busqueda</b><i class="glyphicon glyphicon-filter"></i></p>
					<div class="radio-inline">
					    <label>
					      <input type="radio" name="filter" onclick="location.href = ('?page=reporte_prestamos');" <?php echo (count($_GET)==1 && count($_POST)==0)?'checked="checked"':''; ?> />&nbsp;Historial&nbsp;Completo
					    </label>
					</div>
					<div class="radio-inline">
					    <label>
					      <input type="radio" name="filter" id="filter-date" <?php echo (count($_POST)>0)?'checked="checked"':''; ?> />&nbsp;Rango&nbsp;de&nbsp;Fecha&nbsp;<img src="images/calendar.png" class="img img-circle">
					    </label>
					</div>
					<form id="show-calendars" <?php echo (count($_POST)>0)?'':'style="display:none;"' ?> class="form-inline" action="?page=reporte_prestamos" method="POST">
						Desde:&nbsp;<input type="text" name="from-date" id="from-date" class="form-control" readonly="readOnly" value="<?php echo (isset($_POST['from-date']))?$_POST['from-date']:''; ?>" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hasta&nbsp;<input type="text" name="to-date" id="to-date" class="form-control" readonly="readOnly" value="<?php echo (isset($_POST['to-date']))?$_POST['to-date']:''; ?>" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button id="btn-filter-date" class="btn btn-danger">Ver!</button>
					</form>
				</div>
			</div>
		</div>
		<?php if ($consultasbd->num_rows($libros) || $consultasbd->num_rows($tesis) || $consultasbd->num_rows($material)){ ?>
		<div class="row">
			<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading text-center">Leyenda de Colores en Filas de La(s) Tabla(s)</div>
					<table class="table table-bordered table-striped table-hover">
						<tbody>
							<tr>
								<td class="success text-center col-lg-3">Prestamo Entregado&nbsp;<img src="images/calendar.png" class="img img-circle"></td>
								<td class="danger text-center col-lg-3">Prestamo Vencido&nbsp;<img src="images/calendar.png" class="img img-circle"></td>
								<td class="warning text-center col-lg-3">Prestamo Cerca a Vencer&nbsp;<img src="images/calendar.png" class="img img-circle"></td>
								<td class="text-center col-lg-3">Prestamo Activo&nbsp;<img src="images/calendar.png" class="img img-circle"></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="row">
				<div class="col-lg-12" id="tbl-libros">
					<div class="table-responsive">
					<?php if ($consultasbd->num_rows($libros)) { ?>
					<div class="panel panel-default">
						<div class="panel-heading"><strong>Libros</strong></div>
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr class="active">
										<th class="col-lg-1 text-center">Cod.&nbsp;Prestamo</th>
										<th class="col-lg-2 text-center">Autor&nbsp;Libro</th>
										<th class="col-lg-2 text-center">Editorial</th>
										<th class="col-lg-4">Descripci&oacute;n&nbsp;</th>
										<th class="col-lg-1 text-center">Fecha&nbsp;Prestamo</th>
										<th class="col-lg-1 text-center">Fecha&nbsp;Devoluci&oacute;n</th>
										<th class="col-lg-3 text-center">Estatus</th>
									</tr>
								</thead>
								<tbody>
									<!--Libros-->
									<?php while ($libro = $consultasbd->fetch_array($libros)) { ?>
									<?php 
										// datos del libro
										$datos_libro = $consultasbd->select($tabla='tbl_libros',$campos='*',$where='WHERE id_libro=\''.$libro['id_libro'].'\'');
										$datos_libro = $consultasbd->fetch_array($datos_libro);
										// datos de autor
										$res_autor = $consultasbd->select($tabla='tbl_autor',$campos='*',$where = ((!empty($datos_libro['id_autor']))?'WHERE id_autor=\''.$datos_libro['id_autor'].'\'':''));
										$fetch_autor = $consultasbd->fetch_array($res_autor);
										$autor = $fetch_autor['nombre'].' '.$fetch_autor['apellido'];
										// datos de editorial
										$res_editorial = $consultasbd->select($tabla='tbl_editorial',$campos='*',$where = ((!empty($datos_libro['id_editorial']))?'WHERE id_editorial=\''.$datos_libro['id_editorial'].'\'':''));
										$fetch_editorial = $consultasbd->fetch_array($res_editorial);
										$editorial = $fetch_editorial['nombre'].' '.$fetch_editorial['ciudad'];
										// datos de materia
										$res_materia = $consultasbd->select($tabla='tbl_materia',$campos='*',$where = ((!empty($datos_libro['id_materia']))?'WHERE id_materia=\''.$datos_libro['id_materia'].'\'':''));
										$fetch_materia = $consultasbd->fetch_array($res_materia);
										$materia = $fetch_materia['nombre_materia'];

										$datos_libro['id_autor'] = $autor;
										$datos_libro['id_editorial'] = $editorial;
										$datos_libro['id_materia'] = $materia;
										$datos_libro['fecha_publicacion'] = date('d-m-Y',strtotime($datos_libro['fecha_publicacion']));
										// total dias prestamo
										$segundos=strtotime($libro['fecha_devolucion']) - strtotime($libro['fecha_prestamo']);
										$diferencia_dias=intval($segundos/60/60/24);
										if (date('Y-m-d') > $libro['fecha_devolucion']) {
											$alert = $class_alert[1];
										} else {
											if ($diferencia_dias <= 0) { $alert = $class_alert[1]; } else
											if ($diferencia_dias > 0 && $diferencia_dias < 2) { $alert = $class_alert[0]; }
											else { $alert = '';}
										}
									?>
								  		<tr id="row_lib_<?php echo $libro['id_prestamo']; ?>" class="<?php echo ($libro['status'] == 'f')?'success':$alert; ?>">
								  			<td class='text-center'><?php echo $libro['id_prestamo']; ?></td>
								  			<td class='text-center'><?php echo strtoupper($datos_libro['id_autor']) ?></td>
								  			<td class='text-center'><?php echo strtoupper($datos_libro['id_editorial']) ?></td>
								  			<td class='descripcion_libro'><?php echo strtoupper($datos_libro['descripcion']); ?></td>
								  			<td class='text-center'><?php echo date('d-m-Y',strtotime($libro['fecha_prestamo'])); ?></td>
								  			<td class='text-center'><?php echo date('d-m-Y',strtotime($libro['fecha_devolucion'])); ?></td>
								  			<td class='text-center'>
								  				<?php echo ($libro['status'] == 'f')?'ENTREGADO':'PENDIENTE'; ?>
								  			</td>
								  		</tr>
								  	<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
					<?php } ?>
				</div>
				<!--Tesis-->
				<?php if ($consultasbd->num_rows($tesis)) { ?>
				<div class="col-lg-12" id="tbl-tesis">
					<div class="panel panel-default">
						<div class="panel-heading"><strong>Tesis</strong></div>
						<table class="table table-bordered table-striped table-hover">
							<thead>
								<tr class="active">
									<th class="col-lg-1 text-center">Cod.&nbsp;Prestamo</th>
									<th class="col-lg-2 text-center">Materia</th>
									<th class="col-lg-2 text-center">Autor&nbsp;Tesis</th>
									<th class="col-lg-5">Titulo&nbsp;</th>
									<th class="col-lg-1 text-center">Fecha&nbsp;Prestamo</th>
									<th class="col-lg-1 text-center">Fecha&nbsp;Devoluci&oacute;n</th>
									<th class="col-lg-1 text-center">Acci&oacute;n</th>
								</tr>
							</thead>
							<tbody>
								<!--Libros-->
								<?php while ($tesi = $consultasbd->fetch_array($tesis)) { ?>
								<?php
									$datos_tesis = $consultasbd->select($tabla='tbl_tesis',$campos='*',$where='WHERE id_tesis=\''.$tesi['id_tesis'].'\'');
									$datos_tesis = $consultasbd->fetch_array($datos_tesis);
									// datos de materia
									$res_materia = $consultasbd->select($tabla='tbl_materia',$campos='*',$where = ((!empty($datos_tesis['id_materia']))?'WHERE id_materia=\''.$datos_tesis['id_materia'].'\'':''));
									$fetch_materia = $consultasbd->fetch_array($res_materia);
									$materia = $fetch_materia['nombre_materia'];
									// datos de autor
									$res_autor = $consultasbd->select($tabla='tbl_autor_tesis',$campos='*',$where = ((!empty($datos_tesis['id_autor_tesis']))?'WHERE id_autor_tesis=\''.$datos_tesis['id_autor_tesis'].'\'':''));
									$fetch_autor = $consultasbd->fetch_array($res_autor);
									$autor = $fetch_autor['nombre'].' '.$fetch_autor['apellido'];

									$datos_tesis['id_autor_tesis'] = $autor;
									$datos_tesis['id_materia'] = $materia;
									// total dias prestamo
									$segundos=strtotime($tesi['fecha_devolucion']) - strtotime($tesi['fecha_prestamo']);
									$diferencia_dias=intval($segundos/60/60/24);
									if (date('Y-m-d') > $tesi['fecha_devolucion']) {
										$alert = $class_alert[1];
									} else {
										if ($diferencia_dias <= 0) { $alert = $class_alert[1]; } else
										if ($diferencia_dias > 0 && $diferencia_dias < 2) { $alert = $class_alert[0]; }
										else { $alert = '';}
									}
								?>
							  		<tr id="row_tes_<?php echo $tesi['id_prestamo_tesis']; ?>" class="<?php echo $alert; ?>">
							  			<td class='text-center'><?php echo $tesi['id_prestamo_tesis']; ?></td>
							  			<td class='text-center'><?php echo strtoupper($materia); ?></td>
							  			<td class='text-center'><?php echo strtoupper($datos_tesis['id_autor_tesis']) ?></td>
							  			<td class='descripcion_tesi'><?php echo strtoupper($datos_tesis['titulo']); ?></td>
							  			<td class='text-center'><?php echo date('d-m-Y',strtotime($tesi['fecha_prestamo'])); ?></td>
							  			<td class='text-center'><?php echo date('d-m-Y',strtotime($tesi['fecha_devolucion'])); ?></td>
							  			<td class='text-center'>
							  				<?php echo ($libro['status'] == 'f')?'ENTREGADO':'PENDIENTE'; ?>
							  			</td>
							  		</tr>
							  	<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
				<?php } ?>
				<!--Materiales-->
				<?php if ($consultasbd->num_rows($material)) { ?>
				<div class="col-lg-12" id="tbl-mat">
					<div class="panel panel-default">
						<div class="panel-heading"><strong>Materiales</strong></div>
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr class="active">
										<th class="col-lg-1 text-center">Cod.&nbsp;Prestamo</th>
										<th class="col-lg-3 text-center">Tipo</th>
										<th class="col-lg-4 text-center">Nombre</th>
										<th class="col-lg-1 text-center">Fecha&nbsp;Prestamo</th>
										<th class="col-lg-1 text-center">Fecha&nbsp;Devoluci&oacute;n</th>
										<th class="col-lg-1 text-center">Acci&oacute;n</th>
									</tr>
								</thead>
								<tbody>
									<!--Libros-->
									<?php while ($mat = $consultasbd->fetch_array($material)) { ?>
									<?php
										$datos_materiales = $consultasbd->query($sql = 'select * from tbl_material as tbl_mat left outer join tbl_tipo_material tbl_tipo on tbl_mat.id_tipo=tbl_tipo.id_tipo_material WHERE id_material=\''.$mat['id_material'].'\'');
										$datos_materiales = $consultasbd->fetch_array($datos_materiales);
										// total dias prestamo
										$segundos=strtotime($mat['fecha_devolucion']) - strtotime($mat['fecha_prestamo']);
										$diferencia_dias=intval($segundos/60/60/24);
										if (date('Y-m-d') > $mat['fecha_devolucion']) {
											$alert = $class_alert[1];
										} else {
											if ($diferencia_dias <= 0) { $alert = $class_alert[1]; } else
											if ($diferencia_dias > 0 && $diferencia_dias < 2) { $alert = $class_alert[0]; } 
											else { $alert = '';}
											echo $alert;
										}
									?>
								  		<tr id="row_mat_<?php echo $mat['id_prestamo_material']; ?>" class="<?php echo $alert; ?>">
								  			<td class='text-center'><?php echo $mat['id_prestamo_material']; ?></td>
								  			<td class='text-center'><?php echo strtoupper($datos_materiales['descripcion_tipo']); ?></td>
								  			<td class='text-center'><?php echo strtoupper($datos_materiales['nombre']) ?></td>
								  			<td class='text-center'><?php echo date('d-m-Y',strtotime($mat['fecha_prestamo'])); ?></td>
								  			<td class='text-center'><?php echo date('d-m-Y',strtotime($mat['fecha_devolucion'])); ?></td>
								  			<td class='text-center'>
								  				<?php echo ($libro['status'] == 'f')?'ENTREGADO':'PENDIENTE'; ?>
								  			</td>
								  		</tr>
								  	<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
		<?php } else { echo '<div class="alert alert-danger" role="alert" id="alert"><b><i class="glyphicon glyphicon-thumbs-down"></i>&nbsp;Error</b>&nbsp;<span id="mensj">No hay datos para mostrar</span></div>'; } ?>
    </div>
    <div class="panel-footer text-center">
      <div class="btn-group">
          <p><i class="text-muted">BibloWeb v1.0</i></p>
      </div>
    </div>
  </div>
</div>
<script src="librerias/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="librerias/jquery-ui/jquery-ui.min.css">
<script type="text/javascript">
	function test () {
		alertify.confirm('test',function(e){ if (e) {alert("ssss");} });
		
	}
	$(document).on('ready',function(){
		$(".only_num").keypress(function(evt){
	        evt = (evt) ? evt : event
	        var key = (evt.which) ? evt.which : evt.keyCode;
	        if (key > 47 && key < 58 || key == 8 || key == 9) { return true;}
	        else {return false;}
	    });
	    $('#menu-item li.active').removeClass('active');
        $('#liPrestamos').addClass('active');
        // title page
      	$('title').html('..:: Reporte - Prestamos ::..&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
      	valuesTitle();
	    $.datepicker.regional['es'] = {
            closeText: 'Cerrar',
            prevText: '<<',
            nextText: '>>',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
            dayNamesShort: ['Dom','Lun','Mar','Mie','Juv','Vie','Sab'],
            dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sab'],
            weekHeader: 'Sm',
            dateFormat: 'yy-mm-dd',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            buttonImage: "images/calendar.png",
            yearSuffix: ''
      };
      $.datepicker.setDefaults($.datepicker.regional['es']);
      $("#from-date,#to-date").datepicker();
      $("#filter-date").on('click',function(){
      	$("#show-calendars").fadeIn();
      });
      $("#btn-filter-date").on('click',function(e){
      	e.preventDefault();
      	if($("#from-date").val() == '' || $("#to-date").val() == '') { alertify.error("<b>Debe indicar ambos limites de fecha</b>");  ($("#from-date").val() == '')?$("#from-date").focus():$("#to-date").focus(); return false; }
      	else if($("#from-date").val() != '' && $("#to-date").val() != '') { $("#show-calendars").submit(); }
      });
	});
</script>