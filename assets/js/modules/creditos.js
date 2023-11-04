let tblCreditos, tblAbonos;
const idCredito = document.querySelector('#idCredito');
const cliente = document.querySelector('#buscarCliente');
const telefonoCliente = document.querySelector('#telefonoCliente');
const clienteDireccion = document.querySelector('#clienteDireccion');
const abonado = document.querySelector('#abonado');
const restante = document.querySelector('#restante');
const fecha = document.querySelector('#fecha');
const monto_total = document.querySelector('#monto_total');
const monto_abonar = document.querySelector('#monto_abonar');

const btnAccion = document.querySelector('#btnAccion');
const nuevoAbono = document.querySelector('#nuevoAbono');

const modalAbono = new bootstrap.Modal('#modalAbono');

//para filtrar por fechas
const desde = document.querySelector('#desde');
const hasta = document.querySelector('#hasta');

document.addEventListener('DOMContentLoaded', function () {
    tblCreditos = $('#tblCreditos').DataTable({
        ajax: {
            url: base_url + 'creditos/listar',
            dataSrc: ''
        },
        columns: [ //campos en la db
            { data: 'fecha' },
            { data: 'nombre' },
            { data: 'monto' },
            { data: 'restante' },
            { data: 'abonado' },
            { data: 'venta' },
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

    //autocomplete clientes
    $("#buscarCliente").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: base_url + 'creditos/buscar',
                dataType: "json",
                data: {
                    term: request.term
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        minLength: 2,
        select: function (event, ui) {
            telefonoCliente.value = ui.item.telefono;
            clienteDireccion.innerHTML = ui.item.direccion;
            idCredito.value = ui.item.id;
            abonado.value = ui.item.abonado;
            restante.value = ui.item.restante;
            monto_total.value = ui.item.monto;
            fecha.value = ui.item.fecha;
            monto_abonar.focus();
        }
    });

    //levantar el modal abono
    nuevoAbono.addEventListener('click', function () {
        idCredito.value = '';
        telefonoCliente.value = '';
        cliente.value = '';
        clienteDireccion.innerHTML = '';
        abonado.value = '';
        restante.value = '';
        monto_total.value = '';
        monto_abonar.value = '';
        fecha.value = '';
        modalAbono.show();
    })

    btnAccion.addEventListener('click', function () {
        if (monto_abonar.value == '') {
            alertaPersonalizada('warning', 'INGRESE EL MONTO ABONAR');
        } else if (idCredito.value == '' && cliente.value == '' && telefonoCliente.value == '') {
            alertaPersonalizada('warning', 'SELECCIONE UN CLIENTE');
        } else if (parseFloat(restante.value) < parseFloat(monto_abonar.value)) {
            alertaPersonalizada('warning', 'EL MONTO A ABONAR ES MAYOR AL RESTANTE');
        } else {
            const url = base_url + 'creditos/registrarAbono';
            const http = new XMLHttpRequest();
            http.open('POST', url, true);
            http.send(JSON.stringify({
                idCredito: idCredito.value,
                monto_abonar: monto_abonar.value
            }));

            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    alertaPersonalizada(res.type, res.msg);
                    if (res.type == 'success') {
                        modalAbono.hide();
                        tblCreditos.ajax.reload();
                        setTimeout(() => {
                            const ruta = base_url + 'creditos/reporte/' + idCredito.value;
                            window.open(ruta, '_blank');
                        }, 1000);
                    }
                }
            }
        }
    })

    tblAbonos = $('#tblAbonos').DataTable({
        ajax: {
            url: base_url + 'creditos/listarAbonos',
            dataSrc: ''
        },
        columns: [ //campos en la db
            { data: 'fecha' },

            { data: 'abono' },
            { data: 'credito' }

        ],
        language: {
            url: base_url + 'assets/js/spanish.json'
        },
        dom,
        buttons,
        responsive: true,
        order: [[0, 'asc']]
    });

    //filtro rango de fechas
    desde.addEventListener('change', function () {
        tblCreditos.draw();
    })
    hasta.addEventListener('change', function () {
        tblCreditos.draw();
    })

    $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
            var FilterStart = desde.value;
            var FilterEnd = hasta.value;
            var DataTableStart = data[0].trim();
            var DataTableEnd = data[0].trim();
            if (FilterStart == '' || FilterEnd == '') {
                return true;
            }
            if (DataTableStart >= FilterStart && DataTableEnd <= FilterEnd) {
                return true;
            } else {
                return false;
            }
        });
});