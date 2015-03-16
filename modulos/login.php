<?php 
    $title = "Login";
    // si envio datos via POST/Form
    if (isset($_POST['txt_cedula'])):
      
      $cedula = $_POST['txt_cedula'];
      $passwd = md5($_POST['txt_password']);

      if ($cedula == '' || $passwd == ''):
        echo '<script>alertify.error("<b>Ambos campos son obligatorios</b>")</script>';
      else:
        include_once('modulos/modelo.php');
        $user         = $consultasbd->select($table='tbl_operador',$campos='*',$where='WHERE cedula=\''.$cedula.'\' AND password=\''.$passwd.'\'');
        if ($consultasbd->num_rows($user)):
          $datos = $consultasbd->fetch_array($user);

          // consulta privilegios
          $sql_priv = $consultasbd->select($table='tbl_privilegios',$campos='*',$where='WHERE id_privilegio=\''.$datos['id_privilegio'].'\'');
          $res_priv = $consultasbd->fetch_array($sql_priv);

          $_SESSION['id_operador']    = $datos['id_operador'];
          $_SESSION['privilegio']     = $res_priv['privilegio'];
          $_SESSION['nombre']         = $datos['nombre'];
          $_SESSION['apellido']       = $datos['apellido'];
          $_SESSION['cedula']         = $datos['cedula'];
          $_SESSION['session']        = true;

          header('location: index.php');

        else:
          echo '<script>alertify.error("<b>Usuario/Contrase&ntilde;a incorrecto(s)</b>");</script>';
        endif;
      endif;
    endif;

    if(isset($_GET['exit']) && isset($_SESSION['session'])):
      session_unset();
      session_destroy();
      echo '<script>location.href = "index.php?page=login";</script>';
    endif;
?>
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-offset-3 col-sm-6 col-sm-offset-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title"><b>Login de usuario <i class="glyphicon glyphicon-user" style="float:right;"></i></b></h3>
            </div>
            <div class="panel-body">
              <div class="col-md-4">
                <img src="images/user-icon-II.png" class="img-responsive img-circle" style="border:1px solid #444;">
              </div>
              <div class="col-md-7">
                <form class="form-horizontal" method="POST" action="index.php?page=login" id="frm-login">
                  <div class="form-group">
                    <br/>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-addon">Cedula&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                      <input type="text" class="form-control requerido" id="txt_cedula" name="txt_cedula" maxlength="10" placeholder="Ej: 12345678" title="Cedula" />
                    </div>
                    <br/>
                    <div class="input-group">
                      <div class="input-group-addon">Contrase&ntilde;a</div>
                      <input type="password" class="form-control requerido" id="txt_password" name="txt_password" maxlength="30" placeholder="Ej: miclavedeacceso" title="Contrase&ntilde;a" />
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" id="btn-submit" class="btn btn-primary" style="float:right;"><i class="glyphicon glyphicon-ok"></i>&nbsp;Entrar</button>
                    <button type="reset" class="btn btn-danger" style="float:right;"><i class="glyphicon glyphicon-remove"></i>&nbsp;Limpiar</button>
                  </div>
                </form>
              </div>
            </div>
            <div class="panel-footer text-center">
              <div class="btn-group">
                  <p><i class="text-muted">BibloWeb v1.0</i></p>
              </div>
            </div>
        </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).on('ready',function(){
      // title page
      $('title').html('..:: Login de Usuario ::..&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
      valuesTitle();
      // permitir solo numeros en campo de cedula
      $('#txt_cedula').keypress(function validar2(evt){
        evt = (evt) ? evt : event
        var key = (evt.which) ? evt.which : evt.keyCode;
        if (key > 47 && key < 58 || key == 8  || key == 39  || key == 9) {return true;}
        else {return false;}
      });
      $('#btn-submit').on('click',function(e){
        e.preventDefault();
        var validaForm = true;
        $.each($('.requerido'),function(index,obj){
            if ($(this).val() == '') { alertify.error('<b>'+$(this).attr('title')+' es requerido(a)</b>'); validaForm = false; $(this).focus(); return false; }
        });
        if (validaForm) { $('#frm-login').submit(); }
      });
  });
</script>