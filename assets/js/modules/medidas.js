let tblMedidas;
const btnAccion = document.querySelector('#btnAccion');
const form = document.querySelector('#form');

const nombre = document.querySelector('#nombre');
const abreviatura = document.querySelector('#abreviatura');

const errorNombre = document.querySelector('#errorNombre');
const errorAbreviatura = document.querySelector('#errorAbreviatura');

document.addEventListener('DOMContentLoaded', function () {
    tblMedidas = $('#tblMedidas').DataTable({
        ajax: {
            url: base_url + 'medidas/listar', //llamando al metodo del controlador medidas
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

    //enviar datos
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        if (nombre.value == '') {
            errorNombre.textContent = 'NOMBRE REQUERIDO';

        } else if (abreviatura.value == '') {
            errorAbreviatura.textContent = 'ABREVIATURA REQUERIDA';
        } else {
            const url = base_url + 'medidas/registrar';
            insertarRegistros(url, this, tblMedidas, btnAccion, false);
        }
    })
})

// dar de baja a las medidas
function eliminarMedida(idMedida) {
    const url = base_url + 'medidas/eliminar/' + idMedida;
    eliminarRegistros(url, tblMedidas);
}

//editar las medidas
function editarMedida(idMedida) {

    const url = base_url + 'medidas/editar/' + idMedida;
    const http = new XMLHttpRequest();
    http.open('GET', url, true);
    http.send();

    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            //recuperando datos para editar los usuarios
            id.value = res.id;
            nombre.value = res.medida;
            abreviatura.value = res.abreviatura;
            btnAccion.textContent = 'Actualizar';
            firstTab.show()
        }
    }
}