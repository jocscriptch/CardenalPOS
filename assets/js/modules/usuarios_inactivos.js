let tblUsuarios;

document.addEventListener('DOMContentLoaded', function() {
    
     //cargar datos con el pluggin datatables
     tblUsuarios = $('#tblUsuarios').DataTable({
        ajax: {
            url: base_url + 'usuarios/listarInactivos',
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
})

//funcion restaurar usuario
function restaurarUsuario(idUsuario) {
    Swal.fire({
        title: '¿Deseas restaurar el registro?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Restaurar!'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + 'usuarios/restaurar/' + idUsuario;

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
                        tblUsuarios.ajax.reload();
                    }
                }

            }
        }
    })
}