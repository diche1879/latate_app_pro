<?php

/* Desde donde empezamos a contar los registros que se mostrarán en cada página */
$start = ($page > 0) ? (($page * $registers) - $registers) : 0;

$table = "";

/* Guardamos los campos que querermos buscar en una variable */
$fields = "clients.id_client,clients.email_client,clients.username_client,clients.client_company,clients.client_nif,clients.client_phone,clients.client_country,clients.client_city,clients.client_address,clients.client_p_code,roles.name_rol";

if (isset($search) && $search != "") {
    /* creamos la consulta para la busqueda */
    $query_data = "SELECT $fields FROM clients INNER JOIN roles ON roles.id_role = clients.id_role WHERE clients.email_client LIKE '%$search%' OR clients.username_client LIKE '%$search%' OR roles.name_rol LIKE '%$search%' ORDER BY clients.username_client ASC LIMIT $start, $registers";

    $query_total = "SELECT COUNT(clients.id_client) FROM clients INNER JOIN roles ON roles.id_role = clients.id_role 
                    WHERE clients.username_client LIKE '%$search%' 
                    OR clients.email_client LIKE '%$search%' 
                    OR roles.name_rol LIKE '%$search%' ORDER BY clients.username_client ASC";
} else {
    $query_data = "SELECT $fields FROM clients INNER JOIN roles ON roles.id_role = clients.id_role ORDER BY username_client ASC LIMIT $start, $registers";
    $query_total = "SELECT COUNT(id_client) FROM clients";
};

/* conexión bd */
$connection = conection();

/* Crear una variable que contendrá todos los datos del cliente en un array  */
$result_data = $connection->query($query_data);
/* La sobrescribimos y la transformamos en un array */
$result_data = $result_data->fetchAll();

/* Lo mismo se hará con el número tottal de registros */
$result_total = $connection->query($query_total);
/* La convertimos a entero y nos devolverá una única columna de los resultados */
$result_total = (int)$result_total->fetchColumn();

/* calcular el número de páginas a crear dividiendo el número total de registros por los establecidos en la variables registers y lo redondeamos por ecceso col metodo ceil()*/
$nPages = ceil($result_total / $registers);

/* Generar una tabla de clientes */

$table.= '
  <div class="table-container">
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <thead>
                <tr class="has-text-centered">
                    <th>#</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Company</th>
                    <th>Tax Number</th>
                    <th>Telephone</th>
                    <th>Country</th>
                    <th>City</th>
                    <th>Address</th>
                    <th>P.Code</th>
                    <th>Role</th>
                    <th colspan="3">Options</th>
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
                <td>'.$row['username_client'].'</td>
                <td>'.$row['email_client'].'</td>
                <td>'.$row['client_company'].'</td>
                <td>'.$row['client_nif'].'</td>
                <td>'.$row['client_phone'].'</td>
                <td>'.$row['client_country'].'</td>
                <td>'.$row['client_city'].'</td>
                <td>'.$row['client_address'].'</td>
                <td>'.$row['client_p_code'].'</td>
                <td>'.$row['name_rol'].'</td>
               
                <td>
                    <a href="index.php?view=client_update&client_id_up='.$row['id_client'].'" class="button is-success is-rounded is-small">Update</a>
                </td>
                <td>
                    <a href="'.$url.$page.'&client_id_del='.$row['id_client'].'" class="button is-danger is-rounded is-small">Delete</a>
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