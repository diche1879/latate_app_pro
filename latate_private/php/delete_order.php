<?php
$order_id_del = cleanString($_GET['order_id_del']);

/* Verificando pedido */

$check_order = conection();

$check_order = $check_order->query("SELECT * FROM orders WHERE id_order = '$order_id_del'");

/* comprobar si existe la orden */

if ($check_order->rowCount() == 1) {
    $data = $check_order->fetch();
    $delete_order = conection();
    $delete_order = $delete_order->prepare("DELETE FROM orders WHERE id_order = :id");
    $delete_order->execute([':id' => $order_id_del]);

    if ($delete_order->rowCount() == 1) {
        if (is_file("./pdf/".$data['order_pdf'])) {
            chmod("./pdf/".$data['order_pdf'], 0777);
            unlink("./pdf/".$data['order_pdf']);
        }
        echo '
            <div class="notification is-info is-light">
                <strong>PEDIDO ELIMINADO!</strong>
            </div>
        ';
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>ERROR!</strong>
                <p>Could not delete order, please try again.</p>
            </div>
        ';
    }
    $delete_order = null;
}else{
    echo '
        <div class="notification is-danger is-light">
            <strong>ERROR!</strong>
            <p>The order you are trying to delete does not exist.</p>
        </div>
    ';
}

