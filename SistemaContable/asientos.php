<?php
session_start();
$id_usuario = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>
        Asientos Contables
    </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/646ac4fad6.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</head>

<body>
    <?php include './nav.php' ?>
    <div class="container border border-primary-light pt-5 pb-5 mb-5 mt-5 bg-light text-dark">

        <div class="container d-flex ">
            <button type="submit" name="button" class="btn" onclick="goBack()"><i
                    class="bi bi-caret-left-fill"></i></button>
            <script>
                function goBack() {
                    window.history.go(-1);
                }
            </script>
            <div class="container d-flex justify-content-center mb-2">
                <h1><b>Asientos Contables</b></h1>
            </div>
        </div>
        <hr class="container mt-2 mb-4 d-flex justify-content-center" style="width:70%">
        </hr>
        <div class="container row ">
        <?php
            if (isset($_GET['success'])) {
                $success = $_GET['success'];
                if ($success == 'asiento_registrado') {
                    echo "<div class='alert alert-success'  style='text-align: center;'>Registro efectuado correctamente.</div>";
                } 
            }
        ?>
            <form action="" method="GET">

                <div class="row">

                    <div class="col-md-4">

                        <div class="form-group">
                            <label><b>Del Dia</b></label>
                            <input type="date" name="from_date" value="<?php if (isset($_GET['from_date'])) {
                                echo $_GET['from_date'];
                            } ?>" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><b> Hasta el Dia</b></label>
                            <input type="date" name="to_date" value="<?php if (isset($_GET['to_date'])) {
                                echo $_GET['to_date'];
                            } ?>" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><b></b></label> <br>
                            <button type="submit" class="btn btn-info">Filtrar</button>
                            <button type="submit" class="btn btn-secondary" name="clear">Limpiar filtro</button>
                        </div>
                    </div>
                </div>
                <br>
            </form>
        </div>
        <hr class="container mt-4 mb-2 d-flex justify-content-center" style="width:70%">
        </hr>

        <div class="col-8 p-4 container text-center">

            <table class="table table-bordered">

                <thead class="table-info">
                    <tr>
                        <th scope="col">Fecha</th>
                        <th scope="col">Nro Asiento</th>
                        <th scope="col">Descripción</th>
                        <th scope="col"></th>
                    </tr>
                </thead>

                <tbody>
                    <?php

                    include "conexionPDC.php";
                    $sql_extraer_id_usuario = $conexion->query("select id_usuario from usuarios where id_usuario='$id_usuario'");
                    if ($sql_extraer_id_usuario) {
                        $datos_id_usuario = $sql_extraer_id_usuario->fetch_assoc();
                    }
                    $id_usuario = $_SESSION['user_id'];
                    if (isset($_GET['clear'])) {
                        $sql = $conexion->query("SELECT id_asiento, fecha, descripcion
                            FROM asiento
                            WHERE id_usuario = $id_usuario
                            AND (id_asiento, fecha) IN (SELECT id_asiento, MIN(fecha) FROM asiento GROUP BY id_asiento)
                            ORDER BY fecha;");
                    } elseif (!empty($_GET["from_date"]) && !empty($_GET["to_date"])) {
                        $fechadesde = $_GET['from_date'];
                        $fechahasta = $_GET['to_date'];
                        $sql = $conexion->query("SELECT id_asiento, fecha, descripcion
                            FROM asiento
                            WHERE id_usuario = $id_usuario AND fecha BETWEEN '$fechadesde' AND '$fechahasta'
                            AND (id_asiento, fecha) IN (SELECT id_asiento, MIN(fecha) FROM asiento GROUP BY id_asiento)
                            ORDER BY fecha;");
                    } else {
                        $sql = $conexion->query("SELECT id_asiento, fecha, descripcion
                            FROM asiento
                            WHERE id_usuario = $id_usuario
                            AND (id_asiento, fecha) IN (SELECT id_asiento, MIN(fecha) FROM asiento GROUP BY id_asiento)
                            ORDER BY fecha;");
                    }
                    if ($sql) {

                    } else {
                        echo "Error en la consulta: " . $conexion->error;
                    }
                    while ($datos = $sql->fetch_object()) {
                        ?>
                        <tr>
                            <td>
                                <?php
                                echo $datos->fecha;
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $datos->id_asiento;
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $datos->descripcion;
                                ?>
                            </td>

                            <td>
                                <a href="./verAsiento.php?id=<?= $datos->id_asiento ?>"><i class="bi bi-eye-fill"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>

        </div>
        <div class="text-center m-3 p-3">
            <a class="btn btn-primary" href="registrarAsiento.php" role="button">Registrar nuevo asiento</a>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>