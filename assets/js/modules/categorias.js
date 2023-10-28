let tblCategorias;
const form = document.querySelector('#form');
const id = document.querySelector('#id');
const nombre = document.querySelector('#nombre');
const errorNombre = document.querySelector('#errorNombre');
const btnAccion = document.querySelector('#btnAccion');
const btnNuevo = document.querySelector('#btnNuevo');

document.addEventListener('DOMContentLoaded', function () {
    tblCategorias = $('#tblCategorias').DataTable({
        ajax: {
            url: base_url + 'categorias/listar', //llamando al metodo del controlador categorias
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
    btnNuevo.addEventListener('click', function()
    {
      id.value = '';
      errorNombre.textContent = '';
      btnAccion.textContent = 'Registrar';
      form.reset();
    })
    //registro de categorias
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        errorNombre.textContent = '';
        if (nombre.value == '') {
            errorNombre.textContent = 'NOMBRE REQUERIDO';
        } else {
            const url = base_url + 'categorias/registrar';
            insertarRegistros(url, this, tblCategorias, btnAccion, false);
        }
    })
})

function eliminarCategoria(idCategoria) {
    const url = base_url + 'categorias/eliminar/' + idCategoria;
    const titulo = '¿Estás seguro que deseas desactivar esta categoría?';
    const texto = 'La categoría cambiará su estado a inactiva';
    eliminarRegistros(url, tblCategorias, titulo, texto);
}

function editarCategoria (idCategoria) {
    errorNombre.textContent = '';
    const url = base_url + 'categorias/editar/' + idCategoria;
    const http = new XMLHttpRequest();
    http.open('GET', url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            //recuperando datos para editar los usuarios
            id.value = res.id;
            nombre.value = res.categoria;
            btnAccion.textContent = 'Actualizar';
            firstTab.show()
        }
    }
}