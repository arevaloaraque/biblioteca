<?php
	include_once('modulos/modelo.php');
	$user = $consultasbd->select($tabla='tbl_usuario');
	if (count($_GET)==1 && count($_POST)==0) {
		$libros = $consultasbd->select($tabla='tbl_novedad_libro',$campos='*',$where='');
		$tesis = $consultasbd->select($tabla='tbl_novedad_tesis',$campos='*',$where='');
		$material = $consultasbd->select($tabla='tbl_novedad_material',$campos='*',$where='');
		$mostrar = array('libros','tesis','materiales');
		$url_print = 'modulos/reportes_novedades_pdf.php';
	} else if (count($_POST)>0) {
		$from_date = $_POST['from-date'];
		$to_date = $_POST['to-date'];
		$usuario = $_POST['txt_ced_user'];
		$url_print = 'modulos/reportes_novedades_pdf.php?from_date='.$from_date.'&to_date='.$to_date.'&usuario='.$usuario.'&sts-entregado='.((isset($_POST['sts-libro']))?$_POST['sts-libro']:'').'&sts-tesis='.((isset($_POST['sts-tesis']))?$_POST['sts-tesis']:'').'&sts-materiales='.((isset($_POST['sts-materiales']))?$_POST['sts-materiales']:'');
		$wheree = ($from_date != '' && $to_date != '')?' WHERE fecha_novedad>=\''.$from_date.'\' AND fecha_novedad<=\''.$to_date.'\'':'';
		$id_libros = array();
		$id_tesis = array();
		$id_materiales = array();
		$mostrar = array();
		if (isset($_POST['sts-libro'])) { array_push($mostrar, 'libros'); }
		if (isset($_POST['sts-tesis'])) { array_push($mostrar, 'tesis'); }
		if (isset($_POST['sts-materiales'])) { array_push($mostrar, 'materiales'); }
		if (!isset($_POST['sts-libro']) && !isset($_POST['sts-tesis']) && !isset($_POST['sts-materiales'])) { $mostrar = array('libros','tesis','materiales'); }
		if ($usuario != ''){
			$prestamos = $consultasbd->select($tabla='tbl_prestamo_libro',$campos='id_prestamo',$where='WHERE id_usuario=\''.$usuario.'\'');
			while ($prestamo = $consultasbd->fetch_array($prestamos)) {
				$id_libros[] = $prestamo['id_prestamo'];
 			}
 			$libros =(count($id_libros))?$consultasbd->select($tabla='tbl_novedad_libro',$campos='*',$where=(strlen($wheree)>0)?$wheree.' AND id_prestamo IN ('.implode(",",$id_libros).')':' WHERE  id_prestamo IN ('.implode(",",$id_libros).')'):false;
 			$prestamos_tesis = $consultasbd->select($tabla='tbl_prestamo_tesis',$campos='id_prestamo_tesis',$where='WHERE id_usuario=\''.$usuario.'\'');
			while ($prestamo = $consultasbd->fetch_array($prestamos_tesis)) {
				$id_tesis[] = $prestamo['id_prestamo_tesis'];
 			}
 			$tesis =(count($id_tesis)>0)?$consultasbd->select($tabla='tbl_novedad_tesis',$campos='*',$where=(strlen($wheree)>0)?$wheree.' AND id_prestamo_tesis IN ('.implode(",",$id_tesis).')':' WHERE  id_prestamo_tesis IN ('.implode(",",$id_tesis).')'):false;
 			$prestamos_material = $consultasbd->select($tabla='tbl_prestamo_material',$campos='id_prestamo_material',$where='WHERE id_usuario=\''.$usuario.'\'');
			while ($prestamo = $consultasbd->fetch_array($prestamos_material)) {
				$id_materiales[] = $prestamo['id_prestamo_material'];
 			}
 			$material =(count($id_materiales)>0)?$consultasbd->select($tabla='tbl_novedad_material',$campos='*',$where=(strlen($wheree)>0)?$wheree.' AND id_prestamo_material IN ('.implode(",",$id_materiales).')':' WHERE  id_prestamo_material IN ('.implode(",",$id_materiales).')'):false;
		} else {
			$libros = $consultasbd->select($tabla='tbl_novedad_libro',$campos='*',$wheree);
			$tesis = $consultasbd->select($tabla='tbl_novedad_tesis',$campos='*',$wheree);
			$material = $consultasbd->select($tabla='tbl_novedad_material',$campos='*',$wheree);
		}

	}
