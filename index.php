<?php session_start(); ?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="images/favicon.png" />
  <title>..:: Inicio - BibloWeb v1.0 ::..&nbsp;&nbsp;&nbsp;</title>
  <link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/dashboard.css" />
  <link rel="stylesheet" type="text/css" href="plugins/alertifyjs/css/themes/default.min.css" />
  <link rel="stylesheet" type="text/css" href="plugins/alertifyjs/css/alertify.min.css" />
  <link rel="stylesheet" type="text/css" href="css/estilos.css" />
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
 </head>

<body>
<script type="text/javascript" src="librerias/bootstrap/js/jquery.js"></script>
<script type="text/javascript" src="librerias/bootstrap/js/bootstrap.js"></script>
<script type="text/javascript" src="plugins/alertifyjs/alertify.min.js"></script>
<script type="text/javascript" src="js/index.js"></script>
<script>
  $(document).ready(function() {
    $("#liHome").addClass('active');
    $('.actions a, .btn-group a').tooltip();
  });
</script>
<div class="container-fluid">
  <img src="images/gobiernobolivariano.png">
  <span style="float:right;">
    <img src="images/icon_nucleo.png">
    <img src="images/icon_univ.png">
  </span>
</div>
<div class="container-fluid visible-lg">
  <div class="navbar navbar-inverse">
    <div class="container-fluid div_cust">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">BilioWeb v1.0</a>
        
      </div>
      <ul class="nav navbar-nav navbar-right">
          <li><a><strong><?php echo (isset($_SESSION['username']))?'Bienvenido: '.$_SESSION['user_nombre'].' '.$_SESSION['user_apellido']:'' ?></strong></a></li>
        </ul>
    </div>
  </div>
</div>
<div class="container-fluid">
  <div class="row">
    <?php if (isset($_SESSION['session'])): ?>
    <div class="col-md-2">
      <div class="sidebar-nav">
        <div class="div_cust navbar" role="navigation">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <span class="visible-xs navbar-brand">BibloWeb </span>
          </div>
          <div class="navbar-collapse collapse sidebar-navbar-collapse">
            <ul class="nav navbar-nav" id="menu-item">
              <li id="liHome"><a href="index.php"><i class="glyphicon glyphicon-home"></i>&nbsp;&nbsp;Inicio</a></li>
              <li id="liRecursos">
                <a data-toggle="collapse" data-parent="#accordion" href="#ulRecursos"><i class="glyphicon glyphicon-book"></i>&nbsp;&nbsp;Recursos <b class="caret"></b></a>
                <ul id="ulRecursos" class="ul-collapse nav nav-stacked sub-nav collapse in">
                  <li><a href="#"><i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Libros</a></li>
                  <li><a href="#"><i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Tesis</abbr></a></li>
                  <li><a href="#"><i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;Material</abbr></a></li>
                </ul>
              </li>           
              <li><a href="index.php?page=login&exit"><i class="glyphicon glyphicon-off"></i>&nbsp;&nbsp;Cerrar Sesión</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
    <?php endif; ?>
    <?php 
      if (isset($_SESSION['session'])):
        if (isset($_GET['page']) && !isset($_GET['exit']) && !stristr($_GET['page'], 'login')):
          if (file_exists('modulos/'.$_GET['page'].'.php')):
            include_once('modulos/'.$_GET['page'].'.php');
          else:
            echo 'no existe';
          endif;
        else:
          if (isset($_GET['page']) && isset($_GET['exit']) && stristr($_GET['page'], 'login')):
            include_once('modulos/login.php');
          else:
            include_once('modulos/inicio.php');
          endif;
        endif;
      else:
        include_once('modulos/login.php');
      endif;
    ?>
  </div>
</div>
</div>
</body>
</html>
