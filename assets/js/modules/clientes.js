const form = document.querySelector('#form');
const identidad = document.querySelector('#identidad');
const num_identidad = document.querySelector('#num_identidad');
const nombre = document.querySelector('#nombre');
const telefono = document.querySelector('#telefono');
const direccion = document.querySelector('#direccion');
const id = document.querySelector('#id');
const errorIdentidad = document.querySelector('#errorIdentidad');
const errorNumIdentidad = document.querySelector('#errorNumIdentidad');
const errorNombre = document.querySelector('#errorNombre');
const errorTelefono = document.querySelector('#errorTelefono');
const errorCorreo = document.querySelector('#errorCorreo');
const errorDireccion = document.querySelector('#errorDireccion');
const btnNuevo = document.querySelector('#btnNuevo');

let tblClientes, editorDireccion;

document.addEventListener('DOMContentLoaded', function () {
    // Inicializar DataTable y CKEditor
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

    btnNuevo.addEventListener('click', function () {
        id.value = '';
        btnAccion.textContent = 'Registrar';
        editorDireccion.setData('');
        form.reset();
        limpiarCampos();
    });
    num_identidad.addEventListener('keypress', handleEnterKeyPress);
    form.addEventListener('submit', handleSubmit);
});


// Función para validar número de identidad
function validarNumIdentidad(numIdentidad, tipoIdentidad) {
    const numIdentidadRegex = /^[0-9]+$/;
    const esNacional = tipoIdentidad === 'Nacional';

    if (!numIdentidadRegex.test(numIdentidad)) {
        return "El número de identidad debe contener solo dígitos numéricos.";
    }

    if ((esNacional && numIdentidad.length !== 9) || (!esNacional && numIdentidad.length !== 12)) {
        return `La cédula ${esNacional ? 'nacional' : 'extranjera'} debe contener ${esNacional ? '9' : '12'} dígitos numéricos.`;
    }

    return null;
}

// lógica cuando se presiona enter para consultar la API
function handleEnterKeyPress(event) {
    if (event.key === 'Enter') {
        event.preventDefault();
        const numIdentidad = num_identidad.value;
        const apiUrl = `https://apis.gometa.org/cedulas/${numIdentidad}`;
        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                if (data.results && data.results.length > 0) {
                    const nombreCompleto = data.results[0].fullname;
                    nombre.value = nombreCompleto;
                } else {
                    nombre.value = "No se encontraron resultados para la identificación proporcionada";
                }
            })
            .catch(error => {
                console.error("Error al consultar la API:", error);
                nombre.value = "Error al consultar la API.";
            });
    }
}

// Función para manejar la lógica cuando se envía el formulario
function handleSubmit(event) {
    event.preventDefault();
    limpiarCampos();
    const tipoIdentidadValue = identidad.value;
    const numIdentidadValue = num_identidad.value.trim();
    const numIdentidadError = validarNumIdentidad(numIdentidadValue, tipoIdentidadValue);

    // Validar que se haya seleccionado una identidad
    if (tipoIdentidadValue === '') {
        errorIdentidad.textContent = "Debes seleccionar un tipo de identidad.";
        return;
    }

    // Validar el número de identidad si hay un error
    if (numIdentidadError) {
        errorNumIdentidad.textContent = numIdentidadError;
        return;
    }

    // Validar los demás campos
    if (nombre.value.trim() === '') {
        errorNombre.textContent = "NOMBRE REQUERIDO";
        return;
    } else if (telefono.value.trim() === '') {
        errorTelefono.textContent = "TELÉFONO REQUERIDO";
        return;
    } else if (direccion.value.trim() === '') {
        errorDireccion.textContent = "LA DIRECCIÓN ES REQUERIDA";
        return;
    }

    // Si pasa todas las validaciones, continuar con el envío del formulario
    const url = base_url + 'clientes/registrar';
    insertarRegistros(url, form, tblClientes, btnAccion, false);
    editorDireccion.setData('');
}

// funciones para eliminar y editar registros de clientes
function eliminarCliente(idCliente) {
    const url = base_url + 'clientes/eliminar/' + idCliente;
    const titulo = '¿Estás seguro que deseas desactivar el cliente?';
    const texto = 'El cliente cambiará su estado a inactivo';
    eliminarRegistros(url, tblClientes, titulo, texto);
}

function editarCliente(idCliente) {
    limpiarCampos();
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

// Función para limpiar campos
function limpiarCampos() {
    errorIdentidad.textContent = '';
    errorNumIdentidad.textContent = '';
    errorNombre.textContent = '';
    errorTelefono.textContent = '';
    errorCorreo.textContent = '';
    errorDireccion.textContent = '';
}