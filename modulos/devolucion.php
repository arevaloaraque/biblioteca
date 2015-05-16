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
									?>
								  		<tr id="<?php echo $libro['id_prestamo']; ?>" class="<?php echo $alert; ?>">
								  			<td class='text-center'><?php echo $libro['id_prestamo']; ?></td>
								  			<td class='text-center'><?php echo strtoupper($datos_libro['id_autor']) ?></td>
								  			<td class='text-center'><?php echo strtoupper($datos_libro['id_editorial']) ?></td>
								  			<td class='descripcion_libro'><?php echo strtoupper($datos_libro['descripcion']); ?></td>
								  			<td class='text-center'><?php echo date('d-m-Y',strtotime($libro['fecha_prestamo'])); ?></td>
								  			<td class='text-center'><?php echo date('d-m-Y',strtotime($libro['fecha_devolucion'])); ?></td>
								  			<td class='text-center'>
								  				<button class="btn-pres-libro btn btn-danger" id="<?php echo $libro['id_prestamo']; ?>">Devolver&nbsp;&nbsp;<i class="glyphicon glyphicon-ok-circle"></i></button>&nbsp;
								  				<button class="btn-nov-libro btn btn-danger" id="<?php echo $libro['id_prestamo']; ?>">Novedad&nbsp;&nbsp;<i class="glyphicon glyphicon-remove-circle"></i></button>
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
							  		<tr id="<?php echo $tesi['id_prestamo_tesis']; ?>" class="<?php echo $alert; ?>">
							  			<td class='text-center'><?php echo $tesi['id_prestamo_tesis']; ?></td>
							  			<td class='text-center'><?php echo strtoupper($materia); ?></td>
							  			<td class='text-center'><?php echo strtoupper($datos_tesis['id_autor_tesis']) ?></td>
							  			<td class='descripcion_tesi'><?php echo strtoupper($datos_tesis['titulo']); ?></td>
							  			<td class='text-center'><?php echo date('d-m-Y',strtotime($tesi['fecha_prestamo'])); ?></td>
							  			<td class='text-center'><?php echo date('d-m-Y',strtotime($tesi['fecha_devolucion'])); ?></td>
							  			<td class='text-center'>
							  				<button class="btn-pres-tesis btn btn-danger" id="<?php echo $tesi['id_prestamo_tesis']; ?>">Devolver&nbsp;&nbsp;<i class="glyphicon glyphicon-ok-sign"></i></button>&nbsp;
							  				<button class="btn-nov-tesis btn btn-danger" id="<?php echo $tesi['id_prestamo_tesis']; ?>">Novedad&nbsp;&nbsp;<i class="glyphicon glyphicon-remove-circle"></i></button>
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
								  		<tr id="<?php echo $mat['id_prestamo_material']; ?>" class="<?php echo $alert; ?>">
								  			<td class='text-center'><?php echo $mat['id_prestamo_material']; ?></td>
								  			<td class='text-center'><?php echo strtoupper($datos_materiales['descripcion_tipo']); ?></td>
								  			<td class='text-center'><?php echo strtoupper($datos_materiales['nombre']) ?></td>
								  			<td class='text-center'><?php echo date('d-m-Y',strtotime($mat['fecha_prestamo'])); ?></td>
								  			<td class='text-center'><?php echo date('d-m-Y',strtotime($mat['fecha_devolucion'])); ?></td>
								  			<td class='text-center'>
								  				<button class="btn-pres-mat btn btn-danger" id="<?php echo $mat['id_prestamo_material']; ?>">Devolver&nbsp;&nbsp;<i class="glyphicon glyphicon-ok-circle"></i></button>&nbsp;
								  				<button class="btn-nov-mat btn btn-danger" id="<?php echo $mat['id_prestamo_material']; ?>">Novedad&nbsp;&nbsp;<i class="glyphicon glyphicon-remove-circle"></i></button>
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
<link rel="stylesheet" type="text/css" href="plugins/chosen_v1.4.0/chosen.css">
<script src="plugins/chosen_v1.4.0/chosen.jquery.js" type="text/javascript"></script>
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
      	$('title').html('..:: Devolucion - Prestamo ::..&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
      	valuesTitle();
      	$('#txt_ced_user').chosen({no_results_text:'Sin Resultados',width:"100%"});
	    $('#txt_ced_user').on('change',function(){
	    	if ($('#txt_ced_user').val() == '') { return false; } else { $('#frm-buscar-ced').submit(); }
	    });
	    // devolucion de libro
	    $('.btn-pres-libro').on('click',function(){
	    	var id_prestamo = $(this).attr('id');
	    	$.post('modulos/response_ajax.php',{'id_prestamo':id_prestamo,'function':'verificar_novedades','recurso':'libro'},function(resp){
	    		if (resp == 'true') {
	    			alertify.confirm('<b>¿Esta seguro de realizar la devoluci&oacute;n del Libro?</b>',function(e){
    					if (e) {
	    					$.post('modulos/response_ajax.php',{'id_prestamo':id_prestamo,'function':'entrega_prestamo','recurso':'libro'},function(resp){
		    					if (resp == "true") {
		    						$("tr#"+id_prestamo).remove();
		    						if ($("#tbl-libros>tbody>tr").length == 0) { $("#tbl-libros").fadeOut(); } 
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
	    $('.btn-pres-tesis').on('click',function(){
	    	var id_prestamo = $(this).attr('id');
	    	$.post('modulos/response_ajax.php',{'id_prestamo':id_prestamo,'function':'verificar_novedades','recurso':'tesis'},function(resp){
	    		if (resp == 'true') {
	    			alertify.confirm('<b>¿Esta seguro de realizar la devoluci&oacute;n de la Tesis?</b>',function(e){
    					if (e) {
	    					$.post('modulos/response_ajax.php',{'id_prestamo':id_prestamo,'function':'entrega_prestamo','recurso':'tesis'},function(resp){
		    					if (resp == "true") {
		    						$("tr#"+id_prestamo).remove();
		    						if ($("#tbl-tesis>tbody>tr").length == 0) { $("#tbl-tesis").fadeOut(); } 
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
	    $('.btn-pres-mat').on('click',function(){
	    	var id_prestamo = $(this).attr('id');
	    	$.post('modulos/response_ajax.php',{'id_prestamo':id_prestamo,'function':'verificar_novedades','recurso':'material'},function(resp){
	    		if (resp == 'true') {
	    			alertify.confirm('<b>¿Esta seguro de realizar la devoluci&oacute;n del Material?</b>',function(e){
    					if (e) {
	    					$.post('modulos/response_ajax.php',{'id_prestamo':id_prestamo,'function':'entrega_prestamo','recurso':'material'},function(resp){
		    					if (resp == "true") {
		    						$("tr#"+id_prestamo).remove();
		    						if ($("#tbl-mat>tbody>tr").length == 0) { $("#tbl-mat").fadeOut(); } 
		    					}
		    				});
    					}
	    			});
	    		} else {
	    			alertify.alert('<b>Este&nbsp;prestamo&nbsp;posee&nbsp;novedades.<br/><br/>Vaya&nbsp;al&nbsp;men&uacute;&nbsp;&nbsp;<a href="?page=novedades"><i class=\"glyphicon glyphicon-edit\"></i>&nbsp;Novedades</a>&nbsp;para&nbsp;verificar.</b>').set({'label':'OK, GRACIAS!'});
	    		}
	    	});
	    });
	});
</script>