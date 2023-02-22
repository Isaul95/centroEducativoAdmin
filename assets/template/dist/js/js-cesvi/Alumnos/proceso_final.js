    $(document).ready(function(){
    mostrarBtnAgregarOficioServicioSocial();
    mostrarBtnAgregarOficioPracticasProfes();
    mostrarBtnAgregarOficioTitulacion();
debugger;
    var alumno = $("#noControlProcFinTitulacion").val();
    var tipo_documento = "TITULACION";
    $("#tbl_listaDocDeTitulacionXteeb").DataTable().destroy();
    llenarTablaDocumentosDeTitulacionXxxx();

    }); // FIN DE LA FUNCION PRINCIPAL



    /* -------------------------------------------------------------------------- */
    /*            Insert oficio pa Practicas_profesionale                         */
    /* -------------------------------------------------------------------------- */
    $(document).on("click", "#darAltaOficioPracticas", function(e) {
        e.preventDefault();
        debugger;

        var numero_control = $("#noControlProcFinPracticas").val();
        var img = $("#archivoProcFinPracticas")[0].files[0]; // this is file
                      // var tipo_de_pago = $("#pago").val();
        var archivo = $("#archivoProcFinPracticas")[0].files[0];
        var semestre = $("#semestreProcFinPracticas").val();

        if (archivo == undefined) {
            alert("No seleccionó el documento a guardar...!");
        } else {
            var fd = new FormData();

            fd.append("alumno", numero_control);
            fd.append("archivo", img); //Obt principalmente el name file
            fd.append("archivo", archivo); // Obt el file como tal
            fd.append("tipo_documento", 'PRACTICAS');  //  => Practocas profesionales
            // fd.append("estado_archivo", 6);  // 6 => estatyus de "Registro baucher"
            fd.append("semestre", semestre);

            $.ajax({
                type: "post",
                url: base_url+'Alumnos/Practicas_profesionales/insertarOficioPracticasProfesional',
                data: fd,
                processData: false,
                contentType: false,
                dataType: "json",
                enctype : 'multipart/form-data',
                success: function(response) {
                    if (response.res == "success") {
                        toastr["success"](response.message);
                        $("#formularioAltaOficioProcFinPracticas")[0].reset();
                        //  Si se inserto bien el baucher se recarga la pagina
                        // location.reload();
                    } else {
                        toastr["error"](response.message);
                    }
                },
            });
        }
    });








/* -------------------------------------------------------------------------- */
/*                  Insert oficio pa Servicio_social                          */
/* -------------------------------------------------------------------------- */
        $(document).on("click", "#darAltaOficioServicio", function(e) {
            e.preventDefault();
            debugger;

            var numero_control = $("#noControlProcFinServSocial").val();
            var img = $("#archivoProcFinServicio")[0].files[0]; // this is file
                          // var tipo_de_pago = $("#pago").val();
            var archivo = $("#archivoProcFinServicio")[0].files[0];
            var semestre = $("#semestreProcFinServSocial").val();

            if (archivo == undefined) {
                alert("No seleccionó el documento a guardar...!");
            } else {
                var fd = new FormData();

                fd.append("alumno", numero_control);
                fd.append("archivo", img); //Obt principalmente el name file
                fd.append("archivo", archivo); // Obt el file como tal
                fd.append("tipo_documento", 'SERVICIO');  //  => Practocas profesionales
                // fd.append("estado_archivo", 6);  // 6 => estatyus de "Registro baucher"
                fd.append("semestre", semestre);

                $.ajax({
                    type: "post",
                    url: base_url+'Alumnos/Servicio_social/insertarOficioServicioSocial',
                    data: fd,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    enctype : 'multipart/form-data',
                    success: function(response) {
                        if (response.res == "success") {
                            toastr["success"](response.message);
                            $("#formularioAltaOficioProcFinServicio")[0].reset();
                            //  Si se inserto bien el baucher se recarga la pagina
                            // location.reload();
                        } else {
                            toastr["error"](response.message);
                        }
                    },
                });
            }
        });










/* -------------------------------------------------------------------------- */
/*                    Insert oficio para Titulacion                           */
/* -------------------------------------------------------------------------- */
            $(document).on("click", "#darAltaOficioTitulacion", function(e) {
                e.preventDefault();
                debugger;

                var numero_control = $("#noControlProcFinTitulacion").val();
                var img = $("#archivoProcFinTitulacion")[0].files[0]; // this is file
                var archivo = $("#archivoProcFinTitulacion")[0].files[0];
                var semestre = $("#semestreProcFinTitulacion").val();

                if (archivo == undefined) {
                    alert("No seleccionó el documento a guardar...!");
                } else {
                    var fd = new FormData();

                    fd.append("alumno", numero_control);
                    fd.append("archivo", img); //Obt principalmente el name file
                    fd.append("archivo", archivo); // Obt el file como tal
                    fd.append("tipo_documento", 'TITULACION');  //  => Practocas profesionales
                    fd.append("estado_archivo", '8');  //  => Practocas profesionales
                    fd.append("semestre", semestre);

                    $.ajax({
                        type: "post",
                        url: base_url+'Alumnos/Titulacion/insertarOficioDeTitulacion',
                        data: fd,
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        enctype : 'multipart/form-data',
                        success: function(response) {
                            if (response.res == "success") {
                                toastr["success"](response.message);
                                $("#formularioAltaOficioProcFinTitulacion")[0].reset();
                                $("#tbl_listaDocDeTitulacionXteeb").DataTable().destroy();
                                llenarTablaDocumentosDeTitulacionXxxx();
                            } else {
                                toastr["error"](response.message);
                            }
                        },
                    });
                }
            });



