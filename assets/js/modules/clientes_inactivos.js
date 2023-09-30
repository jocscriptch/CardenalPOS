let tblClientes;
document.addEventListener('DOMContentLoaded', function () {

    tblClientes = $('#tblClientes').DataTable({
        ajax: {
            url: base_url + 'clientes/listarInactivos',
            dataSrc: ''
        },
        columns: [ //campos en la db
            { data: 'identidad' },
            { data: 'num_identidad' },
            { data: 'nombre' },
            { data: 'telefono' },
            { data: 'correo' },
            { data: 'direccion' },
            { data: 'acciones' } //accion en el controlador
        ],
        language: {
            url: base_url + 'assets/js/spanish.json'
        },
        dom,
        buttons,
        responsive: true,
        order: [[0, 'asc']]
    });
});

function restaurarCliente(idCliente)
{
    const url = base_url + 'clientes/restaurar/' + idCliente;
    restaurarRegistros(url, tblClientes);
}