let tblUsuarios;

document.addEventListener('DOMContentLoaded', function () {

    $('#tblUsuarios').DataTable( {
        ajax: {
            url: base_url + 'usuarios/listar',
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
        language:{
            url: base_url + 'assets/js/spanish.json'
        },
        dom,
        buttons
    } );
})