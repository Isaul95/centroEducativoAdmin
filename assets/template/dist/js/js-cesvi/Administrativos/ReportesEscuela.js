$(document).ready(function () {
    //$('#tbl_reportes_alumnos').hide();

    llenarTablaReportAlumnos();
    llenar_combo_grados_grupos();
    llenarTablaReportMaestros();
    llenar_combo_grados_maestros();
    llenar_combo_grados_constancias();
    llenarTablaReportConstancias();

    $("#combo_grado_alumno").change(function () {
        //$('#tbl_reportes_alumnos').show(); // mostrar la tabla
        $("#tbl_reportes_alumnos").DataTable().destroy();
        llenarTablaReportAlumnos($("#combo_grado_alumno").val());
    });

    /*$("#combo_grado_maestro").change(function () {
        $("#tbl_reportes_maestros").DataTable().destroy();
        llenarTablaReportMaestros($("#combo_grado_maestro").val());
    });*/

    $("#combo_constancias").change(function () {
        $("#tbl_reportes_constancias").DataTable().destroy();
        llenarTablaReportConstancias($("#combo_constancias").val());
    });

}); // FIN DE LA FUNCION PRINCIPAL


function llenar_combo_grados_grupos() {
    $.ajax({
        type: "get",
        url: base_url + 'Administrativos/Grados/consultarGrados',
        dataType: "json",
        success: function (data) {
            console.log(data);
            $.each(data, function (key, registro) {
                $("#combo_grado_alumno").append('<option value=' + registro.id_grado_grupo + '>' + registro.nombre + ' - ' + registro.descripcion + '</option>');
            });
        },
    });
}

function llenar_combo_grados_maestros() {
    $.ajax({
        type: "get",
        url: base_url + 'Administrativos/Grados/consultarGrados',
        dataType: "json",
        success: function (data) {
            console.log(data);
            $.each(data, function (key, registro) {
                $("#combo_grado_maestro").append('<option value=' + registro.id_grado_grupo + '>' + registro.nombre + ' - ' + registro.descripcion + '</option>');
            });
        },
    });
}


function llenar_combo_grados_constancias() {
    $.ajax({
        type: "get",
        url: base_url + 'Administrativos/Grados/consultarGrados',
        dataType: "json",
        success: function (data) {
            console.log(data);
            $.each(data, function (key, registro) {
                $("#combo_constancias").append('<option value=' + registro.id_grado_grupo + '>' + registro.nombre + ' - ' + registro.descripcion + '</option>');
            });
        },
    });
}



