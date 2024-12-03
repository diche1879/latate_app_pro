<?php
/* Verificar existencia del producto */
require_once "main.php";

$product_id = cleanString($_POST['img_up_id']);

/* Verificar el producto */

$check_product = conection();

$check_product = $check_product->query("SELECT * FROM productos WHERE id_product = '$product_id'");

if ($check_product->rowCount() == 1) {
    $datas = $check_product->fetch();
} else {
    echo '
        <div class="notification is-danger is-light">
        <strong>ERROR!</strong>
        <p>The image does not exist</p>
        </div>';
    exit();
}
$check_product = null;

/* Directorio de imagenes */
$img_dir = "../img/products/";

if ($_FILES['product_photo']['name'] == "" || $_FILES['product_photo']['size'] == 0) {
    echo '
    <div class="notification is-danger is-light">
    <strong>ERROR!</strong>
    <p>The image does not exist</p>
    </div>';
    exit();
}

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

chmod($img_dir, 0777);

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

$img_name = renamePhotos($datas['article']);
$photo = $img_name.$img_ext;

if (!move_uploaded_file($_FILES['product_photo']['tmp_name'], $img_dir.$photo)) {
    echo '
    <div class="notification is-danger is-light">
      <strong>ERROR!</strong>
      <p>The image cannot be archived now!</p>
    </div>';
    exit();
}

if (is_file($img_dir.$datas['image']) && $img_dir.$datas['image'] != $photo) {
    chmod($img_dir.$datas['image'], 0777);
    unlink($img_dir.$datas['image']);
}

/* Actualizar los datos */
$update_product = conection();

$update_product = $update_product->prepare("UPDATE productos SET image = :photo WHERE id_product =:id");

$dates = [
    ":photo" => $photo,
    ":id" => $product_id
];

if ($update_product->execute($dates)) {
    echo '
       <div class="notification is-info is-light">
         <strong>IMAGE UPDATED!</strong>
         <p>The product image was updated successfully!<br> Please press OK to reload the changes.</p>

         <p class="has_text_centered pt-5 pb-5">
         <a href="index.php?view=product_img&product_id_up=' . $product_id . '" class="button is-link is-rounded">OK</a>
         </p>
       </div>';
} else {
    if (is_file($img_dir.$photo)) {
        chmod($img_dir.$photo, 0777);
        unlink($img_dir.$photo);
    }

    echo '
       <div class="notification is-warning is-light">
         <strong>ERROR!</strong>
         <p>The image cannot be uploaded at this time. Please try again later.</p>
       </div>';
}
$update_product = null;
