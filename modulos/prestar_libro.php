<?php 
	include_once('modulos/modelo.php');
	if (isset($_GET['id_libro'])) {
		$id_libro = $_GET['id_libro'];
		$sql_libro = $consultasbd->select($tabla='tbl_libros',$campos='*',$where=' WHERE status=true AND id_libro=\''.$id_libro.'\'');
		$datos_libro = $consultasbd->fetch_array($sql_libro);
    $user = $consultasbd->select('tbl_usuario',$campos='*');
    // validar si el libro existe
    if ($consultasbd->num_rows($sql_libro) == 0){
      echo '<script>location.href="?page=prestamos";</script>';
    }
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
	} else if (isset($_POST) && count($_POST)>0) {
    $id_libro = $_POST['codigo_libro'];
    $id_usuario = $_POST['txt_id_user'];
    var_dump($_POST);exit();
  }
?>
<div class="col-sm-9 col-md-10">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title"><b>Registro&nbsp;Prestamo&nbsp;de&nbsp;Libro<i class="glyphicon glyphicon-transfer" style="float:right;"></i></b></h3>
    </div>
    <div class="panel-body">
    	<form action="?page=prestar_libro" id="frm-prestar" method="POST" class="well" id="frm-act-oper" accept-charset="utf-8">
    		<div class="row">
    			<div class="col-lg-2">
    				<label for="txt_codigo_libro">Cod&iacute;go&nbsp;Libro&nbsp;&nbsp;<i class="glyphicon glyphicon-credit-card"></i></label>
	    			<input type="text" name="txt_codigo_libro" id="txt_codigo_libro" class="form-control required" title="Cod&iacute;go Libro" disabled="disabled" value="<?php echo $datos_libro['id_libro']; ?>" />	
            <input type="hidden" name="codigo_libro" id="codigo_libro" value="<?php echo $datos_libro['id_libro']; ?>" />
    			</div>
    		</div>
    		<br/>
	    	<div class="row">
	    		<div class="col-lg-12">
	    			<label for="txt_descripcion">Descripci&oacute;n&nbsp;Libro&nbsp;&nbsp;<i class="glyphicon glyphicon-book"></i></label>
	    			<input type="text" name="txt_descripcion" id="txt_descripcion" class="form-control required" title="Descripcion Libro" readOnly="readOnly" value="<?php echo strtoupper($datos_libro['descripcion']); ?>" />
	    		</div>
	    	</div>
        <br/>
        <div class="row">
          <div class="col-lg-2">
            <label for="txt_fecha_devolucion">Fecha&nbsp;devoluci&oacute;n&nbsp;&nbsp;<img src="images/calendar.png" /></label>
            <input type="text" name="txt_fecha_devolucion" id="txt_fecha_devolucion" min="<?php echo date('d-m-Y'); ?>" class="form-control required" title="Fecha devoluci&oacute;n" readOnly="readOnly" />
          </div>
        </div>
        <br/>
        <div class="row">
          <div class="col-lg-12">
            <label for="txt_autor">Autor&nbsp;&nbsp;<i class="glyphicon glyphicon-user"></i></label>
            <input type="text" name="txt_autor" id="txt_autor" class="form-control required" title="Autor Libro" readOnly="readOnly" value="<?php echo strtoupper($datos_libro['id_autor']); ?>" />
          </div>
        </div>
        <br/>
        <div class="row">
          <div class="col-lg-5">
            <label for="txt_id_user">Usuario&nbsp;Solicitante&nbsp;&nbsp;<i class="glyphicon glyphicon-user"></i></label>
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
        <div class="row" id="btn-prestamo">
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
        $.post('modulos/response_ajax.php',{'id_usuario':id_usuario,'function':'status_user_prestamo','recurso':'libro','id_recurso':$('#codigo_libro').val()},function(resp){
            $('#load-l').hide();
            $('#btn-prestamo').show();
            resp = JSON.parse(resp);
            $('#text-resp').fadeIn();
            $('#alert').html(resp.mensj);
            $('#alert').addClass(resp.type);
            if (resp.type == 'alert-success') {
                 
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