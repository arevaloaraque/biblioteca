<div class="col-sm-9 col-md-10">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title"><b>Prestamos <i class="glyphicon glyphicon-folder-open" style="float:right;"></i></b></h3>
    </div>
    <div class="panel-body">
      <div class="col-md-12">
            

          <ul class="nav nav-tabs">
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
                      <input type="hidden" name="tipo_prestamo" value="libro" />
                      <input type="hidden" name="function" value="consultar_recurso" />
                      <input type="text" class="form-control" size="10" id="txt_codigol" name="txt_codigol" placeholder="C&oacute;digo Libro" />
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" size="40" id="txt_descripcionl" name="txt_descripcionl" placeholder="Descripci&oacute;n Libro" />
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
                      <input type="hidden" name="tipo_prestamo" value="tesis" />
                      <input type="hidden" name="function" value="consultar_recurso" />
                      <input type="text" class="form-control" size="10" id="txt_codigot" name="txt_codigot" placeholder="C&oacute;digo Tesis" />
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" size="40" id="txt_descripciont" name="txt_descripciont" placeholder="Descripci&oacute;n Tesis" />
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
                      <input type="hidden" name="tipo_prestamo" value="material" />
                      <input type="hidden" name="function" value="consultar_recurso" />
                      <input type="text" class="form-control" size="10" id="txt_codigom" name="txt_codigom" placeholder="C&oacute;digo Material" />
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" size="40" id="txt_descripcionm" name="txt_descripcionm" placeholder="Descripci&oacute;n Material" />
                    </div>
                    <button type="submit" id="btnm" class="btn btn-primary btn-form">Buscar&nbsp;Material&nbsp;&nbsp;<i class="glyphicon glyphicon-search"></i></button>
                    <img src="images/cargando.gif" id="load-m" class="img-circle load-m" />
                  </form>
                </div>
              </div> <!-- Materiales -->
          </div><!-- tab content -->


      </div>
    </div>
    <div class="panel-footer text-center">
      <div class="btn-group">
          <p><i class="text-muted">BibloWeb v1.0</i></p>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function() {
    $('#menu-item li.active').removeClass('active');
    $('#liPrestamos').addClass('active');
    // validacion de formulario 
    $('.btn-form').click(function(e){
      e.preventDefault();
      var prefx = $(this).attr('id').substring(3,4);
      if ($('#txt_codigo'+prefx).val() == '' && $('#txt_descripcion'+prefx).val() == '') { alertify.error('<b>Debe completar al menos un campo</b>'); $('#txt_codigo'+prefx).focus(); }
      else {
        $.ajax({
          beforeSend: function(){
            $('#load-'+prefx).show(function(){ $(this).fadeIn('slow'); });
          },
          type:     'POST',
          url:      'modulos/response_ajax.php',
          data:     $('#form-'+prefx).serialize(),
          dataType: 'json',
          success: function (resp) {
            
          }
        });
      }
    });
  });
</script>