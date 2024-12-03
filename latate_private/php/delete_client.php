<?php
$client_id_del = cleanString($_GET['client_id_del']);

/* Verificando cliente */

$check_client = conection();

$check_client = $check_client->query("SELECT id_client FROM clients WHERE id_client = '$client_id_del'");

if ($check_client->rowCount() == 1) {
    $check_order = conection();
    $check_order = $check_order->query("SELECT id_client FROM orders WHERE id_client = '$client_id_del' LIMIT 1");

    if ($check_order->rowCount() <= 0) {
        $delete_client = conection();
        $delete_client = $delete_client->prepare("DELETE FROM clients WHERE id_client = :id");
        $delete_client->execute([':id' => $client_id_del]);

        if ($delete_client->rowCount() == 1) {
            echo '
               <div class="notification is-info is-light">
                 <strong>CLIENT DELETED!</strong>
                 <p>The client was successfully deleted</p>
               </div>';
        } else {
            echo '
               <div class="notification is-danger is-light">
                 <strong>ERROR!</strong>
                 <p>The client could not be deleted, please try again.</p>
               </div>';
        }
        $delete_client = null;
    } else {
        echo '
           <div class="notification is-danger is-light">
             <strong>OPERATION DENIED!</strong>
             <p>The client cannot be deleted because he has registered products.</p>
           </div>';
    }
    $check_order = null;
} else{
    echo '
       <div class="notification is-danger is-light">
         <strong>ERROR!</strong>
         <p>Client does not exist</p>
       </div>';
}