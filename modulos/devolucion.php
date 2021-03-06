<?php
	include_once('modulos/modelo.php');
	$class_alert = array('warning','danger');
	$user = $consultasbd->select($tabla='tbl_usuario');
	if (isset($_POST) && count($_POST)>0) {
		$id_usuario = $_POST['txt_ced_user'];
		$libros = $consultasbd->select($tabla='tbl_prestamo_libro',$campos='*',$where='WHERE id_usuario=\''.$id_usuario.'\' AND status=true');
		$tesis = $consultasbd->select($tabla='tbl_prestamo_tesis',$campos='*',$where='WHERE id_usuario=\''.$id_usuario.'\' AND status=true');
		$material = $consultasbd->select($tabla='tbl_prestamo_material',$campos='*',$where='WHERE id_usuario=\''.$id_usuario.'\' AND status=true');
	}
?>
<div class="col-sm-9 col-md-10">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title"><b>Devoluci&oacute;n Libro(s), Tesis, Material(es)<i class="glyphicon glyphicon-book" style="float:right;"></i></b></h3>
    </div>
    <div class="panel-body">
    	<div class="row">
    		<div class="col-lg-12">
    			<form class="form" action="?page=devolucion" id="frm-buscar-ced" method="POST">
	    			<div class="col-lg-5">
			            <label for="txt_ced_user">Usuario&nbsp;&nbsp;<i class="glyphicon glyphicon-user"></i></label>
			            <input type="hidden" name="send" id="send" class="required" value="" title="Seleccione usuario valido." />
			            <select name="txt_ced_user" id="txt_ced_user" class="chosen-select form-control required" data-placeholder="Seleccione Usuario" title="Usuario Solicitante">
			                <option value=""></option>
			                <?php 
			                  $id_usuario = (isset($id_usuario))?$id_usuario:false;
			                  while ($user_det = $consultasbd->fetch_array($user)) {
			                  	$selected = ($id_usuario == $user_det['id_usuario'])?'selected=selected':'';
			                    echo '<option value="'.$user_det['id_usuario'].'" '.$selected.'>'.$user_det['cedula'].' - '.$user_det['nombre'].' '.$user_det['apellido'].'</option>';
			                  }
			                ?>
			            </select>
			        	<img src="images/cargando.gif" id="load-l" class="img-circle load-l" />
			        </div>
    			</form>
    		</div>	
    	</div>	
    	<br/>
    	<?php if (isset($_POST) && count($_POST)) { ?>
		<?php if ($consultasbd->num_rows($libros) || $consultasbd->num_rows($tesis) || $consultasbd->num_rows($material)){ ?>
		<div class="row">
			<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading text-center">Leyenda de Colores en Filas de La(s) Tabla(s)</div>
					<table class="table table-bordered table-striped table-hover">
						<tbody>
							<tr>
								<td class="danger text-center col-lg-4">Prestamo Vencido&nbsp;<img src="images/calendar.png" class="img img-circle"></td>
								<td class="warning text-center col-lg-4">Prestamo Cerca a Vencer&nbsp;<img src="images/calendar.png" class="img img-circle"></td>
								<td class="text-center col-lg-4">Prestamo Activo&nbsp;<img src="images/calendar.png" class="img img-circle"></td>
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
										<th class="col-lg-3 text-center">Acci&oacute;n</th>
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
										// consulta de novedad
										$res_nov = $consultasbd->select($tabla='tbl_novedad_libro',$campos='status',$where='WHERE id_prestamo=\''.$libro['id_prestamo'].'\'');
										$fetch_nov = $consultasbd->fetch_array($res_nov);
									?>	
								  		<tr id="row_lib_<?php echo $libro['id_prestamo']; ?>" class="<?php echo $alert; ?>">
								  			<td class='text-center'><?php echo $libro['id_prestamo']; ?></td>
								  			<td class='text-center'><?php echo strtoupper($datos_libro['id_autor']) ?></td>
								  			<td class='text-center'><?php echo strtoupper($datos_libro['id_editorial']) ?></td>
								  			<td class='descripcion_libro'><?php echo strtoupper($datos_libro['descripcion']); ?></td>
								  			<td class='text-center'><?php echo date('d-m-Y',strtotime($libro['fecha_prestamo'])); ?></td>
								  			<td class='text-center'><?php echo date('d-m-Y',strtotime($libro['fecha_devolucion'])); ?></td>
								  			<td class='text-center'>
								  				<?php if ($fetch_nov['status'] == 't'): ?>
								  				<button class="btn-nov-libro-del btn btn-danger" id="<?php echo $libro['id_prestamo']; ?>">Ver Novedad(es)&nbsp;&nbsp;<i class="glyphicon glyphicon-remove-circle"></i></button>
								  				<?php else: ?>
								  				<button class="btn-pres-libro btn btn-danger" id="<?php echo $libro['id_prestamo']; ?>">Devolver&nbsp;&nbsp;<i class="glyphicon glyphicon-ok-circle"></i></button>&nbsp;
								  				<button class="btn-nov-libro btn btn-danger" id="<?php echo $libro['id_prestamo']; ?>">Novedad&nbsp;&nbsp;<i class="glyphicon glyphicon-remove-circle"></i></button>
								  				<?php endif; ?>
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
					<div class="table-responsive">
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
									// consulta de novedad
									$res_nov = $consultasbd->select($tabla='tbl_novedad_tesis',$campos='status',$where='WHERE id_prestamo_tesis=\''.$tesi['id_prestamo_tesis'].'\'');
									$fetch_nov = $consultasbd->fetch_array($res_nov);
								?>
							  		<tr id="row_tes_<?php echo $tesi['id_prestamo_tesis']; ?>" class="<?php echo $alert; ?>">
							  			<td class='text-center'><?php echo $tesi['id_prestamo_tesis']; ?></td>
							  			<td class='text-center'><?php echo strtoupper($materia); ?></td>
							  			<td class='text-center'><?php echo strtoupper($datos_tesis['id_autor_tesis']) ?></td>
							  			<td class='descripcion_tesi'><?php echo strtoupper($datos_tesis['titulo']); ?></td>
							  			<td class='text-center'><?php echo date('d-m-Y',strtotime($tesi['fecha_prestamo'])); ?></td>
							  			<td class='text-center'><?php echo date('d-m-Y',strtotime($tesi['fecha_devolucion'])); ?></td>
							  			<td class='text-center'>
							  				<?php if ($fetch_nov['status'] == 't'): ?>
							  				<button class="btn-nov-tesis-del btn btn-danger" id="<?php echo $tesi['id_prestamo_tesis']; ?>">Ver Novedad(es)&nbsp;&nbsp;<i class="glyphicon glyphicon-remove-circle"></i></button>
							  				<?php else: ?>
							  				<button class="btn-pres-tesis btn btn-danger" id="<?php echo $tesi['id_prestamo_tesis']; ?>">Devolver&nbsp;&nbsp;<i class="glyphicon glyphicon-ok-sign"></i></button>&nbsp;
							  				<button class="btn-nov-tesis btn btn-danger" id="<?php echo $tesi['id_prestamo_tesis']; ?>">Novedad&nbsp;&nbsp;<i class="glyphicon glyphicon-remove-circle"></i></button>
							  				<?php endif; ?>
							  			</td>
							  		</tr>
							  	<?php } ?>
							</tbody>
						</table>
					</div>
					</div>
				</div>
				<?php } ?>
				<!--Materiales-->
				<?php if ($consultasbd->num_rows($material)) { ?>
				<div class="col-lg-12" id="tbl-mat">
					<div class="table-responsive">
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

										// consulta de novedad
										$res_nov = $consultasbd->select($tabla='tbl_novedad_material',$campos='status',$where='WHERE id_prestamo_material=\''.$mat['id_prestamo_material'].'\'');
										$fetch_nov = $consultasbd->fetch_array($res_nov);
									?>
								  		<tr id="row_mat_<?php echo $mat['id_prestamo_material']; ?>" class="<?php echo $alert; ?>">
								  			<td class='text-center'><?php echo $mat['id_prestamo_material']; ?></td>
								  			<td class='text-center'><?php echo strtoupper($datos_materiales['descripcion_tipo']); ?></td>
								  			<td class='text-center'><?php echo strtoupper($datos_materiales['nombre']) ?></td>
								  			<td class='text-center'><?php echo date('d-m-Y',strtotime($mat['fecha_prestamo'])); ?></td>
								  			<td class='text-center'><?php echo date('d-m-Y',strtotime($mat['fecha_devolucion'])); ?></td>
								  			<td class='text-center'>
								  				<?php if ($fetch_nov['status'] == 't'): ?>
								  				<button class="btn-nov-mat-del btn btn-danger" id="<?php echo $mat['id_prestamo_material']; ?>">Ver Novedad(es)&nbsp;&nbsp;<i class="glyphicon glyphicon-remove-circle"></i></button>
								  				<?php else: ?>
								  				<button class="btn-pres-mat btn btn-danger" id="<?php echo $mat['id_prestamo_material']; ?>">Devolver&nbsp;&nbsp;<i class="glyphicon glyphicon-ok-circle"></i></button>&nbsp;
								  				<button class="btn-nov-mat btn btn-danger" id="<?php echo $mat['id_prestamo_material']; ?>">Novedad&nbsp;&nbsp;<i class="glyphicon glyphicon-remove-circle"></i></button>
								  				<?php endif; ?>
								  			</td>
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
		<?php } else { echo '<script>alertify.error("<b>Este Usuario no posee Prestamos Activos</b>");</script>'; } ?>
		<?php } ?>
    </div>
    <div class="panel-footer text-center">
      <div class="btn-group">
          <p><i class="text-muted">BibloWeb v1.0</i></p>
      </div>
    </div>
  </div>
