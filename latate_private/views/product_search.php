<div class="container pb-6 pt-6">
    <?php
    require_once "./php/main.php";

    if (isset($_POST['module_search'])) {
        require_once "./php/searcher.php";
    }

    if (!isset($_SESSION['search_product']) && empty($_SESSION['search_product'])) {
    ?>
        <div class="container is-fluid mb-6">
            <h1 class="title">Products</h1>
            <h2 class="subtitle">Find a product</h2>
        </div>

        <div class="columns">
            <div class="column">
                <form action="" method="POST" autocomplete="off">
                    <input type="hidden" name="module_search" value="product">
                    <div class="field is-grouped">
                        <p class="control is-expanded">
                            <input class="input is-rounded" type="text" name="txt_searcher" placeholder="¿Qué estas buscando?" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ -]{1,30}" maxlength="30">
                        </p>
                        <p class="control">
                            <button class="button is-info" type="submit">Buscar</button>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    <?php
    } else {
    ?>

        <div class="columns">
            <div class="column">
                <form class="has-text-centered mt-6 mb-6" action="" method="POST" autocomplete="off">
                    <input type="hidden" name="module_search" value="product">
                    <input type="hidden" name="delete_searcher" value="product">
                    <p>Estas buscando <strong>“<?php echo $_SESSION['search_product']; ?>”</strong></p>
                    <br>
                    <button type="submit" class="button is-danger is-rounded">Eliminar busqueda</button>
                </form>
            </div>
        </div>
    <?php

        /* Eliminar un producto */
        if (isset($_GET['product_id_del'])) {
            require_once "./php/delete_product.php";
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

        $category_id = (isset($_GET['id_category'])) ? $_GET['id_category'] : 0;

        $page = cleanString($page);
        $url = "index.php?view=product_search&pages=";
        /* Registros por página */
        $registers = 15;
        $search = $_SESSION['search_product'];

        require_once "./php/product_listing.php";
    }
    ?>

</div>