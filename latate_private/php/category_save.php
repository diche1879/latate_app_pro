<?php
require_once "main.php";

/* Almacenando datos desde el form */
$name = cleanString($_POST['category_name']);
$site = cleanString($_POST['category_site']);

if ($name == "") {
    echo '
      <div class="notification is-danger is-light">
        <strong>ERROR!</strong>
        <p>All fields must be filled in</p>
      </div>';
    exit();
  }

  if (verifyData("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}", $name)) {
    echo '
      <div class="notification is-danger is-light">
        <strong>ERROR!</strong>
        <p>Name does not match required format</p>
      </div>';
    exit();
  }

  if($site != ""){
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

/* Guardar datos a la base de datos */
$save_category = conection();

/* Preparar la consulta para insertar los datos en la base de datos */
/* Usar marcadores paar insertar datos */
$save_category = $save_category->prepare("INSERT INTO category(category_name, category_site) VALUES(:name, :site)");

$dates = [
    ":name" => $name,
    ":site" => $site
  ];

  $save_category->execute($dates);

  if ($save_category->rowCount() == 1){
    echo '
      <div class="notification is-info is-light">
        <strong>Success!</strong>
        <p>Category saved successfully!</p>
      </div>';
  }else{
    echo '
      <div class="notification is-danger is-light">
        <strong>ERROR!</strong>
        <p>An error occurred while saving the category. Please try again.</p>
      </div>';
  };
  
  /* Cerrar la conexión con la base de datos */
  
  $save_category = null;