</div>
<!-- Ventana Modal, Agregar novedad -->
<div class="modal fade" id="modalwindow">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true" class="text-danger"><small>[&times;]</small></span><span class="sr-only"></span></button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
      	<form class="form" id="form-new-novedad">
      		<div class="row">
			  	<div class="form-group col-lg-12">
			    	<label for="descripcion">Descripci&oacute;n Novedad</label>
				    <textarea name="descripcion" id="descripcion" class="form-control require"></textarea>
			    	</select>
			    	<input type="hidden" name="id_recurso" id="id_recurso" />
			  	</div>
			</div>
      		<div class="row" id="row-des-entrega" style="display:none;">
			  	<div class="form-group col-lg-12">
			    	<label for="descripcion_entrega">Descripci&oacute;n Entrega</label>
				    <textarea name="descripcion_entrega" id="descripcion_entrega" class="form-control require"></textarea>
			    	</select>
			  	</div>
			</div>
		</form>
      </div>
      <div class="modal-footer"></div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script src="librerias/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="librerias/jquery-ui/jquery-ui.min.css">
<link rel="stylesheet" type="text/css" href="plugins/chosen_v1.4.0/chosen.css">
<script src="plugins/chosen_v1.4.0/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript">
	function test () {
		alertify.confirm('test',function(e){ if (e) {alert("ssss");} });
		
	}
	$(document).on('ready',function(){
		// creacion de la ventana de dialogo
		$( "#dialog" ).dialog();
		$( ".ui-dialog" ).css({'border':'2px solid #000'});
		$( ".ui-dialog" ).hide();

		$(".only_num").keypress(function(evt){
	        evt = (evt) ? evt : event
	        var key = (evt.which) ? evt.which : evt.keyCode;
	        if (key > 47 && key < 58 || key == 8 || key == 9) { return true;}
	        else {return false;}
	    });
	    $('#menu-item li.active').removeClass('active');
        $('#liPrestamos').addClass('active');
        // title page
      	$('title').html('..:: Devolucion - Prestamo ::..&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
      	valuesTitle();
      	$('#txt_ced_user').chosen({no_results_text:'Sin Resultados',width:"100%"});
	    $('#txt_ced_user').on('change',function(){
	    	if ($('#txt_ced_user').val() == '') { return false; } else { $('#frm-buscar-ced').submit(); }
	    });
	    // devolucion de libro
	    $(document).on('click','.btn-pres-libro',function(){
	    	var id_prestamo = $(this).attr('id');
	    	$.post('modulos/response_ajax.php',{'id_prestamo':id_prestamo,'function':'verificar_novedades','recurso':'libro'},function(resp){
	    		if (resp == 'true') {
	    			alertify.confirm('<b>¿Esta seguro de realizar la devoluci&oacute;n del Libro?</b>',function(e){
    					if (e) {
	    					$.post('modulos/response_ajax.php',{'id_prestamo':id_prestamo,'function':'entrega_prestamo','recurso':'libro'},function(resp){
		    					if (resp == "true") {
		    						$("#row_lib_"+id_prestamo).remove();
		    						if ($("#tbl-libros tbody tr").length == 0) { $("#tbl-libros").fadeOut(); } 
		    					}
		    				});
    					}
	    			});
	    		} else {
	    			alertify.alert('<b>Este&nbsp;prestamo&nbsp;posee&nbsp;novedades.<br/><br/>Vaya&nbsp;al&nbsp;men&uacute;&nbsp;&nbsp;<a href="?page=novedades"><i class=\"glyphicon glyphicon-edit\"></i>&nbsp;Novedades</a>&nbsp;para&nbsp;verificar.</b>').set({'label':'OK, GRACIAS!'});
	    		}
	    	});
	    });
		// devolucion de tesis
	    $(document).on('click','.btn-pres-tesis',function(){
	    	var id_prestamo = $(this).attr('id');
	    	$.post('modulos/response_ajax.php',{'id_prestamo':id_prestamo,'function':'verificar_novedades','recurso':'tesis'},function(resp){
	    		if (resp == 'true') {
	    			alertify.confirm('<b>¿Esta seguro de realizar la devoluci&oacute;n de la Tesis?</b>',function(e){
    					if (e) {
	    					$.post('modulos/response_ajax.php',{'id_prestamo':id_prestamo,'function':'entrega_prestamo','recurso':'tesis'},function(resp){
		    					if (resp == "true") {
		    						$("#row_tes_"+id_prestamo).remove();
		    						if ($("#tbl-tesis tbody tr").length == 0) { $("#tbl-tesis").fadeOut(); } 
		    					}
		    				});
    					}
	    			});
	    		} else {
	    			alertify.alert('<b>Este&nbsp;prestamo&nbsp;posee&nbsp;novedades.<br/><br/>Vaya&nbsp;al&nbsp;men&uacute;&nbsp;&nbsp;<a href="?page=novedades"><i class=\"glyphicon glyphicon-edit\"></i>&nbsp;Novedades</a>&nbsp;para&nbsp;verificar.</b>').set({'label':'OK, GRACIAS!'});
	    		}
	    	});
	    });
		// devolucion de material
	    $(document).on('click','.btn-pres-mat',function(){
	    	var id_prestamo = $(this).attr('id');
	    	$.post('modulos/response_ajax.php',{'id_prestamo':id_prestamo,'function':'verificar_novedades','recurso':'material'},function(resp){
	    		if (resp == 'true') {
	    			alertify.confirm('<b>¿Esta seguro de realizar la devoluci&oacute;n del Material?</b>',function(e){
    					if (e) {
	    					$.post('modulos/response_ajax.php',{'id_prestamo':id_prestamo,'function':'entrega_prestamo','recurso':'material'},function(resp){
		    					if (resp == "true") {
		    						$("#row_mat_"+id_prestamo).remove();
		    						if ($("#tbl-mat tbody tr").length == 0) { $("#tbl-mat").fadeOut(); } 
		    					}
		    				});
    					}
	    			});
	    		} else {
	    			alertify.alert('<b>Este&nbsp;prestamo&nbsp;posee&nbsp;novedades.<br/><br/>Vaya&nbsp;al&nbsp;men&uacute;&nbsp;&nbsp;<a href="?page=novedades"><i class=\"glyphicon glyphicon-edit\"></i>&nbsp;Novedades</a>&nbsp;para&nbsp;verificar.</b>').set({'label':'OK, GRACIAS!'});
	    		}
	    	});
	    });
		// registrar novedad libro
		$(document).on('click','.btn-nov-libro',function(e){
			var id_prestamo = $(this).attr('id');
			$('#modalwindow').modal('show'); $(".modal-title").text("Registro de novedad para prestamo Libro");
			$('.modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button><button class="btn btn-danger" id="btn-nov-lib">Guardar</button>');
			$("#descripcion").val(""); $("#id_recurso").val(id_prestamo); 
		});
		$(document).on('click','#btn-nov-lib',function(){
			if ($('#descripcion').val() == '') { alertify.error('<b>Debe indicar una descripci&oacute;n</b>'); $('#descripcion').focus(); return false; }
			$.post('modulos/response_ajax.php',{'id_prestamo':$('#id_recurso').val(),'descripcion':$('#descripcion').val(),'function':'registrar_novedad','recurso':'libro'},function(resp){
				if (resp != ''){
					var id = $('#id_recurso').val();
					$('#'+id+'.btn-pres-libro').remove();
					$('#'+id+'.btn-nov-libro').attr('class','btn-nov-libro-del btn btn-danger').html('Ver Novedad(es)&nbsp;&nbsp;<i class="glyphicon glyphicon-remove-circle"></i>');
					$('#modalwindow').modal('hide');
					alertify.success('<b>Novedad registrada con exito</b>');
				}
			});
		});
		$(document).on('click','.btn-nov-libro-del',function(){
			var id_prestamo = $(this).attr('id');
			$.post('modulos/response_ajax.php',{'id_prestamo':id_prestamo,'recurso':'libro','function':'get_novedades'},function(resp){
				if (resp != '') {
					var resp = JSON.parse(resp);
					$('#modalwindow').modal('show'); $(".modal-title").text("Eliminación de novedad para prestamo Libro");
					$('.modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button><button class="btn btn-danger btn-nov-lib-fin" id="'+id_prestamo+'">Eliminar y entregar Libro</button>');
					$('#row-des-entrega').fadeIn(); $("#id_recurso").val(id_prestamo); 
					$('#descripcion').val(resp[0].descripcion).attr('disabled',true);
				}
			});
		});
		$(document).on('click','.btn-nov-lib-fin',function(){
			var id_prestamo = $(this).attr('id');
			if ($('#descripcion_entrega').val() == '') { alertify.error('<b>Debe indicar una descripci&oacute;n final</b>'); $('#descripcion_entrega').focus(); return false; }
			$.post('modulos/response_ajax.php',{'id_prestamo':id_prestamo,'recurso':'libro','function':'set_novedades','descripcion':$('#descripcion').val(),'descripcion_entrega':$('#descripcion_entrega').val()},function(resp){
				if (resp != '') {
					if (resp != '') {
						$('#'+id_prestamo+'.btn-nov-libro-del').attr({'class':'btn-pres-libro btn btn-danger','id':id_prestamo}).html('Devolver&nbsp;&nbsp;<i class="glyphicon glyphicon-ok-circle"></i>');
						$.post('modulos/response_ajax.php',{'id_prestamo':id_prestamo,'function':'entrega_prestamo','recurso':'libro'},function(resp){
	    					if (resp == "true") {
	    						$("#row_lib_"+id_prestamo).remove();
	    						if ($("#tbl-libros tbody tr").length == 0) { $("#tbl-libros").fadeOut(); } 
	    					}
	    				});
						$('#modalwindow').modal('hide');
					}
				}
			});
		});
		// registrar novedad tesis
		$(document).on('click','.btn-nov-tesis',function(e){
			var id_prestamo = $(this).attr('id');
			$('#modalwindow').modal('show'); $(".modal-title").text("Registro de novedad para prestamo Tesis");
			$('.modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button><button class="btn btn-danger" id="btn-nov-tes">Guardar</button>');
			$("#descripcion").val(""); $("#id_recurso").val(id_prestamo); 
		});
		$(document).on('click','#btn-nov-tes',function(){
			if ($('#descripcion').val() == '') { alertify.error('<b>Debe indicar una descripci&oacute;n</b>'); $('#descripcion').focus(); return false; }
			$.post('modulos/response_ajax.php',{'id_prestamo':$('#id_recurso').val(),'descripcion':$('#descripcion').val(),'function':'registrar_novedad','recurso':'tesis'},function(resp){
				if (resp != ''){
					var id = $('#id_recurso').val();
					$('#'+id+'.btn-pres-tesis').remove();
					$('#'+id+'.btn-nov-tesis').attr('class','btn-nov-tesis-del btn btn-danger').html('Ver Novedad(es)&nbsp;&nbsp;<i class="glyphicon glyphicon-remove-circle"></i>');
					$('#modalwindow').modal('hide');
					alertify.success('<b>Novedad registrada con exito</b>');
				}
			});
		});
		$(document).on('click','.btn-nov-tesis-del',function(){
			var id_prestamo = $(this).attr('id');
			$.post('modulos/response_ajax.php',{'id_prestamo':id_prestamo,'recurso':'tesis','function':'get_novedades'},function(resp){
				if (resp != '') {
					var resp = JSON.parse(resp);
					$('#modalwindow').modal('show'); $(".modal-title").text("Eliminación de novedad para prestamo Tesis");
					$('.modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button><button class="btn btn-danger btn-nov-tes-fin" id="'+id_prestamo+'">Eliminar y entregar Tesis</button>');
					$('#row-des-entrega').fadeIn(); $("#id_recurso").val(id_prestamo); 
					$('#descripcion').val(resp[0].descripcion).attr('disabled',true);
				}
			});
		});
		$(document).on('click','.btn-nov-tes-fin',function(){
			var id_prestamo = $(this).attr('id');
			if ($('#descripcion_entrega').val() == '') { alertify.error('<b>Debe indicar una descripci&oacute;n final</b>'); $('#descripcion_entrega').focus(); return false; }
			$.post('modulos/response_ajax.php',{'id_prestamo':id_prestamo,'recurso':'tesis','function':'set_novedades','descripcion':$('#descripcion').val(),'descripcion_entrega':$('#descripcion_entrega').val()},function(resp){
				if (resp != '') {
					if (resp != '') {
						$('#'+id_prestamo+'.btn-nov-tesis-del').attr({'class':'btn-pres-tesis btn btn-danger','id':id_prestamo}).html('Devolver&nbsp;&nbsp;<i class="glyphicon glyphicon-ok-circle"></i>');
						$.post('modulos/response_ajax.php',{'id_prestamo':id_prestamo,'function':'entrega_prestamo','recurso':'tesis'},function(resp){
	    					if (resp == "true") {
	    						$("#row_tes_"+id_prestamo).remove();
	    						if ($("#tbl-tesis tbody tr").length == 0) { $("#tbl-tesis").fadeOut(); } 
	    					}
	    				});
						$('#modalwindow').modal('hide');
					}
				}
			});
		});
		// registrar novedad material
		$(document).on('click','.btn-nov-mat',function(e){
			var id_prestamo = $(this).attr('id');
			$('#modalwindow').modal('show'); $(".modal-title").text("Registro de novedad para prestamo Material");
			$('.modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button><button class="btn btn-danger" id="btn-nov-material">Guardar</button>');
			$("#descripcion").val(""); $("#id_recurso").val(id_prestamo); 
		});
		$(document).on('click','#btn-nov-material',function(){
			if ($('#descripcion').val() == '') { alertify.error('<b>Debe indicar una descripci&oacute;n</b>'); $('#descripcion').focus(); return false; }
			$.post('modulos/response_ajax.php',{'id_prestamo':$('#id_recurso').val(),'descripcion':$('#descripcion').val(),'function':'registrar_novedad','recurso':'material'},function(resp){
				if (resp != ''){
					var id = $('#id_recurso').val();
					$('#'+id+'.btn-pres-mat').remove();
					$('#'+id+'.btn-nov-mat').attr('class','btn-nov-mat-del btn btn-danger').html('Ver Novedad(es)&nbsp;&nbsp;<i class="glyphicon glyphicon-remove-circle"></i>');
					$('#modalwindow').modal('hide');
					alertify.success('<b>Novedad registrada con exito</b>');
				}
			});
		});
		$(document).on('click','.btn-nov-mat-del',function(){
			var id_prestamo = $(this).attr('id');
			$.post('modulos/response_ajax.php',{'id_prestamo':id_prestamo,'recurso':'material','function':'get_novedades'},function(resp){
				if (resp != '') {
					var resp = JSON.parse(resp);
					$('#modalwindow').modal('show'); $(".modal-title").text("Eliminación de novedad para prestamo Material");
					$('.modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button><button class="btn btn-danger btn-nov-mat-fin" id="'+id_prestamo+'">Eliminar y entregar Material</button>');
					$('#row-des-entrega').fadeIn(); $("#id_recurso").val(id_prestamo); 
					$('#descripcion').val(resp[0].descripcion).attr('disabled',true);
				}
			});
		});
		$(document).on('click','.btn-nov-mat-fin',function(){
			var id_prestamo = $(this).attr('id');
			if ($('#descripcion_entrega').val() == '') { alertify.error('<b>Debe indicar una descripci&oacute;n final</b>'); $('#descripcion_entrega').focus(); return false; }
			$.post('modulos/response_ajax.php',{'id_prestamo':id_prestamo,'recurso':'material','function':'set_novedades','descripcion':$('#descripcion').val(),'descripcion_entrega':$('#descripcion_entrega').val()},function(resp){
				if (resp != '') {
					$('#'+id_prestamo+'.btn-nov-mat-del').attr({'class':'btn-pres-mat btn btn-danger','id':id_prestamo}).html('Devolver&nbsp;&nbsp;<i class="glyphicon glyphicon-ok-circle"></i>');
					$.post('modulos/response_ajax.php',{'id_prestamo':id_prestamo,'function':'entrega_prestamo','recurso':'material'},function(resp){
    					if (resp == "true") {
    						$("#row_mat_"+id_prestamo).remove();
    						if ($("#tbl-mat tbody tr").length == 0) { $("#tbl-mat").fadeOut(); } 
    					}
    				});
					$('#modalwindow').modal('hide');
				}
			});
		});
	});
</script>