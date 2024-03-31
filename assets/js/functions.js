var firstTabEl = document.querySelector('#nav-tab button:last-child')
var firstTab = new bootstrap.Tab(firstTabEl)

var primerTabEl = document.querySelector('#nav-tab button:first-child')
var primerTab = new bootstrap.Tab(primerTabEl)


function insertarRegistros(url, idForm, tbl, idBoton, accion) {
    //crear formData
    const data = new FormData(idForm);
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
                if (accion) {
                    clave.removeAttribute('readonly');
                }
                if (tbl != null) {
                    document.querySelector('#id').value = '';
                    idBoton.textContent = 'Registrar';
                    idForm.reset();
                    tbl.ajax.reload();
                    primerTab.show();
                }
            }
        }

    }
}

function eliminarRegistros(url, tbl, titulo, texto) {
    Swal.fire({
        title: titulo,
        text: texto,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Desactivar'
    }).then((result) => {
        if (result.isConfirmed) {
            const http = new XMLHttpRequest(); //creando instancia de XMLHTTPREQUEST
            http.open('GET', url, true); //abriendo una conexion
            http.send();
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
                        tbl.ajax.reload();
                    }
                }
            }
        }
    })
}
function restaurarRegistros(url, tbl) {
    Swal.fire({
        title: '¿Deseas restaurar el registro?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Restaurar!'
    }).then((result) => {
        if (result.isConfirmed) {
            const http = new XMLHttpRequest(); //creando instancia de XMLHTTPREQUEST
            http.open('GET', url, true); //abriendo una conexion
            http.send();
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
                        tbl.ajax.reload();
                    }
                }
            }
        }
    })
}

function alertaPersonalizada(type, msg) {
    Swal.fire({
        toast: true,
        position: 'top',
        icon: type,
        title: msg,
        showConfirmButton: false,
        timer: 2000
    })
}