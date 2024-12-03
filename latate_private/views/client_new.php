<div class="container pb-6 pt-6 p-2">
    <div class="container is-fluid mb-6">
        <h1 class="title">Clientes</h1>
        <h2 class="subtitle">New client</h2>
    </div>

    <?php
    require_once "./php/main.php";
    ?>
    <div class="form-rest mb-6 mt-6"></div>

    <form action="./php/client_save.php" method="POST" autocomplete="off" class="FormularioAjax">
        <div class="columns">
            <div class="column">
                <label>Type of client <span class="requireds">*</span></label><br>
                <div class="select is-rounded">
                    <select name="client_role">
                        <option value="" selected="">Select an option</option>
                        <?php
                        $roles = conection();
                        $roles = $roles->query("SELECT * FROM roles");
                        if ($roles->rowCount() > 0) {
                            /* Cuando solo es un dato utilizamos fetch, pero si el registro es mas que uno se utilizará fetchAll */
                            $roles = $roles->fetchAll();
                            foreach ($roles as $role) {
                                // Convertir el nombre del rol a mayúsculas
                                $name_rol_uppercase = strtoupper($role['name_rol']);
                                echo '<option value="' . $role['id_role'] . '">' . $name_rol_uppercase . '</option>';
                            }
                        }
                        $roles = null;
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Username <span class="requireds">*</span></label>
                    <input class="input" type="text" name="client_username" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Email <span class="requireds">*</span></label>
                    <input class="input" type="email" name="client_email" maxlength="70" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Company Name <span class="requireds">*</span></label>
                    <input class="input" type="text" name="client_company" pattern="[a-zA-ZÀ-ÿñÑ\\s+@#.,'-]{2,100}" maxlength="30" required>
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Tax ID Number <span class="requireds">*</span></label>
                    <input class="input" type="text" name="client_nif" pattern="^[a-zA-Z0-9\-\.]{5,20}$" maxlength="20" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Phone Number</label>
                    <input class="input" type="tel" name="client_phone" maxlength="20">
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Country & State</label>
                    <input class="input" type="text" name="client_country" pattern="[a-zA-Z0-9\s\.]{4,30}" maxlength="30" placeholder="EE.UU. (California)">
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>City</label>
                    <input class="input" type="text" name="client_city" pattern="^[a-zA-ZÀ-ÿñÑ\s\-]{2,100}$" maxlength="100">
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Address</label>
                    <input class="input" type="text" name="client_address" maxlength="100">
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Postal Code</label>
                    <input class="input" type="text" name="client_p_code" pattern="^[a-zA-Z0-9]{3,10}$" maxlength="10">
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Password <span class="requireds">*</span></label>
                    <input class="input" type="password" name="client_password_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Repeat Password <span class="requireds">*</span></label>
                    <input class="input" type="password" name="client_password_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
                </div>
            </div>
        </div>
        <p class="has-text-centered">
            <button type="submit" class="button is-info is-rounded">SAVE</button>
        </p>
    </form>
</div>