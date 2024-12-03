<?php
    $product_id_del = cleanString($_GET['product_id_del']);

    /* Verificando producto */
    $check_product = conection();
    $check_product = $check_product->query("SELECT * FROM productos WHERE id_product = '$product_id_del'");

    /* Comprobar si el producto existe */
    if ($check_product->rowCount() == 1) {
        $data = $check_product->fetch();
        $delete_product = conection();
        $delete_product = $delete_product->prepare("DELETE FROM productos WHERE id_product = :id");
        $delete_product->execute([':id' => $product_id_del]);

        if ($delete_product->rowCount() == 1) {
            if (is_file("./img/products/".$data['image'])) {
                chmod("./img/products/".$data['image'], 0777);
                unlink("./img/products/".$data['image']);
            }
            echo '
               <div class="notification is-info is-light">
                 <strong>PRODUCT DELETED!</strong>
                 <p>The product was successfully deleted!</p>
               </div>';
        } else {
            echo '
               <div class="notification is-danger is-light">
                 <strong>ERROR!</strong>
                 <p>Could not delete product, please try again.</p>
               </div>';
        }

        $delete_product = null;
    }else{
        echo '
               <div class="notification is-danger is-light">
                 <strong>ERROR!</strong>
                 <p>The product you are trying to delete does not exist.</p>
               </div>';
    }
    $check_product = null;
?>