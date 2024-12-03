<?php
/* Almacenar datos */
$user = cleanString($_POST['login_usuario']);
$password = cleanString($_POST['login_clave']);

/* verificando campos obligatorios */
if ($user == "" || $password == "") {
    echo '
      <div class="notification is-danger is-light">
        <strong>ERROR!</strong>
        <p>All fields must be filled in</p>
      </div>';
    exit();
}

/* verificar la integridad de los datos */

/* Verificar Usuario */
if (verifyData("[a-zA-Z0-9]{4,20}", $user)) {
    echo '
      <div class="notification is-danger is-light">
        <strong>ERROR!</strong>
        <p>User does not match required format</p>
      </div>';
    exit();
}

/* Verificar contraseña */
if (verifyData("[a-zA-Z0-9$@.-]{7,100}", $password)) {
    echo '
      <div class="notification is-danger is-light">
        <strong>ERROR!</strong>
        <p>Password does not match required format</p>
      </div>';
    exit();
}


/* Consulta a la BD */

$check_user = conection();

$check_user = $check_user->query("SELECT * FROM usuario WHERE user = '$user'");

if ($check_user->rowCount() == 1) {
    $check_user = $check_user->fetch();

    if ($check_user['user'] == $user && password_verify($password, $check_user['user_password'])) {
        $_SESSION['id'] = $check_user['id_user'];
        $_SESSION['name'] = $check_user['user_name'];
        $_SESSION['surname'] = $check_user['user_surname'];
        $_SESSION['user'] = $check_user['user'];
        
        if (headers_sent()) {
            echo "<script> window.location.href='index.php?view=home'</script>";
        } else {
            header("Location: index.php?view=home");
        }
        
    } else {
        echo '
      <div class="notification is-danger is-light">
        <strong>ERROR!</strong>
        <p>Incorrect User or Password</p>
      </div>';
    }
} else {
    echo '
      <div class="notification is-danger is-light">
        <strong>ERROR!</strong>
        <p>Incorrect User or Password</p>
      </div>';
    exit();
}

$check_user = null;
