<?php
session_start();
$id_usuario = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libro Diario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

</head>

<body >

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
            <div class="container d-flex justify-content-center mt-2 mb-3">
                <h1><b>Libro Diario</b></h1>
            </div>
        </div>
        <hr class="container  mb-2 d-flex justify-content-center" style="width:70%">
        </hr>
        <div class="col-10 p-4 container text-center">

            <table class="table table-bordered">

                <thead class="table-info">
                    <tr>
                        <th scope="col">Nro de Asiento</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Cuenta</th>
                        <th scope="col">Debe</th>
                        <th scope="col">Haber</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include "conexionPDC.php";
                    $sql = $conexion->query("SELECT * 
                                            FROM asiento a 
                                            inner join registrar_asiento r 
                                            ON a.id_asiento = r.id_asiento");
                    while ($datos = $sql->fetch_object()) {
                        $id_cuenta = $datos->id_cuenta;
                        $sql_cuenta = $conexion->query("SELECT nombre FROM cuenta where id_cuenta = $id_cuenta");
                        $nombre_cuenta = $sql_cuenta->fetch_assoc();
                        ?>
                        <tr>
                            <td>
                                <?= $datos->id_asiento ?>
                            </td>
                            <td>
                                <?= $datos->fecha ?>
                            </td>
                            <td>
                                <?= $datos->descripcion ?>
                            </td>
                            <td>
                                <?= $nombre_cuenta["nombre"] ?>
                            </td>
                            <td>
                                <?= $datos->debe ?>
                            </td>
                            <td>
                                <?= $datos->haber ?>
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