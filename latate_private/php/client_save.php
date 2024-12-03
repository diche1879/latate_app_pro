<?php
require_once "../inc/session_start.php";
/* Requerimos el uso del archivo main donde se encuentran todas nuestras funciones */
require_once "main.php";

/* Almacnando datos en variables */

$role = cleanString($_POST['client_role']);
$client_username = cleanString($_POST['client_username']);
$client_company = cleanString($_POST['client_company']);
$client_nif = cleanString($_POST['client_nif']);
$client_phone = cleanString($_POST['client_phone']);
$client_country = cleanString($_POST['client_country']);
$client_city = cleanString($_POST['client_city']);
$client_address = cleanString($_POST['client_address']);
$client_p_code = cleanString($_POST['client_p_code']);
$client_email = cleanString($_POST['client_email']);
$client_password_1 = cleanString($_POST['client_password_1']);
$client_password_2 = cleanString($_POST['client_password_2']);

/* verificando campos obligatorios */
/* en caso de no rellenar todos los campos aparecerá el mensaje de error */
if ($role == "" || $client_username == "" || $client_email == "" || $client_company == "" || $client_nif == "" || $client_password_1 == "" || $client_password_2 == "") {
    echo '
      <div class="notification is-danger is-light">
        <strong>ERROR!</strong>
        <p>All fields must be filled in</p>
      </div>';
    exit();
}


/* Verificar que el tipo de cliente existe */

$check_role = conection();
$check_role = $check_role->query("SELECT id_role FROM roles WHERE id_role = '$role'");
if ($check_role->rowCount() == 0) {
    echo '
        <div class="notification is-danger is-light">
          <strong>ERROR!</strong>
          <p>Role does not exist!</p>
        </div>';
    exit();
}

/* Cerrar la conexión con la base de datos */
$check_role = null;

/* Verificar username */

if (verifyData("[a-zA-Z0-9]{4,20}", $client_username)) {
    echo '
    <div class="notification is-danger is-light">
      <strong>ERROR!</strong>
      <p>Name does not match required format</p>
    </div>';
    exit();
}

/* Verificar email */

if (filter_var($client_email, FILTER_VALIDATE_EMAIL)) {
    $check_email = conection();
    $check_email = $check_email->query("SELECT id_client FROM clients WHERE email_client = '$client_email'");
    if ($check_email->rowCount() > 0) {
        echo '
        <div class="notification is-danger is-light">
          <strong>ERROR!</strong>
          <p>Email already exists!</p>
        </div>';
        exit();
    }
    $check_email = null;
} else {
    echo '
    <div class="notification is-danger is-light">
      <strong>ERROR!</strong>
      <p>Invalid email format</p>
    </div>';
    exit();
}

/* verificar el nombre de la empresa */

if (verifyData("[a-zA-ZÀ-ÿñÑ\\s+@#.,'-]{2,100}", $client_company)) {
  /* verificar que el nombre de la empresa no exista ya en albase de datos */
  $check_company = conection();
  $check_company = $check_company->query("SELECT id_client FROM clients WHERE client_company = '$client_company'");
  if ($check_company->rowCount() > 0) {
    echo '
    <div class="notification is-danger is-light">
      <strong>ERROR!</strong>
      <p>Company already exists!</p>
    </div>';
    exit();
  }
  $check_company = null;
}else{
  echo '
    <div class="notification is-danger is-light">
      <strong>ERROR!</strong>
      <p>Company does not match required format</p>
    </div>';
  exit();
}

/* verificar que el nif ya exista*/
$check_nif = conection();
$check_nif = $check_nif->query("SELECT id_client FROM clients WHERE client_nif = '$client_nif'");
if ($check_nif->rowCount() > 0) {
    echo '
        <div class="notification is-danger is-light">
          <strong>ERROR!</strong>
          <p>The tax number already exists!</p>
        </div>';
    exit();
}

/* Verificar formato pais */

if ($client_country && verifyData("[a-zA-Z0-9\s\.]{4,30}", $client_country)) {
    echo '
    <div class="notification is-danger is-light">
      <strong>ERROR!</strong>
      <p>Country does not match required format</p>
    </div>';
    exit();
}
/* Verificar formato ciudad */

if ($client_city && verifyData("[a-zA-ZÀ-ÿñÑ\s\-]{2,100}", $client_city)) {
    echo '
    <div class="notification is-danger is-light">
      <strong>ERROR!</strong>
      <p>City does not match required format</p>
    </div>';
    exit();
}

/* verificar dirección */

/* if (verifyData("", $client_address)) {
    echo '
    <div class="notification is-danger is-light">
      <strong>ERROR!</strong>
      <p>Address does not match required format</p>
    </div>';
    exit();
} */

/* verificar codigo postal */

if (verifyData("[a-zA-Z0-9]{3,10}", $client_p_code)) {
    echo '
    <div class="notification is-danger is-light">
      <strong>ERROR!</strong>
      <p>Invalid Postal Code format</p>
    </div>';
    exit();
}

/* Verificar formato contraseñas */
if (verifyData("[a-zA-Z0-9$@.-]{7,100}", $client_password_1) || verifyData("[a-zA-Z0-9$@.-]{7,100}", $client_password_2)) {
    echo '
      <div class="notification is-danger is-light">
        <strong>ERROR!</strong>
        <p>Passwords does not match required format</p>
      </div>';
    exit();
}

/* verificar que las passwords coincidan */
if ($client_password_1 != $client_password_2) {
    echo '
      <div class="notification is-danger is-light">
        <strong>ERROR!</strong>
        <p>Passwords do not match</p>
      </div>';
    exit();
} else {
    /* encriptar contraseña */
    $password_client = password_hash($client_password_1, PASSWORD_BCRYPT, ["cost" => 10]);
}

/* Guardar los dato en la bd */
$register_client = conection();
$register_client = $register_client->prepare("INSERT INTO clients (id_role, email_client, username_client, client_company, client_nif, client_phone, client_country, client_city, client_address, client_p_code, password_client) VALUES(:id_role, :email_client, :username_client, :client_company, :client_nif, :client_phone, :client_country, :client_city, :client_address, :client_p_code, :password_client)");

/* Crear un array donde el maracdor se corresponda a su varible */
$dates = [
  "id_role" => $role,
  "email_client" => $client_email,
  "username_client" => $client_username,
  "client_company" => $client_company,
  "client_nif" => $client_nif,
  "client_phone" => $client_phone,
  "client_country" => $client_country,
  "client_city" => $client_city,
  "client_address" => $client_address,
  "client_p_code" => $client_p_code,
  "password_client" => $password_client
];

$register_client->execute($dates);

if ($register_client->rowCount() == 1) {
    echo '
      <div class="notification is-success is-light">
        <strong>Success!</strong>
        <p>Client saved successfully!</p>
      </div>';
  } else {
  
    echo '
      <div class="notification is-danger is-light">
        <strong>ERROR!</strong>
        <p>An error occurred while saving the client. Please try again.</p>
      </div>';
  };

  /* Cerrar conexión bd */
$register_client = null;
