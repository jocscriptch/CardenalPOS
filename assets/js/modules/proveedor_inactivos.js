let tblProveedores;
document.addEventListener('DOMContentLoaded', function () {
    // Inicializar DataTable y CKEditor
    tblProveedores = $('#tblProveedores').DataTable({
        ajax: {
            url: base_url + 'proveedor/listarInactivos',
            dataSrc: ''
        },
        columns: [
            { data: 'nombre' },
            { data: 'telefono' },
            { data: 'correo' },
            { data: 'direccion' },
            { data: 'acciones' }
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


function restaurarProveedor(idProveedor) {
    const url = base_url + 'proveedor/restaurar/' + idProveedor;
    restaurarRegistros(url, tblProveedores);
}