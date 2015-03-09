<div class="col-sm-9 col-md-10">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title"><b>Perfil de usuario <i class="glyphicon glyphicon-user" style="float:right;"></i></b></h3>
    </div>
    <div class="panel-body">
      <div class="col-md-3">
        <img src="images/user-icon.png" class="img-responsive img-circle" style="border:1px solid #444;">
      </div>
      <div class="col-md-8">
        <ul class="list-group">
          <li class="list-group-item text-right"><b><i>
            <script type="text/javascript">document.write(horaActual());</script></i>&nbsp;<img src="images/calendar.png" /></b></li>
          <li class="list-group-item">
            <strong><i class="glyphicon glyphicon-user"></i>&nbsp;Operador:&nbsp;&nbsp;</strong><?php echo $_SESSION['nombre'].' '.$_SESSION['apellido']; ?></li>
          <li class="list-group-item">
            <strong><i class="glyphicon glyphicon-credit-card"></i>&nbsp;Cedula:&nbsp;&nbsp;</strong><?php echo $_SESSION['cedula']; ?></li>
          <li class="list-group-item">
            <strong><i class="glyphicon glyphicon-star"></i>&nbsp;Privilegio:&nbsp;&nbsp;</strong><?php echo $_SESSION['privilegio']; ?></li>
          <li class="list-group-item text-right">
            <button class="btn btn-primary">Cambiar contrase&ntilde;a</button></li>
        </ul>
      </div>
    </div>
    <div class="panel-footer text-center">
      <div class="btn-group">
          <p><i class="text-muted">BibloWeb v1.0</i></p>
      </div>
    </div>
  </div>
</div>