<div class="container pb-6 pt-6">
    <div class="container is-fluid mb-6">
        <h1 class="title">Products</h1>
        <h2 class="subtitle">List of products</h2>
    </div>
    
    <?php
        require_once "./php/main.php";

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
        $url = "index.php?view=product_list&pages=";
        /* Registros por página */
        $registers = 15;
        $search = "";

        require_once "./php/product_listing.php";
    ?>
</div>