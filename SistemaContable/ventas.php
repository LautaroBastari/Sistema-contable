<?php
session_start();
$id_usuario = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Ventas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/646ac4fad6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</head>

<body>
    <?php
    include "conexionPDC.php";
    ?>
    <script>
        function goBack() {
            window.history.go(-1);
        }
    </script>
    <?php include './nav.php' ?>
    <div class="container border border-primary-light pt-2 pb-2 mb-5 mt-5 bg-light text-dark">
        <div class="container d-flex mt-3">
            <button type="submit" name="button" class="btn" onclick="goBack()"><i class="bi bi-caret-left-fill"></i></button>
            <div class="container d-flex justify-content-center mt-2">
                <h1><b>Registro de Ventas</b></h1>
            </div>

            <?php
              include "conexionPDC.php";
              $sql_tipo_usuario = $conexion->query("SELECT rol 
                                                    FROM usuarios 
                                                    WHERE id_usuario = $id_usuario");
            
              $datos_tipo_rol = $sql_tipo_usuario->fetch_array();
              $rol = $datos_tipo_rol["rol"];
              if ($rol === "admin") {
                  echo '<div class="text-end ">';
                  echo '<a class="btn btn-primary" href="productos.php" role="button">Registrar ventas</a>';
                  echo '</div>';
              }
            ?>

        </div>
        <hr class="container mb-2 d-flex justify-content-center" style="width:70%">
        </hr>
        <div class="col-11 pt-2 container text-center">

            <table class="table table-bordered">

                <thead class="table-info">
                        <tr>
                        <th scope="col">Número</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Producto</th>
                        <th scope="col">Coste Total</th>
                        <th scope="col">Factura</th>
                        <th scope="col" style="color: green;">Nota de débito</th>
                        <th scope="col" style="color: red;">Nota de crédito</th>
                        </tr>
                    </thead>
                <tbody>
                <?php
                include "conexionPDC.php";
                $consulta_venta = $conexion->query("SELECT id_venta, fecha, cliente, producto, coste_total FROM venta");

                $last_id_venta = null;
                $last_cliente = null;

                while ($datos_venta = $consulta_venta->fetch_assoc()) { 
                    $numero_venta = $datos_venta["id_venta"];
                    $fecha = $datos_venta["fecha"]; 
                    $cliente = $datos_venta["cliente"]; 
                    $producto = $datos_venta["producto"];
                    $coste_total = $datos_venta["coste_total"];
                    $iva = $coste_total * 0.21;
                    ?>
                    <tr>
                        <td>
                            <?= $numero_venta ?>
                        </td>

                        <td>
                            <?= $fecha ?>
                        </td>

                        
                        <?php if ($last_id_venta !== $numero_venta): ?>
                            <td>
                                <?= $cliente ?>
                            </td>
                        <?php else: ?>
                            <td class="invisible-td"></td>
                        <?php endif; ?>
                        

                        <td>
                            <?= $producto ?>
                        </td>

                        <td>
                            <?= $coste_total + $iva ?>
                        </td>

                        <td>
                            <?php if ($last_id_venta !== $numero_venta): ?>
                                <a href="facturaA.php?id=<?= $numero_venta ?>"><i class="fa-regular fa-pen-to-square m-2"></i></a>
                            <?php endif; ?>
                        </td>

                        <td>
                        <?php if ($last_id_venta !== $numero_venta): ?>
                            <a class="btn btn-success" href="notaDebito.php?id_venta=<?= $numero_venta ?>" role="button">D</a>
                            <a class="btn btn-warning" href="debito.php?id_venta=<?= $numero_venta ?>" role="button">
                                <i class="bi bi-card-text"></i>
                            </a>
                        <?php endif; ?>
                    </td>

                    <td>
                        <?php if ($last_id_venta !== $numero_venta): ?>
                            <a class="btn btn-danger" href="notaCredito.php?id_venta=<?= $numero_venta ?>" role="button">C</a>
                            <a class="btn btn-warning" href="credito.php?id_venta=<?= $numero_venta ?>" role="button">
                                <i class="bi bi-card-text"></i>
                            </a>
                        <?php endif; ?>
                    </td>
                    </tr>
                    <?php
                    $last_id_venta = $numero_venta;
                    $last_cliente = $cliente;
                }
                ?>


                </tbody>

            </table>
            <?php
                        if (isset($_GET['error'])) {
                            $error = urldecode($_GET['error']);
                            echo "<div class='alert alert-warning'>$error</div>";
                        }
                        if (isset($_GET['exito'])) {
                            $exito = urldecode($_GET['exito']);
                            echo "<div class='alert alert-success'>$exito</div>";
                        }
                        
                        if (isset($_GET['creditos_vacios'])) {
                            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                            echo 'No se encontraron registros en la nota de crédito.';
                            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                            echo '</div>';
                        }
                        if (isset($_GET['debitos_vacios'])) {
                            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                            echo 'No se encontraron registros en la nota de débito.';
                            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                            echo '</div>';
                        }

                ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>
</body>

</html>