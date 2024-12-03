<div class="container pb-6 pt-6">
    <div class="container is-fluid mb-6">
        <h1 class="title">Productos</h1>
        <h2 class="subtitle">Actualizar imagen de producto</h2>
    </div>
    

    <?php
    /* Incluir el botón de volver atrás */
    include "./inc/btn_back.php";

    require_once "./php/main.php";

    $id = (isset($_GET['product_id_up'])) ? $_GET['product_id_up'] : 0;
    $id = cleanString($id);

    $check_product = conection();
    $check_product = $check_product->query("SELECT * FROM productos WHERE id_product = '$id'");

    if ($check_product->rowCount() > 0) {
        $data = $check_product->fetch();
    ?>

        <div class="form-rest mb-6 mt-6"></div>

        <div class="columns">
            <div class="column is-two-fifths">

                <?php
                if (is_file("./img/products/".$data['image'])) {
                    # code...

                ?>
                    <figure class="image mb-6">
                        <img src="./img/products/<?php echo $data['image'] ?>">
                    </figure>
                    <form class="FormularioAjax" action="./php/product_img_delete.php" method="POST" autocomplete="off">

                        <input type="hidden" name="img_del_id" value="<?php echo $data['id_product'] ?>">

                        <p class="has-text-centered">
                            <button type="submit" class="button is-danger is-rounded">Delete image</button>
                        </p>
                    </form>

                <?php } else { ?>
                    <figure class="image mb-6">
                        <img src="./img/producto.jpg">
                    </figure>
                <?php } ?>

            </div>


            <div class="column">
                <form class="mb-6 has-text-centered FormularioAjax" action="./php/product_img_update.php" method="POST" enctype="multipart/form-data" autocomplete="off">

                    <h4 class="title is-4 mb-6"><?php echo $data['article'] ?></h4>

                    <label>Foto o imagen del producto</label><br>

                    <input type="hidden" name="img_up_id" value="<?php echo $data['id_product'] ?>">

                    <div class="file has-name is-horizontal is-justify-content-center mb-6">
                        <label class="file-label">
                            <input class="file-input" type="file" name="product_photo" accept=".jpg, .png, .jpeg">
                            <span class="file-cta">
                                <span class="file-label">Image</span>
                            </span>
                            <span class="file-name">JPG, JPEG, PNG. (MAX 3MB)</span>
                        </label>
                    </div>
                    <p class="has-text-centered">
                        <button type="submit" class="button is-success is-rounded">Actualizar</button>
                    </p>
                </form>
            </div>
        </div>



    <?php
    } else {
        include "./inc/error_alert.php";
    }
    $check_product = null;
    ?>

</div>