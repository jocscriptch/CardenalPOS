let tblUsuarios;
const form = document.querySelector('#form');
const nombres = document.querySelector('#nombres');
const apellidos = document.querySelector('#apellidos');
const email = document.querySelector('#email');
const telefono = document.querySelector('#telefono');
const direccion = document.querySelector('#direccion');
const clave = document.querySelector('#clave');
const rol = document.querySelector('#rol');

//para mostrar errores
const errorNombres = document.querySelector('#errorNombres');
const errorApellidos = document.querySelector('#errorApellidos');
const errorEmail = document.querySelector('#errorEmail');
const errorTelefono = document.querySelector('#errorTelefono');
const errorDireccion = document.querySelector('#errorDireccion');
const errorClave = document.querySelector('#errorClave');
const errorRol = document.querySelector('#errorRol');

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

        }else{
                const url = base_url + 'usuarios/registrar';
                //crear formData
                const data = new FormData(this);
                const http = new XMLHttpRequest(); //creando instancia de XMLHTTPREQUEST
                http.open('POST', url, true); //abriendo una conexion
                http.send(data); //enviando datos
    
                //verificar estados
                http.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        const res = JSON.parse(this.responseText);
                        Swal.fire({
                            toast: true,
                            position: 'top',
                            icon: res.type,
                            title: res.msg,
                            showConfirmButton: false,
                            timer: 2000
                          })
                          if (res.type == 'success') {
                            form.reset();
                            tblUsuarios.ajax.reload();
                          }
                    }
                
            }
        }

    })
})