<?php
/*  conexión a la BD */
function conection()
{
    $pdo = new PDO('mysql:host=localhost;dbname=latate_app', 'root', '');
    return $pdo;
}

/* PRUEBA FUNCIONAMIENTO CONNEXIÓN BD */
/* $pdo->query("INSERT INTO category(category_name, category_site) VALUES('prueba','texto prueba')"); */

/* VERIFICAR DATOS */
function verifyData($filter, $string){
    if (preg_match("/^" . $filter . "$/", $string)) {
        return false;
    } else {
        return true;
    }
}
/* function verifyData($filter, $string) {
    // Aquí aseguramos que la expresión esté bien formada
    if (preg_match("/^" . $filter . "$/u", $string)) {
        return false; // No hay error
    } else {
        return true; // Hay error
    }
} */

/* FUNCIÓN PARA LIMPIAR CADENAS DE TEXTO Y EVITAR INIECCIONES SQL EN LOS INPUT*/

function cleanString($string)
{
    /* Eliminar espacios en blanco */
    $string = trim($string);
    /* Eliminar barras */
    $string = stripslashes($string);
    /* Evitar iniección de codigo JS */
    $string = str_ireplace("<script>", "", $string);
    $string = str_ireplace("</script>", "", $string);
    $string = str_ireplace("<script src>", "", $string);
    $string = str_ireplace("<script type>", "", $string);
    /* Evitar todas las peticiones mysql */
    $string = str_ireplace("SELECT * FROM", "", $string);
    $string = str_ireplace("DELETE FROM", "", $string);
    $string = str_ireplace("INSERT INTO", "", $string);
    $string = str_ireplace("DROP TABLE", "", $string);
    $string = str_ireplace("DROP DATABASE", "", $string);
    $string = str_ireplace("TRUNCATE TABLE", "", $string);
    $string = str_ireplace("SHOW TABLES", "", $string);
    $string = str_ireplace("SHOW DATABASES", "", $string);
    /* Evitar iniección de codigo PHP */
    $string = str_ireplace("<?php", "", $string);
    $string = str_ireplace("?>", "", $string);
    /* Evitar simbulos */
    $string = str_ireplace("--", "", $string);
    $string = str_ireplace("^", "", $string);
    $string = str_ireplace("<", "", $string);
    $string = str_ireplace("[", "", $string);
    $string = str_ireplace("]", "", $string);
    $string = str_ireplace("==", "", $string);
    $string = str_ireplace(";", "", $string);
    $string = str_ireplace("::", "", $string);
    $string = trim($string);
    $string = stripslashes($string);
    return $string;
}

/* RENOMBRAR FOTOS */
function renamePhotos($photoName)
{
    /* Remplazamos los caracteres no permitidos en las nominaciones por guión bajo */
    $photoName = str_ireplace(" ", "_", $photoName);
    $photoName = str_ireplace("/", "_", $photoName);
    $photoName = str_ireplace("#", "_", $photoName);
    $photoName = str_ireplace("-", "_", $photoName);
    $photoName = str_ireplace("$", "_", $photoName);
    /* $photoName= str_ireplace(".","_",$photoName); */
    $photoName = str_ireplace(",", "_", $photoName);
    /* Renombramos la foto */
    $photoName = $photoName . "_" . rand(0, 100);
    return $photoName;
}

/* PAGINADOR DE TABLAS */
function tablesPager($page, $nPages, $url, $buttons)
{
    $table = '<nav class="pagination is-centered is-rounded" role="navigation" aria-label="pagination"';
    /* Comprobamos si estamos en la primera página. 
   Si así resulta se desactivará la opción de página anterior*/
    if ($page <= 1) {
        $table.= '
        <a class="pagination-previous is-disabled" disabled >Previous</a>
        <ul class="pagination-list">';
    } else {
        $table.= '
        <a class="pagination-previous" href="' . $url . ($page - 1) . '">Previous</a>
        <ul class="pagination-list">
            <li><a class="pagination-link" href="' . $url . '1">1</a></li>
            <li><span class="pagination-ellipsis">&hellip;</span></li>';
    }

    $ci = 0;
    /* Añadimos los botones de navegación */
    for ($i = $page; $i <= $nPages; $i++) {
        if ($ci == $buttons) break;

        if ($i == $page) {
            /* $table.='<li class="pagination-item is-active"><a class="pagination-link" href="'.$url.$i.'">'.$i.'</a></li>'; */
            $table .= '<li><a class="pagination-link is-current" href="' . $url . $i . '">' . $i . '</a></li>';
        } else {
            $table.= '<li><a class="pagination-link" href="' . $url . $i . '">' . $i . '</a></li>';
        }

        $ci++;
    }

    /* Verificamos si estamos en la última página
    Si así resulta se desactivará la opción de página posterior */
    if ($page = $nPages) {
        $table.= '
        </ul>
        <a class="pagination-next is-disabled" disabled >Next</a>';
    } else {
        $table.= '
        <li><span class="pagination-ellipsis">&hellip;</span></li>
        <li><a class="pagination-link" href="' . $url . $nPages . '">' . $nPages . '</a></li>
        </ul>
        <a class="pagination-next" href="' . $url . ($page + 1) . '">Next</a>';
    }


    $table.= '</nav>';
    return $table;
}


