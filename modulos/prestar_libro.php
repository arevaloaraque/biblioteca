<?php 
	include_once('modulos/modelo.php');
	if (isset($_GET['id_libro'])) {
		$id_libro = $_GET['id_libro'];
		$sql_libro = $consultasbd->select($tabla='tbl_libros',$campos='*',$where=' WHERE status=true');
		$datos_libro = $consultasbd->fetch_array($sql_libro);
    $user = $consultasbd->select('tbl_usuario',$campos='*');
	}
?>
<div class="col-sm-9 col-md-10">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title"><b>Registro&nbsp;Prestamo&nbsp;de&nbsp;Libro<i class="glyphicon glyphicon-transfer" style="float:right;"></i></b></h3>
    </div>
    <div class="panel-body">
    	<form action="?page=act_operador" method="POST" class="well" id="frm-act-oper" accept-charset="utf-8">
    		<div class="row">
    			<div class="col-lg-2">
    				<label for="txt_codigo_libro">Cod&iacute;go&nbsp;Libro&nbsp;&nbsp;<i class="glyphicon glyphicon-credit-card"></i></label>
	    			<input type="text" name="txt_codigo_libro" id="txt_codigo_libro" class="form-control required" title="Cod&iacute;go Libro" disabled="disabled" value="<?php echo $datos_libro['id_libro']; ?>" />	
            <input type="hidden" name="codigo_libro" value="<?php echo $datos_libro['id_libro']; ?>" />
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
          <div class="col-lg-5">
            <label for="txt_id_user">Usuario&nbsp;Solicitante&nbsp;&nbsp;<i class="glyphicon glyphicon-user"></i></label>
            <select name="txt_id_user" id="txt_id_user" class="chosen-select form-control required" data-placeholder="Seleccione Usuario" title="Cedula de Usuario">
                <option value=""></option>
                <?php 
                  while ($user_det = $consultasbd->fetch_array($user)) {
                    echo '<option value="'.$user_det['id_usuario'].'">'.$user_det['cedula'].' - '.$user_det['nombre'].' '.$user_det['apellido'].'</option>';
                  }
                ?>
            </select>
          </div>
        </div>
        <div class="row" id="text-resp" style="display:none;">
          <div class="col-lg-5">
            <br />
            <div class="alert" role="alert" id="alert"></div>
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
      $("#txt_id_user").chosen({no_results_text:'Sin Resultados',width:"100%"});
      ajax_user = function(id_usuario) {
        $.post('modulos/response_ajax.php',{'id_usuario':id_usuario,'function':'status_user_prestamo','recurso':'libro'},function(resp){
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
  });
</script>