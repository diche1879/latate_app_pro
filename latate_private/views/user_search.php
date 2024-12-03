<div class="container pb-6 pt-6">
    <?php
    require_once "./php/main.php";

    # Importamos el codigo general de searcher para definir o elimnar el valo de la $_SESSION['search_user']
    if (isset($_POST['module_search'])) {
        require_once "./php/searcher.php";
    }
    #Creamos una condicional por lo que si no ha sido insertado ningun parametro de busqueda, entonces la variable está vacia o nop está definida se mostrará el formulario
    if (!isset($_SESSION['search_user']) && empty($_SESSION['search_user'])) {
    ?>
        <div class="container is-fluid mb-6">
            <h1 class="title">Usuarios</h1>
            <h2 class="subtitle">Buscar usuario</h2>
        </div>


        <div class="columns">
            <div class="column">
                <form method="POST" autocomplete="off">
                    <input type="hidden" name="module_search" value="user">
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
                    <input type="hidden" name="module_search" value="user">
                    <input type="hidden" name="delete_searcher" value="user">
                    <p>Estas buscando <strong>"<?php echo $_SESSION['search_user']; ?>"</strong></p>
                    <br>
                    <button type="submit" class="button is-danger is-rounded">Eliminar busqueda</button>
                </form>
            </div>
        </div>
    <?php
        #El codigo de páginación precedentemente creado en el archivo user_list.php modificando la $url y definendo la variable $search

        if (isset($_GET['user_id_del'])) {
            require_once "./php/delete_user.php";
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
        $url = "index.php?view=user_search&pages=";
        $registers = 15;
        $search = $_SESSION['search_user'];

        require_once "./php/users_list.php";
    }
    ?>
</div>