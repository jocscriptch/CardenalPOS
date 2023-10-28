const form = document.querySelector('#form');
const btnAccion = document.querySelector('#btnAccion');
const btnNuevo = document.querySelector('#btnNuevo');
const nombre = document.querySelector('#nombre');
const telefono = document.querySelector('#telefono');
const correo = document.querySelector('#correo');
const direccion = document.querySelector('#direccion');
const id = document.querySelector('#id');
const errorNombre = document.querySelector('#errorNombre');
const errorTelefono = document.querySelector('#errorTelefono');
const errorCorreo = document.querySelector('#errorCorreo');
const errorDireccion = document.querySelector('#errorDireccion');
let tblProveedores, editorDireccion;

document.addEventListener('DOMContentLoaded', function () {

    // Inicializar DataTable y CKEditor
    tblProveedores = $('#tblProveedores').DataTable({
        ajax: {
            url: base_url + 'proveedor/listar', //llamando al metodo del controlador proveedor
            dataSrc: ''
        },
        columns: [ //campos en la db
            { data: 'nombre' },
            { data: 'telefono' },
            { data: 'correo' },
            { data: 'direccion' },
            { data: 'acciones' } //accion en el controlador proveedor
        ],
        language: {
            url: base_url + 'assets/js/spanish.json'
        },
        dom,
        buttons,
        responsive: true,
        order: [[0, 'asc']]
    });

    // inicializando el ckeditor
    ClassicEditor
        .create(document.querySelector('#direccion'), {
            toolbar: {
                items: [
                    'selectAll', '|',
                    'heading', '|',
                    'bold', 'italic',
                    'outdent', 'indent', '|',
                    'undo', 'redo',
                    'alignment', '|',
                    'link', 'blockQuote', 'insertTable', 'mediaEmbed'
                ],
                shouldNotGroupWhenFull: true
            },
        })
        .then(editor => {
            editorDireccion = editor;
        })
        .catch(error => {
            console.error(error);
        });

    btnNuevo.addEventListener('click', function () {
        id.value = '';
        btnAccion.textContent = 'Registrar';
        editorDireccion.setData('');
        form.reset();
        limpiarCampos();
    });

    //registrar proveedor
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        limpiarCampos();

        if (nombre.value == '') {
            errorNombre.textContent = 'NOMBRE REQUERIDO';
            return;
        } else if (telefono.value == '') {
            errorTelefono.textContent = 'TELEFONO REQUERIDO';
            return;
        } else if (correo.value == '') {
            errorCorreo.textContent = 'CORREO REQUERIDO';
            return;
        } else if (direccion.value == '') {
            errorDireccion.textContent = 'DIRECCION REQUERIDA';
            return;
        } else {
            const url = base_url + 'proveedor/registrar';
            insertarRegistros(url, this, tblProveedores, btnAccion, false);
        }
    });
});

function eliminarProveedor(idProveedor) {
    const url = base_url + 'proveedor/eliminar/' + idProveedor;
    const titulo = '¿Estás seguro que deseas desactivar el proveedor?';
    const texto = 'El proveedor cambiará su estado a inactivo';
    eliminarRegistros(url, tblProveedores, titulo, texto);
}

function editarProveedor(idProveedor) {
    limpiarCampos();
    const url = base_url + 'proveedor/editar/' + idProveedor;
    const http = new XMLHttpRequest();
    http.open('GET', url, true);
    http.send();

    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            //recuperando datos para editar los usuarios
            id.value = res.id;
            nombre.value = res.nombre;
            telefono.value = res.telefono;
            correo.value = res.correo;
            editorDireccion.setData(res.direccion);
            btnAccion.textContent = 'Actualizar';
            firstTab.show()
        }
    }
}

function limpiarCampos() {
    errorNombre.textContent = '';
    errorTelefono.textContent = '';
    errorCorreo.textContent = '';
    errorDireccion.textContent = '';
}