/* -------------------------------------------------------------------------- */
/*                                llenar tabla alumnos               */
/* -------------------------------------------------------------------------- */
function llenarTablaReportAlumnos(grado) {

    var fd = new FormData();
    fd.append("carrera", grado);

    $.ajax({
        type: "post",
        url: base_url + 'Administrativos/ReportesAlumnos/contador',
        data: fd,
        processData: false,
        contentType: false,
        dataType: "json",
        enctype: 'multpart/form-data',

        success: function (response) {
            $("#tbl_reportes_alumnos").DataTable({
                data: response,
                responsive: true,
                columns: [{
                    data: "conteo",
                    visible: false
                },
                {
                    //data: "hombres",
                    className: "text-center",
                    render: function (data, type, row, meta) {
                        var grupo = `${row.id_grado_grupo}`;
                        var hombres = `${row.hombres}`;
                          var a;
                            if(grupo != 'null'){
                                a = '<div class="p-3 mb-2 text-white">'+'Total: '+hombres+'</div>';
                            }else{
                                a = '';
                            }
                        return a;
                    },
                },
                {
                    //data: "mujeres",
                    className: "text-center",
                    render: function (data, type, row, meta) {
                        var grupo = `${row.id_grado_grupo}`;
                        var mujeres = `${row.mujeres}`;
                          var a;
                            if(grupo != 'null'){
                                a = '<div class="p-3 mb-2 text-white">'+'Total: '+mujeres+'</div>';
                            }else{
                                a = '';
                            }
                        return a;
                    },
                },
                {
                    className: "text-center",
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row, meta) {
                        var count = `${row.conteo}`;
                          var a;
                            if(count != 0){
                               var a = `<a title="Alumnos" href="ReportesAlumnos/reportAlumnos/${row.id_grado_grupo}" target="_blank"><i class="far fa-file-excel fa-2x text-success"></i></a>`;
                            }else{
                                a = 'Sin información para generar reporte';
                            }
                        return a;
                    },
                },
                {
                    className: "text-center",
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row, meta) {
                        var count = `${row.conteo}`;
                          var a;
                            if(count != 0){
                            var a = `<a title="Directorio Alumnos" href="ReportesAlumnos/reportDirectorioAlumnos/${row.id_grado_grupo}" target="_blank"><i class="far fa-file-excel fa-2x text-success"></i></a>`;
                          }else{
                            a = 'Sin información para generar reporte';
                        }
                        return a;
                    },
                },
                {
                    className: "text-center",
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row, meta) {
                        var count = `${row.conteo}`;
                          var a;
                        if(count != 0){
                             var a = `<a title="Lista Alumnos" href="ReportesAlumnos/reportListAlumnos/${row.id_grado_grupo}" target="_blank"><i class="far fa-file-excel fa-2x text-success"></i></a>`;
                          }else{
                            a = 'Sin información para generar reporte';
                        }
                        return a;
                    },
                },
                ],
                "language": language_espaniol,
                "paging" : false,
                "searching" : false,
                "info" : false,
            });
        },
    });
}



/* -------------------------------------------------------------------------- */
/*                                llenar tabla maestros               */
/* -------------------------------------------------------------------------- */
function llenarTablaReportMaestros() {

    //var fd = new FormData();
    //fd.append("grado", grado);

    $.ajax({
        type: "post",
        url: base_url + 'Administrativos/ReportesMaestros/contadorMaestros',
        //data: fd,
        processData: false,
        contentType: false,
        dataType: "json",
        enctype: 'multpart/form-data',

        success: function (response) {
            $("#tbl_reportes_maestros").DataTable({
                data: response,
                responsive: true,
                columns: [{
                    data: "conmaestro",
                    visible: false
                },
                {
                    className: "text-center",
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row, meta) {
                        var count = `${row.conmaestro}`;
                          var a;
                            if(count != 0){
                               var a = `<a title="Maestros" href="ReportesMaestros/reportMaestros/${row.id_grado_grupo}" target="_blank"><i class="far fa-file-excel fa-2x text-success"></i></a>`;
                            }else{
                                a = 'Sin información para generar reporte';
                            }
                        return a;
                    },
                },
                {
                    className: "text-center",
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row, meta) {
                        var count = `${row.conmaestro}`;
                          var a;
                            if(count != 0){
                            var a = `<a title="Directorio Maestros" href="ReportesMaestros/reportDirectorioMaestros/${row.id_grado_grupo}" target="_blank"><i class="far fa-file-excel fa-2x text-success"></i></a>`;
                          }else{
                            a = 'Sin información para generar reporte';
                        }
                        return a;
                    },
                },
                ],
                "language": language_espaniol,
                "paging" : false,
                "searching" : false,
                "info" : false,
            });
        },
    });
}





