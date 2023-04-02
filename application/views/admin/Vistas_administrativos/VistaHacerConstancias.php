<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Insert title here</title>
</head>
<body>

<div class="content-wrapper colorfondo">
        <section class="content">
            <div class="box box-solid colorfondo">
                <div class="box-body">

<div class="container">
  <div class="row">
    <div class="col-md-12 mt-5">
      <h1 class="text-center">
      <strong><font color="#D34787">Genera constancia</font></strong>
      </h1>
      <hr style="background-color: black; color: black; height: 1px;">
    </div>
  </div>

  <div class="row">
  <div class="col-10 col-sm-12">
                  <div class="row">
                    <div class="col-4 col-sm-8">
                      <label for="">Seleccione grado y grupo: </label>
                    <select background-color="red" id="combo_constancias" class="form-control"><option value="" selected>Seleccione una opción</option></select>
                    </div>
                  </div>
    </div>
  </div>
                  <br>
  <br>
  <div class="row">
    <div class="col-md-12">
<hr> <!-- Le da una linea sombreada para ver la divicion -->



  <!-- Modal Agregar promedio y fecha en letra pa constancia estudiante -->
  <div class="modal fade" id="modalConstancia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary text-center">
          <strong class="modal-title" id="exampleModalLabel">Capturar promedio y fecha en letra para constancia de alumno</strong>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
              <input type="hidden" id="numero_control_constancia" name="numero_control_constancia">
				      <input type="hidden" id="detalle_constancia" name="detalle_constancia">

            <div class="panel panel-default">
              <div class="panel-body">

	 	<form id="datesLetraConstancia">
            <!--div class="form-group">
            <label for="">Promedio del Alumno:</label>
            <input type="text" class="form-control" id="promedioNumeroAlumno" readonly>
          </div-->

              <div class="form-group">
              <label for="">Capturar promedio: *</label>
              <input type="text" class="form-control" id="promedio" placeholder="Ejemplo: 9.5">
            </div>
            <div class="form-group">
              <label for="">Capturar fecha en letra: *</label>
              <input type="text" class="form-control" id="fecha_letra" placeholder="Ejemplo: treinta y un días del mes de enero de dos mil veintitrés">
            </div>

              </div>
            </div>
		  </form>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Regresar</button>
          <!-- Insert Button -->
          <button type="button" class="btn btn-primary" id="capturaPromedioConstancia">Agregar Datos</button>
        </div>
      </div>
    </div>
  </div>




  <div class="row my-4">
    <div class="col-md-12 mx-auto">
      <table id="tbl_reportes_constancias" class="table table-striped table-bordered dt-responsive nowrap table-hover table-condensed" cellspacing="0">
        <thead class="text-center bg-primary">
          <tr>
            <th class="text-center" width="7%">Numero de control</th>
            <th>Nombre Alumno</th>
            <th class="text-center" width="7%">Genera constancia</th>
            <th class="text-center" width="7%">Captura promedio</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>


              </div>
          </div>
      </section>
</div>

</body>
</html>
