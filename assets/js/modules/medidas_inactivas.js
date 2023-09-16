let tblMedidas;
document.addEventListener('DOMContentLoaded', function(){

    tblMedidas = $('#tblMedidas').DataTable({
        ajax: {
            url: base_url + 'medidas/listarInactivas', //llamando al metodo del controlador medidas
            dataSrc: ''
        },
        columns: [ //campos en la db
            { data: 'medida' },
            { data: 'abreviatura' },
            { data: 'acciones' } //accion en el controlador medidas
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

function restaurarMedida(idMedida) {
    const url = base_url + 'medidas/restaurar/' + idMedida;
    restaurarRegistros(url, tblMedidas);
}