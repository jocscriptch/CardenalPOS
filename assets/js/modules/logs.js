const btnLimpiar = document.querySelector('#btnLimpiar');
let tbLogs;
document.addEventListener('DOMContentLoaded', function () {
    tbLogs = $('#tbLogs').DataTable({
        ajax: {
            url: base_url + 'admin/listarLogs',
            dataSrc: ''
        },
        columns: [ //campos en la db
            { data: 'evento' },
            { data: 'ip' },
            { data: 'detalle' },
            { data: 'fecha' }
        ],
        language: {
            url: base_url + 'assets/js/spanish.json'
        },
        dom,
        buttons,
        responsive: true,
        order: [[0, 'asc']]
    });

    btnLimpiar.addEventListener('click', function () {
        Swal.fire({
            title: 'Estas seguro de limpiar?',
            text: 'Estas a punto de limpiar los logs de la base de datos, esta accion no se puede deshacer',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminar'
        }).then((result) => {
            if (result.isConfirmed) {
                const url = base_url + 'admin/limpiarLogs';
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
                            tbLogs.ajax.reload();
                        }
                    }
                }
            }
        })
    })
});