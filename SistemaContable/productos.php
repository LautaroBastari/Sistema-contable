<?php
session_start();
$id_usuario = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Venta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <script src="https://kit.fontawesome.com/646ac4fad6.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</head>

<body>

    <script>
        function goBack() {
            window.history.go(-1);
        }

    </script>

    <?php include './nav.php' ?>
    <div class="container border border-primary-light pt-2 pb-2 mb-5 mt-5 bg-light ">
        <div class="container d-flex mt-3">
            <button type="submit" name="button" class="btn" onclick="goBack()"><i
                    class="bi bi-caret-left-fill"></i></button>
            <div class="container d-flex justify-content-center ">
                <h2><b>Registro ventas</b></h2>
            </div>
        </div>
        <hr class="container mb-3 d-flex justify-content-center" style="width:70%">
        </hr>
        <div class="row d-flex justify-content-between mb-2">


            <div class="col-4 container d-flex border border-secondary justify-content-center">
                <form method="POST" action="controlador/registrarProducto.php">
                    <?php
                    include "conexionPDC.php";

                    ?>
                    <!-- Agregar productos dinámicamente -->

                    <div id="productos-container">
                        <div class=" d-flex align-items-center mt-3 mb-3">
                            <label for="exampleInputEmail1" class="form-label me-2">Producto: </label>
                            <select class="form-control" name="producto" id="producto">
                                <!-- Opciones de productos -->
                                <option value="stock">
                                    <?php
                                    include "conexionPDC.php";
                                    $sql = $conexion->query("SELECT DISTINCT nombre, cantidad_actual from stock ORDER BY nombre ASC");
                                    while ($datos = $sql->fetch_object()) {
                                        if ($datos->cantidad_actual > 0) {
                                            echo '<option value="' . $datos->nombre . '">' . $datos->nombre . ' (' . $datos->cantidad_actual . ')</option>';
                                        }
                                        $nombre_articulo2 = $datos->nombre;
                                    }
                                    ?>
                                </option>
                            </select>
                        </div>

                        <div class=" d-flex align-items-center mt-3 mb-3">
                            <label for="exampleInputEmail1" class="form-label me-2">Cantidad: </label>
                            <input type="number" class="form-control" name="cantidad" id="cantidad">
                        </div>


                    </div>

                    <div class="d-flex justify-content-center">

                        
                        <button type="submit" class="btn btn-success mb-3 " id="agregarProducto">Agregar producto</button>
                    </form>
                    </div>
                    
            </div>
            
            <div class="col-4 container d-flex border border-secondary justify-content-center">

                <form method="POST" action="controlador/registrarVenta.php">

                    <?php
                    function obtenerFechaActual()
                    {
                        return date("Y-m-d", time());
                    }
                    $fecha_actual = obtenerFechaActual();
                    $fecha_max = $fecha_actual;
                    ?>
                    <label for="exampleInputEmail1" class="form-label mt-3 me-3">Fecha: </label>
                    <input type="date" name="fecha" max="<?= $fecha_max ?>">

                    <div class=" d-flex align-items-center mt-3 mb-3">
                        <label for="condicion" class="form-label me-2">Cliente:</label>
                        <select class="form-control" name="cliente" id="cliente">
                            <option value="cliente">
                                <?php
                                include "conexionPDC.php";
                                $sql = $conexion->query("SELECT nombre from clientes ORDER BY nombre ASC");
                                while ($datos = $sql->fetch_object()) {
                                    echo '<option value="' . $datos->nombre . '">' . $datos->nombre . '</option>';
                                    $nombre_cuenta2 = $datos->nombre;

                                }
                                ?>
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Método de pago</label>
                            <select class="form-control" name="metodo_pago" id="condicion">
                                <option value="Caja">Efectivo</option>
                                <option value="Banco c/c">Cheque Banco</option>
                                <option value="Deudores por ventas">Deudores</option>
                                <option value="Documentos a cobrar">Cheques de terceros</option>
                            </select>
                    </div>


                    <a class="btn btn-dark me-2" href="ventas.php" role="button">Cerrar</a>
                    <button type="submit" class="btn btn-primary " name="agregar" value="Ok">Agregar
                        Venta</button>

                </form>
            </div>


        </div>
        <hr class="container mt-4 mb-4 d-flex justify-content-center" style="width:70%">
        </hr>
        <div class="col-11 text-center container">
            <table class="table table-bordered">

                <thead class="table-info">
                    <tr>
                        <th scope="col">Numero de venta</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Precio unitario</th>
                        <th scope="col">Precio total</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <?php
                $sql_productos = $conexion->query("SELECT nro_venta, id_articulo, cantidad, precio_total FROM lineas_venta ORDER BY nro_venta ASC");
                while ($datos_venta = $sql_productos->fetch_object()) {
                    $id_articulo = $datos_venta->id_articulo; 
                    $sql_consulta_stock = $conexion->query("SELECT nombre, valor_unitario, valor_venta
                                                                FROM stock 
                                                                WHERE id_articulo = $id_articulo");
                    if ($sql_consulta_stock) {
                        $datos_stock = $sql_consulta_stock->fetch_assoc();
                        $nombre = $datos_stock['nombre']; 
                        $precio_unitario = $datos_stock['valor_venta'];
                    }
                    ?>
                    <tr>
                        <td>
                            <?= $datos_venta->nro_venta ?>
                        </td>
                        <td>
                            <?= $nombre ?>
                        </td>
                        <td>
                            
                            <?= $datos_venta->cantidad ?>
                        </td>
                        <td>
                            <?= $precio_unitario ?>
                        </td>
                        <td>
                            <?= $datos_venta->precio_total ?>
                        </td>
                        <td>
                            <a onclick="return eliminar()"
                                href="controlador/eliminarProducto.php?nro_venta=<?= $datos_venta->nro_venta ?>"><i
                                    class="fa-solid fa-trash"></i></a>
                        </td>

                    </tr>

                <?php }
                ?>
                <tbody>


                </tbody>
                <?php
                        if (isset($_GET['error'])) {
                            $error = urldecode($_GET['error']);
                            echo "<div class='alert alert-warning'>$error</div>";
                        }
                        if (isset($_GET['exito'])) {
                            $exito = urldecode($_GET['exito']);
                            echo "<div class='alert alert-success'>$exito</div>";
                        }
                        
                ?>
            </table>
            <?php
                if (isset($_GET['exito_eliminacion'])) {
                    $exito = urldecode($_GET['exito_eliminacion']);
                    echo "<div class='alert alert-success'>$exito</div>";
                }

                if (isset($_GET['error_eliminacion'])) {
                    $error = urldecode($_GET['error_eliminacion']);
                    echo "<div class='alert alert-warning'>$error</div>";
                }
            ?>
        </div>
    </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>