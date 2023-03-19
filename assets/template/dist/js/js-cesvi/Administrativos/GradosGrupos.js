$(document).ready(function () {
    llenartablagradosgrupos(); // SEINICIALIZA LA FUNCTIO DE LA CARGA DEL LISTADO DE LA TABLA
});
/* ---------------------------- Add periodo Modal --------------------------- */
$("#modal_add_gradogrupo").on("hide.bs.modal", function (e) {
    // do something...
    $("#addgradogrupo")[0].reset();
});
/* ---------------------------- Edit periodo Modal --------------------------- */
$("#modaleditargradogrupo").on("hide.bs.modal", function (e) {
    // do something...
    $("#formeditargradogrupo")[0].reset();
});
//////////////////////// AGREGAR PERIODO ////////////////////////////////////////////////7
$(document).on("click", "#btnaddgradogrupo", function (e) {
    e.preventDefault();
    var nombre = $("#gradogrupo").val();
    var descripcion = $("#descripciongradogrupo").val();
    if (nombre == "" || descripcion == "" ) {
        alert("¡Complete todos los campos!");
    } else {
        var fd = new FormData();
        fd.append("nombre", nombre);
        fd.append("descripcion", descripcion);
        $.ajax({
            type: "post",
            url: base_url + 'Administrativos/GradosGrupos/insertargradogrupo',
            data: fd,
            processData: false,
            contentType: false,
            dataType: "json",
            enctype: 'multipart/form-data',
            success: function (response) {
                if (response.res == "success") {
                    toastr["success"](response.message);
                    $("#modal_add_gradogrupo").modal("hide");
                    $("#addgradogrupo")[0].reset();
                    $("#tbl_gradosgrupos").DataTable().destroy();
                    llenartablagradosgrupos();
                } else {
                    toastr["error"](response.message);
                }
            },
        });
    }
});
//////////////////////// VER PERIODOS ////////////////////////////////////////////////7
function llenartablagradosgrupos() {
    $.ajax({
        type: "get",
        url: base_url + 'Administrativos/GradosGrupos/vergradosgrupos',
        dataType: "json",
        success: function (response) {
            var i = "1";
            $("#tbl_gradosgrupos").DataTable({
                data: response,
                responsive: true,
                columns: [
                    {
                        data: "id_grado_grupo",
                        "visible": false,
                        "searchable": false
                    },

                    {
                        data: "nombre",
                    },
                    {
                        data: "descripcion",
                    },
                    {
                        orderable: false,
                        searchable: false,
                        data: function (row, type, set) {
                            return `  
                        <a href="#" id="edit_gradogrupo" class="btn btn-success btn-remove" value="${row.id_grado_grupo}"><i class="far fa-edit"></i></a>
                        <a href="#" id="del_gradogrupo" class="btn btn-danger btn-remove" value="${row.id_grado_grupo}"><i class="fas fa-trash-alt"></i></a>
                                 `;
                        },
                    },
                ],
                "language": language_espaniol,
            });
        },
    });
}
//////////////////////// ELIMINAR PERIODO ////////////////////////////////////////////////7
$(document).on("click", "#del_gradogrupo", function (e) {
    e.preventDefault();
    var del_id = $(this).attr("value");
    Swal.fire({
        title: "¿Estás seguro de Borrar?",
        text: "¡Esta acción es irreversile!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "¡Si, bórralo!",
        cancelButtonText: "¡No, cancelar!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: base_url + 'Administrativos/GradosGrupos/eliminargradogrupo',
                data: {
                    del_id: del_id,
                },
                dataType: "json",
                success: function (data) {
                    if (data.responce == "success") {
                        Swal.fire(
                            '¡Eliminado!',
                            'El grado y grupo fue eliminado',
                            'success'
                        );
                        $("#tbl_gradosgrupos").DataTable().destroy();
                        llenartablagradosgrupos();
                    }
                },
            });
        }
    });
});
////////////////////////// GET PERIODO FOR EDIT /////////////////////////////////
$(document).on("click", "#edit_gradogrupo", function (e) {
    e.preventDefault();
    var edit_id = $(this).attr("value");
    $.ajax({
        type: "post",
        url: base_url + 'Administrativos/GradosGrupos/editargradogrupo',
        data: {
            edit_id: edit_id,
        },
        dataType: "json",
        success: function (data) {
            // console.log(data); ver la respuesta del json, los valores que contiene
            $('#modaleditargradogrupo').modal('show');
            $('#id_grado_grupo').val(data.post.id_grado_grupo)
            $('#gradogrupoeditar').val(data.post.nombre)
            $('#descripciongradogrupoeditar').val(data.post.descripcion)
        },
    });
});
////////////////////////// EDIT PERIODO /////////////////////////////////
$(document).on("click", "#update_gradogrupo", function (e) {
    e.preventDefault();
    var id_grado_grupo = $('#id_grado_grupo').val();
    var nombre = $('#gradogrupoeditar').val();
    var descripcion = $('#descripciongradogrupoeditar').val();
    if (id_grado_grupo == "" || nombre == "") {
        alert("¡Complete todos los campos!");
    } else {
        $.ajax({
            type: "post",
            url: base_url + 'Administrativos/GradosGrupos/updategradogrupo',
            data: {
                id_grado_grupo: id_grado_grupo,
                nombre: nombre,
                descripcion: descripcion
            },
            dataType: "json",
            success: function (data) {
                if (data.responce == "success") {
                    toastr["success"](data.message);
                    $("#modaleditargradogrupo").modal("hide");
                    $("#formeditargradogrupo")[0].reset();
                    $("#tbl_gradosgrupos").DataTable().destroy();
                    llenartablagradosgrupos();
                } else {
                    toastr["error"](data.message);
                }
            },
        });
    }
});
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
