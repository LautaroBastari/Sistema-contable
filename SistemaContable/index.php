<?php
session_start();

require 'database.php';

if (isset($_SESSION['user_id'])) {
    $records = $conn->prepare('SELECT id_usuario, email, password 
                                    FROM usuarios 
                                    WHERE id_usuario = :id_usuario');
    //Prepare: Hace una consulta a la base de datos.
    $records->bindParam(':id_usuario', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $user = null;

    if (is_array($results) && count($results) > 0) {
        $user = $results;
    }
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>
        Inicio
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/646ac4fad6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">



</head>

<body>
    <?php if (!empty($user)): ?>
        <?php include './nav.php' ?>
    <?php endif ?>
    <div class="container border border-primary-light pt-5 pb-2 mb-5 mt-5 bg-light text-dark">
        <div class="container text-center">
            <?php if (!empty($user)): ?>
                <div class="container mb-5 text-center">
                    <img src="/php-login/assets/mk-asociados-low-resolution-logo-color-on-transparent-background.png"
                        alt="MK Asociados" width="250" height="50" class="mb-4">
                    <h1><b>Bienvenido

                            <?= $user['email'] ?>
                        </b>
                    </h1>
                    <hr class="container mt-4 mb-2 d-flex justify-content-center" style="width:70%">
                    </hr>
                    <br>Has ingresado correctamente.</br>
                    <br>Puedes realizar estas operaciones:
                    <div class="row row-cols-2  m-3">
                        <div class="container border border-black bg-danger-subtle p-4">
                            <i class="bi bi-table"></i>
                            <a href="asientos.php">Asientos contables</a>
                        </div>
                        <div class="container border border-black bg-info-subtle p-4">
                            <i class="bi bi-table"></i>
                            <a href="plandecuentas.php">Plan de cuentas</a>
                        </div>
                        <div class="container border border-black bg-info-subtle p-4">
                            <i class="fa-sharp fa-solid fa-book "></i>
                            <a href="libroDiario.php">Libro Diario</a>
                        </div>
                        <div class="container border border-black bg-danger-subtle p-4">
                            <i class="bi bi-book ms-2"></i>
                            <a href="libroMayor.php">Libro Mayor</a>
                        </div>
                        <div class="container border border-black bg-danger-subtle p-4">
                            <i class="bi bi-briefcase"></i>
                            <a href="ventas.php">Registro de Ventas</a>
                        </div>
                        <div class="container border border-black bg-info-subtle p-4">
                            <i class="bi bi-file-bar-graph"></i>
                            <a href="clientes.php">Administración de Clientes</a>
                        </div>
                        <div class="container border border-black bg-info-subtle p-4">
                            <i class="bi bi-archive"></i>
                            <a href="stock.php">Administración de Stock</a>
                        </div>
                        <div class="container border border-black bg-danger-subtle p-4">
                            <i class="bi bi-card-list"></i>
                            <a href="informeVentas.php">Informe de Ventas</a>
                        </div>
                        <div class="container border border-black p-4">
                            <i class="bi bi-escape"></i>
                            <a href="logout.php">Cerrar Sesión</a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    <?php else: ?>
        <div class="container border border-primary-light pt-5 pb-2 mb-5 mt-5 bg-danger-subtle text-dark">
            <h1>¡Bienvenido a nuestro Sistema Contable!</h1>
            <h4>Por favor, ingresa a tu cuenta o registrate en el caso que no tengas una</h4>
            <a href="login.php">Ingresar</a> o
            <a href="signup.php">Registrarme</a>
        </div>
    <?php endif; ?>

</body>

</html>