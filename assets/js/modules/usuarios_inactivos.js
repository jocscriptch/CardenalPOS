let tblUsuarios;

document.addEventListener('DOMContentLoaded', function () {

    //cargar datos con el pluggin datatables
    tblUsuarios = $('#tblUsuarios').DataTable({
        ajax: {
            url: base_url + 'usuarios/listarInactivos',
            dataSrc: ''
        },
        columns: [
            { data: 'nombres' },
            { data: 'correo' },
            { data: 'telefono' },
            { data: 'direccion' },
            { data: 'rol' },
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
})

//funcion restaurar usuario
function restaurarUsuario(idUsuario) {
    const url = base_url + 'usuarios/restaurar/' + idUsuario;
    restaurarUsuario(url, tblUsuarios);
}