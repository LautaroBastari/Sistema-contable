<?php
session_start();
$id_usuario = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan de Cuentas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/646ac4fad6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>
    <?php include './nav.php' ?>
    <div id="incluirNav"></div>
    <script>
        function eliminar() {
            var respuesta = confirm("¿Estas seguro que deseas eliminar esta cuenta?");
            return respuesta
        }
    </script>

    <?php
    include "conexionPDC.php";
    include "controlador/eliminar.php";
    ?>
    <div class="container border border-primary-light pt-2 pb-2 mb-5 mt-5 bg-light text-dark">
        <div class="container d-flex mt-5 ">
            <a type="submit" name="button" class="btn" href="registrarAsiento.php"><i
                    class="bi bi-caret-left-fill"></i></a>
            <script>
                function goBack() {
                    window.history.go(-1);
                }
            </script>
            <div class="container d-flex justify-content-center mb-2">
                <h1><b>Plan de Cuentas</b></h1>
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
                echo 'Añadir Cuenta';
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
                            <h3 class="text-center text-secondary">Registro de cuentas</h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST">
                                <?php
                                include "conexionPDC.php";
                                include "controlador/registrar.php";
                                ?>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" name="nombre">
                                </div>

                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Numero de cuenta</label>
                                    <input type="number" class="form-control" name="nro_cuenta">
                                </div>

                                <div class="mb-3">
                                    <label for="tipo" class="form-label">Tipo</label>
                                    <select class="form-control" name="tipo" id="tipo">
                                        <option value="Ac">Ac</option>
                                        <option value="Pa">Pa</option>
                                        <option value="R+">R+</option>
                                        <option value="R-">R-</option>
                                        <option value="Pm">Pm</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="tipo" class="form-label">Recibe saldo</label>
                                    <select class="form-control" name="recibe_saldo" id="recibe_saldo">
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                    </select>
                                </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary" name="registrar" value="Ok">Registrar
                                cuenta</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <hr class="container mb-4 d-flex justify-content-center" style="width:70%">
        </hr>
        <div class="col-10  container text-center">

            <table class="table table-bordered">

                <thead class="bg-info">
                    <tr>
                        <th scope="col">Numero de la cuenta</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Recibe saldo</th>
                        <th scope="col">Tipo</th>
                        <th scope="col"></th>
                    </tr>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
                        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
                        crossorigin="anonymous"></script>
                </thead>



                <tbody>
                    <?php
                    $sql = $conexion->query("SELECT id_cuenta, nombre, tipo, nro_cuenta, recibe_saldo FROM cuenta ORDER BY nro_cuenta ASC");
                    while ($datos = $sql->fetch_object()) { ?>
                        <tr>
                            <td>
                                <?= $datos->nro_cuenta ?>
                            </td>
                            <td>
                                <?= $datos->nombre ?>
                            </td>
                            <td>
                                <?= $datos->recibe_saldo ?>
                            </td>
                            <td>
                                <?= $datos->tipo ?>
                            </td>
                            <td>
                                <div>
                                <?php
                                    if ($rol === "admin") {
                                        echo '<a href="modificacion.php?id=' . $datos->id_cuenta . '"><i class="fa-regular fa-pen-to-square m-2"></i></a>';
                                        echo '<a onclick="return eliminar()" href="plandecuentas.php?id=' . $datos->id_cuenta . '"><i class="fa-solid fa-trash m-2"></i></a>';
                                    }
                                ?>
                                </div>
                            </td>
                        </tr>

                    <?php }
                    ?>

                </tbody>
            </table>

        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
                        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
                        crossorigin="anonymous"></script>
</body>

</html>