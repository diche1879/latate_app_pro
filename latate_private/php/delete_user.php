<?php
$user_id_del = cleanString($_GET['user_id_del']);
/* Verificar usuario */

$check_user = conection();

$check_user = $check_user->query("SELECT id_user FROM usuario WHERE id_user = '$user_id_del'");

if ($check_user->rowCount() == 1) {
    $check_products = conection();
    $check_products = $check_products->query("SELECT id_user FROM productos WHERE id_user = '$user_id_del' LIMIT 1");

    if ($check_products->rowCount() <= 0) {
        $delete_user = conection();
        $delete_user = $delete_user->prepare("DELETE FROM usuario WHERE id_user = :id");
        $delete_user->execute([':id' => $user_id_del]);

        if ($delete_user->rowCount() == 1) {
            echo '
               <div class="notification is-info is-light">
                 <strong>USER DELETED!</strong>
                 <p>The user was successfully deleted</p>
               </div>';
        } else {
            echo '
               <div class="notification is-danger is-light">
                 <strong>ERROR!</strong>
                 <p>Could not delete user, please try again.</p>
               </div>';
        }

        $delete_user = null;
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
         <p>User does not exist</p>
       </div>';
};
