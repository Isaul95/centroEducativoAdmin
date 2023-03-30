$(document).ready(function () {
    //$('#tbl_reportes_alumnos').hide();

    llenarTablaReportAlumnos();
    llenar_combo_grados_grupos();
    llenarTablaReportMaestros();
    llenar_combo_grados_maestros();

    $("#combo_grado_alumno").change(function () {
        //$('#tbl_reportes_alumnos').show(); // mostrar la tabla
        $("#tbl_reportes_alumnos").DataTable().destroy();
        llenarTablaReportAlumnos($("#combo_grado_alumno").val());
    });

    $("#combo_grado_maestro").change(function () {
        //$('#tbl_reportes_alumnos').show(); // mostrar la tabla
        $("#tbl_reportes_maestros").DataTable().destroy();
        llenarTablaReportMaestros($("#combo_grado_maestro").val());
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
function llenarTablaReportMaestros(grado) {

    var fd = new FormData();
    fd.append("grado", grado);

    $.ajax({
        type: "post",
        url: base_url + 'Administrativos/ReportesMaestros/contadorMaestros',
        data: fd,
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

