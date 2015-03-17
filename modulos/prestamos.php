<div class="col-sm-9 col-md-10">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title"><b>Prestamos <i class="glyphicon glyphicon-folder-open" style="float:right;"></i></b></h3>
    </div>
    <div class="panel-body">
      <div class="col-md-12">
            

          <ul class="nav nav-tabs" id="navegacion-busqueda">
            <li class="active" id="inx"><a class="text-danger" href="#tab_a" data-toggle="tab">Libros</a></li>
            <li><a href="#tab_b" class="text-danger" data-toggle="tab">Tesis</a></li>
            <li><a href="#tab_c" class="text-danger" data-toggle="tab">Materiales</a></li>
          </ul>
          <div class="tab-content">
              <div class="tab-pane fade in active" id="tab_a">
                <div class="col-lg-12">
                  <br/>
                  <form class="form-inline" id="form-l">
                    <div class="form-group">
                      <input type="hidden" name="tipo_recurso" value="libro" />
                      <input type="hidden" name="function" value="consultar_recurso" />
                      <input type="text" class="form-control codigo" size="10" id="txt_codigol" name="txt_codigol" placeholder="C&oacute;digo Libro" />
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control descripcion" size="40" id="txt_descripcionl" name="txt_descripcionl" placeholder="Descripci&oacute;n Libro" />
                    </div>
                    <button type="submit" id="btnl" class="btn btn-primary btn-form">Buscar&nbsp;Libro&nbsp;&nbsp;<i class="glyphicon glyphicon-search"></i></button>
                    <img src="images/cargando.gif" id="load-l" class="img-circle load-l" />
                  </form>
                </div>
              </div> <!-- Libros -->
              <div class="tab-pane fade" id="tab_b">
                <div class="col-lg-12">
                  <br/>
                  <form class="form-inline" id="form-t">
                    <div class="form-group">
                      <input type="hidden" name="tipo_recurso" value="tesis" />
                      <input type="hidden" name="function" value="consultar_recurso" />
                      <input type="text" class="form-control codigo" size="10" id="txt_codigot" name="txt_codigot" placeholder="C&oacute;digo Tesis" />
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control descripcion" size="40" id="txt_descripciont" name="txt_descripciont" placeholder="Descripci&oacute;n Tesis" />
                    </div>
                    <button type="submit" id="btnt" class="btn btn-primary btn-form">Buscar&nbsp;Tesis&nbsp;&nbsp;<i class="glyphicon glyphicon-search"></i></button>
                    <img src="images/cargando.gif" id="load-t" class="img-circle load-t" />
                  </form>
                </div>
              </div> <!-- Tesis -->
              <div class="tab-pane fade" id="tab_c">
                  <div class="col-lg-12">
                  <br/>
                  <form class="form-inline" id="form-m">
                    <div class="form-group">
                      <input type="hidden" name="tipo_recurso" value="material" />
                      <input type="hidden" name="function" value="consultar_recurso" />
                      <input type="text" class="form-control codigo" size="10" id="txt_codigom" name="txt_codigom" placeholder="C&oacute;digo Material" />
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control descripcion" size="40" id="txt_descripcionm" name="txt_descripcionm" placeholder="Descripci&oacute;n Material" />
                    </div>
                    <button type="submit" id="btnm" class="btn btn-primary btn-form">Buscar&nbsp;Material&nbsp;&nbsp;<i class="glyphicon glyphicon-search"></i></button>
                    <img src="images/cargando.gif" id="load-m" class="img-circle load-m" />
                  </form>
                </div>
              </div> <!-- Materiales -->
          </div><!-- tab content -->

          <p>&nbsp;</p>
          <!-- Resultado de la busqueda -->
          <div id="table-result" class="table-responsive">
            <table class='table table-bordered table-striped table-hover datatable dataTable' id="datatable" style='border-radius:5px;'>
              <thead id="head-result">
              </thead>
              <tbody id='content-result'>
              </tbody>
            </table>
          </div>

      </div>
    </div>
    <div class="panel-footer text-center">
      <div class="btn-group">
          <p><i class="text-muted">BibloWeb v1.0</i></p>
      </div>
    </div>
  </div>
