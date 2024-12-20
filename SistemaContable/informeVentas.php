<?php
session_start();
$id_usuario = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe de Ventas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>
    <?php include './nav.php' ?>
    <div class="container border border-primary-light pt-2 pb-2 mb-5 mt-5 bg-light text-dark">
        <div class="container d-flex mt-3">
            <button type="submit" name="button" class="btn" onclick="goBack()"><i class="bi bi-caret-left-fill"></i></button>
            <script>
                function goBack() {
                    window.history.go(-1);
                }
            </script>
            <div class="container d-flex justify-content-center mt-2">
                <h1><b>Informe de Ventas</b></h1>
            </div>
        </div>
        <hr class="container mb-2 d-flex justify-content-center" style="width:70%">
        </hr>
        <div class="col-10 pt-2 container text-center">
            <table class="table table-bordered">
                <thead class="table-info">
                    <tr>
                        <th scope="col">Rubro</th>
                        <th scope="col">Producto</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Cantidad (hoy)</th>
                        <th scope="col">Presupuesto (hoy)</th>
                        <th scope="col">Cantidad (mes)</th>
                        <th scope="col">Presupuesto (mes)</th>
                        <th scope="col">Cumplimiento% <br> (Mes)</th>
                        <th scope="col">Importe Vendido</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    include "conexionPDC.php";
                    $consulta_rubros = $conexion -> query("SELECT DISTINCT rubro FROM stock");
                    $presupuesto_mensual = 1000;
                    $presupuesto_diario = $presupuesto_mensual / 30;
                    $presupuesto_diario_total = 0;
                    $cantidad_total = 0;
                    $importe_total = 0;
                    $presupuesto_total = 0;
                    $importe_vendido_total = 0;
                    $cantidad_total_hoy = 0;
                    $importe_total_hoy = 0;

                    if($consulta_rubros){
                        while ($datos_rubros = $consulta_rubros -> fetch_assoc()) {
                            $rubro = $datos_rubros['rubro'];
                            $ventas_por_producto = [];
                            $ventas_por_producto_hoy = [];

                            // Consultas para ventas del mes y del día
                            $consulta_producto = $conexion -> query("SELECT v.producto, v.id_producto, v.cantidad, v.coste_total, s.valor_venta
                                                                    FROM venta v
                                                                    INNER JOIN stock s ON v.id_producto = s.id_articulo
                                                                    WHERE s.rubro = '$rubro' AND MONTH(v.fecha) = MONTH(CURRENT_DATE()) AND YEAR(v.fecha) = YEAR(CURRENT_DATE())");
                            $consulta_dia = $conexion->query("SELECT v.producto, v.id_producto, v.cantidad, v.coste_total, s.valor_venta
                                                                    FROM venta v
                                                                    INNER JOIN stock s ON v.id_producto = s.id_articulo
                                                                    WHERE s.rubro = '$rubro'
                                                                    AND DAY(v.fecha) = DAY(CURRENT_DATE())
                                                                    AND MONTH(v.fecha) = MONTH(CURRENT_DATE())
                                                                    AND YEAR(v.fecha) = YEAR(CURRENT_DATE())");

                            // Procesar ventas del mes
                            while ($datos_ventas = $consulta_producto->fetch_assoc()) {
                                $producto = $datos_ventas['producto'];
                                $precio_venta = $datos_ventas['valor_venta'];
                                $cantidad = $datos_ventas['cantidad'];
                                $precio_total = $datos_ventas['coste_total'];

                                $clave_producto_precio = $producto . "_" . $precio_venta;

                                if (!isset($ventas_por_producto[$clave_producto_precio])) {
                                    $ventas_por_producto[$clave_producto_precio] = [
                                        'producto' => $producto,
                                        'precio_venta' => $precio_venta,
                                        'cantidad' => 0,
                                        'precio_total' => 0,
                                    ];
                                    $presupuesto_total += $presupuesto_mensual;
                                    $presupuesto_diario_total += $presupuesto_diario;
                                }

                                $ventas_por_producto[$clave_producto_precio]['cantidad'] += $cantidad;
                                $ventas_por_producto[$clave_producto_precio]['precio_total'] += $precio_total;

                                $cantidad_total += $cantidad;
                                $importe_vendido_total += $precio_total;
                                $importe_total += $precio_venta;
                            }

                            // Procesar ventas del día
                            while ($datos_ventas_hoy = $consulta_dia -> fetch_assoc()) {
                                $producto_hoy = $datos_ventas_hoy['producto'];
                                $precio_venta_hoy = $datos_ventas_hoy['valor_venta'];
                                $cantidad_hoy = $datos_ventas_hoy['cantidad'];
                                $precio_total_hoy = $datos_ventas_hoy['coste_total'];

                                $clave_producto_precio_hoy = $producto_hoy . "_" . $precio_venta_hoy;

                                if (!isset($ventas_por_producto_hoy[$clave_producto_precio_hoy])) {
                                    $ventas_por_producto_hoy[$clave_producto_precio_hoy] = [
                                        'producto' => $producto_hoy,
                                        'precio_venta' => $precio_venta_hoy,
                                        'cantidad' => 0,
                                        'precio_total' => 0,
                                    ];
                                }

                                $ventas_por_producto_hoy[$clave_producto_precio_hoy]['cantidad'] += $cantidad_hoy;
                                $ventas_por_producto_hoy[$clave_producto_precio_hoy]['precio_total'] += $precio_total_hoy;
                                $cantidad_total_hoy += $cantidad_hoy;
                                $importe_total_hoy += $precio_total_hoy;
                            }

                            $first_row = true;
                            foreach ($ventas_por_producto as $clave_producto_precio => $data) {
                                $producto = $data['producto'];
                                $precio_venta = $data['precio_venta'];
                                $cantidad = $data['cantidad'];
                                $precio_total = $data['precio_total'];
                                $cantidad_hoy = isset($ventas_por_producto_hoy[$clave_producto_precio]) ? $ventas_por_producto_hoy[$clave_producto_precio]['cantidad'] : 0;
                                $precio_total_hoy = isset($ventas_por_producto_hoy[$clave_producto_precio]) ? $ventas_por_producto_hoy[$clave_producto_precio]['precio_total'] : 0;
                    ?>
                    <tr>
                        <?php if ($first_row): ?>
                            <td rowspan="<?= count($ventas_por_producto) ?>" style="vertical-align: middle;">
                                <?= $rubro ?>
                            </td>
                        <?php $first_row = false; endif; ?>
                        <td><?= $producto ?></td>
                        <td><?= $precio_venta ?></td>
                        <td><?= $cantidad_hoy ?></td>
                        <td><?= $presupuesto_diario ?></td>
                        <td><?= $cantidad ?></td>
                        <td><?= $presupuesto_mensual ?></td>
                        <td>
                            <?php 
                            $cumplimiento = ($precio_total / $presupuesto_mensual) * 100;
                            echo number_format($cumplimiento, 2) . '%';
                            ?>
                        </td>
                        <td><?= $precio_total ?></td>
                    </tr>
                    <?php 
                            }
                        }
                    } else {
                        echo "<div class='alert alert-warning'> Error al ejecutar la consulta: " . $conexion->error . "</div>";
                    }
                    ?>

                    <tr>
                        <td><span style="color: blue;"><strong>Total productos:</strong></span></td>
                        <td><?= "-" ?></td>
                        <td><?= "-" ?></td>
                        <td><?= $cantidad_total_hoy ?></td>
                        <td><?= "-" ?></td>
                        <td><?= $cantidad_total ?></td>
                        <td><?= "-" ?></td>
                        <td><?= "-" ?></td>
                        <td><?= "-" ?></td>
                    </tr>

                    <tr>
                        <td><span style="color: blue;"><strong>Total importe:</strong></span></td>
                        <td><?= "-" ?></td>
                        <td><?= $importe_total ?></td>
                        <td><?= "-" ?></td>
                        <td><?= $presupuesto_diario_total ?></td>
                        <td><?= "-" ?></td>
                        <td><?= $presupuesto_total ?></td>
                        <?php
                        if ($presupuesto_total != 0) {
                            $resultado = ($importe_vendido_total / $presupuesto_total) * 100;
                        } else {
                            $resultado = 0;
                        }
                        ?>
                        <td><?= $resultado ?></td>
                        <td><?= $importe_vendido_total ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
