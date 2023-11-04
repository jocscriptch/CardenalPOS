<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $data['title']; ?>
    </title>
    <link rel="stylesheet" href="<?php echo BASE_URL . 'assets/css/factura.css'; ?>">
</head>

<body>
    <table id="datos-empresa">
        <tr>
            <td class="logo">
                <img src="<?php echo BASE_URL . 'assets/images/logoPos7.png'; ?>" alt="">
            </td>
            <td class="info-empresa">
                <p>
                    <?php echo $data['empresa']['nombre']; ?>
                </p>
                <p>Teléfono:
                    <?php echo $data['empresa']['telefono']; ?>
                </p>
                <p>Dirección:
                    <?php echo $data['empresa']['direccion']; ?>
                </p>
            </td>
            <td class="info-compra">
                <div class="container-factura">
                    <span class="factura">Factura</span>
                    <p>N°: <strong><?php echo $data['venta']['serie']; ?></strong></p>
                    <p>Fecha:
                        <?php echo $data['venta']['fecha']; ?>
                    </p>
                    <p>Hora:
                        <?php echo $data['venta']['hora']; ?>
                    </p>
                </div>
            </td>
        </tr>
    </table>


    <h5 class="title">Datos del Cliente</h5>
    <table id="container-info">
        <tr>
            <td>
                <strong>
                    <?php echo $data['venta']['identidad'] ?>
                </strong>
                <p>
                    <?php echo $data['venta']['num_identidad'] ?>
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <strong>Nombre: </strong>
                <p>
                    <?php echo $data['venta']['nombre'] ?>
                </p>
            </td>
            <td>
                <strong>Teléfono: </strong>
                <p>
                    <?php echo $data['venta']['telefono'] ?>
                </p>
            </td>
            <td>
                <strong>Dirección: </strong>
                <p>
                    <?php echo $data['venta']['direccion'] ?>
                </p>
            </td>
        </tr>
    </table>
    <h5 class="title">Detalle de los Productos</h5>
    <table id="container-producto">
        <thead>
            <tr>
                <th>Cantidad</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>SubTotal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $productos = json_decode($data['venta']['productos'], true);
            
            // //IVA incluido
            // $subTotal = $data['venta']['total'] / 1.13;
            // $iva = $data['venta']['total'] - $subTotal;
            // $grantotal = $data['venta']['total'] - $data['venta']['descuento'];

            //IVA no incluido
            // $subTotal = $data['venta']['total'];
            // $iva = $subTotal * 0.13;
            // $total = $subTotal + $iva;
            foreach ($productos as $producto) { ?>
                <tr>
                    <td>
                        <?php echo $producto['cantidad']; ?>
                    </td>
                    <td>
                        <?php echo $producto['nombre']; ?>
                    </td>
                    <td>
                        <?php echo number_format($producto['precio'], 2); ?>
                    </td>
                    <td>
                        <?php echo number_format($producto['cantidad'] * $producto['precio'], 2); ?>
                    </td>
                </tr>
            <?php } ?>
            <tr class="total">
                <td class="text-right" colspan="3">SubTotal</td>
                <td class="text-right">
                    <?php echo number_format($data['venta']['subtotal'], 2); ?>
                </td>
            </tr>
            <tr class="total">
                <td class="text-right" colspan="3">IVA 13%</td>
                <td class="text-right">
                    <?php echo number_format($data['venta']['iva'], 2); ?>
                </td>
            </tr>
            <tr class="total">
                <td class="text-right" colspan="3">Gran Total</td>
                <td class="text-right">
                    <?php echo number_format($data['venta']['total'], 2); ?>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="mensaje">
        <h4>
            <?php echo $data['venta']['metodo'] ?>
        </h4>
        <?php echo $data['empresa']['mensaje']; ?>
        <?php if ($data['venta']['estado'] == 0) { ?>
            <h1>Venta Anulada</h1>
        <?php } ?>
    </div>

</body>

</html>