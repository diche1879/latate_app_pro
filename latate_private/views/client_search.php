<div class="container pb-6 pt-6">
    <?php
    require_once "./php/main.php";

    if (isset($_POST['module_search'])) {
        require_once "./php/searcher.php";
    }

    if (!isset($_SESSION['search_client']) && empty($_SESSION['search_client'])) {
    ?>
        <div class="container is-fluid mb-6">
            <h1 class="title">Clients</h1>
            <h2 class="subtitle">Search client</h2>
        </div>


        <div class="columns">
            <div class="column">
                <form method="POST" autocomplete="off">
                    <input type="hidden" name="module_search" value="client">
                    <div class="field is-grouped">
                        <p class="control is-expanded">
                            <input class="input is-rounded" type="text" name="txt_searcher" placeholder="Who are you looking for?" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" maxlength="30">
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
    ?>
        <div class="columns">
            <div class="column">
                <form class="has-text-centered mt-6 mb-6" method="POST" autocomplete="off">
                    <input type="hidden" name="module_search" value="client">
                    <input type="hidden" name="delete_searcher" value="client">
                    <p>Estas buscando <strong>"<?php echo $_SESSION['search_client']; ?>"</strong></p>
                    <br>
                    <button type="submit" class="button is-danger is-rounded">Delete search</button>
                </form>
            </div>
        </div>

    <?php

        if (isset($_GET['client_id_del'])) {
            require_once "./php/delete_client.php";
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
        $url = "index.php?view=client_search&pages=";

        $registers = 15;
        $search = $_SESSION['search_client'];

        require_once "./php/clients_list.php";
    }
    ?>

</div>