<?php

/* Desde donde empezamos a contar los registros que se mostrarán en cada página */
$start = ($page > 0) ? (($page * $registers) - $registers) : 0;

$table = "";
/* Guardamos los campos que querermos buscar en una variable */
$fields = "productos.id_product,productos.reference,productos.article,productos.price,productos.price_dos,productos.stock,productos.image,category.category_name,usuario.user_name,usuario.user_surname";

/* Consulta para busqueda donde search es la variable que ingresa el usuario, si no está definida entonces se proporcionará el listado sin filtros aplicados */
if (isset($search) && $search != "") {
    /* creamos la consulta para la busqueda */
    $query_data = "SELECT $fields FROM productos INNER JOIN category ON productos.id_category=category.id_category INNER JOIN usuario ON productos.id_user=usuario.id_user WHERE productos.reference LIKE '%$search%' OR productos.article LIKE '%$search%' ORDER BY productos.article ASC LIMIT $start, $registers";

    $query_total = "SELECT COUNT(id_product) FROM productos WHERE reference LIKE '%$search%' OR article LIKE '%$search%'";
} else if ($category_id > 0) {
    $query_data = "SELECT $fields FROM productos INNER JOIN category ON productos.id_category=category.id_category INNER JOIN usuario ON productos.id_user=usuario.id_user WHERE productos.id_category='$category_id' ORDER BY productos.article ASC LIMIT $start, $registers";

    $query_total = "SELECT COUNT(id_product) FROM productos WHERE id_category='$category_id'";
} else {
    $query_data = "SELECT $fields FROM productos INNER JOIN category ON productos.id_category=category.id_category INNER JOIN usuario ON productos.id_user=usuario.id_user ORDER BY productos.article ASC LIMIT $start, $registers";
    $query_total = "SELECT COUNT(id_product) FROM productos";
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



if ($result_total >= 1 && $page <= $nPages) {
    $counter = $start + 1;
    $pag_start = $start + 1;
    /* Recorremos el array donde hay almacenados todos los usuario y por cada usauario creamos una linea de la tabla con sus botones modificar e eliminar */
    foreach ($result_data as $row) {
        $table .= '

            <article class="media">
                <figure class="media-left">
                    <p class="image is-128x128">';
        if (is_file("./img/products/" . $row['image'])) {
            $table .= '<img src="./img/products/' . $row['image'] . '">';
        } else {
            $table .= '<img src="./img/producto.jpg">';
        }

        $table .= '</p>
                </figure>
                <div class="media-content">
                    <div class="content">
                        <p>
                            <strong>' . $counter . ' - ' . $row['article'] . '</strong><br>
                            <strong>CODE:</strong> ' . $row['reference'] . '<br> 
                            <strong>WHOLESALER PRICE:</strong> € ' . $row['price'] . '<br> 
                            <strong>STORE PRICE:</strong> € ' . $row['price_dos'] . '<br> 
                            <strong>STOCK:</strong> ' . $row['stock'] . '<br> 
                            <strong>CATEGORY:</strong> ' . $row['category_name'] . '<br> 
                            <strong>MODIFY FOR:</strong> ' . $row['user_name'] . ' ' . $row['user_surname'] . '
                        </p>
                    </div>
                    </div>
                    <div class="has-text-left">
                        <a href="index.php?view=product_img&product_id_up=' . $row['id_product'] . '" class="button is-link is-rounded is-small">Update Image</a>
                        <a href="index.php?view=product_act&product_id_up=' . $row['id_product'] . '" class="button is-success is-rounded is-small">Update</a>
                        <a href="' . $url . $page . '&product_id_del=' . $row['id_product'] . '" class="button is-danger is-rounded is-small">Delete</a>
                    </div>
                    </article>


            
        ';
        $counter++;
    };
    $pag_end = $counter - 1;
} else {
    if ($result_total >= 1) {
        $table .= '
            <p class="has-text-centered">
                <a href="' . $url . '1" class="button is-link is-rounded is-small mt-4 mb-4">
                    Haga clic acá para recargar el listado
                </a>
            </p>
        ';
    } else {
        $table .= '<p class="has-text-centered">No hay registros en el sistema</p>';
    }
}

if ($result_total >= 1 && $page <= $nPages) {
    $table .= '
    <p class="has-text-right">Showing products from <strong>' . $pag_start . '</strong> to <strong>' . $pag_end . '</strong> of <strong>a total ' . $result_total . '</strong></p>
    ';
}
$connection = null;

echo $table;
if ($result_total >= 1 && $page <= $nPages) {
    echo  tablesPager($page, $nPages, $url, 3);
};
