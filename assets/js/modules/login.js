const form = document.querySelector('#form');
const email = document.querySelector('#email');
const password = document.querySelector('#password');
const emailError = document.querySelector('#emailError');
const passwordError = document.querySelector('#passwordError');

document.addEventListener('DOMContentLoaded', function () {
    form.addEventListener('submit', function (e) {

        e.preventDefault();
        emailError.textContent = '';
        passwordError.textContent = '';

        
        if (email.value == '') {
            emailError.textContent = 'INGRESE UN CORREO';
        } else if (password.value == '') {
            passwordError.textContent = 'INGRESE LA CONTRASEÑA';
        }else {

        const url = base_url + 'home/validateLogin';
        //crear formData
        const data = new FormData(this);
        const http = new XMLHttpRequest(); //creando instancia de XMLHTTPREQUEST
        http.open('POST', url, true); //abriendo una conexion
        http.send(data); //enviando datos

        //verificar estados
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                if(res.type == 'success'){
                    window.location = base_url + 'admin';
                }
                alert(res.msg);
              }
            }
       }
    });
})