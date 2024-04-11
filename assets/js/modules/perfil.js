const nombre = document.querySelector('#nombrePerfil');
const apellido = document.querySelector('#apellidoPerfil');
const correo = document.querySelector('#correoPerfil');
const telefono = document.querySelector('#telefonoPerfil');
const direccion = document.querySelector('#direccionPerfil');
const btnAccion = document.querySelector('#btnGuardarCambios');
const formularioPerfil = document.querySelector('#formularioPerfil');

document.addEventListener('DOMContentLoaded', function () {
    formularioPerfil.addEventListener('submit', function (e) {
        e.preventDefault();
        if (nombre.value == '') {
            alertaPersonalizada('warning', 'NOMBRE REQUERIDO');
        } else if (apellido.value == '') {
            alertaPersonalizada('warning', 'APELLIDO REQUERIDO');
        } else if (correo.value == '') {
            alertaPersonalizada('warning', 'CORREO REQUERIDO');
        } else if (telefono.value == '') {
            alertaPersonalizada('warning', 'TELEFONO REQUERIDO');
        } else if (direccion.value == '') {
            alertaPersonalizada('warning', 'DIRECCION REQUERIDA');
        } else {
            const url = base_url + 'usuarios/modificarDatos';
            //hacer una instancia del objeto XMLHttpRequest
            const http = new XMLHttpRequest();
            //Abrir una Conexion - POST - GET
            http.open('POST', url, true);
            //Enviar Datos
            http.send(new FormData(this));
            //verificar estados
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    alertaPersonalizada(res.type, res.msg);
                    if (res.clave) {
                        setTimeout(() => {
                            window.location = base_url + 'usuarios/salir';
                        }, 1500);
                    }else{
                        setTimeout(() => {
                            window.location = base_url + 'usuarios/perfil';
                        }, 1500);
                    }
                    
                }
            }
        }
    })
})