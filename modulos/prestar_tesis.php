<?php 
	include_once('modulos/modelo.php');
	if (isset($_GET['id_tesis'])) {
		$id_tesis = $_GET['id_tesis'];
		$sql_tesis = $consultasbd->select($tabla='tbl_tesis',$campos='*',$where=' WHERE status=true AND id_tesis=\''.$id_tesis.'\'');
		$datos_tesis = $consultasbd->fetch_array($sql_tesis);
    $user = $consultasbd->select('tbl_usuario',$campos='*');
    // validar si el tesis existe
    if ($consultasbd->num_rows($sql_tesis) == 0){
      echo '<script>location.href="?page=prestamos&rec_not=true";</script>';
    }
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
    $datos_tesis['fecha_publicacion'] = date('d-m-Y',strtotime($datos_tesis['fecha_publicacion']));
	} else if (isset($_POST) && count($_POST)>0) {
    $id_tesis = $_POST['codigo_tesis'];
    $id_usuario = $_POST['txt_id_user'];
    $fecha_devolucion = $_POST['txt_fecha_devolucion'];
    $tabla = 'tbl_prestamo_tesis';
    $campos = '(id_tesis,id_operador,id_usuario,fecha_prestamo,fecha_devolucion)';
    $values = '\''.$id_tesis.'\',\''.$_SESSION['id_operador'].'\',\''.$id_usuario.'\',\''.date('Y-m-d').'\',\''.$fecha_devolucion.'\'';
    // registro de prestamo
    $consultasbd->insert($tabla,$campos,$values);
    // actualizacion de status de disponibilidad de libro
    $tabla = 'tbl_tesis';
    $set   = 'status=false';
    $where = ' WHERE id_tesis=\''.$id_tesis.'\'';
    $consultasbd->update($tabla,$set,$where);
    // auditoria
    $auditar_mnsj = "Realizo prestamo de tesis. datos: (id_tesis=>".$id_tesis.",id_usuario=>".$id_usuario.")";
    $auditar_user = $_SESSION['id_operador'];
    $auditar_date = date('Y-m-d');
    $auditar_hour = date('H:m');
    $consultasbd->insert($tabla='tbl_auditoria',$campos='(id_operador,descripcion,hora,fecha_auditoria)',$values='\''.$auditar_user.'\',\''.$auditar_mnsj.'\',\''.$auditar_hour.'\',\''.$auditar_date.'\'');
    // FIN auditoria
    // redireccion vista prestamos
    echo '<script>location.href="?page=prestamos&pres_cmp=true";</script>';
  } else {
    echo '<script>location.href="?page=prestamos";</script>';
  }
