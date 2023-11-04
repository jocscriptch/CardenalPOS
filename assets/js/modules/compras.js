const tblNuevaCompra = document.querySelector('#tblNuevaCompra tbody');
//provedores
const telefonoProveedor = document.querySelector('#telefonoProveedor');
const direccionProveedor = document.querySelector('#proveedorDireccion');
const idProveedor = document.querySelector('#idProveedor');

document.addEventListener('DOMContentLoaded', function () {
    //autocomplete proveedores
    $("#buscarProveedor").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: base_url + 'proveedor/buscar',
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
            telefonoProveedor.value = ui.item.telefono;
            direccionProveedor.innerHTML = ui.item.direccion;
            idProveedor.value = ui.item.id;
            //serie.focus();
        }
    });

    //cargar datos
    mostrarProducto();

    //completar compra
    btnAccion.addEventListener('click', function () {
        let filas = document.querySelectorAll('#tblNuevaCompra tr').length;
        if (filas < 2) {
            alertaPersonalizada('warning', 'CARRITO VACIO');
            return;
        } else if (idProveedor.value == ''
            && telefonoProveedor.value == '') {
            alertaPersonalizada('warning', 'PROVEEDOR REQUERIDO');
            return;
        } else {
            const url = base_url + 'compras/registrarCompra';
            //hacer una instancia del objeto XMLHttpRequest
            const http = new XMLHttpRequest();
            //Abrir una Conexion - POST - GET
            http.open('POST', url, true);
            //Enviar Datos
            http.send(JSON.stringify({
                productos: listaCarrito,
                idProveedor: idProveedor.value,
                //serie: serie.value,
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
                                    const ruta = base_url + 'compras/reporte/ticked/' + res.idCompra;
                                    window.open(ruta, '_blank');
                                } else if (result.isDenied) {
                                    const ruta = base_url + 'compras/reporte/factura/' + res.idCompra;
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

    //mostrar historial
    //cargar datos con el plugin datatables
    tblHistorial = $('#tblHistorial').DataTable({
        ajax: {
            url: base_url + 'compras/listar',
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
            { data: 'acciones' },
        ],
        language: {
            url: base_url + 'assets/js/spanish.json'
        },
        dom,
        buttons,
        responsive: true,
        order: [[0, 'asc']],
    });

    //filtro rango de fechas
    desde.addEventListener('change', function () {
        tblHistorial.draw();
    })
    hasta.addEventListener('change', function () {
        tblHistorial.draw();
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
})

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
                        const precioCompra = parseFloat(producto.precio_compra);
                        const cantidad = parseInt(producto.cantidad);
                        const subTotalProducto = precioCompra * cantidad;

                        html += `<tr>
                            <td>${producto.nombre}</td>
                            <td>₡ ${precioCompra.toFixed(2)}</td>
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
                    tblNuevaCompra.innerHTML = html;
                    subtotalPagar.value = subtotal.toFixed(2);
                    totalPagar.value = total.toFixed(2);

                    btnEliminarProducto();
                    agregarCantidad();
                } else {
                    tblNuevaCompra.innerHTML = '';
                }
            }
        }
    } else {
        tblNuevaCompra.innerHTML = `<tr>
            <td colspan="4" class="text-center">CARRITO VACIO</td>
        </tr>`;
    }
    subtotalPagar.value = '0.00';
    totalPagar.value = '0.00';
}

function verReporte(idCompra) {
    Swal.fire({
        title: '¿Desea Generar Reporte?',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Ticked',
        denyButtonText: `Factura`,
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            const ruta = base_url + 'compras/reporte/ticked/' + idCompra;
            window.open(ruta, '_blank');
        } else if (result.isDenied) {
            const ruta = base_url + 'compras/reporte/factura/' + idCompra;
            window.open(ruta, '_blank');
        }
    })
}

function anularCompra(idCompra) {
    Swal.fire({
        title: '¿Está seguro de anular la compra?',
        text: "El stock de los productos cambiarán!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Anular!'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + 'compras/anular/' + idCompra;
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