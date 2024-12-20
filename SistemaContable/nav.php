<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>nav</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top" style="padding-top: 0px;padding-bottom: 0px">
        <div class="container-fluid bg-primary-subtle text-emphasis-primary">
            <a class="navbar-brand ms-2" href="/php-login">
                <img src="/php-login/assets/mk-asociados-low-resolution-logo-color-on-transparent-background.png"
                    alt="MK Asociados" width="250" height="60">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse d-flex" id="navbarNav">
                <ul class="navbar-nav " style="margin-left: auto">
                    <li class="nav-item dropdown p-2 m-2">
                        <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <b>Asientos Contables</b>
                        </a>
                        <ul class="dropdown-menu bg-secondary-subtle ">
                            <li><a class="dropdown-item" href="asientos.php">Listado de Asientos</a></li>
                            <li><a class="dropdown-item" href="registrarAsiento.php">Registrar Asiento</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="plandecuentas.php">Plan de Cuentas</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown p-2 m-2">
                        <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <b>Libros Contables</b>
                        </a>
                        <ul class="dropdown-menu ">
                            <li><a class="dropdown-item" href="libroDiario.php">Libro Diario</a></li>
                            <li><a class="dropdown-item" href="libroMayor.php">Libro Mayor</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown p-2 m-2">
                        <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <b>Sistema de Ventas</b>
                        </a>
                        <ul class="dropdown-menu ">
                            <li><a class="dropdown-item" href="ventas.php">Ventas</a></li>
                            <li><a class="dropdown-item" href="stock.php">Administración de Stock</a></li>
                            <li><a class="dropdown-item" href="clientes.php">Administración de Clientes</a></li>
                            <li><a class="dropdown-item" href="informeVentas.php">Informe de Ventas</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
                        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
                        crossorigin="anonymous"></script>
</body>

</html>