<div class="container pb-6 pt-6">
    <div class="container is-fluid mb-6">
        <h1 class="title">Orders</h1>
        <h2 class="subtitle">New Order</h2>
    </div>
    <?php
    require_once "./php/main.php";
    ?>
    <div class="form-rest mb-6 mt-6"></div>
    <form action="./php/order_save.php" method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Client Username</label>
                    <input class="input" type="text" name="username_client" pattern="[a-zA-Z0-9- ]{1,70}" maxlength="70" required>
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Order Amount</label>
                    <input class="input" type="number" name="order_amount" step="0.01" required>
                </div>
            </div>
        </div>
        <div class="columns is-mobile is-multiline is-centered">
            <div class="column is-narrow">
                <label>Order PDF</label><br>
                <div class="file has-name">
                    <label class="file-label">
                        <input class="file-input" type="file" name="order_pdf" accept=".pdf">
                        <span class="file-cta">
                            <span class="file-label">PDF</span>
                        </span>
                        <span class="file-name">PDF (MAX 3MB)</span>
                    </label>
                </div>
            </div>
            <div class="column is-narrow">
                <label>Order State</label><br />
                <div class="select is-rounded ">
                    <select name="order_state" id="order_state">
                        <option value="processing">Processing</option>
                        <option value="finalized ">Finalized </option>
                    </select>
                </div>
            </div>
        </div>
        <p class="has-text-centered">
            <button type="submit" class="button is-info is-rounded">SAVE</button>
        </p>
    </form>
</div>