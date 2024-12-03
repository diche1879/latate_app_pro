<?php

/* Desde donde empezamos a contar los registros que se mostrarán en cada página */
$start = ($page > 0) ? (($page * $registers) - $registers) : 0;

$table = "";

/* Consulta para busqueda donde search es la variable que ingresa el usuario, si no está definida entonces se proporcionará el listado sin filtros aplicados */
if (isset($search) && $search != "") {
    /* creamos la consulta para la busqueda */
    $query_data = "SELECT * FROM category WHERE category_name LIKE '%$search%' OR category_site LIKE '%$search%' ORDER BY category_name ASC LIMIT $start, $registers";

    $query_total = "SELECT COUNT(id_category) FROM category WHERE category_name LIKE '%$search%' OR category_site LIKE '%$search%'";
} else {
    $query_data = "SELECT * FROM category ORDER BY category_name ASC LIMIT $start, $registers";
    $query_total = "SELECT COUNT(id_category) FROM category";
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
                    <th>Name</th>
                    <th>Storage location</th>
                    <th>Products</th>
                    <th colspan="2">Options</th>
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
                <td>'.$row['category_name'].'</td>
                <td>'.substr($row['category_site'], 0, 25).'</td>
                <td>
                    <a href="index.php?view=product_category&category_id='.$row['id_category'].'" class="button is-info is-rounded is-small">See the products</a>
                </td>
                <td>
                    <a href="index.php?view=category_act&category_id_up='.$row['id_category'].'" class="button is-success is-rounded is-small">Update</a>
                </td>
                <td>
                    <a href="'.$url.$page.'&category_id_del='.$row['id_category'].'" class="button is-danger is-rounded is-small">Delete</a>
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
                <td colspan="6">
                    <a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
                        Haga clic acá para recargar el listado
                    </a>
                </td>
            </tr>
        ';
    } else {
        $table.= '
            <tr class="has-text-centered" >
                <td colspan="6">
                    No hay registros en el sistema
                </td>
            </tr>
        ';
    }
}

$table .= '</tbody></table></div>';

if($result_total >= 1 && $page <= $nPages){
    $table.= '
    <p class="has-text-right">Showing category from <strong>'.$pag_start.'</strong> to <strong>'.$pag_end.'</strong> of <strong>a total '.$result_total.'</strong></p>
    ';
}   
$connection =null;

echo $table;    
if($result_total >= 1 && $page <= $nPages){
    echo  tablesPager($page, $nPages, $url, 3);
};