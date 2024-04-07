const tblNuevaVenta = document.querySelector('#tblNuevaVenta tbody');

const idCliente = document.querySelector('#idCliente');
const telefonoCliente = document.querySelector('#telefonoCliente');
const clienteDireccion = document.querySelector('#clienteDireccion');

const metodo = document.querySelector('#metodo');
const impresion_directa = document.querySelector('#impresion_directa');
const errorCliente = document.querySelector('#errorCliente');

document.addEventListener('DOMContentLoaded', function () {
    //cargar productos del localStorage
    mostrarProducto();

    //autocomplete clientes
    $("#buscarCliente").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: base_url + 'clientes/buscar',
                dataType: "json",
                data: {
                    term: request.term
                },
                success: function (data) {
                    response(data);
                    if (data.length > 0) {
                        errorCliente.textContent = '';
                    } else {
                        errorCliente.textContent = 'CLIENTE NO ENCONTRADO';
                    }
                }
            });
        },
        minLength: 2,
        select: function (event, ui) {
            telefonoCliente.value = ui.item.telefono;
            clienteDireccion.innerHTML = ui.item.direccion;
            idCliente.value = ui.item.id;
        }
    });

    //completar venta
    btnAccion.addEventListener('click', function () {
        let filas = document.querySelectorAll('#tblNuevaVenta tr').length;
        if (filas < 2) {
            alertaPersonalizada('warning', 'CARRITO VACIO');
            return;
        } else if (idCliente.value == ''
            && telefonoCliente.value == '') {
            alertaPersonalizada('warning', 'CLIENTE REQUERIDO');
            return;
        } else if (metodo.value == '') {
            alertaPersonalizada('warning', 'METODO DE PAGO REQUERIDO');
            return;
        } else {
            const url = base_url + 'ventas/registrarVenta';
            //hacer una instancia del objeto XMLHttpRequest
            const http = new XMLHttpRequest();
            //Abrir una Conexion - POST - GET
            http.open('POST', url, true);
            //Enviar Datos
            http.send(JSON.stringify({
                productos: listaCarrito,
                idCliente: idCliente.value,
                metodo: metodo.value,
                //impresion: impresion_directa.checked
            }));
            //verificar estados
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    console.log(this.responseText);
                    alertaPersonalizada(res.type, res.msg);
                    if (res.type == 'success') {
                        localStorage.removeItem(nombreKey);
                        setTimeout(() => {
                            Swal.fire({
                                title: '¿Desea Generar Reporte?',
                                showDenyButton: true,
                                showCancelButton: true,
                                confirmButtonText: 'Ticked',
                                denyButtonText: `Factura`,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    const ruta = base_url + 'ventas/reporte/ticked/' + res.idVenta;
                                    window.open(ruta, '_blank');
                                } else if (result.isDenied) {
                                    const ruta = base_url + 'ventas/reporte/factura/' + res.idVenta;
                                    window.open(ruta, '_blank');
                                }
                                window.location.reload();
                            })
                        }, 2000);
                    }
                }
            }
        }
    })

    //cargar datos con el plugin datatables
    tblHistorial = $('#tblHistorial').DataTable({
        ajax: {
            url: base_url + 'ventas/listar',
            dataSrc: ''
        },
        columns: [
            { data: 'fecha' },
            {
                data: 'hora',
                render: function (data) {
                    // Formatear la hora utilizando moment.js en formato de 12 horas
                    return moment(data, 'HH:mm:ss').format('hh:mm A');
                }
            },

            {
                data: 'total',
                render: function (data, type, row) {
                    return '₡' + parseFloat(data).toFixed(2);
                }
            },
            { data: 'nombre' },
            { data: 'serie' },
            { data: 'metodo' },
            { data: 'acciones' }
        ],
        language: {
            url: base_url + 'assets/js/spanish.json'
        },
        dom,
        buttons,
        responsive: true,
        order: [[4, 'desc']],
    });
});

//cargar productos
function mostrarProducto() {
    let subtotal = 0;
    if (localStorage.getItem(nombreKey) != null) {
        const url = base_url + 'productos/mostrarDatos';
        const http = new XMLHttpRequest();
        http.open('POST', url, true);
        http.send(JSON.stringify(listaCarrito));
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                let html = '';
                if (res.productos.length > 0) {
                    res.productos.forEach(producto => {
                        const precioVenta = parseFloat(producto.precio_venta);
                        const cantidad = parseInt(producto.cantidad);
                        const subTotalProducto = precioVenta * cantidad;

                        html += `<tr>
                            <td>${producto.nombre}</td>
                            <td>₡ ${precioVenta.toFixed(2)}</td>
                            <td width="100">
                                <input type="number" class="form-control inputCantidad" data-id="${producto.id}" value="${cantidad}" placeholder="Cantidad">
                            </td>
                            <td>₡ ${subTotalProducto.toFixed(2)}</td>
                            <td class="text-center"><button class="btn btn-danger btnEliminar" data-id="${producto.id}" type="button"><i class="fas fa-trash"></i></button></td>
                        </tr>`;
                        subtotal += subTotalProducto;
                    });

                    const iva = subtotal * 0.13;
                    const total = subtotal + iva;
                    tblNuevaVenta.innerHTML = html;
                    subtotalPagar.value = subtotal.toFixed(2);
                    totalPagar.value = total.toFixed(2);

                    btnEliminarProducto();
                    agregarCantidad();
                } else {
                    tblNuevaVenta.innerHTML = '';
                }
            }
        }
    } else {
        tblNuevaVenta.innerHTML = `<tr>
            <td colspan="4" class="text-center">CARRITO VACIO</td>
        </tr>`;
    }
    subtotalPagar.value = '0.00';
    totalPagar.value = '0.00';
}

function verReporte(idVenta) {
    Swal.fire({
        title: '¿Desea Generar Reporte?',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Ticked',
        denyButtonText: `Factura`,
    }).then((result) => {
        if (result.isConfirmed) {
            const ruta = base_url + 'ventas/reporte/ticked/' + idVenta;
            window.open(ruta, '_blank');
        } else if (result.isDenied) {
            const ruta = base_url + 'ventas/reporte/factura/' + idVenta;
            window.open(ruta, '_blank');
        }
    })
}

function anularVenta(idVenta) {
    Swal.fire({
        title: '¿Está seguro de anular la venta?',
        text: "El stock de los productos cambiarán!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Anular!'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + 'ventas/anular/' + idVenta;
            //hacer una instancia del objeto XMLHttpRequest
            const http = new XMLHttpRequest();
            //Abrir una Conexion - POST - GET
            http.open('GET', url, true);
            //Enviar Datos
            http.send();
            //verificar estados
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    alertaPersonalizada(res.type, res.msg);
                    if (res.type == 'success') {
                        tblHistorial.ajax.reload();
                    }
                }
            }
        }
    })
}