let tblCategorias;
document.addEventListener('DOMContentLoaded', function()
{
    tblCategorias = $('#tblCategorias').DataTable({
        ajax: {
            url: base_url + 'categorias/listarInactivas', //llamando al metodo del controlador categorias
            dataSrc: ''
        },
        columns: [ //campos en la db
            { data: 'categoria' },
            {
                data: 'fecha',
                render: function (data) {
                   // Formatear la fecha y hora utilizando moment.js en formato de 12 horas
                   return moment(data).format('DD-MM-YYYY h:mm:ss a');
                }
            },
            { data: 'acciones' } //accion en el controlador categorias
        ],
        language: {
            url: base_url + 'assets/js/spanish.json'
        },
        dom,
        buttons,
        responsive: true,
        order: [[0, 'asc']]
    });
})

function restaurarCategoria(idCategoria)
{
    const url = base_url + 'categorias/restaurar/' + idCategoria;
    restaurarRegistros(url, tblCategorias);
}