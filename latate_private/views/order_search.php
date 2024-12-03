<div class="container pb-6 pt-6">
    <?php
    require_once "./php/main.php";

    if (isset($_POST['module_search'])) {
        require_once "./php/searcher.php";
    }

    if (!isset($_SESSION['search_order']) && empty($_SESSION['search_order'])) {
    ?>  <div class="container is-fluid mb-6">
            <h1 class="title">Order</h1>
            <h2 class="subtitle">Find an order</h2>
        </div>
        <div class="columns">
            <div class="column">
                <form action="" method="POST" autocomplete="off">
                    <input type="hidden" name="module_search" value="order">
                    <div class="field is-grouped">
                        <p class="control is-expanded">
                            <input class="input is-rounded" type="text" name="txt_searcher" placeholder="What are you looking for?" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ -]{1,30}" maxlength="30">
                        </p>
                        <p class="control">
                            <button class="button is-info" type="submit">Search</button>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    <?php
    } else {
    ?><div class="columns">
            <div class="column">
                <form class="has-text-centered mt-6 mb-6" action="" method="POST" autocomplete="off">
                    <input type="hidden" name="module_search" value="order">
                    <input type="hidden" name="delete_searcher" value="order">
                    <p>Estas buscando <strong>“<?php echo $_SESSION['search_order']; ?>”</strong></p>
                    <br>
                    <button type="submit" class="button is-danger is-rounded">Delete Search</button>
                </form>
            </div>
        </div>
    <?php

        /* Eliminar un producto */
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

        $order_id = (isset($_GET['id_order'])) ? $_GET['id_order'] : 0;

        $page = cleanString($page);
        $url = "index.php?view=order_search&pages=";
        /* Registros por página */
        $registers = 15;
        $search = $_SESSION['search_order'];

        require_once "./php/order_listing.php";
    }
    ?>

</div>