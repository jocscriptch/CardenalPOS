const btnCambiar = document.querySelector('#btnCambiar');
const nueva_clave = document.querySelector('#nueva_clave');
const confirm_clave = document.querySelector('#confirm_clave');
const token = document.querySelector('#token');
document.addEventListener('DOMContentLoaded', function () {
    btnCambiar.addEventListener('click', function () {
        if (nueva_clave.value === '' || confirm_clave.value === '') {
            Swal.fire({
                toast: true,
                position: 'top',
                icon: 'warning',
                title: 'Todos los campos con * son requeridos',
                showConfirmButton: false,
                timer: 2000
            })
        } else {
            if (nueva_clave.value !== confirm_clave.value) {
                Swal.fire({
                    toast: true,
                    position: 'top',
                    icon: 'warning',
                    title: 'Las contraseñas no coinciden',
                    showConfirmButton: false,
                    timer: 2000
                })
            } else {
                const url = base_url + 'principal/resetPassword';
                const http = new XMLHttpRequest(); //creando instancia de XMLHTTPREQUEST
                http.open('POST', url, true); //abriendo una conexion
                http.send(JSON.stringify({ nueva_clave: nueva_clave.value, confirm_clave: confirm_clave.value, token: token.value }));
                //verificar estados
                http.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        console.log(this.responseText);
                        const res = JSON.parse(this.responseText);
                        Swal.fire({
                            toast: true,
                            position: 'top',
                            icon: res.type,
                            title: res.msg,
                            showConfirmButton: false,
                            timer: 3000
                        })
                        if (res.type === 'success') {
                            setTimeout(() => {
                                window.location.href = base_url;
                            }, 4000);
                        }
                    }
                }
            }
        }
    });
});