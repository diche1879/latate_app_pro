<?php
require_once "main.php";

$id = cleanString($_POST['id_order']);

/* Verificar la orden */

$check_order = conection();

$check_order = $check_order->query("SELECT * FROM orders WHERE id_order = '$id'");

if ($check_order->rowCount() <= 0) {
    echo '
    <div class="notification is-danger is-light">
        <button class="delete" aria-label="delete"></button>
        <strong>Error!</strong>
        <p>The order does not exist</p>
    </div>
    ';
    exit();
}else{
    $datas = $check_order->fetch();
}

$check_order = null;

/* Almacenando datos desde el form */
$amount = cleanString($_POST['order_amount']);
$state = cleanString($_POST['order_state']);

/* en caso de no rellenar todos los campos aparecerá el mensaje de error */
if ($amount == "" || $state == "") {
    echo '
      <div class="notification is-danger is-light">
        <strong>ERROR!</strong>
        <p>All fields must be filled in</p>
      </div>';
    exit();
}

/* actualizar datos */

$update_order = conection();

$update_order = $update_order->prepare("UPDATE orders SET order_amount = :amount, order_state = :state WHERE id_order = :id");

$dates = [
    ":amount" => $amount,
    ":state" => $state,
    ":id" => $id
];

if ($update_order->execute($dates)) {
    echo '
    <div class="notification is-success is-light">
        <button class="delete" aria-label="delete"></button>
        <strong>Success!</strong>
        <p>Order updated successfully</p>
    </div>';
}else{
    echo '
    <div class="notification is-danger is-light">
        <button class="delete" aria-label="delete"></button>
        <strong>ERROR!</strong>
        <p>An error occurred while updating the order</p>
    </div>';
}

$update_order = null;