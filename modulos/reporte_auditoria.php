<?php
	include_once('modulos/modelo.php');
	$user = $consultasbd->select($tabla='tbl_operador');
	if (count($_GET)==1 && count($_POST)==0) {
		$auditoria = $consultasbd->select($tabla='tbl_auditoria',$campos='*',$where='');
		$url_print = 'modulos/reporte_auditoria_pdf.php';
	} else if (count($_POST)>0) {
		$from_date = $_POST['from-date'];
		$to_date = $_POST['to-date'];
		$usuario = $_POST['txt_ced_user'];
		$url_print = 'modulos/reporte_auditoria_pdf.php?from_date='.$from_date.'&to_date='.$to_date.'&usuario='.$usuario;
		$wheree = ($from_date != '' && $to_date != '')?' WHERE fecha_auditoria>=\''.$from_date.'\' AND fecha_auditoria<=\''.$to_date.'\'':'';
		if ($usuario != ''){
			$auditoria = $consultasbd->select($tabla='tbl_auditoria',$campos='*',$where=(strlen($wheree)>0)?$wheree.' AND id_operador=\''.$usuario.'\'':'WHERE id_operador=\''.$usuario.'\'');
		} else {
			$auditoria = $consultasbd->select($tabla='tbl_auditoria',$campos='*',$where=$wheree);
		}

	}
?>
<div class="col-sm-9 col-md-10">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title"><b>Reporte de Auditoria&nbsp;<i class="glyphicon glyphicon-list" style="float:right;"></i></b></h3>
    </div>
    <div class="panel-body">
    	<br/>
		<div class="row">
			<div class="col-lg-12">
				<div class="well">
					<p><b>Filtro&nbsp;de&nbsp;Busqueda</b><i class="glyphicon glyphicon-filter"></i></p>
					<div class="radio-inline">
					    <label>
					      <input type="radio" name="filter" onclick="location.href = ('?page=reporte_auditoria');" <?php echo (count($_GET)==1 && count($_POST)==0)?'checked="checked"':''; ?> />&nbsp;Historial&nbsp;Completo
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
					<form id="show-calendars" <?php echo (count($_POST)>0)?'':'style="display:none;"' ?> class="form-inline" action="?page=reporte_auditoria" method="POST">
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
							<div class="form-group col-lg-6">
							    <select name="txt_ced_user" id="txt_ced_user" class="form-control chosen-select form-control required" data-placeholder="Seleccione Usuario(omitir si no desea aplicar este filtro)" title="Usuario">
					                <option value="">Todos los usuarios</option>
					                <?php 
					                  $id_usuario = (isset($usuario))?$usuario:false;
					                  while ($user_det = $consultasbd->fetch_array($user)) {
					                  	$selected = ($id_usuario == $user_det['id_operador'])?'selected=selected':'';
					                    echo '<option value="'.$user_det['id_operador'].'" '.$selected.'>'.$user_det['cedula'].' - '.strtoupper($user_det['nombre']).' '.strtoupper($user_det['apellido']).'</option>';
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
		<?php if ($consultasbd->num_rows($auditoria)){ ?>
		<div class="row" id="content-print">
				<?php if ($consultasbd->num_rows($auditoria)) { ?>
				<div class="col-lg-12" id="tbl-mat">
					<div class="panel panel-default">
						<div class="panel-heading"><strong>Registro de Auditoria</strong></div>
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-hover" id="datatable">
									<thead>
										<tr class="active">
											<th class="col-lg-1 text-center">Cod.&nbsp;Auditoria</th>
											<th class="col-lg-3 text-center">Operador</th>
											<th class="col-lg-4 text-center">Descripci&oacute;n</th>
											<th class="col-lg-1 text-center">Hora</th>
											<th class="col-lg-3 text-center">Fecha Auditoria</th>
										</tr>
									</thead>
									<tbody id="tbody">
										<?php while ($det_auditoria = $consultasbd->fetch_array($auditoria)) { ?>
										<?php
											$operador = $consultasbd->select($tabla='tbl_operador',$campos='*',$where='WHERE id_operador=\''.$det_auditoria['id_operador'].'\'');
											$datos_ope = $consultasbd->fetch_array($operador);
										?>
									  		<tr id="row_tes_<?php echo $det_auditoria['id_auditoria']; ?>" class="">
							  					<td class='text-center'><?php echo $det_auditoria['id_auditoria']; ?></td>
									  			<td class='text-center'><?php echo strtoupper($datos_ope['nombre'].' '.$datos_ope['apellido']); ?></td>
									  			<td class='text-center'><?php echo $det_auditoria['descripcion']; ?></td>
									  			<td class='text-center'><?php echo $det_auditoria['hora']; ?></td>
									  			<td class='text-center'><?php echo ($det_auditoria['fecha_auditoria'] != '')?date('d-m-Y',strtotime($det_auditoria['fecha_auditoria'])):''; ?></td>
									  		</tr>
									  	<?php } ?>
									</tbody>
								</table>
							</div>
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
<link rel="stylesheet" type="text/css" href="plugins/dataTables/css/datatables.css">
<script src="plugins/dataTables/js/jquery.dataTables.js" type="text/javascript"></script>
<script src="plugins/dataTables/js/datatables.js" type="text/javascript"></script>
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
      	$('title').html('..:: Reporte - Auditoria ::..&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
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
      $('#datatable').dataTable({
	      "AaSorting": [[0, "asc"]],
	      "sPaginationType": "bs_normal",
	    }); 
	    $('.dataTable').each(function(){
	      var datatable = $(this);
	      // SEARCH - Add the placeholder for Search and Turn this into in-line form control
	      var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
	      search_input.attr({'placeholder':'Buscar Libro','id':'btn_search_table'});
	      search_input.addClass('form-control input-sm');
	      // LENGTH - Inline-Form control
	      var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
	      length_sel.addClass('form-control input-sm');
	    });
	    $('#btn_search_table').attr({'title':'Filtrar resultado'});
	    $('#btn_search_table').addClass('form-control');
	    $('#btn_search_table').tooltip();
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
      	if($('#txt_ced_user').val() == '' && ($("#from-date").val() == '' && $("#to-date").val() == '')) { alertify.error("<b>Debe indicar al menos un filtro. Para fecha deben ser ambos campos</b>");  ($("#from-date").val() == '')?$("#from-date").focus():$("#to-date").focus(); return false; }
      	else if(($("#from-date").val() != '' && $("#to-date").val() != '') || $('#txt_ced_user').val() != '') { $("#show-calendars").submit(); }
      });
      if ($('#tbody tr').length == 0) {
      	$('#tbody-materiales').html('<tr><td colspan="7" class="text-center"><h4>SIN RESULTADOS</h4></td></tr>');
      }
	});
</script>