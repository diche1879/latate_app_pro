<div class="container pb-6 pt-6">
    <div class="container is-fluid mb-6">
        <h1 class="title">Products</h1>
        <h2 class="subtitle">Update Product</h2>
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

        <h2 class="title has-text-centered"><?php echo $data['article'] ?></h2>

        <form action="./php/product_update.php" method="POST" class="FormularioAjax" autocomplete="off">

            <input type="hidden" name="id_product" required value="<?php echo $data['id_product'] ?>">

            <div class="columns">
                <div class="column">
                    <div class="control">
                        <label>Reference</label>
                        <input class="input" type="text" name="product_code" pattern="[a-zA-Z0-9- ]{1,70}" maxlength="70" required value="<?php echo $data['reference'] ?>">
                    </div>
                </div>
                <div class="column">
                    <div class="control">
                        <label>Article</label>
                        <input class="input" type="text" name="product_name" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}" maxlength="70" required value="<?php echo $data['article'] ?>">
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column">
                    <div class="control">
                        <label>Composition</label>
                        <input class="input" type="text" name="product_composition" pattern="[a-zA-Z0-9 ,_%-]{1,70}" maxlength="70" value="<?php echo $data['composition'] ?>">
                    </div>
                </div>
                <div class="column">
                    <div class="control">
                        <label>Weight</label>
                        <input class="input" type="text" name="product_weight" pattern="[a-zA-Z0-9 ]{1,70}" maxlength="70" value="<?php echo $data['weight'] ?>">
                    </div>
                </div>
                <div class="column">
                    <div class="control">
                        <label>Width</label>
                        <input class="input" type="text" name="product_width" pattern="[a-zA-Z0-9 ]{1,70}" maxlength="70" value="<?php echo $data['width'] ?>">
                    </div>
                </div>
            </div>
            <div class="columns">

                <div class="column">
                    <div class="control">
                        <label>Description</label>
                        <textarea class="textarea" name="product_description" pattern="[a-zA-Z0-9 .,!?-_()%\n\r]{0,1000}"><?php echo $data['description'] ?></textarea>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column">
                    <div class="control">
                        <label>Format</label>
                        <input class="input" type="text" name="product_format" pattern="[a-zA-Z0-9- ]{1,70}" maxlength="70" value="<?php echo $data['format'] ?>">
                    </div>
                </div>
                <div class="column">
                    <div class="control">
                        <label>Wholesaler Price in EURO</label>
                        <input class="input" type="number" step="0.01" name="product_price" pattern="[0-9.]{1,25}" maxlength="25" required value="<?php echo $data['price'] ?>">
                    </div>
                </div>
                <div class="column">
                    <div class="control">
                        <label>Store Price in EURO</label>
                        <input class="input" type="number" step="0.01" name="product_price_dos" pattern="[0-9.]{1,25}" maxlength="25" required value="<?php echo $data['price_dos'] ?>">
                    </div>
                </div>
            </div>
            <div class="columns">

                <div class="column">
                    <div class="control">
                        <label>Stock</label>
                        <input class="input" type="text" name="product_stock" pattern="[0-9]{1,25}" maxlength="25" required value="<?php echo $data['stock'] ?>">
                    </div>
                </div>
                <div class="column">
                    <div class="control">
                        <label>Availability</label>
                        <input class="input" type="text" name="product_availability" pattern="[a-zA-Z0-9- ]{1,70}" maxlength="25" required value="<?php echo $data['availability'] ?>">
                    </div>
                </div>
                <div class="column">
                    <label>Category</label><br>
                    <div class="select is-rounded">
                        <select name="product_category">
                            <?php
                            $categories = conection();
                            $categories = $categories->query("SELECT * FROM category");
                            if ($categories->rowCount() > 0) {
                                $categories = $categories->fetchAll();
                                foreach ($categories as $category) {
                                    if ($data['id_category'] == $category['id_category']) {
                                        echo '<option value="' . $category['id_category'] . '" selected="">' . $category['category_name'] . ' (Actual)</option>';
                                    } else {
                                        echo '<option value="' . $category['id_category'] . '">' . $category['category_name'] . '</option>';
                                    };
                                }
                            }
                            $categories = null;
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <p class="has-text-centered">
                <button type="submit" class="button is-success is-rounded">Update</button>
            </p>
        </form>



    <?php
    } else {
        include "./inc/error_alert.php";
    }
    $check_product = null;
    ?>

</div>