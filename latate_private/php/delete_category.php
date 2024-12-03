<?php
$category_id_del = cleanString($_GET['category_id_del']);

/* Verificando categoria */
$check_category = conection();
$check_category = $check_category->query("SELECT id_category FROM category WHERE id_category = '$category_id_del'");

if ($check_category->rowCount() == 1) {
    $check_products = conection();
    $check_products = $check_products->query("SELECT id_category FROM productos WHERE id_category = '$category_id_del' LIMIT 1");

    if ($check_products->rowCount() <= 0) {
        $delete_category = conection();
        $delete_category = $delete_category->prepare("DELETE FROM category WHERE id_category = :id");
        $delete_category->execute([':id' => $category_id_del]);

        if ($delete_category->rowCount() == 1) {
            echo '
               <div class="notification is-info is-light">
                 <strong>CATEGORY DELETED!</strong>
                 <p>The category was successfully deleted</p>
               </div>';
        } else {
            echo '
               <div class="notification is-danger is-light">
                 <strong>ERROR!</strong>
                 <p>Could not delete category, please try again.</p>
               </div>';
        }

        $delete_category = null;
    } else {
        echo '
           <div class="notification is-danger is-light">
             <strong>OPERATION DENIED!</strong>
             <p>The user cannot be deleted because he has registered products.</p>
           </div>';
    }
    $check_products = null;


} else {
    echo '
       <div class="notification is-danger is-light">
         <strong>ERROR!</strong>
         <p>Category does not exist</p>
       </div>';
}
$check_category = null;