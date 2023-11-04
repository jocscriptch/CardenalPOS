let tblProductos;
const form = document.querySelector("#form");
const btnAccion = document.querySelector("#btnAccion");
const btnNuevo = document.querySelector("#btnNuevo");

const id = document.querySelector("#id");
const codigo = document.querySelector("#codigo");
const descripcion = document.querySelector("#descripcion");
const precio_compra = document.querySelector("#precio_compra");
const precio_venta = document.querySelector("#precio_venta");
const id_medida = document.querySelector("#id_medida");
const id_categoria = document.querySelector("#id_categoria");
const foto = document.querySelector("#foto");
const foto_actual = document.querySelector("#foto_actual");
const containerPreview = document.querySelector("#containerPreview");

const errorCodigo = document.querySelector("#errorCodigo");
const errorDescripcion = document.querySelector("#errorDescripcion");
const errorCompra = document.querySelector("#errorCompra");
const errorVenta = document.querySelector("#errorVenta");
const errorMedida = document.querySelector("#errorMedida");
const errorCategoria = document.querySelector("#errorCategoria");

document.addEventListener("DOMContentLoaded", function () {
    tblProductos = $("#tblProductos").DataTable({
        ajax: {
            url: base_url + "productos/listar", //llamando al metodo del controlador productos
            dataSrc: "",
        },
        columns: [ //campos en la db
            { data: 'codigo' },
            { data: 'descripcion' },

            {
                data: 'precio_compra',
                render: function (data, type, row) {
                    return '₡ ' + parseFloat(data).toFixed(2);
                }
            },
            {
                data: 'precio_venta',
                render: function (data, type, row) {
                    return '₡ ' + parseFloat(data).toFixed(2);
                }
            },
            { data: 'cantidad' },
            { data: 'medida' },
            { data: 'categoria' },
            { data: 'imagen' },
            { data: 'acciones' } //accion en el controlador categorias

        ],
        language: {
            url: base_url + "assets/js/spanish.json",
        },
        dom,
        buttons,
        responsive: true,
        order: [[0, "asc"]],
    });

    //imagen vista previa
    foto.addEventListener("change", function (e) {
        foto_actual.value = "";
        if (
            e.target.files[0].type == "image/png" ||
            e.target.files[0].type == "image/jpg" ||
            e.target.files[0].type == "image/jpeg"
        ) {
            const url = e.target.files[0];
            const tmpUrl = URL.createObjectURL(url);
            containerPreview.innerHTML = `
            <img class="img-thumbnail img-fluid" src="${tmpUrl}" style="max-width: 200px; max-height: 200px;">
            <button class="btn btn-danger" type="button" onClick="borrarImg()"><i class="fas fa-trash"></i></button>`;
        } else {
            foto.value = "";
            alertaPersonalizada(
                "warning",
                "SOLO SE PERMITEN IMAGENES PNG, JPG Y JPEG"
            );
        }
    });

    //limpiar los campos del formulario
    btnNuevo.addEventListener("click", function () {
        id.value = "";
        btnAccion.textContent = "Registrar";
        form.reset();
        borrarImg();
        limpiarCampos();
    });

    //registro de productos
    form.addEventListener("submit", function (e) {
        e.preventDefault();
        limpiarCampos();
        if (codigo.value == "") {
            errorCodigo.textContent = "CODIGO REQUERIDO";
        } else if (descripcion.value == "") {
            errorDescripcion.textContent = "DESCRIPCION REQUERIDA";
        } else if (precio_compra.value == "") {
            errorCompra.textContent = "PRECIO DE COMPRA REQUERIDO";
        } else if (precio_venta.value == "") {
            errorVenta.textContent = "PRECIO DE VENTA REQUERIDO";
        } else if (id_medida.value == "") {
            errorMedida.textContent = "SELECCIONA LA MEDIDA";
        } else if (id_categoria.value == "") {
            errorCategoria.textContent = "SELECCIONA LA CATEGORIA";
        } else {
            const url = base_url + "productos/registrar";
            insertarRegistros(url, this, tblProductos, btnAccion, false);
        }
    });
});

function borrarImg() {
    foto.value = "";
    containerPreview.innerHTML = "";
    foto_actual.value = "";
}

function eliminarProducto(idProducto) {
    const url = base_url + "productos/eliminar/" + idProducto;
    const titulo = "¿Estás seguro que deseas desactivar el producto?";
    const texto = "El producto cambiará su estado a inactivo";
    eliminarRegistros(url, tblProductos, titulo, texto);
}

function editarProducto(idProducto) {
    limpiarCampos();
    const url = base_url + "productos/editar/" + idProducto;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();

    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            //recuperando datos para editar los usuarios
            id.value = res.id;
            codigo.value = res.codigo;
            descripcion.value = res.descripcion;
            precio_compra.value = res.precio_compra;
            precio_venta.value = res.precio_venta;
            id_medida.value = res.id_medida;
            id_categoria.value = res.id_categoria;
            foto_actual.value = res.foto;
            containerPreview.innerHTML = `
            <img class="img-thumbnail img-fluid" src="${base_url + res.foto
                }" style="max-width: 200px; max-height: 200px;">
            <button class="btn btn-danger" type="button" onClick="borrarImg()"><i class="fas fa-trash"></i></button>`;
            btnAccion.textContent = "Actualizar";
            firstTab.show();
        }
    };
}
function limpiarCampos() {
    errorCodigo.textContent = "";
    errorDescripcion.textContent = "";
    errorCompra.textContent = "";
    errorVenta.textContent = "";
    errorMedida.textContent = "";
    errorCategoria.textContent = "";
}