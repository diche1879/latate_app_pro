<?php

/* Desde donde empezamos a contar los registros que se mostrarán en cada página */
$start = ($page > 0) ? (($page * $registers) - $registers) : 0;

$table = "";

/* Guardar en variables los campos que queremos buscar */
$fields = "orders.id_order,orders.id_client,orders.order_date,orders.order_amount,orders.order_state,orders.order_pdf,clients.id_client,clients.username_client,clients.id_role,roles.id_role,roles.name_rol";

if (isset($search) && $search != '') {
    $query_data = "SELECT $fields 
               FROM orders 
               INNER JOIN clients ON orders.id_client = clients.id_client 
               INNER JOIN roles ON clients.id_role = roles.id_role 
               WHERE orders.order_state LIKE '%$search%' 
                  OR clients.username_client LIKE '%$search%' 
                  OR roles.name_rol LIKE '%$search%' 
               ORDER BY clients.username_client";

    $query_total = "SELECT COUNT(orders.id_order) FROM orders INNER JOIN clients ON orders.id_client = clients.id_client INNER JOIN roles ON clients.id_role = roles.id_role WHERE orders.order_state LIKE '%$search%' OR clients.username_client LIKE '%$search%' OR roles.name_rol LIKE '%$search%'";
} else {
    $query_data = "SELECT $fields 
               FROM orders 
               INNER JOIN clients ON orders.id_client = clients.id_client 
               INNER JOIN roles ON clients.id_role = roles.id_role  ORDER BY clients.username_client ASC LIMIT $start, $registers";
    $query_total = "SELECT COUNT(id_order) FROM orders";
}

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

/* echo "<p>Total de registros: " . $result_total . "</p>"; */
$nPages = ceil($result_total / $registers);


$table.= '
  <div class="table-container">
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <thead>
                <tr class="has-text-centered">
                    <th>#</th>
                    <th>Client</th>
                    <th>Role</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>State</th>
                    <th>PDF</th>
                    <th colspan="3">Options</th>
                </tr>
            </thead>
            <tbody>
';

if ($result_total >= 1 && $page <= $nPages) {
    $counter = $start + 1;
    $pag_start = $start + 1;
    /* Crear las row de la tabla por cada elemento encontrado */
    foreach ($result_data as $row) {
        $url_pdf = "./pdf/";
        $table .= '
        <tr class="has-text-centered" >
				<td>'.$counter.'</td>
                <td>'.$row['username_client'].'</td>
                <td>'.$row['name_rol'].'</td>
                <td>'.$row['order_date'].'</td>
                <td>'.$row['order_amount'].'</td>
                <td>'.$row['order_state'].'</td>
                <td>
                <a href="'.$url_pdf.$row['order_pdf'].'" target="_blank"><img src="./img/icons8-pdf-48.png" alt=""></a>
                </td>
                <td>
                    <a href="index.php?view=order_act&order_id_up='.$row['id_order'].'" class="button is-success is-rounded is-small">Update</a>
                </td>
                <td>
                    <a href="'.$url.$page.'&order_id_del='.$row['id_order'].'" class="button is-danger is-rounded is-small">Delete</a>
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