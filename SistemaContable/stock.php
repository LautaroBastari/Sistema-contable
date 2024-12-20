<?php
session_start();
$id_usuario = $_SESSION['user_id'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Stock</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>
    <?php include './nav.php';
          include 'controlador/registrarStock.php' ?>
    <div class="container border border-primary-light pt-2 pb-2 mb-5 mt-5 bg-light text-dark">
        <div class="container d-flex mt-3">
            <button type="submit" name="button" class="btn" onclick="goBack()"><i
                    class="bi bi-caret-left-fill"></i></button>
            <script>
                function goBack() {
                    window.history.go(-1);
                }
            </script>
            <div class="container d-flex justify-content-center mt-2">
                <h1><b>Administración de Stock</b></h1>
            </div>

            <?php
            include "conexionPDC.php";
            $sql_tipo_usuario = $conexion->query("SELECT rol FROM usuarios WHERE id_usuario = $id_usuario");
            $datos_tipo_rol = $sql_tipo_usuario->fetch_array();
            $rol = $datos_tipo_rol["rol"];
            if ($rol === "admin") {
                echo '<div class="mt-3">';
                echo '<form method="post">';
                echo '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">';
                echo 'Añadir Stock';
                echo '</button>';
                echo '</form>';
                echo '</div>';
            }
            ?>


            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    
                        <div class="modal-header">
                            <h3 class="text-center text-secondary">Agregar Stock</h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST">
                                <?php
                                include "conexionPDC.php";
                                include "controlador/registrar.php";
                                
                                function obtenerFechaActual()
                                    {
                                        return date("Y-m-d", time());
                                    }
                                    $fecha_actual = obtenerFechaActual();
                                    $fecha_max = $fecha_actual;
                                ?>

                                

                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" name="nombre">
                                </div>

                                <label for="exampleInputEmail1" class="form-label mt-3 me-3">Fecha: </label>
                                <input type="date" name="fecha" max="<?= $fecha_max ?>">
    

                                <div class="mb-3">
                                    <label for="condicion" class="form-label">Rubro</label>
                                    <select class="form-control" name="rubro" id="condicion">
                                        <option value="Maquinaria electrica">Maquinaria eléctrica</option>
                                        <option value="Hilos y cables">Hilos y cables</option>
                                        <option value="Pilas y baterias">Pilas y baterías</option>
                                        <option value="Equipo de iluminacion">Equipo de iluminación</option>
                                        <option value="Articulos de iluminación">Articulos de iluminación</option>
                                        <option value="Equipos eléctricos">Equipos eléctricos</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Cantidad actual</label>
                                    <input type="number" class="form-control" name="cantidad_act">
                                </div>

                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Cantidad maxima</label>
                                    <input type="number" class="form-control" name="cantidad_max">
                                </div>

                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Valor unitario</label>
                                    <input type="number" class="form-control" name="valor_unitario">
                                </div>

                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Valor de venta</label>
                                    <input type="number" class="form-control" name="valor_venta">
                                </div>
                                
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary" name="registrar" value="Ok">Agregar articulos</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <hr class="container  mb-2 d-flex justify-content-center" style="width:70%">
        </hr>
        <div class="col-11 pt-2 container text-center">

            <table class="table table-bordered">

                <thead class="table-info">
                    <tr>
                        <th scope="col">Nro de articulo</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Rubro</th>
                        <th scope="col">Cantidad actual</th>
                        <th scope="col">Cantidad maxima</th>
                        <th scope="col">Valor unitario</th>
                        <th scope="col">Valor de venta</th>
                        <th scope="col">Valor inventario</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $sql = $conexion->query("SELECT id_articulo, nombre, fecha, rubro, cantidad_actual, cantidad_maxima, valor_unitario, valor_venta, valor_inventario FROM stock ORDER BY id_articulo ASC");
                    while($datos = $sql->fetch_object()){
                        ?>
                    <tr>
                        <td>
                            <?= $datos->id_articulo ?>
                        </td>
                        <td>
                            <?= $datos->nombre ?>
                        </td>
                            
                        <td>
                            <?= $datos->fecha ?>
                        </td>

                        <td>
                            <?= $datos->rubro ?>
                        </td>

                        <td>
                            <?= $datos->cantidad_actual ?>
                        </td>

                        <td>
                            <?= $datos->cantidad_maxima ?>
                        </td>

                        <td>
                            <?= $datos->valor_unitario ?>
                        </td>

                        <td>
                            <?= $datos->valor_venta ?>
                        </td>

                        <td>
                            <?= $datos->valor_inventario ?>
                        </td>



                    </tr>
                    <?php }
                    ?>

                </tbody>

            </table>
            
        </div>
    </div>

</body>

</html>