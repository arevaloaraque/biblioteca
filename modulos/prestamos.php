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
                  div.
              </div>
              <div class="tab-pane fade" id="tab_b">
                  Tesis
              </div>
              <div class="tab-pane fade" id="tab_c">
                  Materiales
              </div>
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
    $("menu-item .active").removeClass('active');
    $('#liPrestamos').addClass('active');
  });
</script>