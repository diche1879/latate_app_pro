<div class="container pb-6 pt-6">
    <div class="container is-fluid mb-6">
        <h1 class="title">Products</h1>
        <h2 class="subtitle">New product</h2>
    </div>
    <?php
    require_once "./php/main.php";
    ?>
    <div class="form-rest mb-6 mt-6"></div>
    <!-- El enctype="multipart/form-data es lo que nos permite enviar imagenes -->
    <form action="./php/product_save.php" method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Reference</label>
                    <input class="input" type="text" name="product_code" pattern="[a-zA-Z0-9- ]{1,70}" maxlength="70" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Article</label>
                    <input class="input" type="text" name="product_name" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}" maxlength="70" required>
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Composition</label>
                    <input class="input" type="text" name="product_composition" pattern="[a-zA-Z0-9 ,_%-]{1,70}" maxlength="70">
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Weight</label>
                    <input class="input" type="text" name="product_weight" pattern="[a-zA-Z0-9 ]{1,70}" maxlength="70">
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Width</label>
                    <input class="input" type="text" name="product_width" pattern="[a-zA-Z0-9 ]{1,70}" maxlength="70">
                </div>
            </div>
        </div>
        <div class="columns">

            <div class="column">
                <div class="control">
                    <label>Description</label>
                    <textarea class="textarea" name="product_description" pattern="[a-zA-Z0-9 .,!?-_()%\n\r]{0,1000}"></textarea>
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Format</label>
                    <input class="input" type="text" name="product_format" pattern="[a-zA-Z0-9- ]{1,70}" maxlength="70">
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Wholesaler Price</label>
                    <input class="input" type="number" step="0.01" name="product_price" maxlength="25" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Store Price</label>
                    <input class="input" type="number" step="0.01"  name="product_price_dos" maxlength="25" required>
                </div>
            </div>
        </div>
        <div class="columns">
        <div class="column">
                <div class="control">
                    <label>Stock</label>
                    <input class="input" type="text" name="product_stock" pattern="[a-zA-Z0-9- ]{1,70}" maxlength="25" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Availability</label>
                    <input class="input" type="text" name="product_availability" pattern="[a-zA-Z0-9- ]{1,70}" maxlength="25" required>
                </div>
            </div>
        </div>
        <div class="columns">
           
            <div class="column">
                <label>Category</label><br>
                <div class="select is-rounded">
                    <select name="product_category">
                        <option value="" selected="">Seleccione una opción</option>
                        <?php
                        $categories = conection();
                        $categories = $categories->query("SELECT * FROM category");
                        if ($categories->rowCount() > 0) {
                            /* Cuando solo es un dato utilizamos fetch, pero si el registro es mas que uno se utilizará fetchAll */
                            $categories = $categories->fetchAll();
                            foreach ($categories as $category) {
                                echo '<option value="' . $category['id_category'] . '">' . $category['category_name'] . '</option>';
                            }
                        }
                        $categories = null;
                        ?>
                    </select>
                </div>
            </div>
           
            <div class="column">
                <label>Product Image</label><br>
                <div class="file is-small has-name">
                    <label class="file-label">
                        <input class="file-input" type="file" name="product_photo" accept=".jpg, .png, .jpeg">
                        <span class="file-cta">
                            <span class="file-label">Image</span>
                        </span>
                        <span class="file-name">JPG, JPEG, PNG. (MAX 3MB)</span>
                    </label>
                </div>
            </div>
        </div>
        <p class="has-text-centered">
            <button type="submit" class="button is-info is-rounded">Guardar</button>
        </p>
    </form>
</div>