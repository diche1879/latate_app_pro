<?php
require_once "../inc/session_start.php";
/* Requerimos el uso del archivo main donde se encuentran todas nuestras funciones */
require_once "main.php";
/* Almacnando datos en variables */
$user = cleanString($_POST['username_client']);
$amount = cleanString($_POST['order_amount']);
$state = cleanString($_POST['order_state']);

/* condicional que define los campos son obligatorios */
if ($user == "" || $amount == "" || $state == "") {
    echo '
        <div class="notification is-danger is-light">
          <strong>ERROR!</strong>
          <p>All fields must be filled in</p>
        </div>';
    exit();
}

/* Verificando integridad de los dados */
if (verifyData("[a-zA-Z0-9- ]{1,70}", $user)) {
    echo '
        <div class="notification is-danger is-light">
          <strong>ERROR!</strong>
          <p>Code does not match required format</p>
        </div>';
    exit();
}
if (verifyData("[0-9,]{1,70}", $amount)) {
    echo '
        <div class="notification is-danger is-light">
          <strong>ERROR!</strong>
          <p>Code does not match required format</p>
        </div>';
    exit();
}
if ($state != 'processing' && $state != 'finalized') {
    echo '
        <div class="notification is-danger is-light">
          <strong>ERROR!</strong>
          <p>Code does not match required format</p>
        </div>';
    exit();
}

/* PDF a base de datos */
/* Directorio de archivos PDF */
$pdf_dir = "../pdf/";

/* Comprobar si se seleccionó un PDF por medio de la variable propia de PHP $_FILES */
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
  if ($_FILES['order_pdf']['size'] / 1024 > 3072) { // 3MB
    echo '
        <div class="notification is-danger is-light">
          <strong>ERROR!</strong>
          <p>PDF size too large!</p>
        </div>';
    exit();
  }

  /* Asignación de nombre al PDF */
  $pdf_name = renamePhotos($user); // Cambia esta función según tus necesidades
  $pdf_ext = ".pdf"; // Extensión del archivo PDF
  $pdf_name=$pdf_name.$pdf_ext;
  chmod($pdf_dir, 0777);

  /* Moviendo el PDF al directorio */
  if (!move_uploaded_file($_FILES['order_pdf']['tmp_name'], $pdf_dir.$pdf_name)) {
    echo '
    <div class="notification is-danger is-light">
      <strong>ERROR!</strong>
      <p>The PDF cannot be archived now!</p>
    </div>';
    exit();
  }
} else {
  $pdf_name = "";
}



$conexion = conection(); // Establecer la conexión

/* Preparar la consulta para obtener el id_client basado en el nombre de usuario */
$find_client = $conexion->prepare("SELECT id_client FROM clients WHERE username_client = :username");
$find_client->bindParam(':username', $user);  // Enlazar el nombre de usuario

$find_client->execute();  // Ejecutar la consulta

$client = $find_client->fetch(PDO::FETCH_ASSOC);  // Obtener el resultado

if($client && isset($client['id_client'])) {
    // Si se encuentra el cliente, procedemos a guardar la orden

    /* Preparar la consulta para insertar la orden */
    $save_order = $conexion->prepare("INSERT INTO orders (id_client, order_amount, order_state, order_pdf) VALUES (:id_client, :amount_order, :state_order, :pdf)");

    /* Ligar parámetros y ejecutar la consulta */
    $dates = [
        ':id_client' => $client['id_client'],  // Usar el id_client obtenido previamente
        ':amount_order' => $amount,
        ':state_order' => $state,
        ':pdf' => $pdf_name
    ];

    $save_order->execute($dates);  // Ejecutar la consulta de inserción

    if($save_order->rowCount() == 1){
        echo '
            <div class="notification is-success is-light">
              <strong>Success!</strong>
              <p>Order saved successfully</p>
            </div>';
    } else {
        // Si la inserción falla, eliminar el archivo PDF si existe
        if(is_file($pdf_dir.$pdf_name)){
            chmod($pdf_dir,0777);
            unlink($pdf_dir.$pdf_name);
        }
        echo '
            <div class="notification is-danger is-light">
              <strong>ERROR!</strong>
              <p>An error occurred while saving the product. Please try again.</p>
            </div>';
    }

    /* Cerrar conexión */
    $save_order = null;

} else {
    // Si no se encuentra el cliente, muestra un error
    echo '
        <div class="notification is-danger is-light">
          <strong>ERROR!</strong>
          <p>No client found with that username.</p>
        </div>';
}

/* Cerrar conexión */
$find_client = null;
$conexion = null;  // Cerrar la conexión

