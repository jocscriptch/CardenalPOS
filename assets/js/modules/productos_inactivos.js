let tblProductos;

document.addEventListener('DOMContentLoaded', function () {
    tblProductos = $('#tblProductos').DataTable({
        ajax: {
            url: base_url + 'productos/listarInactivos', //llamando al metodo del controlador productos
            dataSrc: ''
        },
        columns: [ //campos en la db
            { data: 'codigo' },
            { data: 'descripcion' },
            { data: 'precio_compra' },
            { data: 'precio_venta' },
            { data: 'cantidad' },
            { data: 'medida' },
            { data: 'categoria' },
            { data: 'imagen' },
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
});

function restaurarProducto(idProducto)
{
    const url = base_url + 'productos/restaurar/' + idProducto;
    restaurarRegistros(url, tblProductos);
}