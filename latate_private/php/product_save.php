<?php
require_once "../inc/session_start.php";
/* Requerimos el uso del archivo main donde se encuentran todas nuestras funciones */
require_once "main.php";

/* Almacnando datos en variables */
$code = cleanString($_POST['product_code']);
$name = cleanString($_POST['product_name']);

$composition = cleanString($_POST['product_composition']);
$weight = cleanString($_POST['product_weight']);
$width = cleanString($_POST['product_width']);
$description = cleanString($_POST['product_description']);
$format = cleanString($_POST['product_format']);
$price = cleanString($_POST['product_price']);
$price_dos = cleanString($_POST['product_price_dos']);
$stock = cleanString($_POST['product_stock']);
$availability = cleanString($_POST['product_availability']);
$category = cleanString($_POST['product_category']);

/* condicional que define los campos son obligatorios */
if ($code == "" || $name == "" || $price == "" || $stock == "" || $category == "") {
  echo '
      <div class="notification is-danger is-light">
        <strong>ERROR!</strong>
        <p>All fields must be filled in</p>
      </div>';
  exit();
}

/* Verificando integridad de los dados */
if (verifyData("[a-zA-Z0-9- ]{1,70}", $code)) {
  echo '
      <div class="notification is-danger is-light">
        <strong>ERROR!</strong>
        <p>Code does not match required format</p>
      </div>';
  exit();
}

if (verifyData("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}", $name)) {
  echo '
      <div class="notification is-danger is-light">
        <strong>ERROR!</strong>
        <p>Name does not match required format</p>
      </div>';
  exit();
}
if (verifyData("[a-zA-Z0-9 ,_%-]{1,70}", $composition)) {
  echo '
      <div class="notification is-danger is-light">
        <strong>ERROR!</strong>
        <p>Composition does not match required format</p>
      </div>';
  exit();
}
if (verifyData("[a-zA-Z0-9 ]{1,70}", $weight)) {
  echo '
      <div class="notification is-danger is-light">
        <strong>ERROR!</strong>
        <p>Weight does not match required format</p>
      </div>';
  exit();
}
if (verifyData("[a-zA-Z0-9 ]{1,70}", $width)) {
  echo '
      <div class="notification is-danger is-light">
        <strong>ERROR!</strong>
        <p>Width does not match required format</p>
      </div>';
  exit();
}

if (verifyData("[0-9.]{1,25}", $price)) {
  echo '
      <div class="notification is-danger is-light">
        <strong>ERROR!</strong>
        <p>Price does not match required format</p>
      </div>';
  exit();
}
if (verifyData("[0-9.]{1,25}", $price_dos)) {
  echo '
      <div class="notification is-danger is-light">
        <strong>ERROR!</strong>
        <p>Price does not match required format</p>
      </div>';
  exit();
}


if (verifyData("[a-zA-Z0-9- ]{1,70}", $stock)) {
  echo '
      <div class="notification is-danger is-light">
        <strong>ERROR!</strong>
        <p>Stock does not match required format</p>
      </div>';
  exit();
}
if (verifyData("[a-zA-Z0-9- ]{1,70}", $availability)) {
  echo '
      <div class="notification is-danger is-light">
        <strong>ERROR!</strong>
        <p>Availability does not match required format</p>
      </div>';
  exit();
}

/* Verificar que el codigo y el nombre del producto sean unicos en base de datos */

$check_code = conection();
$check_code = $check_code->query("SELECT reference FROM productos WHERE reference = '$code'");
if ($check_code->rowCount() > 0) {
  echo '
        <div class="notification is-danger is-light">
          <strong>ERROR!</strong>
          <p>Code already exists!</p>
        </div>';
  exit();
}
/* Cerrar la conexión con la base de datos */
$check_code = null;

$check_name = conection();
$check_name = $check_name->query("SELECT article FROM productos WHERE article = '$name'");
if ($check_name->rowCount() > 0) {
  echo '
        <div class="notification is-danger is-light">
          <strong>ERROR!</strong>
          <p>Article already exists!</p>
        </div>';
  exit();
}
/* Cerrar la conexión con la base de datos */
$check_name = null;

