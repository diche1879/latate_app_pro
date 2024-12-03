<?php
require_once "main.php";

$id = cleanString($_POST['id_order']);
$amount = cleanString($_POST['order_amount']);
$state = cleanString($_POST['order_state']);

/* Verificar que los campos no estén vacíos */
if ($amount == "" || $state == "") {
    echo '
      <div class="notification is-danger is-light">
        <strong>ERROR!</strong>
        <p>All fields must be filled in</p>
      </div>';
    exit();
}

/* Directorio de PDFs */
$pdf_dir = "../pdf/";

/* Obtener el username del cliente a partir de la orden */
$connection = conection();
$query_client = $connection->prepare("SELECT clients.username_client, orders.order_pdf
                                      FROM orders 
                                      INNER JOIN clients ON orders.id_client = clients.id_client 
                                      WHERE orders.id_order = :id_order");
$query_client->execute([":id_order" => $id]);

if ($query_client->rowCount() == 0) {
    echo '
      <div class="notification is-danger is-light">
        <strong>ERROR!</strong>
        <p>Order or Client not found!</p>
      </div>';
    exit();
}

$client_data = $query_client->fetch();
$username = $client_data['username_client'];
$current_pdf = $client_data['order_pdf']; // Obtener el PDF actual

$pdf_updated = false;
$pdf_name = '';

if ($_FILES['order_pdf']['name'] != "" && $_FILES['order_pdf']['size'] > 0) {
    /* Verificando y creando el directorio de archivos PDF */
    if (!file_exists($pdf_dir)) {
        if (!mkdir($pdf_dir, 0777)) {
            echo '
            <div class="notification is-danger is-light">
                <strong>ERROR!</strong>
                <p>Error creating directory!</p>
            </div>';
            exit();
        }
    }

    /* Verificar el formato del PDF */
    if (mime_content_type($_FILES['order_pdf']['tmp_name']) != "application/pdf") {
        echo '
            <div class="notification is-danger is-light">
              <strong>ERROR!</strong>
              <p>PDF format not allowed!</p>
            </div>';
        exit();
    }

    /* Verificar tamaño del PDF */
    if ($_FILES['order_pdf']['size'] / 1024 > 3072) { // 3MB límite
        echo '
            <div class="notification is-danger is-light">
              <strong>ERROR!</strong>
              <p>PDF size too large!</p>
            </div>';
        exit();
    }

    /* Asignación de nombre al PDF utilizando el username del cliente */
    $pdf_name = renamePhotos($username); // Renombrar usando el username del cliente
    $pdf_ext = ".pdf"; // Extensión del archivo PDF
    $pdf_name = $pdf_name . $pdf_ext;

    chmod($pdf_dir, 0777);

    /* Mover el archivo al directorio */
    if (!move_uploaded_file($_FILES['order_pdf']['tmp_name'], $pdf_dir . $pdf_name)) {
        echo '
        <div class="notification is-danger is-light">
          <strong>ERROR!</strong>
          <p>The PDF cannot be archived now!</p>
        </div>';
        exit();
    }

    /* Eliminar el PDF anterior si existe */
    if (!empty($current_pdf) && file_exists($pdf_dir . $current_pdf)) {
        unlink($pdf_dir . $current_pdf);
    }

    $pdf_updated = true;
} else {
    $pdf_name = ""; // Si no hay un nuevo PDF
}

/* Actualizar la orden */
$update_order = conection();

$update_query = "UPDATE orders SET order_amount = :amount, order_state = :state";
if ($pdf_updated) {
    $update_query .= ", order_pdf = :pdf";
}

$update_query .= " WHERE id_order = :id";

$update_order = $update_order->prepare($update_query);

$dates = [
    ":amount" => $amount,
    ":state" => $state,
    ":id" => $id
];

if ($pdf_updated) {
    $dates[":pdf"] = $pdf_name;
}

if ($update_order->execute($dates)) {
    echo '
    <div class="notification is-success is-light">
        <button class="delete" aria-label="delete"></button>
        <strong>Success!</strong>
        <p>Order updated successfully</p>
    </div>';
} else {
    echo '
    <div class="notification is-danger is-light">
        <button class="delete" aria-label="delete"></button>
        <strong>ERROR!</strong>
        <p>An error occurred while updating the order</p>
    </div>';
}

$update_order = null;