?>
<div class="col-sm-9 col-md-10">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title"><b>Registro&nbsp;Prestamo&nbsp;de&nbsp;Tesis<i class="glyphicon glyphicon-transfer" style="float:right;"></i></b></h3>
    </div>
    <div class="panel-body">
    	<form action="?page=prestar_tesis" id="frm-prestar" method="POST" class="well" accept-charset="utf-8">
    		<div class="row">
    			<div class="col-lg-2">
    				<label for="txt_codigo_tesis">Cod&iacute;go&nbsp;Tesis&nbsp;&nbsp;<i class="glyphicon glyphicon-credit-card"></i></label>
	    			<input type="text" name="txt_codigo_tesis" id="txt_codigo_tesis" class="form-control required" title="Cod&iacute;go Tesis" disabled="disabled" value="<?php echo $datos_tesis['id_tesis']; ?>" />	
            <input type="hidden" name="codigo_tesis" id="codigo_tesis" value="<?php echo $datos_tesis['id_tesis']; ?>" />
    			</div>
    		</div>
    		<br/>
	    	<div class="row">
	    		<div class="col-lg-12">
	    			<label for="txt_autor">Autor&nbsp;Tesis&nbsp;&nbsp;<i class="glyphicon glyphicon-user"></i></label>
	    			<input type="text" name="txt_autor" id="txt_autor" class="form-control required" title="Autor Tesis" readOnly="readOnly" value="<?php echo strtoupper($datos_tesis['id_autor_tesis']); ?>" />
	    		</div>
	    	</div>
        <br/>
        <div class="row">
          <div class="col-lg-12">
            <label for="txt_descripcion">Titulo&nbsp;Tesis&nbsp;&nbsp;<i class="glyphicon glyphicon-tag"></i></label>
            <input type="text" name="txt_descripcion" id="txt_descripcion" class="form-control required" title="Descripcion Tesis" readOnly="readOnly" value="<?php echo strtoupper($datos_tesis['titulo']); ?>" />
          </div>
        </div>
        <br/>
        <div class="row">
          <div class="col-lg-3">
            <label for="txt_fecha_devolucion">Fecha&nbsp;devoluci&oacute;n&nbsp;&nbsp;<img src="images/calendar.png" /></label>
            <input type="text" name="txt_fecha_devolucion" id="txt_fecha_devolucion" min="<?php echo date('d-m-Y'); ?>" class="form-control required" title="Fecha devoluci&oacute;n" readOnly="readOnly" />
          </div>
        </div>
        <br/>
        <div class="row">
          <div class="col-lg-5">
            <label for="txt_id_user">Usuario&nbsp;Solicitante&nbsp;&nbsp;<i class="glyphicon glyphicon-user"></i></label>
            <input type="hidden" name="send" id="send" class="required" value="" title="Seleccione usuario valido." />
            <select name="txt_id_user" id="txt_id_user" class="chosen-select form-control required" data-placeholder="Seleccione Usuario" title="Usuario Solicitante">
                <option value=""></option>
                <?php 
                  while ($user_det = $consultasbd->fetch_array($user)) {
                    echo '<option value="'.$user_det['id_usuario'].'">'.$user_det['cedula'].' - '.$user_det['nombre'].' '.$user_det['apellido'].'</option>';
                  }
                ?>
            </select>
            <img src="images/cargando.gif" id="load-l" class="img-circle load-l" />
          </div>
        </div>
        <div class="row" id="text-resp" style="display:none;">
          <div class="col-lg-5">
            <br />
            <div class="alert" role="alert" id="alert"></div>
          </div>
        </div>
        <div class="row" id="btn-prestamo" style="display:none;">
          <br/>
          <div class="col-lg-12 text-right">
            <button class="btn btn-danger" id="btn-prestar"><b>Procesar Prestamo&nbsp;&nbsp;</b><i class="glyphicon glyphicon-saved"></i></button>
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
<script src="librerias/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="librerias/jquery-ui/jquery-ui.min.css">
<link rel="stylesheet" type="text/css" href="plugins/chosen_v1.4.0/chosen.css">
<script src="plugins/chosen_v1.4.0/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript" charset="utf-8" >
  var ajax_user = function(){};
  var isJson    = function(){};
  $(document).on('ready',function(){
      $(".only_num").keypress(function(evt){
        evt = (evt) ? evt : event
        var key = (evt.which) ? evt.which : evt.keyCode;
        if (key > 47 && key < 58 || key == 8 || key == 9) { return true;}
        else {return false;}
      });
      isJson = function (str) {
          try {
              JSON.parse(str);
          } catch (e) {
              return false;
          }
          return true;
      }
      $('#menu-item li.active').removeClass('active');
        $('#liPrestamos').addClass('active');
        // title page
      $('title').html('..:: Registro de Prestamo ::..&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
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
            dateFormat: 'dd-mm-yy',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            minDate: new Date(),
            maxDate: '+1W',
            buttonImage: "images/calendar.png",
            yearSuffix: ''
      };
      $.datepicker.setDefaults($.datepicker.regional['es']);
      $('#txt_fecha_devolucion').datepicker();
      $("#txt_id_user").chosen({no_results_text:'Sin Resultados',width:"100%"});
      ajax_user = function(id_usuario) {
        $('#load-l').show();
        $('#text-resp').hide();
        $('#btn-prestamo').hide();
        $.post('modulos/response_ajax.php',{'id_usuario':id_usuario,'function':'status_user_prestamo','recurso':'tesis','id_recurso':$('#codigo_tesis').val()},function(resp){
            $('#load-l').hide();
            resp = JSON.parse(resp);
            $('#text-resp').fadeIn();
            $('#alert').html(resp.mensj);
            $('#alert').attr('class','alert '+resp.type);
            if (resp.type == 'alert-success') {
                 $('#btn-prestamo').show();
                 $('#send').val(1);
            } else {
              $('#send').val('');
            }
        });
      }
      $('#txt_id_user').on('change',function(){
          ($(this).val() != '')?(ajax_user($(this).val())):alertify.error('<b>Cedula es Requerido</b>')
      });
      var band = true;
      $('#btn-prestar').on('click',function(e){
          e.preventDefault();
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
              $('#frm-prestar').submit();
          } 
      });
  });
</script>