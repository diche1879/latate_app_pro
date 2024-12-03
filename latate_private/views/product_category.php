<div class="container pb-6 pt-6">
    <div class="container is-fluid mb-6">
        <h1 class="title">Productos</h1>
        <h2 class="subtitle">Lista de productos por categoría</h2>
    </div>
    

    <?php
    require_once "./php/main.php";
    ?>
    <div class="columns">



        <div class="column is-one-third">
            <h2 class="title has-text-centered">Categorías</h2>

            <?php
            $categories = conection();
            $categories = $categories->query("SELECT * FROM category");
            if ($categories->rowCount() > 0) {
                $categories = $categories->fetchAll();
                foreach ($categories as $category) {
                    echo '<a href="index.php?view=product_category&category_id=' . $category['id_category'] . '" class="button is-link is-inverted is-fullwidth">' . $category['category_name'] . '</a>';
                }
            } else {
                echo '<p class="has-text-centered" >No hay categorías registradas</p>';
            }
            $categories = null;
            ?>

        </div>



        <div class="column">
            <?php
            $category_id = (isset($_GET['category_id'])) ? $_GET['category_id'] : 0;
            $categories = conection();
            $categories = $categories->query("SELECT * FROM category WHERE id_category='$category_id'");
            if ($categories->rowCount() > 0) {
                $categories = $categories->fetch();
                echo '
                    <h2 class="title has-text-centered">' . $categories['category_name'] . '</h2>
                    <p class="has-text-centered pb-6">' . $categories['category_site'] . '</p>';

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

                $page = cleanString($page);
                $url = "index.php?view=product_category&category_id=$category_id&pages=";
                /* Registros por página */
                $registers = 15;
                $search = "";

                require_once "./php/product_listing.php";
            } else {
                echo '<h2 class="has-text-centered title" >Seleccione una categoria para empezar</h2>';
            }
            $categories = null;

            ?>
        </div>

    </div>
</div>