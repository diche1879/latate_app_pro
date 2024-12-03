<?php
require_once "../inc/session_start.php";
require_once "main.php";

$id = cleanString($_POST['id_user']);

/* Verificar el usuario */

$check_user = conection();

$check_user = $check_user->query("SELECT * FROM usuario WHERE id_user = '$id'");

if ($check_user->rowCount() <= 0) {

    echo '
    <div class="notification is-danger is-light">
      <strong>ERROR!</strong>
      <p>The user does not exist</p>
    </div>';
    exit();
} else {
    $datas = $check_user->fetch();
}
$check_user = null;

$admin_user = cleanString(($_POST['admin_user']));
$admin_key = cleanString(($_POST['admin_key']));

if ($admin_user == "" || $admin_key == "") {
    echo '
      <div class="notification is-danger is-light">
        <strong>ERROR!</strong>
        <p>All fields must be filled in</p>
      </div>';
    exit();
};

/* Verificando integridad de los dados */
if (verifyData("[a-zA-Z0-9]{4,20}", $admin_user)) {
    echo '
      <div class="notification is-danger is-light">
        <strong>ERROR!</strong>
        <p>User does not match required format</p>
      </div>';
    exit();
}

if (verifyData("[a-zA-Z0-9$@.-]{7,100}", $admin_key)) {
    echo '
      <div class="notification is-danger is-light">
        <strong>ERROR!</strong>
        <p>Password does not match required format</p>
      </div>';
    exit();
}

/* Verificando admin */
$check_admin = conection();

$check_admin = $check_admin->query("SELECT user, user_password FROM usuario WHERE user = '$admin_user' AND id_user = '" . $_SESSION['id'] . "'");

if ($check_admin->rowCount() == 1) {
    $check_admin = $check_admin->fetch();
    if ($check_admin['user'] != $admin_user || !password_verify($admin_key, $check_admin['user_password'])) {
        echo '
        <div class="notification is-danger is-light">
          <strong>ERROR!</strong>
          <p>Incorrect user or administrator password</p>
        </div>';
        exit();
    }
} else {
    echo '
      <div class="notification is-danger is-light">
        <strong>ERROR!</strong>
        <p>Incorrect user or administrator password</p>
      </div>';
    exit();
}
$check_admin = null;

/* Almacenando datos desde el form */
$name = cleanString($_POST['user_name']);
$surname = cleanString($_POST['user_surname']);
$user = cleanString($_POST['user']);
$email = cleanString($_POST['user_mail']);
$password_1 = cleanString($_POST['password_1']);
$password_2 = cleanString($_POST['password_2']);

/* verificando campos obligatorios */
/* en caso de no rellenar todos los campos aparecerá el mensaje de error */
if ($name == "" || $surname == "" || $user == "" || $email == "") {
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
if ($email != '' && $email != $datas['user_mail']) {
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
        # Cerrar la conexión con la base de datos 
        $check_email = null;
    } else {
        echo '
      <div class="notification is-danger is-light">
        <strong>ERROR!</strong>
        <p>Email does not match required format</p>
      </div>';
        exit();
    }
}

/* Verifiacr usuario */
if ($user != $datas['user']) {
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
}



/* verificar passwords  */
if ($password_1 != "" || $password_2 != "") {
    /* verificar el texto introducido en las password */
    if (verifyData("[a-zA-Z0-9$@.-]{7,100}", $password_1) || verifyData("[a-zA-Z0-9$@.-]{7,100}", $password_2)) {
        echo '
          <div class="notification is-danger is-light">
            <strong>ERROR!</strong>
            <p>Passwords does not match required format</p>
          </div>';
        exit();
    } else {
        /* Verifica que las passwords coincidan */
        if ($password_1 != $password_2) {
            echo '
              <div class="notification is-danger is-light">
                <strong>ERROR!</strong>
                <p>Passwords do not match</p>
              </div>';
            exit();
        } else {
            /* Encriptar la contraseña */
            $password = password_hash($password_1, PASSWORD_BCRYPT, ["cost" => 10]);
        }
    }
} else {
    $password = $datas['user_password'];
}

/* Actualizar los datos */
$update_user = conection();

$update_user = $update_user->prepare("UPDATE usuario SET user_name =:name, user_surname =:surname, user =:user, user_mail =:email, user_password =:password WHERE id_user =:id");

$dates = [
    ":name" => $name,
    ":surname" => $surname,
    ":user" => $user,
    ":email" => $email,
    ":password" => $password,
    ":id" => $id
];

if ($update_user->execute($dates)) {
    echo '
       <div class="notification is-info is-light">
         <strong>USER UPDATED!</strong>
         <p>User successfully updated!</p>
       </div>';
} else {
    echo '
       <div class="notification is-danger is-light">
         <strong>ERROR!</strong>
         <p>User could not be updated, please try again!</p>
       </div>';
}
$update_user = null;
