    $(document).ready(function(){

      llenar_combo_carreras_TesisTitulacion_Profe();
      llenar_combo_opciones_TesisTitulacion_Profe();


      $("#combo_CarreraTesis_Profe").change(function () {
            var tipo_documento = "TITULACION";
            var licenciatura = $("#combo_CarreraTesis_Profe").val();
            var opciones = $("#combo_opcionesTesis_Profe").val();

                  $("#tbl_listaDeOficiosToAdmin").DataTable().destroy();
                  llenarTablaDocumentosDeTitulacionToProfesor(tipo_documento,licenciatura,opciones);
        });


        $("#combo_opcionesTesis_Profe").change(function () {
            var tipo_documento = "TITULACION";
            var licenciatura = $("#combo_CarreraTesis_Profe").val();
            var opciones = $("#combo_opcionesTesis_Profe").val();

                  $("#tbl_listaDeOficiosToAdmin").DataTable().destroy();
                  llenarTablaDocumentosDeTitulacionToProfesor(tipo_documento,licenciatura,opciones);
         });




    }); // FIN DE LA FUNCION PRINCIPAL




/* -------------------------------------------------------------------------- */
/*                    Insert oficio para Titulacion                           */
/* -------------------------------------------------------------------------- */
            $(document).on("click", "#darAltaOficioTitulacionToProfesor", function(e) {
                e.preventDefault();
                debugger;

                var comentarios = $("#comentarios").val();
                var img = $("#archivoProcFinTitulacionToProfesor")[0].files[0]; // this is file
                var archivo = $("#archivoProcFinTitulacionToProfesor")[0].files[0];
                var userProfe = $("#usernameProfesor").val();

                if (archivo == undefined) {
                    alert("No seleccionó el documento a guardar...!");
                } else {
                    var fd = new FormData();

                    fd.append("comentarios", comentarios);
                    fd.append("archivo", img); //Obt principalmente el name file
                    fd.append("archivo", archivo); // Obt el file como tal
                    fd.append("tipo_documento", 'TESIS_REVISADO');  //  => Practocas profesionales
                    fd.append("estado_archivo", '9');  //  => Practocas profesionales
                    fd.append("alumno", userProfe);

                    $.ajax({
                        type: "post",
                        url: base_url+'Profesores/VerTitulaciones/insertarOficioDeTitulacionOfProfesores',
                        data: fd,
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        enctype : 'multipart/form-data',
                        success: function(response) {
                            if (response.res == "success") {
                                toastr["success"](response.message);
                                $("#formularioAltaOficioProcFinTitulacionToProfesor")[0].reset();
                                $("#tbl_listaDocDeTitulacionToProfesores").DataTable().destroy();
                                llenarTablaDocumentosDeTitulacionToProfesor();
                            } else {
                                toastr["error"](response.message);
                            }
                        },
                    });
                }
            });




    function llenarTablaDocumentosDeTitulacionToProfesor(tipo_documento,licenciatura,opciones) {
      debugger;
      var datos = {
                   tipo_documento : tipo_documento,
                   licenciatura : licenciatura,
                   opciones : opciones,
                 }

        $.ajax({
            type: "get",
            url: base_url+'Profesores/VerTitulaciones/obtenerComprobantesTitulacionToProfesor',
            dataType: "json",
            // data : (datos),
            success: function(response) {
                var i = "1";
                $("#tbl_listaDocDeTitulacionToProfesores").DataTable({
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
                                return a = `<a title="Descarga Baucher" href="VerTitulaciones/verArchivoTitulacionOfProfesor/${row.id_oficio}/${row.alumno}/${row.tipo_documento}" target="_blank"><i class="far fa-file-pdf fa-2x"></i></a>`;
                            },
                        },
                        {
                            orderable: false,
                            searchable: false,
                            "className": "text-center",
                            data: function (row, type, set) {
                                return `<a class="btn btn-danger btn-remove" onclick=deleteOficioTitulacionOfProfesor('${row.id_oficio}','${row.alumno}','${row.tipo_documento}')><i class="fas fa-trash-alt"></i></a>`;
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



          function deleteOficioTitulacionOfProfesor(id_oficio, alumno, tipo_documento){
              // debugger;
                    var datos = {
                        id_oficio : id_oficio,
                        alumno : alumno,
                        tipo_documento : tipo_documento,
                    }

                    const swalWithBootstrapButtons = Swal.mixin({
                      customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger mr-2'
                      },
                      buttonsStyling: false
                    })

                    swalWithBootstrapButtons.fire({
                      title: 'Esta seguro de borrar el registro...?',
                      text: "!Esta acción es irreversile!",
                      icon: 'warning',
                      showCancelButton: true,
                      confirmButtonText: 'Si, bórralo!',
                      cancelButtonText: 'No, cancelar!',
                      reverseButtons: true
                    }).then((result) => {
                      if (result.value) {

                          $.ajax({
                               url: base_url+'Profesores/VerTitulaciones/eliminarRegistroTitulacionToProfesores',
                            type: "post",
                            dataType: "json",
                            data: {
                                id_oficio : id_oficio,
                                alumno : alumno,
                                tipo_documento : tipo_documento,
                            },
                            success: function(data){
                              if (data.responce == "success") {
                                  swalWithBootstrapButtons.fire(
                                    '¡Eliminado!',
                                    'El registro ha sido eliminado.!',
                                    'success'
                                  );
                                  $("#tbl_listaDocDeTitulacionToProfesores").DataTable().destroy();
                                  llenarTablaDocumentosDeTitulacionToProfesor();
                              }else{
                                  swalWithBootstrapButtons.fire(
                                    '¡Eliminado',
                                    'El registro no se pudo eliminar...!',
                                    'error'
                                  );
                              }
                            }
                          });

                      } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                      ) {
                        swalWithBootstrapButtons.fire(
                          'Cancelada',
                          'El registro no se elimino...!',
                          'error'
                        )
                      }
                    });

                }





      function llenar_combo_opciones_TesisTitulacion_Profe() {
          $.ajax({
              type: "get",
              url: base_url + 'Profesores/PlaneacionProfesores/obteneropciones',
              dataType: "json",
              success: function (data) {
                  $.each(data, function (key, registro) {
                      $("#combo_opcionesTesis_Profe").append('<option value=' + registro.id_opcion + '>' + registro.descripcion + '</option>');
                  });
              },
          });
      }


      function llenar_combo_carreras_TesisTitulacion_Profe() {
          $.ajax({
              type: "get",
              url: base_url + 'Profesores/PlaneacionProfesores/obtenercarreras',
              dataType: "json",
              success: function (data) {
                  console.log(data);
                  $.each(data, function (key, registro) {
                      $("#combo_CarreraTesis_Profe").append('<option value=' + registro.id_carrera + '>' + registro.carrera_descripcion + '</option>');
                  });
              },
          });
      }
