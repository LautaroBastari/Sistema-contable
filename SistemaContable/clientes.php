<?php
session_start();
$id_usuario = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Clientes</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>
    <?php include './nav.php' ?>

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
                <h1><b>Administración de Clientes</b></h1>
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
                echo 'Añadir Cliente';
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
                            <h3 class="text-center text-secondary">Registro de clientes</h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST">
                                <?php
                                include "conexionPDC.php";
                                include "controlador/registrarCliente.php";
                                ?>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" name="nombre">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Codigo de cliente</label>
                                    <input type="number" class="form-control" name="codigo">
                                </div>

                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">DNI</label>
                                    <input type="number" class="form-control" name="dni">
                                </div>

                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">CUIT</label>
                                    <input type="number" class="form-control" name="cuit">
                                </div>

                                <div class="mb-3">
                                    <label for="condicion" class="form-label">Condición Fiscal</label>
                                    <select class="form-control" name="cond_fiscal" id="cond_fiscal">
                                        <option value="Responsable Inscripto">Responsable Inscripto</option>
                                        <option value="Monotributista">Monotributista</option>
                                        <option value="Exento al IVA">Exento al IVA</option>
                                        <option value="Consumidor Final">Consumidor Final</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Direccion</label>
                                    <input type="text" class="form-control" name="direccion">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Email</label>
                                    <input type="text" class="form-control" name="email">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Teléfono</label>
                                    <input type="number" class="form-control" name="telefono">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Saldo iniciante</label>
                                    <input type="number" class="form-control" name="saldo">
                                </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary" name="agregar" value="Ok">Agregar cliente</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <hr class="container mb-2 d-flex justify-content-center" style="width:70%">
        </hr>
        <div class="col-11 pt-2 container text-center">
            <table class="table table-bordered">
                <thead class="bg-info">
                    <tr >
                        <th scope="col">Nombre</th> 
                        <th scope="col">Código de Cliente</th>
                        <th scope="col">DNI</th>
                        <th scope="col">CUIT</th>
                        <th scope="col">Condición Fiscal</th>
                        <th scope="col">Dirección</th>
                        <th scope="col">Email</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col">Saldo</th>
                        <th scope="col">Límite de Crédito</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include "conexionPDC.php";
                    $sql = $conexion->query("SELECT * FROM clientes");
                    while ($datos = $sql->fetch_object()) { ?>
                        <tr>
                            <td>
                                <?= $datos->nombre ?> 
                            </td>
                            <td>
                                <?= $datos->codigo ?>
                            </td>
                            <td>
                                <?= $datos->dni ?>
                            </td>
                            <td>
                                <?= $datos->cuit ?>
                            </td>
                            <td>
                                <?= $datos->cond_fiscal ?>
                            </td>
                            <td>
                                <?= $datos->direccion ?>
                            </td>
                            <td>
                                <?= $datos->email ?>
                            </td>
                            <td>
                                <?= $datos->telefono ?>
                            </td>
                            <td>
                                <?= $datos->saldo ?>
                            </td>
                            <td>
                                <?= $datos->limite ?>
                            </td>
                        </tr>
                    <?php }
                    ?>
                </tbody>
            </table>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>