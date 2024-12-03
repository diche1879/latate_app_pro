<?php
$module_search = cleanString($_POST['module_search']);

/* Establecer que este código solo funcionará si en un input oculto del formulario estará presente uno de los términos del array */
$modules = ["user", "category", "product", "client", "order"];

/* Condicional que verifica si lo que contiene $module_search existe en array $modules por medio del método de PHP in_array() */
if (in_array($module_search, $modules)) {
    /* Un array de las vistas al que redireccionamos un usuario cuando se borra el término de búsqueda */
    $modules_url = [
        "user" => "user_search",
        "category" => "category_search",
        "product" => "product_search",
        "client" => "client_search",
        "order" => "order_search"
    ];

    /* Sobrescribimos la variable asignando el valor correspondiente al almacenado en $module_search */
    $modules_url = $modules_url[$module_search];

    /* Nombre de la variable de sesión */
    $module_search = "search_" . $module_search;

    if (isset($_POST['txt_searcher'])) {
        $txt = cleanString($_POST['txt_searcher']);
        if ($txt == "") {
            $error_message = '
               <div class="notification is-danger is-light">
                 <strong>ERROR!</strong>
                 <p>Enter your search term</p>
               </div>';
        } else {
            if (verifyData("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ -]{1,30}", $txt)) {
                $error_message = '
               <div class="notification is-danger is-light">
                 <strong>ERROR!</strong>
                 <p>Search term does not match the specified format</p>
               </div>';
            } else {
                // Sin salida previa, directo a header()
                $_SESSION[$module_search]=$txt;
                header("Location: index.php?view=$modules_url", true, 303);
                exit(); // Es importante asegurarse de salir después de redirigir
            }
        }
    }
    
    if (isset($error_message)) {
        echo $error_message; // Solo imprime si es necesario
    }

    /* Eliminar busqueda */
    if (isset($_POST['delete_searcher'])) {
        unset($_SESSION[$module_search]);
        header("Location: index.php?view=$modules_url", true, 303);
        exit();
    };
} else {
    echo '
    <div class="notification is-danger is-light">
      <strong>ERROR!</strong>
      <p>The request could not be executed</p>
    </div>';
}

    /* Iniciar búsqueda */
    /* if (isset($_POST['txt_searcher'])) {
        $txt = cleanString($_POST['txt_searcher']);
        if ($txt == "") {
            echo '
               <div class="notification is-danger is-light">
                 <strong>ERROR!</strong>
                 <p>Enter your search term</p>
               </div>';
        } else {
            if (verifyData("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ -]{1,30}", $txt)) {
                echo '
               <div class="notification is-danger is-light">
                 <strong>ERROR!</strong>
                 <p>Search term does not match the specified format</p>
               </div>';
            } else {
                // Aquí no debería haber ninguna salida antes de header()
                $_SESSION[$module_search] = $txt;
                header("Location: index.php?view=$modules_url", true, 303);
                exit();
            }
        }
    }; */
