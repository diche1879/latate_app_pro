<?php
require_once "main.php";

$id = cleanString($_POST['id_product']);

/* Verificar el producto */

$check_product = conection();

$check_product = $check_product->query("SELECT * FROM productos WHERE id_product = '$id'");

if ($check_product->rowCount() <= 0) {

    echo '
        <div class="notification is-danger is-light">
        <strong>ERROR!</strong>
        <p>The product does not exist</p>
        </div>';
    exit();
} else {
    $datas = $check_product->fetch();
}
$check_product = null;

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
  
  /* if (verifyData("[0-9.]{1,25}", $price)) {
    echo '
        <div class="notification is-danger is-light">
          <strong>ERROR!</strong>
          <p>Price does not match required format</p>
        </div>';
    exit();
  } */
  
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
if($code!=$datas['reference']){
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
}

/* Verificar nombre */
if ($name!=$datas['article']) {
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
}

/* verificar categoria */
if($category!=$datas['id_category']){
    $check_category = conection();
    $check_category = $check_category->query("SELECT id_category FROM category WHERE id_category = '$category'");
    if ($check_category->rowCount() < 0) {
      echo '
            <div class="notification is-danger is-light">
              <strong>ERROR!</strong>
              <p>Category does not exist already exists!</p>
            </div>';
      exit();
    }
    /* Cerrar la conexión con la base de datos */
    $check_category = null;
}

  /* Actualizar los datos */
  $update_product = conection();

  $update_product = $update_product->prepare("UPDATE productos SET reference =:code, article =:name, composition =:composition, weight =:weight, width =:width, description =:description, format =:format, price =:price, price_dos =:price_dos, stock =:stock, id_category =:category WHERE id_product =:id");

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
    ":stock" => $stock,
    ":category" => $category,
    ":id" => $id
  ];

  if ($update_product->execute($dates)) {
    echo '
       <div class="notification is-info is-light">
         <strong>PRODUCT UPDATED!</strong>
         <p>Product successfully updated!</p>
       </div>';
} else {
    echo '
       <div class="notification is-danger is-light">
         <strong>ERROR!</strong>
         <p>Product could not be updated, please try again!</p>
       </div>';
}
$update_product = null;