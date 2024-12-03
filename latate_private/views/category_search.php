<div class="container pb-6 pt-6">
    <?php
    require_once "./php/main.php";

    if (isset($_POST['module_search'])) {
        require_once "./php/searcher.php";
    }

    if (!isset($_SESSION['search_category']) && empty($_SESSION['search_category'])) {
    ?>  <div class="container is-fluid mb-6">
            <h1 class="title">Categorías</h1>
            <h2 class="subtitle">Buscar categoría</h2>
        </div>


        <div class="columns">
            <div class="column">
                <form method="POST" autocomplete="off">
                    <input type="hidden" name="module_search" value="category">
                    <div class="field is-grouped">
                        <p class="control is-expanded">
                            <input class="input is-rounded" type="text" name="txt_searcher" placeholder="¿Qué estas buscando?" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" maxlength="30">
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
                <form class="has-text-centered mt-6 mb-6" method="POST" autocomplete="off">
                    <input type="hidden" name="module_search" value="category">
                    <input type="hidden" name="delete_searcher" value="category">
                    <p>Estas buscando <strong>"<?php echo $_SESSION['search_category']; ?>"</strong></p>
                    <br>
                    <button type="submit" class="button is-danger is-rounded">Eliminar busqueda</button>
                </form>
            </div>
        </div>

    <?php

        if (isset($_GET['category_id_del'])) {
            require_once "./php/delete_category.php";
        }

        if (!isset($_GET['pages'])) {
            $page = 1;
        } else {
            $page = (int) $_GET['pages'];
            if ($page <= 1) {
                $page = 1;
            }
        }

        $page = cleanString($page);
        $url = "index.php?view=category_search&pages=";
        /* Registros por página */
        $registers = 15;
        $search = $_SESSION['search_category'];

        require_once "./php/category_listing.php";
    }
    ?>

</div>