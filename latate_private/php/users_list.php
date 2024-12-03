<?php

/* Desde donde empezamos a contar los registros que se mostrarán en cada página */
$start = ($page > 0) ? (($page * $registers) - $registers) : 0;

$table = "";

/* Consulta para busqueda donde search es la variable que ingresa el usuario, si no está definida entonces se proporcionará el listado sin filtros aplicados */
if (isset($search) && $search != "") {
    /* creamos la consulta para la busqueda */
    $query_data = "SELECT * FROM usuario WHERE ((id_user != '".$_SESSION['id']."') AND(user_name LIKE '%$search%' OR user_surname LIKE '%$search%' OR user LIKE '%$search%' OR user_mail LIKE '%$search%')) ORDER BY user_name ASC LIMIT $start, $registers";

    $query_total = "SELECT COUNT(id_user) FROM usuario WHERE ((id_user != '".$_SESSION['id']."') AND (user_name LIKE '%$search%' OR user_surname LIKE '%$search%' OR user LIKE '%$search%' OR user_mail LIKE '%$search%'))";
} else {
/* Se proporciona el listado de todos los usuarios fuera que el usuario que ha empèzado sesión.
    le ponemos el limite desde cuando queremos empezar a contar hasta donde queremos llegar*/
    $query_data = "SELECT * FROM usuario WHERE id_user != '".$_SESSION['id']."' ORDER BY user_name ASC LIMIT $start, $registers";

    /* Contamos todos los registros escluido el usuario que inició sesión */
    $query_total = "SELECT COUNT(id_user) FROM usuario WHERE id_user != '".$_SESSION['id']."'";
};

/* Establecemos la conexión a la base de datos */
$connection = conection();

/* Crear una variable que contendrá todos los datos de los usuarios en un array  */
$result_data = $connection->query($query_data);
/* La sobrescribimos y la transformamos en un array */
$result_data = $result_data->fetchAll();


/* Lo mismo se hará con el número tottal de registros */
$result_total = $connection->query($query_total);
/* La convertimos a entero y nos devolverá una única columna de los resultados */
$result_total = (int)$result_total->fetchColumn();

/* calcular el número de páginas a crear dividiendo el número total de registros por los establecidos en la variables registers y lo redondeamos por ecceso col metodo ceil()*/
$nPages = ceil($result_total / $registers);


/* Generar la tabla de los usuarios */
$table.= '
  <div class="table-container">
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <thead>
                <tr class="has-text-centered">
                    <th>#</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th colspan="2">Opciones</th>
                </tr>
            </thead>
            <tbody>
';

if ($result_total >= 1 && $page <= $nPages) {
    $counter = $start + 1;
    $pag_start = $start + 1;
    /* Recorremos el array donde hay almacenados todos los usuario y por cada usauario creamos una linea de la tabla con sus botones modificar e eliminar */
    foreach($result_data as $row) {
        $table.='
            <tr class="has-text-centered" >
				<td>'.$counter.'</td>
                <td>'.$row['user_name'].'</td>
                <td>'.$row['user_surname'].'</td>
                <td>'.$row['user'].'</td>
                <td>'.$row['user_mail'].'</td>
                <td>
                    <a href="index.php?view=act_user&user_id_up='.$row['id_user'].'" class="button is-success is-rounded is-small">Update</a>
                </td>
                <td>
                    <a href="'.$url.$page.'&user_id_del='.$row['id_user'].'" class="button is-danger is-rounded is-small">Delete</a>
                </td>
            </tr>
        ';
        $counter++;
    };
    $pag_end = $counter - 1;
} else {
    if ($result_total >= 1) {
        $table.= '
            <tr class="has-text-centered" >
                <td colspan="7">
                    <a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
                        Haga clic acá para recargar el listado
                    </a>
                </td>
            </tr>
        ';
    } else {
        $table.= '
            <tr class="has-text-centered" >
                <td colspan="7">
                    No hay registros en el sistema
                </td>
            </tr>
        ';
    }
}

$table .= '</tbody></table></div>';

if($result_total >= 1 && $page <= $nPages){
    $table.= '
    <p class="has-text-right">Mostrando usuarios <strong>'.$pag_start.'</strong> al <strong>'.$pag_end.'</strong> de un <strong>total de '.$result_total.'</strong></p>
    ';
}   
$connection =null;

echo $table;    
if($result_total >= 1 && $page <= $nPages){
    echo  tablesPager($page, $nPages, $url, 3);
};