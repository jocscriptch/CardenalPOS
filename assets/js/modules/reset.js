const btnEnviar = document.querySelector('#btnEnviar');
const correo = document.querySelector('#email');
document.addEventListener('DOMContentLoaded', function () {
    btnEnviar.addEventListener('click', function () {
        if (correo.value === '') {
            Swal.fire({
                toast: true,
                position: 'top',
                icon: 'warning',
                title: 'Correo requerido',
                showConfirmButton: false,
                timer: 2000
            })
        } else {
            const url = base_url + 'principal/sendEmail/' + correo.value;
            const http = new XMLHttpRequest(); //creando instancia de XMLHTTPREQUEST
            http.open('GET', url, true); //abriendo una conexion
            http.send();
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
                        timer: 4000
                    })
                }
            }
        }
    });
});