/* -------------------------------------------------------------------------- */
/*                         llenar tabla constancias de alumnos               */
/* -------------------------------------------------------------------------- */
function llenarTablaReportConstancias(grado) {

    var fd = new FormData();
    fd.append("carrera", grado);

    $.ajax({
        type: "post",
        url: base_url + 'Administrativos/Constancias/obtenerAlumnos',
        data: fd,
        processData: false,
        contentType: false,
        dataType: "json",
        enctype: 'multpart/form-data',

        success: function (response) {
            $("#tbl_reportes_constancias").DataTable({
                data: response,
                responsive: true,
                columns: [
                {
                    data: "numero_control",
                    //visible: false
                },
                {
                    data: "alumno",
                },
                {
                    className: "text-center",
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row, meta) {
                        var promedio = `${row.promedio_alumno}`;
                        var fecha_letra = `${row.fecha_letra}`;
                          var a;
                            if((promedio != 0 || promedio != 'null') && fecha_letra != 'null'){
                               var a = `<a title="Constancia PDF" href="Constancias/generaConstanciaFPDFIsa/${row.id_detalle}" target="_blank"><i class="far fa-file-pdf fa-2x"></i></a>`;
                            }else{
                                a = 'Debere capturar promedio y fecha';
                            }
                        return a;
                    },
                },
                {
                    orderable: false,
                    searchable: false,
                    className: "text-center",
                    render: function (data, type, row, meta) {
                      var a = `<a title="Agregar promedio del alumno" onclick=modalCapturaPromedio('${row.numero_control}','${row.id_detalle}')><i class="fas fa-edit iconbig azul fa-2x"></i></a>`;
                      return a;
                    },
                },
                ],
                "language": language_espaniol,
            });
        },
    });
}



function modalCapturaPromedio(numero_control, detalle){
    $("#modalConstancia").modal("show");
    $("#numero_control_constancia").val(numero_control);
    $("#detalle_constancia").val(detalle);
}



$(document).on("click", "#capturaPromedioConstancia", function(e){
    e.preventDefault();
    debugger;

    var date = new Date();
    var dia = String(date.getDate()).padStart(2, '0');
    var anio = String(date.getFullYear());
    var mesActual = new Intl.DateTimeFormat('es-ES', { month: 'long'}).format(new Date());
    var fecha = dia+' de '+mesActual+' de '+anio;
    console.log(fecha)

        var datos = {
                id_detalle: $("#detalle_constancia").val(),
                promedio_alumno: $("#promedio").val(),
                fecha_letra : $("#fecha_letra").val(),
                fecha_constancia : fecha,
              }

            if (datos.promedio == "" || datos.fecha_letra == "" ) {
                alert("El promedio y la fecha son obligatorios");
            }else{
                $.ajax({
                url: base_url+'Administrativos/Constancias/capturaPromedioConstanciaAlumno',
                type: "post",
                dataType: "json",
                data : (datos),
                success: function(data){
                if (data.responce == "success") {
                    toastr["success"](data.message);
                    $("#modalConstancia").modal("hide");
                    llenarTablaReportConstancias($("#combo_constancias").val());
                    $("#tbl_reportes_constancias").DataTable().destroy();
                }else{
                    toastr["error"](data.message);
                }
                        }
                    });
                $("#datesLetraConstancia")[0].reset();  // VACIA MODAL DESPUES DE INSERT
            }
});


function obtenerNombreMes (numero) {
    let miFecha = new Date();
    if (0 < numero && numero <= 12) {
      miFecha.setMonth(numero - 1);
      return new Intl.DateTimeFormat('es-ES', { month: 'long'}).format(miFecha);
    } else {
      return null;
    }
  }



// ********************   variable PARA CAMBIAR DE IDIOMA AL ESPAÑOL EL DataTable  *************************
var language_espaniol = {
    "lengthMenu": "Mostrar _MENU_ registros por pagina",
    "zeroRecords": "No se encontraron resultados en su busqueda",
    "searchPlaceholder": "Buscar Registros",
    "info": "Total: _TOTAL_ registros",
    "infoEmpty": "No Existen Registros",
    "infoFiltered": "(filtrado de un total de _MAX_ registros)",
    "search": "Buscar:",
    "paginate": {
        "first": "Primero",
        "last": "Último",
        "next": "Siguiente",
        "previous": "Anterior"
    }, /* TODO ESTO ES PARA CAMBIAR DE IDIOMA */
}

