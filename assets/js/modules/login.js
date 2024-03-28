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
        } else {

            const url = base_url + 'principal/validateLogin';
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
                        position: 'top-right',
                        icon: res.type,
                        title: res.msg,
                        showConfirmButton: false,
                        timer: 3000
                    })
                    if (res.type == 'success') {
                        setTimeout(() => {
                            let timerInterval
                            Swal.fire({
                                title: res.msg,
                                html: 'Rediccionando Usuario <b></b> milisegundos.',
                                timer: 2000,
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading()
                                    const b = Swal.getHtmlContainer().querySelector('b')
                                    timerInterval = setInterval(() => {
                                        b.textContent = Swal.getTimerLeft()
                                    }, 100)
                                },
                                willClose: () => {
                                    clearInterval(timerInterval)
                                }
                            }).then((result) => {
                                /* Read more about handling dismissals below */
                                if (result.dismiss === Swal.DismissReason.timer) {
                                    window.location = base_url + 'admin';
                                }
                            })
                        }, 2000);
                    }
                }
            }
        }
    });
})