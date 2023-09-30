let tblClientes, editorDireccion;
const form = document.querySelector('#form');
const btnAccion = document.querySelector('#btnAccion');
const btnNuevo = document.querySelector('#btnNuevo');

const identidad = document.querySelector('#identidad');
const num_identidad = document.querySelector('#num_identidad');
const nombre = document.querySelector('#nombre');
const telefono = document.querySelector('#telefono');
const correo = document.querySelector('#correo');
const direccion = document.querySelector('#direccion');
const id = document.querySelector('#id');

const errorIdentidad = document.querySelector('#errorIdentidad');
const errorNumIdentidad = document.querySelector('#errorNumIdentidad');
const errorNombre = document.querySelector('#errorNombre');
const errorTelefono = document.querySelector('#errorTelefono');
const errorDireccion = document.querySelector('#errorDireccion');


document.addEventListener('DOMContentLoaded', function () {
    tblClientes = $('#tblClientes').DataTable({
        ajax: {
            url: base_url + 'clientes/listar', //llamando al metodo del controlador clientes
            dataSrc: ''
        },
        columns: [ //campos en la db
            { data: 'identidad' },
            { data: 'num_identidad' },
            { data: 'nombre' },
            { data: 'telefono' },
            { data: 'correo' },
            { data: 'direccion' },
            { data: 'acciones' } //accion en el controlador clientes
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
    
    //limpiar campos
    btnNuevo.addEventListener('click', function () {
        id.value = '';
        btnAccion.textContent = 'Registrar';
        editorDireccion.setData('');
        form.reset();
    })
    //registrar clientes
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        errorIdentidad.textContent = '';
        errorNumIdentidad.textContent = '';
        errorNombre.textContent = '';
        errorTelefono.textContent = '';
        errorDireccion.textContent = '';

        if (identidad.value == '') {
            errorIdentidad.textContent = "IDENTIDAD REQURIDA";
        } else if (num_identidad.value == '') {
            errorNumIdentidad.textContent = "NUMERO DE IDENTIDAD REQURIDO";
        }
        else if (nombre.value == '') {
            errorNombre.textContent = "NOMBRE REQURIDO";
        } else if (telefono.value == '') {
            errorTelefono.textContent = "TELEFONO REQURIDO";
        } else if (direccion.value == '') {
            errorDireccion.textContent = "LA DIRECCION ES REQURIDA";
        } else {
            const url = base_url + 'clientes/registrar';
            insertarRegistros(url, this, tblClientes, btnAccion, false);
            editorDireccion.setData('');
        }
    })
})

function eliminarCliente(idCliente) {
    const url = base_url + 'clientes/eliminar/' + idCliente;
    const titulo = '¿Estás seguro que deseas desactivar el cliente?';
    const texto = 'El cliente cambiará su estado a inactivo';
    eliminarRegistros(url, tblClientes, titulo, texto);
}

function editarCliente(idCliente) {
    const url = base_url + 'clientes/editar/' + idCliente;
    const http = new XMLHttpRequest();
    http.open('GET', url, true);
    http.send();

    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            //recuperando datos para editar los usuarios
            id.value = res.id;
            identidad.value = res.identidad;
            num_identidad.value = res.num_identidad;
            nombre.value = res.nombre;
            telefono.value = res.telefono;
            correo.value = res.correo;
            editorDireccion.setData(res.direccion);
            btnAccion.textContent = 'Actualizar';
            firstTab.show()
        }
    }
}