</div>
<link rel="stylesheet" type="text/css" href="plugins/dataTables/css/datatables.css">
<script src="plugins/dataTables/js/jquery.dataTables.js" type="text/javascript"></script>
<script src="plugins/dataTables/js/datatables.js" type="text/javascript"></script>
<script>
  var create_datatable = function() {};
  var control_datatable = 0;
  $(document).ready(function() {
    $('#menu-item li.active').removeClass('active');
    $('#liPrestamos').addClass('active');
    // click sobre pestañas
    $('#navegacion-busqueda li').click(function(){
        if ($(this).not('.active')) {
          $('#head-result').html('');
          $('#content-result').html('');
          $('#table-result').fadeOut();
          $('.descripcion').val('');
          $('.codigo').val('');
        }
    });
    create_datatable = function() {
        // Configuracion datatable
        $('#datatable').dataTable({
          "AaSorting": [[0, "asc"]],
          "sPaginationType": "bs_normal",
          ajax: "data.json"
        }); 
        $('.datatable').each(function(){
          var datatable = $(this);
          // SEARCH - Add the placeholder for Search and Turn this into in-line form control
          var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
          search_input.attr({'placeholder':'Filtrar Resultado','id':'btn_search_table'});
          search_input.addClass('form-control input-sm');
          // LENGTH - Inline-Form control
          var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
          length_sel.addClass('form-control input-sm');
        });
        $('#btn_search_table').attr('title','Filtrar resultado');
        $('#btn_search_table').tooltip();
    }

    // validacion de formulario 
    $('.btn-form').click(function(e){
      e.preventDefault();
      var prefx = $(this).attr('id').substring(3,4);
      if ($('#txt_codigo'+prefx).val() == '' && $('#txt_descripcion'+prefx).val() == '') { alertify.error('<b>Debe completar al menos un campo</b>'); $('#txt_codigo'+prefx).focus(); }
      else {
        $.ajax({
          beforeSend: function(){
            $('#head-result').html('');
            $('#content-result').html('');
            $('#table-result').fadeOut();
            $('#load-'+prefx).fadeIn();
          },
          type:     'POST',
          url:      'modulos/response_ajax.php',
          data:     $('#form-'+prefx).serialize(),
          dataType: 'json',
          success: function (resp) {
            $('#load-'+prefx).fadeOut();
            $('#txt_codigo'+prefx).val(''); $('#txt_descripcion'+prefx).val(''); 
            if (resp == 0) { 
              alertify.error('<b>No se encontraron datos</b>');
            } else if(resp == 1){
              alertify.error('<b>Acceso denegado</b>');
            } else if(typeof(resp) == "object") {
                  if (prefx == 'l') {
                      $('#head-result').append('<tr class="danger"><th class=\'col-lg-1 text-center\'>C&oacute;digo</th><th class=\'col-lg-2 text-center\'>Autor</th><th class=\'col-lg-2 text-center\'>Editorial</th><th class=\'col-lg-2 text-center\'>Materia</th><th class=\'col-lg-3\'>Descripci&oacute;n</th><th class=\'col-lg-1 text-center\'>Fecha</th><th class=\'text-center col-lg-1\'>Solicitud(s)</th></tr>');
                  } else if (prefx == 't') {
                      $('#head-result').append('<tr class="danger"><th class=\'col-lg-1 text-center\'>C&oacute;digo</th><th class=\'col-lg-2 text-center\'>Materia</th><th class=\'col-lg-2 text-center\'>Autor</th><th class=\'col-lg-2\'>Titulo</th><th class=\'col-lg-1 text-center\'>Fecha Publicaci&oacute;n</th><th class=\'col-lg-1 text-center\'>Mensi&oacute;n</th><th class=\'text-center col-lg-1\'>Solicitud(s)</th></tr>');
                  } else if (prefx == 'm') {}
              $.each(resp,function(index,array){
                  if (prefx == 'l') {
                      $('#content-result').append('<tr><td class=\'text-center\'>'+ array['id_libro'] +'</td><td class=\'text-center\'>'+ array['id_autor'].toUpperCase() +'</td><td class=\'text-center\'>'+ array['id_editorial'].toUpperCase() +'</td><td class=\'text-center\'>'+ array['id_materia'].toUpperCase() +'</td><td>'+ array['descripcion'].toUpperCase() +'</td><td class=\'text-center\'>'+ array['fecha_publicacion'] +'</td><td class=\'text-center\'><button class=\'btn btn-danger\'>Prestar&nbsp;&nbsp;<i class=\'glyphicon glyphicon-transfer\'></i></button></td></tr>');
                  } else if (prefx == 't') {
                      $('#content-result').append('<tr><td class=\'text-center\'>'+ array['id_tesis'] +'</td><td class=\'text-center\'>'+ array['id_materia'].toUpperCase() +'</td><td class=\'text-center\'>'+ array['id_autor_tesis'].toUpperCase() +'</td><td>'+ array['titulo'].toUpperCase() +'</td><td class=\'text-center\'>'+ array['fecha_publicacion'] +'</td><td class=\'text-center\'>'+ array['mension'].toUpperCase() +'</td><td class=\'text-center\'><button class=\'btn btn-danger\'>Prestar&nbsp;&nbsp;<i class=\'glyphicon glyphicon-transfer\'></i></button></td></tr>');
                  } else if (prefx == 'm') {}
              });
              $('#table-result').fadeIn();
              if (control_datatable == 0) {create_datatable(); control_datatable++;}
            }
          }
        });
      }
    });
  });
</script>