<div class="content-wrapper colorfondo"> <!-- STAR ALL CONTENT -->
             <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                <div class="box box-solid colorfondo">
                    <div class="box-body">
<div class="container">
  <div class="row">
    <div class="col-md-12 mt-5">
      <h3 class="text-center">
      <strong><font color="#D34787"> TITULACIÓN DE ALUMNOS </font></strong>
    </h3>
      <hr style="background-color: black; color: black; height: 1px;">
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <!-- <div class="row">
          <div class="col-md-12">

            <center>
                        <br>
                        <?php foreach($datosAlumnoProcesoFinal as $datosAlumnoProcesoFinal):?>
                          <div class="row">

                            <div class="col-sm-12">
                              <br>
                               <div class="row">
                                  <div class="col-4 col-sm-2">
                                  <label for="">No. Control:</label>
                              <input type="text" class="form-control text-center" id="noControlProcFinTitulacion" readonly value="<?php echo $datosAlumnoProcesoFinal->numero_control;?>" >
                                  </div>

                                  <div class="col-8 col-sm-8">
                                  <label for="">Carrera:</label>
                                  <input type="text" class="form-control" id="carreraProcFinTitulacion" readonly value="<?php echo $datosAlumnoProcesoFinal->carrera_descripcion;?>" >
                                  </div>

                                  <div class="col-2 col-sm-2">
                                  <label for="">Semestre:</label>
                        <input type="text" class="form-control text-center" id="semestreProcFinTitulacion" readonly value="<?php echo $datosAlumnoProcesoFinal->semestre;?>" >
                                  </div>

                                </div>

                            </div>

                          </div>
                          <?php endforeach;?>
                        <br>
            </center>

          </div>
      </div> -->


      <div class="row">
      <div class="col-10 col-sm-12">
                    <div class="row">
                        <div class="col-4 col-sm-6">
                          <label for="">Seleccione alguna carrera: </label>
                        <select background-color="red" id="combo_CarreraTesis_Profe" class="form-control">
                        <option value="" selected>Seleccione una carrera...</option>
                        </select>
                        </div>

                        <div class="col-8 col-sm-4">
                            <label for="">Seleccione alguna opción de estudio: </label>
                          <select background-color="red" id="combo_opcionesTesis_Profe" class="form-control">
                            <option value="" selected>Seleccione una opción...</option>
                          </select>
                          </div>

                    </div> <!--END OF SECOND ROW-->
      </div><!--class="col-10 col-sm-12"-->
      </div>
<hr>



<div class="modal-dialog" id="formularioRegistroOficioTitulacion">
  <div class="modal-content">
    <div class="modal-body">
      <form id="formularioAltaOficioProcFinTitulacionToProfesor">

        <div class="form-group">
          <label for="">Profesor: </label>
          <input type="text" class="form-control" id="usernameProfesor" readonly value="<?php echo $nombres;?>" >
        </div>
            <div class="form-group">
              <label for="">Agregar Comentarios: </label>
              <input type="text" class="form-control" id="comentarios" placeholder="Disponible hasta 300 caracteres...">
            </div>
            <div class="form-group">
              <label for="customFile">Adjuntar archivo: *</label>
              <input type="file" class="custom-file-input" id="archivoProcFinTitulacionToProfesor">
            </div>

      </form>
    </div>

    <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="darAltaOficioTitulacionToProfesor">Agregar</button>
    </div>

    </div>
</div>





                              <!-- Modal Agregar nueuvo registro -->
                              <!-- <div class="modal fade" id="modalDocumento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"> -->
                                <!-- <div class="modal-dialog"> -->
                                  <div class="modal-content">
                                    <!-- <div class="modal-header bg-primary text-center">
                                      <strong class="modal-title" id="exampleModalLabel">Guardar recibo de pago</strong>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div> -->
                                    <div class="modal-body">
                                          <!-- <input type="hidden" id="numero_controlVarHide" name="numero_controlVarHide">
                            				      <input type="hidden" id="id_alta_baucher_bancoVarHide" name="id_alta_baucher_bancoVarHide">
                            				      <input type="hidden" id="id_reciboVarHide" name="id_reciboVarHide">
                                          <input type="hidden" id="userAlta" name="userAlta" value="<?php echo $username;?>" > -->

                                        <div>
                                          <label> <span class="rojo">*</span>Seleccione el archivo formato PDF/WORD</label>
                                        </div>
                                        <div class="panel panel-default">
                                          <div class="panel-body">
                                    <!-- <div class="row">
                                      <form id="formularioAltaOficioProcFinTitulacion">

                                            <div class="form-group">
                                              <label for="customFile">Adjuntar archivo: *</label>
                                              <input type="file" class="custom-file-input" id="archivoProcFinTitulacion">
                                            </div>
                                      </form>
                                    </div> -->

                                          <table id="tbl_listaDocDeTitulacionToProfesores" class="table table-striped table-bordered table-hover table-condensed" cellspacing="0" style="background:white!important" width="100%">
                                            <thead class="bg-primary">
                                              <tr>
                                                <th width="10%">Usuario</th>
                                                <!-- <center><th width="15%">Nombre archivo</th></center> -->
                                                <center><th width="12%">Tipo Doc.</th></center>
                                                <center><th width="15%">Estado</th></center>
                                                <center><th width="7%">Descarga</th></center>
                                                <center><th width="7%">Eliminar</th></center>
                                                <center><th width="12%">Registro</th></center>
                                                <center><th>Comentarios</th></center>
                                              </tr>
                                            </thead>
                                          </table>
                                          </div>
                                        </div>

                                    </div>
                                    <!-- <div class="modal-footer">
                                      <button type="button" class="btn btn-primary" id="darAltaOficioTitulacion">Agregar</button>
                                    </div> -->
                                  </div>
                                <!-- </div> -->
                              <!-- </div> -->




                          </div>
                        </div>
                      </div>
                    </div> <!-- /.box-body -->
                </div> <!-- /.box -->
            </section>
    </div> <!-- /END ALL CONTENT -->
