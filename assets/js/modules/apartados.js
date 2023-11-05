const modalApartado = new bootstrap.Modal('#modalApartado');
const modalProcesar = new bootstrap.Modal('#modalProcesar');
const fecha_retiro = document.querySelector('#fecha_retiro');
const fecha_apartado = document.querySelector('#fecha_apartado');
const abono = document.querySelector('#abono');
const color = document.querySelector('#color');

const tblNuevoApartado = document.querySelector('#tblNuevoApartado tbody');

const idCliente = document.querySelector('#idCliente');
const telefonoCliente = document.querySelector('#telefonoCliente');
const direccionCliente = document.querySelector('#direccionCliente');

const idApartado = document.querySelector('#idApartado');
const clienteApartado = document.querySelector('#clienteApartado');
const monto_abonado = document.querySelector('#monto_abonado');
const monto_total = document.querySelector('#monto_total');
const monto_pendiente = document.querySelector('#monto_pendiente');
const btnProcesar = document.querySelector('#btnProcesar');

let total = 0;

document.addEventListener('DOMContentLoaded', function () {
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay'
    },
    locale: 'es',
    events: base_url + 'apartados/listar',
    dateClick: function (info) {
      const fechaActual = document.querySelector('#fechaActual').value;
      if (fechaActual > info.dateStr) {
        alertaPersonalizada('warning', 'FECHA PASADA');
        return;
      } else {
        fecha_apartado.value = info.dateStr;
        fecha_retiro.setAttribute('min', fecha_apartado.value);
        modalApartado.show();
      }

    },
    eventClick: function (info) {
      const url = base_url + 'apartados/verDatos/' + info.event.id;
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
          const totalPendiente = parseFloat(res.total) - parseFloat(res.abono);
          idApartado.value = res.id;
          clienteApartado.value = res.nombre;
          monto_abonado.value = res.abono;
          monto_total.value = res.total;
          monto_pendiente.value = totalPendiente.toFixed(2);
          modalProcesar.show();
        }
      }
    }
  });
  calendar.render();

  btnProcesar.addEventListener('click', function () {
    Swal.fire({
      title: '¿Estás seguro de procesar?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, Procesar!'
    }).then((result) => {
      if (result.isConfirmed) {
        const url = base_url + 'apartados/procesarApartado/' + idApartado.value;
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
            generarPDF(idApartado.value);
            idApartado.value = '';
            modalProcesar.hide();
          }
        }
      }
    })

  })

  //cargar productos de localStorage
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
        }
      });
    },
    minLength: 2,
    select: function (event, ui) {
      telefonoCliente.value = ui.item.telefono;
      direccionCliente.innerHTML = ui.item.direccion;
      idCliente.value = ui.item.id;
    }
  });

  //completar apartado
  btnAccion.addEventListener('click', function () {
    let filas = document.querySelectorAll('#tblNuevoApartado tr').length;
    const totalPagarTabla = total;
    if (filas < 2) {
      alertaPersonalizada('warning', 'CARRITO VACIO');
      return;
    } else if (idCliente.value == ''
      && telefonoCliente.value == '') {
      alertaPersonalizada('warning', 'CLIENTE ES REQUERIDO');
      return;
    } else if (fecha_apartado.value == '') {
      alertaPersonalizada('warning', 'FECHA DE APARTADO REQUERIDA');
      return;
    } else if (fecha_retiro.value == '') {
      alertaPersonalizada('warning', 'FECHA DE RETIRO REQUERIDA');
      return;
    } else if (abono.value == '') {
      alertaPersonalizada('warning', 'MONTO ABONAR REQUERIDO');
      return;
    } else if (abono.value == '' || parseFloat(abono.value) <= 0) {
      alertaPersonalizada('warning', 'MONTO ABONAR DEBE SER MAYOR A 0');
      abono.value = '';
      return;
    } else if (abono.value >= totalPagarTabla) {
      alertaPersonalizada('warning', 'ABONO NO PUEDE SER MAYOR AL TOTAL A PAGAR');
      abono.value = '';
      return;

    } else {
      const url = base_url + 'apartados/registrarApartado';
      //hacer una instancia del objeto XMLHttpRequest
      const http = new XMLHttpRequest();
      //Abrir una Conexion - POST - GET
      http.open('POST', url, true);
      //Enviar Datos
      http.send(JSON.stringify({
        productos: listaCarrito,
        idCliente: idCliente.value,
        fecha_apartado: fecha_apartado.value,
        fecha_retiro: fecha_retiro.value,
        abono: abono.value,
        color: color.value
      }));
      //verificar estados
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          console.log(this.responseText);
          alertaPersonalizada(res.type, res.msg);
          if (res.type == 'success') {
            localStorage.removeItem(nombreKey);
            generarPDF(res.idApartado);
          }
        }
      }
    }

  })

  //cargar datos con el plugin datatables
  tblHistorial = $('#tblHistorial').DataTable({
    ajax: {
      url: base_url + 'apartados/listarHistorial',
      dataSrc: ''
    },
    columns: [
      { data: 'fecha_creado' },
      { data: 'cliente' },
      { data: 'abono' },
      { data: 'total' },
      { data: 'fecha_apartado' },
      { data: 'fecha_retiro' },
      { data: 'estado' },
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
          total = subtotal + iva;
          tblNuevoApartado.innerHTML = html;
          totalPagar.value = total.toFixed(2);
          btnEliminarProducto();
          agregarCantidad();
        } else {
          tblNuevoApartado.innerHTML =
            `<tr>
          <td colspan="5" class="text-center">CARRITO VACIO</td>
      </tr>`;
        }
      }
    }
  } else {
    tblNuevoApartado.innerHTML =
      `<tr>
          <td colspan="5" class="text-center">CARRITO VACIO</td>
      </tr>`;
  }
  totalPagar.value = '0.00';
}


function generarPDF(idApartado) {
  setTimeout(() => {
    Swal.fire({
      title: '¿Desea Generar Reporte?',
      showDenyButton: true,
      showCancelButton: true,
      confirmButtonText: 'Ticked',
      denyButtonText: `Factura`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        const ruta = base_url + 'apartados/reporte/ticked/' + idApartado;
        window.open(ruta, '_blank');
      } else if (result.isDenied) {
        const ruta = base_url + 'apartados/reporte/factura/' + idApartado;
        window.open(ruta, '_blank');
      }
      window.location.reload();
    })
  }, 1000);
}

function verReporte(idApartado) {
  Swal.fire({
    title: '¿Desea Generar Reporte?',
    showDenyButton: true,
    showCancelButton: true,
    confirmButtonText: 'Ticked',
    denyButtonText: `Factura`,
  }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.isConfirmed) {
      const ruta = base_url + 'apartados/reporte/ticked/' + idApartado;
      window.open(ruta, '_blank');
    } else if (result.isDenied) {
      const ruta = base_url + 'apartados/reporte/factura/' + idApartado;
      window.open(ruta, '_blank');
    }
  })
}