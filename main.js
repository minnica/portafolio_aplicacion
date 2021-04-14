$(document).ready(function() {
    $("#color_me").change(function() {
        var color = $("option:selected", this).attr("class");
        $("#color_me").attr("class", color);
    });
    var id_tabla, opcion;
    opcion = 4;

    tablaUsuarios = $('#tablaUsuarios').DataTable({
        /*createdRow: function(row, data) {
            if (data["status_produccion"] === 'PENDIENTE' && data["cancelados"] != 'SI') {
                $("td", row).closest('tr').addClass("table-danger");
            } else if (data["cancelados"] === 'SI') {
                $("td", row).closest('tr').addClass("table-primary");
            } else if (data["status_produccion"] === 'TERMINADO') {
               $("td", row).closest('tr').addClass("table-success");
            } else if (data["perfil"] !== '' && (data["contratista"] === '' || data["folio"] === '') && data["cancelados"] === null) {
                $("td", row).closest('tr').addClass("table-info");
            } else if (data["perfil"] === '' && (data["contratista"] !== '' || data["folio"] !== '')) {
                $("td", row).closest('tr').addClass("table-warning");
            } else if (data["contratista"] !== '' && data["folio"] !== '' && data["perfil"] !== '') {
                $("td", row).closest('tr').addClass("table-warning");
            }
        },*/
        dom: 'lr<"tablaUsuarios">tip',
        initComplete: function(settings) {
            var api = new $.fn.dataTable.Api(settings);
            $('#table-filter select').on('change', function() {
                table
                    .columns(10)
                    .search(this.value)
                    .draw();
            });
        },
        responsive: "true",
        dom: 'Bfrtilp',
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fas fa-file-excel"></i> ',
            titleAttr: 'Exportar a Excel',
            className: 'btn btn-success excel',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
            }
        }],
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Busqueda general:",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "sProcessing": "Procesando...",
        },
        "aaSorting": [],
        "ajax": {
            "url": "bd/crud.php",
            "method": 'POST',
            "data": {
                opcion: opcion
            },
            "dataSrc": ""
        },
        "columns": [{
            "data": "id_tabla"
        }, {
            "data": "taller"
        }, {
            "data": "revision"
        }, {
            "data": "marca"
        }, {
            "data": "folio"
        }, {
            "data": "cantidad"
        }, {
            "data": "nombre"
        }, {
            "data": "peso_unitario"
        }, {
            "data": "contratista"
        }, {
            "data": "fecha_produccion"
        }, {
            data: 'status_produccion',
            name: 'status_produccion',
            render: function(data, type, row) {
                console.log('Content of data is : ' + data);
                sev = '';
                switch (data) {
                    case 'PENDIENTE':
                        sev = '<span class="badge bg-danger rounded-pill text-dark">' + data + '</span>';
                        break;
                    case 'PROCESO':
                        sev = '<span class="badge bg-warning rounded-pill text-dark">' + data + '</span>';
                        break;
                    case 'TERMINADO':
                        sev = '<span class="badge bg-success rounded-pill text-dark">' + data + '</span>';
                        break;
                    case 'MATERIALES':
                        sev = '<span class="badge rounded-pill text-dark" style="background-color: #fd7e14">' + data + '</span>';
                        break;
                }
                return sev;
            }


        }, {
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-dark  btn-sm btnEditar'><i class='fas fa-edit'></i></button><button class='btn btn-danger  btn-sm btnBorrar'><i class='fas fa-trash'></i></button></div></div>"
        }]
    });
    var fila;
    $('#formUsuarios').submit(function(e) {
        e.preventDefault();
        id_tabla = $.trim($('#id_tabla').val());
        taller = $.trim($('#taller').val());
        revision = $.trim($('#revision').val());
        marca = $.trim($('#marca').val());
        folio = $.trim($('#folio').val());
        cantidad = $.trim($('#cantidad').val());
        nombre = $.trim($('#nombre').val());
        peso_unitario = $.trim($('#peso_unitario').val());
        contratista = $.trim($('#contratista').val());
        fecha_produccion = $.trim($('#fecha_produccion').val());

        $.ajax({
            url: "bd/crud.php",
            type: "POST",
            datatype: "json",
            data: {
                id_tabla: id_tabla,
                taller: taller,
                revision: revision,
                marca: marca,
                folio: folio,
                cantidad: cantidad,
                nombre: nombre,
                peso_unitario: peso_unitario,
                contratista: contratista,
                fecha_produccion: fecha_produccion,
                opcion: opcion
            },
            success: function(data) {
                tablaUsuarios.ajax.reload(null, false);
            }
        });
        $('#modalCRUD').modal('hide');
    });

    $("#btnNuevo").click(function() {
        opcion = 1;
        id_tabla = null;
        $("#formUsuarios").trigger("reset");
        $(".modal-header").addClass("bg-dark text-white");
        $(".modal-title").text("Registro nuevo");
        $('#modalCRUD').modal('show');
    });
    $(document).on("click", ".btnEditar", function() {
        opcion = 2;
        fila = $(this).closest("tr");
        id_tabla = parseInt(fila.find('td:eq(0)').text());
        taller = fila.find('td:eq(1)').text();
        revision = fila.find('td:eq(2)').text();
        marca = fila.find('td:eq(3)').text();
        folio = fila.find('td:eq(4)').text();
        cantidad = fila.find('td:eq(5)').text();
        nombre = fila.find('td:eq(6)').text();
        peso_unitario = fila.find('td:eq(7)').text();
        contratista = fila.find('td:eq(8)').text();
        fecha_produccion = fila.find('td:eq(9)').text();

        $("#id_tabla").val(id_tabla);
        $("#taller").val(taller);
        $("#revision").val(revision);
        $("#marca").val(marca);
        $("#folio").val(folio);
        $("#cantidad").val(cantidad);
        $("#nombre").val(nombre);
        $("#peso_unitario").val(peso_unitario);
        $("#contratista").val(contratista);
        $("#fecha_produccion").val(fecha_produccion);


        $(".modal-header").addClass("bg-dark text-white");
        $(".modal-title").text("Editar");
        $('#modalCRUD').modal('show');
    });

    var table = $('#tablaUsuarios').DataTable();

    $('#tablaUsuarios tfoot td').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" class="form-control form-control-sm bg-dark text-light" style="width:100%;" placeholder="Buscar"/>');
    });
    table.columns().every(function() {
        var that = this;
        $('input', this.footer()).on('keyup change', function() {
            if (that.search() !== this.value) {
                that.search(this.value).draw();
            }
        });
    });
    $('#tablaUsuarios tfoot tr').appendTo('#tablaUsuarios thead');
    $(document).on("click", ".btnBorrar", function() {
        fila = $(this);
        id_tabla = parseInt($(this).closest('tr').find('td:eq(0)').text());
        opcion = 3;
        var respuesta = confirm("¿Está seguro de borrar el campo CONTRATISTA, TIPO Y FECHA DE ENTREGA del registro " + id_tabla + "?");
        if (respuesta) {
            $.ajax({
                url: "bd/crud.php",
                type: "POST",
                datatype: "json",
                data: {
                    opcion: opcion,
                    id_tabla: id_tabla
                },
                success: function() {
                    tablaUsuarios.ajax.reload(null, false);
                }
            });
        }
    });
});