<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $data['title']; ?>
    </title>
    <link rel="stylesheet" href="<?php echo BASE_URL . 'assets/css/ticked.css'; ?>">
</head>

<body>
    <div class="datos-empresa">
        <p>
            <?php echo $data['empresa']['nombre']; ?>
        </p>
        <p>
            <?php echo $data['empresa']['telefono']; ?>
        </p>
        <p>
            <?php echo $data['empresa']['direccion']; ?>
        </p>
    </div>

    <h5 class="title">Datos del Cliente</h5>
    <div class="datos-info">
        <p><strong>
                <?php echo $data['apartado']['identidad']; ?>
            </strong>
            <?php echo $data['apartado']['num_identidad']; ?>
        </p>
        <p><strong>Nombre: </strong>
            <?php echo $data['apartado']['nombre']; ?>
        </p>
        <p><strong>Teléfono: </strong>
            <?php echo $data['apartado']['telefono']; ?>
        </p>
    </div>

    <h5 class="title">Detalle del apartado</h5>
    <table>
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
            $productos = json_decode($data['apartado']['productos'], true);
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
                <td class="text-right" colspan="3">Total De Apartado</td>
                <td class="text-right">
                    <?php echo number_format($data['apartado']['total'], 2); ?>
                </td>
            </tr>
            <tr class="total">
                <td class="text-right" colspan="2">Fecha De Apartado</td>
                <td class="text-right" colspan="2">
                    <?php echo $data['apartado']['fecha_apartado']; ?>
                </td>
            </tr>
            <tr class="total">
                <td class="text-right" colspan="2">Fecha De Retiro</td>
                <td class="text-right" colspan="2">
                    <?php echo $data['apartado']['fecha_retiro']; ?>
                </td>
            </tr>

        </tbody>
    </table>
    <div class="mensaje">
        <?php if ($data['apartado']['estado'] == 0) { ?>
            <h3>Apartado Finalizado</h3>
        <?php } else { ?>
            <h3>Apartado Pendiente</h3>
        <?php } ?>
        <?php echo $data['empresa']['mensaje']; ?>
    </div>
</body>

</html>