const inputBuscarCodigo = document.querySelector('#buscarProductoCodigo');
const inputBuscarNombre = document.querySelector('#buscarProductoNombre');
const barcode = document.querySelector('#barcode');
const nombre = document.querySelector('#nombre');
const containerCodigo = document.querySelector('#containerCodigo');
const containerNombre = document.querySelector('#containerNombre');

const tblNuevaCompra = document.querySelector('#tblNuevaCompra tbody');
const totalPagar = document.querySelector('#totalPagar');
const serie = document.querySelector('#serie');

//provedores
const telefonoProveedor = document.querySelector('#telefonoProveedor');
const direccionProveedor = document.querySelector('#proveedorDireccion');
const idProveedor = document.querySelector('#idProveedor');

const btnAccion = document.querySelector('#btnAccion');
const desde = document.querySelector('#desde');
const hasta = document.querySelector('#hasta');

let listaCarrito, tblHistorial;

document.addEventListener('DOMContentLoaded', function () {
    //comprobar si ya hay productos en localStorage
    if (localStorage.getItem('posCompra') != null) {
        listaCarrito = JSON.parse(localStorage.getItem('posCompra'));
    }
    //mostrar input para la busqueda por nombre
    nombre.addEventListener('click', function () {
        containerCodigo.classList.add('d-none');
        containerNombre.classList.remove('d-none');
        inputBuscarNombre.value = '';
        inputBuscarNombre.focus();
    })
    //mostrar input para la busqueda por codigo
    barcode.addEventListener('click', function () {
        containerNombre.classList.add('d-none');
        containerCodigo.classList.remove('d-none');
        inputBuscarCodigo.value = '';
        inputBuscarCodigo.focus();
    })

    inputBuscarCodigo.addEventListener('keyup', function (e) {
        if (e.keyCode === 13) {
            buscarProducto(e.target.value);
        }
        return;
    })
    //autocomplete productos
    $("#buscarProductoNombre").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: base_url + 'productos/buscarPorNombre',
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
            agregarProducto(ui.item.id, 1);
            inputBuscarNombre.value = '';
            inputBuscarNombre.focus();
            return false;
        }
    });

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
            serie.focus();
        }
    });

    // cargar datos
    mostrarProducto();

    //completar compra
    btnAccion.addEventListener('click', function () {
        let filas = document.querySelectorAll('#tblNuevaCompra tr').length;
        if (filas < 2) {
            alertaPersonalizada('warning', 'CARRITO VACIO');
            return;
        } else if (idProveedor.value == '' && telefonoProveedor.value == '') {
            alertaPersonalizada('warning', 'PROVEEDOR REQUERIDO');
            return;
        } else if (serie.value == '') {
            alertaPersonalizada('warning', 'SERIE REQUERIDA');
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
                serie: serie.value,
            }));
            //verificar estados
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    alertaPersonalizada(res.type, res.msg);
                    if (res.type == 'success') {
                        localStorage.removeItem('posCompra');
                        setTimeout(() => {
                            Swal.fire({
                                title: '¿Desea generar reporte?',
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
                        }, 1000);
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
            { data: 'hora' },
            { data: 'total' },
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

function buscarProducto(valor) {
    const url = base_url + 'productos/buscarPorCodigo/' + valor;
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
            agregarProducto(res.id, 1);
            inputBuscarCodigo.value = '';
            inputBuscarCodigo.focus();
        }
    }
}

// //agregar productos a localStorage
function agregarProducto(idProducto, cantidad) {
    if (localStorage.getItem('posCompra') == null) {
        listaCarrito = [];
    } else {
        for (let i = 0; i < listaCarrito.length; i++) {
            if (listaCarrito[i]['id'] == idProducto) {
                listaCarrito[i]['cantidad'] = parseInt(listaCarrito[i]['cantidad'] + 1);
                localStorage.setItem('posCompra', JSON.stringify(listaCarrito));
                alertaPersonalizada('success', 'PRODUCTO AGREGADO');
                mostrarProducto();
                return;
            }

        }
    }
    listaCarrito.push({
        id: idProducto,
        cantidad: cantidad
    })
    localStorage.setItem('posCompra', JSON.stringify(listaCarrito));
    alertaPersonalizada('success', 'PRODUCTO AGREGADO');
    mostrarProducto();
}

// //cargar productos
function mostrarProducto() {
    if (localStorage.getItem('posCompra') != null) {
        const url = base_url + 'productos/mostrarDatos';
        //hacer una instancia del objeto XMLHttpRequest
        const http = new XMLHttpRequest();
        //Abrir una Conexion - POST - GET
        http.open('POST', url, true);
        //Enviar Datos
        http.send(JSON.stringify(listaCarrito));
        //verificar estados
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                let html = '';
                if (res.productos.length > 0) {
                    res.productos.forEach(producto => {
                        html += `<tr>
                            <td>${producto.nombre}</td>
                            <td>${producto.precio_compra}</td>
                            <td width="100">
                            <input type="number" class="form-control inputCantidad" data-id="${producto.id}" value="${producto.cantidad}" placeholder="Cantidad">
                            </td>
                            <td>${producto.subTotal}</td>
                            <td><button class="btn btn-danger btnEliminar" data-id="${producto.id}" type="button"><i class="fas fa-trash"></i></button></td>
                        </tr>`;
                    });
                    tblNuevaCompra.innerHTML = html;
                    totalPagar.value = res.total;
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
}
// //agregar evento click para eliminar
function btnEliminarProducto() {
    let lista = document.querySelectorAll('.btnEliminar');
    for (let i = 0; i < lista.length; i++) {
        lista[i].addEventListener('click', function () {
            let idProducto = lista[i].getAttribute('data-id');
            eliminarProducto(idProducto);
        });
    }
}

// eliminar productos del table
function eliminarProducto(idProducto) {
    for (let i = 0; i < listaCarrito.length; i++) {
        if (listaCarrito[i]['id'] == idProducto) {
            listaCarrito.splice(i, 1);
        }
    }
    localStorage.setItem('posCompra', JSON.stringify(listaCarrito));
    alertaPersonalizada('success', 'PRODUCTO ELIMINADO');
    mostrarProducto();
}

//para cambiar la cantidad con evento change
function agregarCantidad() {
    let lista = document.querySelectorAll('.inputCantidad');
    for (let i = 0; i < lista.length; i++) {
        lista[i].addEventListener('change', function () {
            let idProducto = lista[i].getAttribute('data-id');
            let cantidad = lista[i].value;
            cambiarCantidad(idProducto, cantidad);
        });
    }
}

function cambiarCantidad(idProducto, cantidad) {
    for (let i = 0; i < listaCarrito.length; i++) {
        if (listaCarrito[i]['id'] == idProducto) {
            listaCarrito[i]['cantidad'] = cantidad;
        }
    }
    localStorage.setItem('posCompra', JSON.stringify(listaCarrito));
    mostrarProducto();
}

function verReporte(idCompra) {
    Swal.fire({
        title: '¿Desea generar reporte?',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Ticked',
        denyButtonText: `Factura`,
    }).then((result) => {
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