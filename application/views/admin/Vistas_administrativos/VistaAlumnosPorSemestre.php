<div class="content-wrapper colorfondo"> <!-- STAR ALL CONTENT -->
             <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                <div class="box box-solid colorfondo">
                    <div class="box-body">
<div class="container">
  <div class="row">
    <div class="col-md-12 mt-5">
      <h1 class="text-center">
      <strong><font color="#D34787">Datos de la escuela</font></strong>
      </h1>
      <hr style="background-color: black; color: black; height: 1px;">
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">

<div class="row my-4">
    <div class="col-md-12 mx-auto">


      <table id="tbl_datosEscuela" class="table table-striped table-bordered dt-responsive nowrap table-hover table-condensed" cellspacing="0" style="background:white!important">
        <thead class="text-center bg-primary">
          <tr>
            <th>Nombre</th>
            <th>C.C.T.</th>
            <th>Turno</th>
            <th>Zona</th>
            <th class="text-center" width="7%">Actualizar</th>
          </tr>
        </thead>
      </table>

    </div>
  </div>


      <!-- Modal preparado para editar datos y file -->
      <div class="modal fade" id="modalEditarDatos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-primary text-center">
              <h5 class="modal-title" id="exampleModalLabel">Editar datos</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="container-fluid">
                <div class="row text-center">
                  <div class="col-md-12 my-3">
                    <div id="show_img"></div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <form id="formeditarDatos">
                    <div class="form-group">
                        <label for="">Nombre de la escuela:</label>
                        <input type="text" class="form-control" id="nombreEditar">
                    </div>

                    <div class="form-group">
                        <label for="">C.C.T.:</label>
                        <input type="text" class="form-control" id="codigoEditar">
                    </div>

                    <div class="form-group">
                        <label for="">Turno:</label>
                        <input type="text" class="form-control" id="turnoEditar">
                    </div>

                    <div class="form-group">
                        <label for="">Zona:</label>
                        <input type="text" class="form-control" id="zonaEditar">
                    </div>

                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-primary" id="update_datosEscuela">Actualizar</button>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

                    </div>
                </div>
            </section>
    </div> <!-- /END ALL CONTENT -->
