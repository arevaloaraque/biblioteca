<div class="container-fluid">
  <div class="row">
    <div class="col-sm-offset-3 col-sm-6 col-sm-offset-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title"><b>Login de usuario <i class="glyphicon glyphicon-user" style="float:right;"></i></b></h3>
            </div>
            <div class="panel-body">
              <div class="col-md-4">
                <img src="images/user-icon.png" class="img-responsive img-circle" style="border:1px solid #444;">
              </div>
              <div class="col-md-7">
                <form class="form-horizontal" method="POST" action="index.php?page=login">
                  <div class="form-group">
                    <br/>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-addon">Cedula&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                      <input type="text" class="form-control" id="txt_cedula" placeholder="Ej: 12345678">
                    </div>
                    <br/>
                    <div class="input-group">
                      <div class="input-group-addon">Contrase&ntilde;a</div>
                      <input type="text" class="form-control" id="txt_password" placeholder="Ej: 12345678">
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary" style="float:right;"><i class="glyphicon glyphicon-ok"></i>&nbsp;Entrar</button>
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
<?php 
  if (isset($_POST)):
    echo 'Existe $_POST';
  else:
    echo 'NO Existe $_POST';
  endif;
?>
<script type="text/javascript">
  $(document).on('ready',function(){
      
  });
</script>