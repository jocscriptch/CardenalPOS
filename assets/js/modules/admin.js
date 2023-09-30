const form = document.querySelector('#form');
const btnAccion = document.querySelector('#btnAccion');

const rut = document.querySelector('#rut');
const nombre = document.querySelector('#nombre');
const telefono = document.querySelector('#telefono');
const direccion = document.querySelector('#direccion');
const email = document.querySelector('#email');

const errorRut = document.querySelector('#errorRut');
const errorNombre = document.querySelector('#errorNombre');
const errorTelefono = document.querySelector('#errorTelefono');
const errorDireccion = document.querySelector('#errorDireccion');
const errorEmail = document.querySelector('#errorEmail');

document.addEventListener('DOMContentLoaded', function () {
    // inicializando el ckeditor
    ClassicEditor
        .create(document.querySelector('#mensaje'), {
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
        .catch(error => {
            console.error(error);
        });

    //actualizar datos de la empresa
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        errorRut.textContent = '';
        errorNombre.textContent = '';
        errorTelefono.textContent = '';
        errorDireccion.textContent = '';
        errorEmail.textContent = '';

        if (rut.value == '') {
            errorRut.textContent = 'RUT REQUERIDO';

        } else if (nombre.value == '') {
            errorNombre.textContent = "NOMBRE REQUERIDO";

        } else if (email.value == '') {
            errorEmail.textContent = "CORREO REQUERIDO";

        } else if (telefono.value == '') {
            errorTelefono.textContent = "TELEFONO REQUERIDO";

        } else if (direccion.value == '') {
            errorDireccion.textContent = "DIRECCION REQUERIDA";

        } else {
            const url = base_url + 'admin/modificar';
            insertarRegistros(url, this, null, btnAccion, false);
        }
    })
})

