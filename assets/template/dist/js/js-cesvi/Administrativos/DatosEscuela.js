$(document).ready(function () {
    llenartaDatosEscuela(); // SEINICIALIZA LA FUNCTIO DE LA CARGA DEL LISTADO DE LA TABLA
});


/* ---------------------------- Edit periodo Modal --------------------------- 
$("#modalEditarDatos").on("hide.bs.modal", function (e) {
    // do something...
    $("#formeditarDatos")[0].reset();
});
*/

// --------------
function llenartaDatosEscuela() {
    $.ajax({
        type: "get",
        url: base_url + 'Administrativos/DatosEscuela/verDatosEscuela',
        dataType: "json",
        success: function (response) {
            var i = "1";
            $("#tbl_datosEscuela").DataTable({
                data: response,
                responsive: true,
                columns: [
                    {
                        data: "nombre",
                    },
                    {
                        data: "codigo",
                    },
                    {
                        data: "turno",
                    },
                    {
                        data: "zona_escolar",
                    },
                    {
                        orderable: false,
                        searchable: false,
                        data: function (row, type, set) {
                            return `
                            <a href="#" id="edit_datos" class="btn btn-success btn-remove" value="${row.codigo}"><i class="far fa-edit"></i></a>
                                 `;
                        },
                    },
                ],
                "language": language_espaniol,
                paging: false,
                ordering: false,
                searching: false,
            });
        },
    });
}


// --------------
$(document).on("click", "#edit_datos", function (e) {
    e.preventDefault();
    var codigo = $(this).attr("value");
    $.ajax({
        type: "post",
        url: base_url + 'Administrativos/DatosEscuela/editarDatos',
        data: {
            codigo: codigo,
        },
        dataType: "json",
        success: function (data) {
            // console.log(data); ver la respuesta del json, los valores que contiene
            $('#modalEditarDatos').modal('show');
            $('#nombreEditar').val(data.post.nombre)
            $('#codigoEditar').val(data.post.codigo)
            $('#turnoEditar').val(data.post.turno)
            $('#zonaEditar').val(data.post.zona_escolar)
        },
    });
});

// --------------
$(document).on("click", "#update_datosEscuela", function (e) {
    e.preventDefault();
    debugger
    var nombre = $('#nombreEditar').val();
    var codigo = $('#codigoEditar').val();
    var turno = $('#turnoEditar').val();
    var zona_escolar = $('#zonaEditar').val();

    if (nombre == "" || codigo == "" || turno == "" || zona_escolar == "") {
        alert("¡Complete todos los campos!");
    } else {
        $.ajax({
            type: "post",
            url: base_url + 'Administrativos/DatosEscuela/updateDatosEscuela',
            data: {
                nombre: nombre,
                codigo: codigo,
                turno: turno,
                zona_escolar: zona_escolar
            },
            dataType: "json",
            success: function (data) {
                if (data.responce == "success") {
                    toastr["success"](data.message);
                    $("#modalEditarDatos").modal("hide");
                    $("#formeditarDatos")[0].reset();
                    $("#tbl_datosEscuela").DataTable().destroy();
                    llenartaDatosEscuela();
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
