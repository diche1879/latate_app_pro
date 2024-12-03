<?php
/* Verificar existencia del producto */
require_once "main.php";

$product_id = cleanString($_POST['img_del_id']);

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

/* Otorgar permisos de escritura i lectura */
chmod($img_dir, 0777);

if (is_file($img_dir . $datas['image'])) {
    chmod($img_dir . $datas['image'], 0777);

    if (!unlink($img_dir . $datas['image'])) {
        echo '
        <div class="notification is-danger is-light">
        <strong>ERROR!</strong>
        <p>Error trying to delete selected image, please try again</p>
        </div>';
        exit();
    }
}
 /* Actualizar los datos */
 $update_product = conection();

 $update_product = $update_product->prepare("UPDATE productos SET image = :photo WHERE id_product =:id");

 $dates = [
    ":photo" => "",
    ":id" => $product_id
 ];

 if ($update_product->execute($dates)) {
    echo '
       <div class="notification is-info is-light">
         <strong>IMAGE DELETED!</strong>
         <p>The product image was deleted successfully!<br> Please press OK to reload the changes.</p>

         <p class="has_text_centered pt-5 pb-5">
         <a href="index.php?view=product_img&product_id_up='.$product_id.'" class="button is-link is-rounded">OK</a>
         </p>
       </div>';
} else {
    echo '
       <div class="notification is-warning is-light">
         <strong>IMAGE DELETED!</strong>
         <p>Some issues occurred, please press OK to reload the changes.</p>

         <p class="has_text_centered pt-5 pb-5">
         <a href="index.php?view=product_img&product_id_up='.$product_id.'" class="button is-link is-rounded">OK</a>
         </p>
       </div>';
}
$update_product = null;