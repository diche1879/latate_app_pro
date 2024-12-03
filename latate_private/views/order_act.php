<div class="container pb-6 pt-6">
    <div class="container is-fluid mb-6">
        <h1 class="title">Order</h1>
        <h2 class="subtitle">Order Update</h2>
    </div>
    
    <?php
    /* Incluir el botón de volver atrás */
    include "./inc/btn_back.php";

    require_once "./php/main.php";

    $id = (isset($_GET['order_id_up'])) ? $_GET['order_id_up'] : 0;
    $id = cleanString($id);

    $check_order = conection();
    $check_order = $check_order->query("SELECT * FROM orders WHERE id_order = '$id'");

    if ($check_order->rowCount() > 0) {
        $data = $check_order->fetch();
    ?>

        <div class="form-rest mb-6 mt-6"></div>
        <form action="./php/order_update.php" method="POST" enctype="multipart/form-data" class="FormularioAjax" autocomplete="off">
            <input type="hidden" name="id_order" value="<?php echo $data['id_order'] ?>" required>
            <div class="columns">
                <div class="column">
                    <div class="control">
                        <label>Order Amount</label>
                        <input class="input" type="number" name="order_amount" value="<?php echo $data['order_amount'] ?>" step="0.01" required>
                    </div>
                </div>
                <div class="column">
                    <div class="control">
                        <label>Order State</label><br>
                        <div class="select is-rounded ">
                            <select name="order_state" id="order_state">
                                <option value="" selected="">Select an option</option>
                                <option value="processing" <?php if ($data['order_state'] == 'processing') echo 'selected'; ?>>Processing</option>
                                <option value="finalized" <?php if ($data['order_state'] == 'finalized') echo 'selected'; ?>>Finalized</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column">
                    <div class="control">
                        <label>Upload PDF</label>
                        <input class="input" type="file" name="order_pdf" accept="application/pdf">
                    </div>
                </div>
            </div>

            <p class="has-text-centered">
                <button type="submit" class="button is-info is-rounded">SAVE</button>
            </p>
        </form>
    <?php
    } else {
        include "./inc/error_alert.php";
    }
    $check_order = null;
    ?>
</div>