$check_category = conection();
$check_category = $check_category->query("SELECT id_category FROM category WHERE id_category = '$category'");
if ($check_category->rowCount() < 0) {
  echo '
        <div class="notification is-danger is-light">
          <strong>ERROR!</strong>
          <p>Category does not exist!</p>
        </div>';
  exit();
}
/* Cerrar la conexión con la base de datos */
$check_category = null;

/* Directorio de imagenes */
$img_dir = "../img/products/";

/* Comprobar si se seleccionó una imagen por medio de la variable propria de php $_FILES */
if ($_FILES['product_photo']['name'] != "" && $_FILES['product_photo']['size'] > 0) {
  /* verificando y creando el directorio de imagenes */
  if (!file_exists($img_dir)) {
    if (!mkdir($img_dir, 0777)) {
      echo '
        <div class="notification is-danger is-light">
          <strong>ERROR!</strong>
          <p>Error creating directory!</p>
        </div>';
      exit();
    }
  }
  /* Verificar el formato de la imagen */
  if (mime_content_type($_FILES['product_photo']['tmp_name']) != "image/jpeg" && mime_content_type($_FILES['product_photo']['tmp_name']) != "image/png") {
    echo '
        <div class="notification is-danger is-light">
          <strong>ERROR!</strong>
          <p>Image format not allowed!</p>
        </div>';
    exit();
  }

  /* Verificar tamaño de imagen */
  if ($_FILES['product_photo']['size'] / 1024 > 3072) {
    echo '
        <div class="notification is-danger is-light">
          <strong>ERROR!</strong>
          <p>Image size too large!</p>
        </div>';
    exit();
  }

  /* Extensión de la imagen */
  switch (mime_content_type($_FILES['product_photo']['tmp_name'])) {
    case 'image/jpeg':
      $img_ext = ".jpg";
      break;
    case 'image/png':
      $img_ext = ".png";
      break;
    default:
      $img_ext = "";
      break;
  }

  chmod($img_dir, 0777);
  $img_name = renamePhotos($name);
  $photo = $img_name . $img_ext;

  /* Moviendo imagen al directorio */
  if (!move_uploaded_file($_FILES['product_photo']['tmp_name'], $img_dir . $photo)) {
    echo '
    <div class="notification is-danger is-light">
      <strong>ERROR!</strong>
      <p>The image cannot be archived now!</p>
    </div>';
    exit();
  }
} else {
  $photo = "";
}


/* Guardar datos a la base de datos */
$save_product = conection();

/* Preparar la consulta para insertar los datos en la base de datos */
/* Usar marcadores paar insertar datos */
$save_product = $save_product->prepare("INSERT INTO productos(reference, article, composition, weight, width, description, format, price, price_dos, stock, image, id_category, id_user) VALUES(:code, :name, :composition, :weight, :width, :description, :format, :price, :price_dos, :stock, :photo, :category, :user)"); // Asegúrate de que :stock está en la consulta

$dates = [
  ":code" => $code,
  ":name" => $name,
  ":composition" => $composition, 
  ":weight" => $weight, 
  ":width" => $width, 
  ":description" => $description, 
  ":format" => $format, 
  ":price" => $price,
  ":price_dos" => $price_dos,
  ":stock" => $stock, // Asegúrate de que este valor esté incluido
  ":photo" => $photo,
  ":category" => $category,
  ":user" => $_SESSION['id']
];

// Ejecutar la consulta
$save_product->execute($dates);

if ($save_product->rowCount() == 1) {
  echo '
    <div class="notification is-success is-light">
      <strong>Success!</strong>
      <p>Product saved successfully!</p>
    </div>';
} else {
  if (is_file($img_dir.$photo)) {
    chmod($img_dir, 0777);
    unlink($img_dir.$photo);
  }

  echo '
    <div class="notification is-danger is-light">
      <strong>ERROR!</strong>
      <p>An error occurred while saving the product. Please try again.</p>
    </div>';
};

/* Cerrar la conexión con la base de datos */

$save_product = null;
