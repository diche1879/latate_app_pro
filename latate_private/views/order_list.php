<div class="container pb-6 pt-6">
    <div class="container is-fluid mb-6">
        <h1 class="title">Orders</h1>
        <h2 class="subtitle">Orders List</h2>
    </div>
    <?php
    require_once "./php/main.php";

    /* Eliminar un categoria */
    if (isset($_GET['order_id_del'])) {
        require_once "./php/delete_order.php";
    }

    /* nos aseguramos que si la variable no existe se cree en el valor 1 */
    if (!isset($_GET['pages'])) {
        $page = 1;
    } else {
        $page = (int) $_GET['pages'];
        if ($page <= 1) {
            $page = 1;
        }
    }

    $page = cleanString($page);
    $url = "index.php?view=order_list&pages=";
    /* Registros por página */
    $registers = 15;
    $search = "";

    require_once "./php/order_listing.php";
    ?>
</div>