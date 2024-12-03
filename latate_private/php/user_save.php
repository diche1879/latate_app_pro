<?php
/* Requerimos el uso del archivo main donde se encuentran todas nuestras funciones */
require_once "main.php";

/* Almacenando datos desde el form */
$name = cleanString($_POST['name']);
$surname = cleanString($_POST['surname']);
$user = cleanString($_POST['user']);
$email = cleanString($_POST['email']);
$password_1 = cleanString($_POST['password_1']);
$password_2 = cleanString($_POST['password_2']);

/* verificando campos obligatorios */
/* en caso de no rellenar todos los campos aparecerá el mensaje de error */
if ($name == "" || $surname == "" || $user == "" || $email == "" || $password_1 == "" || $password_2 == "") {
  echo '
    <div class="notification is-danger is-light">
      <strong>ERROR!</strong>
      <p>All fields must be filled in</p>
    </div>';
  exit();
}

/* Verificando integridad de los dados */
if (verifyData("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $name)) {
  echo '
    <div class="notification is-danger is-light">
      <strong>ERROR!</strong>
      <p>Name does not match required format</p>
    </div>';
  exit();
}

if (verifyData("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $surname)) {
  echo '
    <div class="notification is-danger is-light">
      <strong>ERROR!</strong>
      <p>Surname does not match required format</p>
    </div>';
  exit();
}

if (verifyData("[a-zA-Z0-9]{4,20}", $user)) {
  echo '
    <div class="notification is-danger is-light">
      <strong>ERROR!</strong>
      <p>User does not match required format</p>
    </div>';
  exit();
}


/* verificar email */
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $check_email = conection();
  $check_email = $check_email->query("SELECT user_mail FROM usuario WHERE user_mail = '$email'");
  if ($check_email->rowCount() > 0) {
    echo '
        <div class="notification is-danger is-light">
          <strong>ERROR!</strong>
          <p>Email already exists!</p>
        </div>';
    exit();
  }
  /* Cerrar la conexión con la base de datos */
  $check_email = null;
} else {
  echo '
    <div class="notification is-danger is-light">
      <strong>ERROR!</strong>
      <p>Email does not match required format</p>
    </div>';
}

if (verifyData("[a-zA-Z0-9$@.-]{7,100}", $password_1) || verifyData("[a-zA-Z0-9$@.-]{7,100}", $password_2)) {
  echo '
    <div class="notification is-danger is-light">
      <strong>ERROR!</strong>
      <p>Passwords does not match required format</p>
    </div>';
  exit();
}


/* Verifiacr usuario */
$check_user = conection();
$check_user = $check_user->query("SELECT user FROM usuario WHERE user = '$user'");
if ($check_user->rowCount() > 0) {
  echo '
        <div class="notification is-danger is-light">
          <strong>ERROR!</strong>
          <p>User already exists!</p>
        </div>';
  exit();
}
/* Cerrar la conexión con la base de datos */
$check_user = null;


/* verificar que las passwords coincidan */
if ($password_1 != $password_2) {
  echo '
    <div class="notification is-danger is-light">
      <strong>ERROR!</strong>
      <p>Passwords do not match</p>
    </div>';
  exit();
}else{
  /* Encriptar la contraseña */
  $password = password_hash($password_1, PASSWORD_BCRYPT, ["cost"=>10]);
}


/* Guardar datos a la base de datos */
$save_user = conection();

/* Preparar la consulta para insertar los datos en la base de datos */
/* Usar marcadores paar insertar datos */
$save_user = $save_user->prepare("INSERT INTO usuario(user_name, user_surname, user, user_mail, user_password) VALUES(:name, :surname, :user, :email, :password)");

/* Crear un array donde el maracdor se corresponda a su varible */
$dates = [
  ":name" => $name,
  ":surname" => $surname,
  ":user" => $user,
  ":email" => $email,
  ":password" => $password
];

/* Ejecutar la consulta */
$save_user->execute($dates);

if ($save_user->rowCount() == 1){
  echo '
    <div class="notification is-success is-light">
      <strong>Success!</strong>
      <p>User saved successfully!</p>
    </div>';
}else{
  echo '
    <div class="notification is-danger is-light">
      <strong>ERROR!</strong>
      <p>An error occurred while saving the user. Please try again.</p>
    </div>';
};

/* Cerrar la conexión con la base de datos */

$save_user = null;

