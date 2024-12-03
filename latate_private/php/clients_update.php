<?php
require_once "main.php";

$id = cleanString($_POST['id_client']);

/* Verificar el cliente */

$check_client = conection();

$check_client = $check_client->query("SELECT * FROM clients WHERE id_client = '$id'");

if ($check_client->rowCount() <= 0) {

  echo '
    <div class="notification is-danger is-light">
        <button class="delete" aria-label="delete"></button>
        <strong>Error!</strong>
        <p>The client does not exist</p>
    </div>
    ';
  exit();
} else {
  $datas = $check_client->fetch();
}
$check_client = null;

/* Almacenando datos desde el form */
$role = cleanString($_POST['client_role']);
$client_username = cleanString($_POST['username_client']);
$client_company = cleanString($_POST['client_company']);
$client_nif = cleanString($_POST['client_nif']);
$client_phone = cleanString($_POST['client_phone']);
$client_country = cleanString($_POST['client_country']);
$client_city = cleanString($_POST['client_city']);
$client_address = cleanString($_POST['client_address']);
$client_p_code = cleanString($_POST['client_p_code']);
$client_email = cleanString($_POST['email_client']);
$client_password_1 = cleanString($_POST['client_password_1']);
$client_password_2 = cleanString($_POST['client_password_2']);

/* en caso de no rellenar todos los campos aparecerá el mensaje de error */
if ($role == "" || $client_username == "" || $client_email == "") {
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
if ($check_role->rowCount() < 0) {
  echo '
        <div class="notification is-danger is-light">
          <strong>ERROR!</strong>
          <p>Role does not exist!</p>
        </div>';
  exit();
}

/* Cerrar la conexión con la base de datos */
$check_role = null;

/* Verificar que el username sea correcto */

if (verifyData("[a-zA-Z0-9]{4,20}", $client_username)) {
  echo '
      <div class="notification is-danger is-light">
        <strong>ERROR!</strong>
        <p>Username does not match required format</p>
      </div>';
  exit();
}

/* Verificar que el email sea correcto */
if ($client_email != '' && $client_email != $datas['email_client']) {
  if (filter_var($client_email, FILTER_VALIDATE_EMAIL)) {
    $check_email = conection();
    $check_email = $check_email->query("SELECT email_client FROM clients WHERE email_client = '$client_email'");
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
  }
}

/* verificar el nombre de la empresa */
$filter = "[a-zA-ZÀ-ÿñÑ\\s+@#.,'-]{2,100}";
if (verifyData($filter, $client_company)) {
  // verificar que el nombre de la empresa no exista ya en albase de datos 

  $check_company = conection();
  $check_company = $check_company->query("SELECT id_client FROM clients WHERE client_company = '$client_company' AND id_client != $id");
  if ($check_company->rowCount() > 0) {
    echo '
    <div class="notification is-danger is-light">
      <strong>ERROR!</strong>
      <p>Company already exists!</p>
    </div>';
    exit();
  }
  $check_company = null;
} else {
  echo '
    <div class="notification is-danger is-light">
      <strong>ERROR!</strong>
      <p>Company does not match required format</p>
    </div>';
  exit();
}

/* verificar que el nif no exista*/
$check_nif = conection();
$check_nif = $check_nif->query("SELECT id_client FROM clients WHERE client_nif = '$client_nif' AND id_client != $id");
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

/* verificar codigo postal */

if ($client_p_code && verifyData("[a-zA-Z0-9]{3,10}", $client_p_code)) {
  echo '
  <div class="notification is-danger is-light">
    <strong>ERROR!</strong>
    <p>Invalid Postal Code format</p>
  </div>';
  exit();
}

/* Verificar formato contraseñas */
/* verificar passwords  */
if ($client_password_1 != "" || $client_password_2 != "") {
  /* verificar el texto introducido en las password */
  if (verifyData("[a-zA-Z0-9$@.-]{7,100}", $client_password_1) || verifyData("[a-zA-Z0-9$@.-]{7,100}", $client_password_2)) {
    echo '
          <div class="notification is-danger is-light">
            <strong>ERROR!</strong>
            <p>Passwords does not match required format</p>
          </div>';
    exit();
  } else {
    /* Verifica que las passwords coincidan */
    if ($client_password_1 != $client_password_2) {
      echo '
              <div class="notification is-danger is-light">
                <strong>ERROR!</strong>
                <p>Passwords do not match</p>
              </div>';
      exit();
    } else {
      /* Encriptar la contraseña */
      $password = password_hash($client_password_1, PASSWORD_BCRYPT, ["cost" => 10]);
    }
  }
} else {
  $password = $datas['password_client'];
}

/* Actualizar los datos */
$update_client = conection();

$update_client = $update_client->prepare("UPDATE clients SET id_role =:id_role, username_client =:username_client, email_client =:email_client, client_company =:client_company, client_nif=:client_nif, client_phone=:client_phone, client_country=:client_country, client_city=:client_city, client_address=:client_address, client_p_code=:client_p_code, password_client =:password_client WHERE id_client =:id");

$dates = [
  ":id_role" => $role,
  ":username_client" => $client_username,
  ":email_client" => $client_email,
  "client_company" => $client_company,
  "client_nif" => $client_nif,
  "client_phone" => $client_phone,
  "client_country" => $client_country,
  "client_city" => $client_city,
  "client_address" => $client_address,
  "client_p_code" => $client_p_code,
  ":password_client" => $password,
  ":id" => $id
];

if ($update_client->execute($dates)) {
  echo '
       <div class="notification is-info is-light">
         <strong>USER UPDATED!</strong>
         <p>Client updated successfully!</p>
       </div>';
} else {
  echo '
       <div class="notification is-danger is-light">
         <strong>ERROR!</strong>
         <p>Client could not be updated, please try again!</p>
       </div>';
}
$update_client = null;
