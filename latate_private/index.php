<?php require "./inc/session_start.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Incluir el head como modulo de plantilla -->
    <?php include "./inc/head.php"; ?>
</head>

<body>


    <!-- Incluir desde la carpeta inc la plantilla del navbar y el script del navbar responsive -->
    <?php
    /* Si view no está definida o está vacia */
    if (!isset($_GET["view"]) || $_GET["view"] == "") {
        /* Entonces cargará la página de login */
        $_GET["view"] = "login";
    }
    /* Si existe un file .php que sea diferente a login.php y 404.php*/
    if (is_file("./views/" . $_GET["view"] . ".php") && $_GET["view"] != "login" && $_GET["view"] != "404") {

        /* Restringir acceso solo en cuanto se haya iniciado sessión */
        if ((!isset($_SESSION["id"])) || ($_SESSION["id"] == "") || (!isset($_SESSION["user"])) || ($_SESSION["user"] == "")) {
            /* Si no hay sesión iniciada se redirecciona a la página de login y forzará el cierre de sesión */
            include "./views/logout.php";
            exit();
        }

        /* Entonces se mostrará el navbar responsive */
        include "./inc/navbar.php";
        /* y la view que responde al if */
        include "./views/" . $_GET["view"] . ".php";

        include "./inc/script.php";
    } else {
        /* si el nombre de esa views es == a login entonce se cargará la página de login */
        if ($_GET["view"] == "login") {
            include "./views/login.php";
        } else {
            /* en el caso no se encontrara la página se mostraría la página 404 */
            include "./views/404.php";
        }
    }
    ?>
</body>

</html>