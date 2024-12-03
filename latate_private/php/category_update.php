<?php

require_once "main.php";

$id = cleanString($_POST['id_category']);

/* Verificar el categoria */

$check_category = conection();

$check_category = $check_category->query("SELECT * FROM category WHERE id_category = '$id'");

if ($check_category->rowCount() <= 0) {

    echo '
    <div class="notification is-danger is-light">
      <strong>ERROR!</strong>
      <p>The category does not exist</p>
    </div>';
    exit();
} else {
    $datas = $check_category->fetch();
}
$check_category = null;

/* Almacenando datos desde el form */
$name = cleanString($_POST['category_name']);
$site = cleanString($_POST['category_site']);

/* verificar campos obligatorios */
if ($name == "") {
    echo '
      <div class="notification is-danger is-light">
        <strong>ERROR!</strong>
        <p>All fields must be filled in</p>
      </div>';
    exit();
}

/* Verifcar la valididad de los datos */
if (verifyData("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}", $name)) {
    echo '
      <div class="notification is-danger is-light">
        <strong>ERROR!</strong>
        <p>Name does not match required format</p>
      </div>';
    exit();
}

if ($site != "") {
    if (verifyData("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{5,150}", $site)) {
        echo '
          <div class="notification is-danger is-light">
            <strong>ERROR!</strong>
            <p>Site does not match required format</p>
          </div>';
        exit();
    }
}

  /* Verifiacr nombre categoria */
  if($name != $datas["category_name"]){
    $check_name = conection();
  $check_name = $check_name->query("SELECT category_name FROM category WHERE category_name = '$name'");
  if ($check_name->rowCount() > 0) {
    echo '
          <div class="notification is-danger is-light">
            <strong>ERROR!</strong>
            <p>Category already exists!</p>
          </div>';
    exit();
  }
  /* Cerrar la conexión con la base de datos */
  $check_name = null;
  }
  

  /* Actualizar los datos */
$update_category = conection();

$update_category = $update_category->prepare("UPDATE category SET category_name =:name, category_site =:site WHERE id_category =:id");

$dates = [
    ":name" => $name,
    ":site" => $site,
    ":id" => $id
];

if ($update_category->execute($dates)) {
    echo '
       <div class="notification is-info is-light">
         <strong>CATEGORY UPDATED!</strong>
         <p>category successfully updated!</p>
       </div>';
} else {
    echo '
       <div class="notification is-danger is-light">
         <strong>ERROR!</strong>
         <p>category could not be updated, please try again!</p>
       </div>';
}
$update_category = null;