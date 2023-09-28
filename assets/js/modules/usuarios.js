let tblUsuarios;
const form = document.querySelector('#form');
const nombres = document.querySelector('#nombres');
const apellidos = document.querySelector('#apellidos');
const email = document.querySelector('#email');
const telefono = document.querySelector('#telefono');
const direccion = document.querySelector('#direccion');
const clave = document.querySelector('#clave');
const rol = document.querySelector('#rol');

const id = document.querySelector('#id');

//para mostrar errores
const errorNombres = document.querySelector('#errorNombres');
const errorApellidos = document.querySelector('#errorApellidos');
const errorEmail = document.querySelector('#errorEmail');
const errorTelefono = document.querySelector('#errorTelefono');
const errorDireccion = document.querySelector('#errorDireccion');
const errorClave = document.querySelector('#errorClave');
const errorRol = document.querySelector('#errorRol');

const btnAccion = document.querySelector('#btnAccion');
const btnNuevo = document.querySelector('#btnNuevo');

document.addEventListener('DOMContentLoaded', function () {

    //cargar datos con el pluggin datatables
    tblUsuarios = $('#tblUsuarios').DataTable({
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
        language: {
            url: base_url + 'assets/js/spanish.json'
        },
        dom,
        buttons,
        responsive: true,
        order: [[0, 'asc']]
    });

    //Limpiar campos
    btnNuevo.addEventListener('click', function () {
        limpiarCampos();
    })

    //registrar usuarios
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        errorNombres.textContent = '';
        errorApellidos.textContent = '';
        errorEmail.textContent = '';
        errorTelefono.textContent = '';
        errorDireccion.textContent = '';
        errorClave.textContent = '';
        errorRol.textContent = '';

        if (nombres.value == '') {
            errorNombres.textContent = 'DEBES INGRESAR EL NOMBRE';

        } else if (apellidos.value == '') {
            errorApellidos.textContent = 'DEBES INGRESAR APELLIDO';

        } else if (email.value == '') {
            errorEmail.textContent = 'DEBES INGRESAR EL CORREO';

        } else if (telefono.value == '') {
            errorTelefono.textContent = 'DEBES INGRESAR EL TELEFONO';

        } else if (direccion.value == '') {
            errorDireccion.textContent = 'DEBES INGRESAR LA DIRECCION';

        } else if (clave.value == '') {
            errorClave.textContent = 'DEBES INGRESAR LA CONTRASEÑA';

        } else if (rol.value == '') {
            errorRol.textContent = 'DEBES INGRESAR EL ROL';

        } else {
            const url = base_url + 'usuarios/registrar';
            insertarRegistros(url, this, tblUsuarios, btnAccion, true);
        }

    })
})

//funcion eliminar usuario
function eliminarUsuario(idUsuario) {
    const url = base_url + 'usuarios/eliminar/' + idUsuario;
    const titulo = '¿Estás seguro que deseas desactivar este usuario?';
    const texto = 'El usuario cambiara su estado a inactivo';
    eliminarRegistros(url,tblUsuarios, titulo, texto);
}

//funcion editar usuario
function editarUsuario(idUsuario) {
    const url = base_url + 'usuarios/editar/' + idUsuario;
    const http = new XMLHttpRequest();
    http.open('GET', url, true);
    http.send();

    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);

            //recuperando datos para editar los usuarios
            id.value = res.id;
            nombres.value = res.nombre;

            apellidos.value = res.apellido;
            email.value = res.correo;
            telefono.value = res.telefono;
            direccion.value = res.direccion;
            rol.value = res.rol;
            clave.value = '0000';
            clave.setAttribute('readonly', 'readonly');
            btnAccion.textContent = 'Actualizar';

            var firstTabEl = document.querySelector('#nav-tab button:last-child')
            var firstTab = new bootstrap.Tab(firstTabEl)
            firstTab.show()
        }
    }
}
function limpiarCampos() {
    id.value = '';
    btnAccion.textContent = 'Registrar';
    clave.removeAttribute('readonly');
    form.reset();
    nombres.focus();
}