?>
<div class="col-sm-9 col-md-10">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title"><b>Reporte de Novedades: Libro(s), Tesis, Material(es)<i class="glyphicon glyphicon-edit" style="float:right;"></i></b></h3>
    </div>
    <div class="panel-body">
    	<br/>
		<div class="row">
			<div class="col-lg-12">
				<div class="well">
					<p><b>Filtro&nbsp;de&nbsp;Busqueda</b><i class="glyphicon glyphicon-filter"></i></p>
					<div class="radio-inline">
					    <label>
					      <input type="radio" name="filter" onclick="location.href = ('?page=reportes_novedades');" <?php echo (count($_GET)==1 && count($_POST)==0)?'checked="checked"':''; ?> />&nbsp;Historial&nbsp;Completo
					    </label>
					</div>
					<div class="radio-inline">
					    <label>
					      <input type="radio" name="filter" id="filter-date" <?php echo (count($_POST)>0)?'checked="checked"':''; ?> />&nbsp;Personalizado&nbsp;
					    </label>
					</div>
					<?php if (count($_POST) == 0): ?>
					<div class="radio-inline">
					    <label>
					      <button type="button" class="btn btn-danger" onclick='javascript:popup("<?php echo $url_print; ?>",700,500)'>Imprimir&nbsp;<i class="glyphicon glyphicon-print"></i></button>
					    </label>
					</div>
					<?php endif; ?>
					<form id="show-calendars" <?php echo (count($_POST)>0)?'':'style="display:none;"' ?> class="form-inline" action="?page=reportes_novedades" method="POST">
						<div class="row">
							<div class="form-group col-lg-4">
								<div class="input-group">
								  <div class="input-group-addon"><small><b>Desde:&nbsp;</b></small></div>
							      <input type="text" name="from-date" id="from-date" class="form-control" readonly="readOnly" value="<?php echo (isset($_POST['from-date']))?$_POST['from-date']:''; ?>" />
							      <div class="input-group-addon"><img src="images/calendar.png"></div>
							    </div>
							</div>
							<div class="form-group col-lg-4">
								<div class="input-group">
								  <div class="input-group-addon"><small><b>Hasta:&nbsp;</b></small></div>
							      <input type="text" name="to-date" id="to-date" class="form-control" readonly="readOnly" value="<?php echo (isset($_POST['to-date']))?$_POST['to-date']:''; ?>" />
							      <div class="input-group-addon"><img src="images/calendar.png"></div>
							    </div>
							</div>
						</div>
						<br/>
						<div class="row">
							<div class="form-group col-lg-8">
							    <table class="table table-bordered table-striped table-hover">
							    	<thead>
							    		<tr><td colspan="4" class=""><b>Filtrar por tipo</b></td></tr>
							    	</thead>
									<tbody>
										<tr>
											<td class="success">
												<div class="checkbox">
													<label>
													  <input type="checkbox" name="sts-libro" class="fil-status" <?php echo (isset($_POST['sts-libro']))?'checked="checked"':'' ?> > Libros
													</label>
												</div>
											</td>
											<td class="danger">
												<div class="checkbox danger">
													<label>
													  <input type="checkbox" name="sts-tesis" class="fil-status" <?php echo (isset($_POST['sts-tesis']))?'checked="checked"':'' ?> > Tesis
													</label>
												</div>
											</td>
											<td class="warning">
												<div class="checkbox">
													<label>
													  <input type="checkbox" name="sts-materiales" class="fil-status" <?php echo (isset($_POST['sts-materiales']))?'checked="checked"':'' ?> > Materiales
													</label>
												</div>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<br/>
						<div class="row">
							<div class="form-group col-lg-6">
							    <select name="txt_ced_user" id="txt_ced_user" class="form-control chosen-select form-control required" data-placeholder="Seleccione Usuario(omitir si no desea aplicar este filtro)" title="Usuario">
					                <option value="">Todos los usuarios</option>
					                <?php 
					                  $id_usuario = (isset($usuario))?$usuario:false;
					                  while ($user_det = $consultasbd->fetch_array($user)) {
					                  	$selected = ($id_usuario == $user_det['id_usuario'])?'selected=selected':'';
					                    echo '<option value="'.$user_det['id_usuario'].'" '.$selected.'>'.$user_det['cedula'].' - '.$user_det['nombre'].' '.$user_det['apellido'].'</option>';
					                  }
					                ?>
					            </select>
							</div>
							<div class="form-group col-lg-6">
								<button id="btn-reset" class="btn btn-danger">Limpiar&nbsp;<i class="glyphicon glyphicon-trash"></i></button>
								<button id="btn-filter-date" class="btn btn-danger">Ver&nbsp;<i class="glyphicon glyphicon-eye-open"></i></button>
								<?php if (count($_POST)>0): ?>
								<button id="btn-filter-date" class="btn btn-danger" onclick='javascript:popup("<?php echo $url_print; ?>",700,500)'>Imprimir&nbsp;<i class="glyphicon glyphicon-print"></i></button>
								<?php endif; ?>
							</div>
						</div>
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
								<td class="success text-center col-lg-4">Libros&nbsp;<i class="glyphicon glyphicon-book"></i></td>
								<td class="danger text-center col-lg-4">Tesis&nbsp;<i class="glyphicon glyphicon-tags"></i></td>
								<td class="warning text-center col-lg-4">Materiales&nbsp;<i class="glyphicon glyphicon-floppy-disk"></i></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="row" id="content-print">
				<div class="col-lg-12" id="tbl-libros">
					<div class="table-responsive">
					<?php if ($consultasbd->num_rows($libros)) { ?>
					<div class="panel panel-default">
						<div class="panel-heading"><strong>Libros</strong></div>
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr class="active">
										<th class="col-lg-1 text-center">Cod.&nbsp;Novedad</th>
										<th class="col-lg-4 text-center">Descripci&oacute;n</th>
										<th class="col-lg-1 text-center">Id&nbsp;Prestamo</th>
										<th class="col-lg-1">Fecha&nbsp;Novedad</th>
										<th class="col-lg-3 text-center">Descripci&oacute;n&nbsp;Final</th>
										<th class="col-lg-1 text-center">Status</th>
									</tr>
								</thead>
								<tbody id="tbody-libro">
									<!--Libros-->
									<?php if(in_array('libros', $mostrar)) { ?>
									<?php while ($libro = $consultasbd->fetch_array($libros)) { ?>
								  		<tr id="row_lib_<?php echo $libro['id_prestamo']; ?>" class="success">
								  			<td class='text-center'><?php echo $libro['id_novedad']; ?></td>
								  			<td class='text-center'><?php echo strtoupper($libro['descripcion']); ?></td>
								  			<td class='text-center'><?php echo $libro['id_prestamo']; ?></td>
								  			<td class='text-center'><?php echo ($libro['fecha_novedad'] != '')?date('d-m-Y',strtotime($libro['fecha_novedad'])):''; ?></td>
								  			<td class='text-center'><?php echo strtoupper($libro['descripcion_final']); ?></td>
								  			<td class='text-center'>
								  				<?php echo ($libro['status'] == 'f')?'FINALIZADO':'PENDIENTE'; ?>
								  			</td>
								  		</tr>
								  	<?php } } ?>
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
									<th class="col-lg-1 text-center">Cod.&nbsp;Novedad</th>
									<th class="col-lg-4 text-center">Descripci&oacute;n</th>
									<th class="col-lg-1 text-center">Id&nbsp;Prestamo</th>
									<th class="col-lg-1">Fecha&nbsp;Novedad</th>
									<th class="col-lg-3 text-center">Descripci&oacute;n&nbsp;Final</th>
									<th class="col-lg-1 text-center">Status</th>
								</tr>
							</thead>
							<tbody id="tbody-tesis">
								<!--Tesis-->
								<?php if(in_array('tesis', $mostrar)) { ?>
								<?php while ($tesi = $consultasbd->fetch_array($tesis)) { ?>
							  		<tr id="row_tes_<?php echo $tesi['id_prestamo_tesis']; ?>" class="danger">
							  			<td class='text-center'><?php echo $tesi['id_novedad_tesis']; ?></td>
								  			<td class='text-center'><?php echo strtoupper($tesi['descripcion']); ?></td>
								  			<td class='text-center'><?php echo $tesi['id_prestamo_tesis']; ?></td>
								  			<td class='text-center'><?php echo ($tesi['fecha_novedad'] != '')?date('d-m-Y',strtotime($tesi['fecha_novedad'])):''; ?></td>
								  			<td class='text-center'><?php echo strtoupper($tesi['descripcion_final']); ?></td>
								  			<td class='text-center'>
								  				<?php echo ($tesi['status'] == 'f')?'FINALIZADO':'PENDIENTE'; ?>
								  			</td>
							  		</tr>
							  	<?php } } ?>
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
										<th class="col-lg-1 text-center">Cod.&nbsp;Novedad</th>
										<th class="col-lg-4 text-center">Descripci&oacute;n</th>
										<th class="col-lg-1 text-center">Id&nbsp;Prestamo</th>
										<th class="col-lg-1">Fecha&nbsp;Novedad</th>
										<th class="col-lg-3 text-center">Descripci&oacute;n&nbsp;Final</th>
										<th class="col-lg-1 text-center">Status</th>
									</tr>
								</thead>
								<tbody id="tbody-materiales">
									<!--Materiales-->
									<?php if(in_array('materiales', $mostrar)) { ?>
									<?php while ($mat = $consultasbd->fetch_array($material)) { ?>
								  		<tr id="row_tes_<?php echo $mat['id_prestamo_tesis']; ?>" class="warning">
							  			<td class='text-center'><?php echo $mat['id_novedad_material']; ?></td>
									  			<td class='text-center'><?php echo strtoupper($mat['descripcion']); ?></td>
									  			<td class='text-center'><?php echo $mat['id_prestamo_material']; ?></td>
									  			<td class='text-center'><?php echo ($mat['fecha_novedad'] != '')?date('d-m-Y',strtotime($mat['fecha_novedad'])):''; ?></td>
									  			<td class='text-center'><?php echo strtoupper($mat['descripcion_final']); ?></td>
									  			<td class='text-center'>
									  				<?php echo ($mat['status'] == 'f')?'FINALIZADO':'PENDIENTE'; ?>
									  			</td>
								  		</tr>
								  	<?php } } ?>
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
<link rel="stylesheet" type="text/css" href="plugins/chosen_v1.4.0/chosen.css">
<script src="plugins/chosen_v1.4.0/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript">
	var popup = function(){};
	$(document).on('ready',function(){
		popup = function (url,ancho,alto) {
			var posicion_x; 
			var posicion_y; 
			posicion_x=(screen.width/2)-(ancho/2); 
			posicion_y=(screen.height/2)-(alto/2); 
			window.open(url, "leonpurpura.com", "width="+ancho+",height="+alto+",menubar=0,toolbar=0,directories=0,scrollbars=no,resizable=no,left="+posicion_x+",top="+posicion_y+"");
		}
		$('#txt_ced_user').chosen({no_results_text:'Sin Resultados',width:"100%"});
		$(".only_num").keypress(function(evt){
	        evt = (evt) ? evt : event
	        var key = (evt.which) ? evt.which : evt.keyCode;
	        if (key > 47 && key < 58 || key == 8 || key == 9) { return true;}
	        else {return false;}
	    });
	    $('#menu-item li.active').removeClass('active');
        $('#liPrestamos').addClass('active');
        // title page
      	$('title').html('..:: Reporte - Novedades ::..&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
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
      $('#btn-reset').on('click',function(e){
      	e.preventDefault();
      	document.getElementById('from-date').value = '';
      	document.getElementById('to-date').value = '';
      	$(".fil-status:checked").removeAttr("checked");
      });
      $("#btn-filter-date").on('click',function(e){
      	e.preventDefault();
      	if(($("#from-date").val() == '' || $("#to-date").val() == '') && $('#txt_ced_user').val() == '' && $(".fil-status:checked").length == 0) { alertify.error("<b>Debe indicar al menos un filtro. Para fecha deben ser ambos campos</b>");  ($("#from-date").val() == '')?$("#from-date").focus():$("#to-date").focus(); return false; }
      	else if(($("#from-date").val() != '' && $("#to-date").val() != '') || $('#txt_ced_user').val() != '' || $(".fil-status:checked").length > 0) { $("#show-calendars").submit(); }
      });
      // verificacion de filtros en tbody
      if ($('#tbody-libro tr').length == 0) {
      	$('#tbody-libro').html('<tr><td colspan="7" class="text-center"><h4>SIN RESULTADOS</h4></td></tr>');
      }

      if ($('#tbody-tesis tr').length == 0) {
      	$('#tbody-tesis').html('<tr><td colspan="7" class="text-center"><h4>SIN RESULTADOS</h4></td></tr>');
      }

      if ($('#tbody-materiales tr').length == 0) {
      	$('#tbody-materiales').html('<tr><td colspan="7" class="text-center"><h4>SIN RESULTADOS</h4></td></tr>');
      }
	});
</script>