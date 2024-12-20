<?php
session_start();
$id_usuario = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libro Mayor</title>
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
            <div class="container d-flex justify-content-center mb-2">
                <h1><b>Libro Mayor</b></h1>
            </div>
        </div>
        <hr class="container mt-4 mb-2 d-flex justify-content-center" style="width:70%">
        </hr>
        <div class="col-10 p-4 container text-center">

            <form action="" method="get">
                <label for="tipo" class="form-label">Seleccionar cuenta: </label>
                <div class="container d-flex justify-content-center mb-3">
                    <select class="form-control-sm" name="busqueda" id="busqueda">
                        <option value="busqueda">
                            <?php
                            include "conexionPDC.php";
                            $sql = $conexion->query("SELECT nombre, nro_cuenta,tipo,recibe_saldo  from cuenta ORDER BY nro_cuenta ASC");
                            while ($datos = $sql->fetch_object()) {
                                $tipo_cuenta= $datos->tipo;
                            if ($datos->recibe_saldo == 1 && ($datos->tipo=="Ac" || $datos->tipo=="Pa")) {
                                echo '<option value="' . $datos->nombre . '">' . $datos->nombre . '  > -Numero de cuenta: ' . $datos->nro_cuenta . '  > -Tipo: '.$tipo_cuenta.'</option>';
                            }
                        }
                            ?>
                        </option>
                    </select>

                    <div class="d-flex ms-2 ">

                        <button type="submit" class="btn btn-primary" name="enviar">Buscar</button>
            </form>
        </div>
    </div>
    <table class="table table-bordered">

        <thead class="table-info">
            <tr>
                <th scope="col">Nro de Asiento</th>
                <th scope="col">Descripción</th>
                <th scope="col">Debe</th>
                <th scope="col">Haber</th>
                <th scope="col">Total</th>
            </tr>
        </thead>

        <tbody>
        <tbody>
            <?php
            include "conexionPDC.php";
            if (isset($_GET['enviar'])) {
                if (isset($_GET['busqueda'])) {
                    $busqueda = $_GET['busqueda'];
                    $sql_cuenta = $conexion->query("SELECT id_cuenta, saldo_final FROM cuenta WHERE nombre LIKE '%$busqueda'");
                    if ($sql_cuenta) {
                        $datos_cuenta = $sql_cuenta->fetch_object();
                        $id_cuenta = $datos_cuenta->id_cuenta;
                        $sql_cruce_tablas = $conexion->query("SELECT a.id_asiento, a.descripcion, r.debe, r.haber, r.saldo_parcial, r.id_cuenta
                                                                        FROM asiento a 
                                                                        inner join registrar_asiento r 
                                                                        ON a.id_asiento = r.id_asiento
                                                                        where r.id_cuenta = $id_cuenta ");
                        if ($sql_cruce_tablas) { //Tengo que conseguir el numero de cuenta, a traves del input, buscarlo en la tabla cuenta y traer el id_cuenta
                            $sql_nombre_cuenta = $conexion->query("SELECT nombre FROM cuenta WHERE id_cuenta = $id_cuenta");
                            $dato_cuenta = $sql_nombre_cuenta->fetch_object();
                            $nombre_cuenta = $dato_cuenta->nombre;
                            echo "Cuenta: " . $nombre_cuenta;
                            while ($datos_libro_mayor = $sql_cruce_tablas->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td>
                                        <?= $datos_libro_mayor["id_asiento"]; ?>
                                    </td>
                                    <td>
                                        <?= $datos_libro_mayor["descripcion"]; ?>
                                    </td>
                                    <td>
                                        <?= "$" . $datos_libro_mayor["debe"]; ?>
                                    </td>
                                    <td>
                                        <?= "$" . $datos_libro_mayor["haber"]; ?>
                                    </td>
                                    <td>
                                        <?= "$" . $datos_libro_mayor["saldo_parcial"]; ?>
                                    </td>
                                </tr>
                            <?php
                            }
                        }
                    }
                }

            }
            ?>
        </tbody>

    </table>

    </div>
    </div>

</body>

</html>