//  DAR PERMISOS A PANTALLAS  Titulacion , servicio_social y Practicas_profesionale

//  1.-  SERVICIO SOCIAL
function mostrarBtnAgregarOficioServicioSocial(){
    debugger;
              var datos = {
                      numero_control : $("#noControlProcFinServSocial").val(),
                  }
              $.ajax({
            url: base_url+'Alumnos/Servicio_social/mostrarOpcionSubirOficioServiSocial',
            type: "post",
            dataType: "json",
                  data : (datos),
                  success : function(data){
              if (data.responce == "success") {
                  toastr["success"](data.message);
                      debugger;
                      $('#formularioRegistroOficioServicio').show();
                      $('#noPermisoDeAddOficioServSocial').hide();
                    }else{
                      // toastr["error"](data.message);
                      $('#noPermisoDeAddOficioServSocial').show();
                      $('#formularioRegistroOficioServicio').hide();
                    }
                      }
              });
      }



//  2.- PRACTICAS PROFESIONALES
function mostrarBtnAgregarOficioPracticasProfes(){
    debugger;
              var datos = {
                      numero_control : $("#noControlProcFinPracticas").val(),
                  }
              $.ajax({
            url: base_url+'Alumnos/Practicas_profesionales/mostrarOpcionSubirOficioPracticasProf',
            type: "post",
            dataType: "json",
                  data : (datos),
                  success : function(data){
              if (data.responce == "success") {
                  toastr["success"](data.message);
                      debugger;
                      $('#formularioRegistroOficioPractProf').show();
                      $('#noPermisoDeAddOficioPracticasProf').hide();
                    }else{
                      // toastr["error"](data.message);
                      $('#noPermisoDeAddOficioPracticasProf').show();
                      $('#formularioRegistroOficioPractProf').hide();
                    }
                      }
              });
      }




      //  2.-  TITULACION
      function mostrarBtnAgregarOficioTitulacion(){
          debugger;
                    var datos = {
                            numero_control : $("#noControlProcFinTitulacion").val(),
                        }
                    $.ajax({
                  url: base_url+'Alumnos/Titulacion/mostrarOpcionSubirOficioTitulacion',
                  type: "post",
                  dataType: "json",
                        data : (datos),
                        success : function(data){
                    if (data.responce == "success") {
                        toastr["success"](data.message);
                            debugger;
                            $('#formularioRegistroOficioTitulacion').show();
                            $('#noPermisoDeAddOficioTitulacion').hide();
                          }else{
                            // toastr["error"](data.message);
                            $('#noPermisoDeAddOficioTitulacion').show();
                            $('#formularioRegistroOficioTitulacion').hide();
                          }
                            }
                    });
            }




    function llenarTablaDocumentosDeTitulacionXxxx() {
      debugger;
      // var datos = {
      //              alumno : alumno,
      //              // tipo_documento : tipo_documento,
      //            }

       console.log("Lista llenarTablaDocumentosDeTitulacion de cada alumno...!");

        $.ajax({
            type: "get",
            url: base_url+'Alumnos/Titulacion/obtenerComprobantesTitulacionxxx',
            dataType: "json",
            // data : (datos),
            success: function(response) {
                var i = "1";
                $("#tbl_listaDocDeTitulacionXteeb").DataTable({
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
                                return a = `<a title="Descarga Baucher" href="Titulacion/verArchivoTitulacion/${row.id_oficio}/${row.alumno}/${row.tipo_documento}" target="_blank"><i class="far fa-file-pdf fa-2x"></i></a>`;
                            },
                        },
                        {
                            orderable: false,
                            searchable: false,
                            "className": "text-center",
                            data: function (row, type, set) {
                                return `<a class="btn btn-danger btn-remove" onclick=deleteOficioTitulacion('${row.id_oficio}','${row.alumno}','${row.tipo_documento}')><i class="fas fa-trash-alt"></i></a>`;
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



          function deleteOficioTitulacion(id_oficio, alumno, tipo_documento){
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
                               url: base_url+'Alumnos/Titulacion/eliminarRegistroTitulacion',
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
                                  $("#tbl_listaDocDeTitulacionXteeb").DataTable().destroy();
                                  llenarTablaDocumentosDeTitulacionXxxx();
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
