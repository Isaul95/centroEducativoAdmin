    $(document).ready(function(){

      llenar_combo_carreras_OficiosTitulacion_Admin();
      llenar_combo_opciones_OficiosTitulacion_Admin();

    // var tipo_documento = "TITULACION";
    // llenarTablaDeOficiosToAdmin(tipo_documento);


    $("#combo_CarreraOficios_Admin").change(function () {
          var tipo_documento = "TITULACION";
          var licenciatura = $("#combo_CarreraOficios_Admin").val();
          var opciones = $("#combo_opcionesOficios_Admin").val();

                $("#tbl_listaDeOficiosToAdmin").DataTable().destroy();
                llenarTablaDeOficiosToAdmin(tipo_documento,licenciatura,opciones);
      });


      $("#combo_opcionesOficios_Admin").change(function () {
          var tipo_documento = "TITULACION";
          var licenciatura = $("#combo_CarreraOficios_Admin").val();
          var opciones = $("#combo_opcionesOficios_Admin").val();

                $("#tbl_listaDeOficiosToAdmin").DataTable().destroy();
                llenarTablaDeOficiosToAdmin(tipo_documento,licenciatura,opciones);
       });





    var tipo_documento2 = "SERVICIO";
    llenarTablaDeOficiosToAdminServicio(tipo_documento2);

    var tipo_documento3 =  "PRACTICAS";
    llenarTablaDeOficiosToAdminPracticas(tipo_documento3);

    }); // FIN DE LA FUNCION PRINCIPAL



// 1.-  llenar tabla de oficios TITULACIONes
    function llenarTablaDeOficiosToAdmin(tipo_documento,licenciatura,opciones) {
      debugger;
      var datos = {
                   tipo_documento : tipo_documento,
                   licenciatura : licenciatura,
                   opciones : opciones,
                 }

        $.ajax({
            type: "post",
            url: base_url+'Administrativos/VerProcesosFinales/obtenerOficiosOfAlumnosToAdmin',
            dataType: "json",
            data : (datos),
            success: function(response) {
                var i = "1";
                $("#tbl_listaDeOficiosToAdmin").DataTable({
                    data: response,
                    responsive: true,
                    columns: [
                      {
                            data: "alumno",
                            // "visible": false,
                            // "searchable": false
                        },
                        // {
                        //     data: "nombre_archivo",
                        // },
                        {
                            data: "tipo_documento",
                        },
                        {
                            data: "estado",
                        },
                        {
                            data: "archivo",
                            "className": "text-center",
                            render: function(data, type, row, meta) {
                                return a = `<a title="Descarga Baucher" href="VerProcesosFinales/verOficiosDeAlumnosToAdmin/${row.id_oficio}/${row.alumno}/${row.tipo_documento}" target="_blank"><i class="far fa-file-pdf fa-2x"></i></a>`;
                            },
                        },
                        {
                            data: "fecha_registro",
                        },
                        {
                            data: "comentarios",
                        },

                    ],
                      "language" : language_espaniol,
                });
            },
        });
    }




//  2.- llenar tabla de oficios SERVICIO SOCIAL
    function llenarTablaDeOficiosToAdminServicio(tipo_documento2) {
      debugger;
      var datos = {
                   tipo_documento : tipo_documento2,
                 }

        $.ajax({
            type: "post",
            url: base_url+'Administrativos/VerProcesosFinales/obtenerOficiosOfAlumnosToAdminServicio',
            dataType: "json",
            data : (datos),
            success: function(response) {
                var i = "1";
                $("#tbl_listaDeOficiosServicioToAdmin").DataTable({
                    data: response,
                    responsive: true,
                    columns: [
                      {
                            data: "alumno",
                            // "visible": false,
                            // "searchable": false
                        },
                        // {
                        //     data: "nombre_archivo",
                        // },
                        {
                            data: "tipo_documento",
                        },
                        {
                            data: "estado",
                        },
                        {
                            data: "archivo",
                            "className": "text-center",
                            render: function(data, type, row, meta) {
                                return a = `<a title="Descarga Baucher" href="VerProcesosFinales/verOficiosDeAlumnosToAdmin/${row.id_oficio}/${row.alumno}/${row.tipo_documento}" target="_blank"><i class="far fa-file-pdf fa-2x"></i></a>`;
                            },
                        },
                        {
                            data: "fecha_registro",
                        },
                        {
                            data: "comentarios",
                        },

                    ],
                      "language" : language_espaniol,
                });
            },
        });
    }





//  3.- llenar tabla de oficios TITULACIONes
    function llenarTablaDeOficiosToAdminPracticas(tipo_documento3) {
      debugger;
      var datos = {
                   tipo_documento : tipo_documento3,
                 }

        $.ajax({
            type: "post",
            url: base_url+'Administrativos/VerProcesosFinales/obtenerOficiosOfAlumnosToAdminPracticas',
            dataType: "json",
            data : (datos),
            success: function(response) {
                var i = "1";
                $("#tbl_listaDeOficiosPracticasToAdmin").DataTable({
                    data: response,
                    responsive: true,
                    columns: [
                      {
                            data: "alumno",
                            // "visible": false,
                            // "searchable": false
                        },
                        // {
                        //     data: "nombre_archivo",
                        // },
                        {
                            data: "tipo_documento",
                        },
                        {
                            data: "estado",
                        },
                        {
                            data: "archivo",
                            "className": "text-center",
                            render: function(data, type, row, meta) {
                                return a = `<a title="Descarga Baucher" href="VerProcesosFinales/verOficiosDeAlumnosToAdmin/${row.id_oficio}/${row.alumno}/${row.tipo_documento}" target="_blank"><i class="far fa-file-pdf fa-2x"></i></a>`;
                            },
                        },
                        {
                            data: "fecha_registro",
                        },
                        {
                            data: "comentarios",
                        },

                    ],
                      "language" : language_espaniol,
                });
            },
        });
    }




    function llenar_combo_opciones_OficiosTitulacion_Admin() {
        $.ajax({
            type: "get",
            url: base_url + 'Profesores/PlaneacionProfesores/obteneropciones',
            dataType: "json",
            success: function (data) {
                $.each(data, function (key, registro) {
                    $("#combo_opcionesOficios_Admin").append('<option value=' + registro.id_opcion + '>' + registro.descripcion + '</option>');
                });
            },
        });
    }


    function llenar_combo_carreras_OficiosTitulacion_Admin() {
        $.ajax({
            type: "get",
            url: base_url + 'Profesores/PlaneacionProfesores/obtenercarreras',
            dataType: "json",
            success: function (data) {
                console.log(data);
                $.each(data, function (key, registro) {
                    $("#combo_CarreraOficios_Admin").append('<option value=' + registro.id_carrera + '>' + registro.carrera_descripcion + '</option>');
                });
            },
        });
    }
