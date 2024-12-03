<div class="container pb-6 pt-6">
    <div class="container is-fluid mb-6">
        <h1 class="title">Clients</h1>
        <h2 class="subtitle">Update data client</h2>
    </div>


    <?php
    /* Incluir el botón de volver atrás */
    include "./inc/btn_back.php";
    require_once "./php/main.php";
    $id = (isset($_GET['client_id_up'])) ? $_GET['client_id_up'] : 0;
    $id = cleanString($id);
    $check_client = conection();
    $check_client = $check_client->query("SELECT * FROM clients WHERE id_client = '$id'");
    if ($check_client->rowCount() > 0) {
        $data = $check_client->fetch();
    ?>

        <div class="form-rest mb-6 mt-6"></div>

        <h2 class="title has-text-centered"><?php echo $data['username_client'] ?></h2>
        <form action="./php/clients_update.php" method="POST" class="FormularioAjax" autocomplete="off">
            <div class="columns">
                <div class="column">
                    <label>Type of client</label><br>
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

                                    // Verificar si este es el rol actual para marcarlo como seleccionado
                                    if ($data['id_role'] == $role['id_role']) {
                                        echo '<option value="' . $role['id_role'] . '" selected="">' . $name_rol_uppercase . ' (Actual)</option>';
                                    } else {
                                        echo '<option value="' . $role['id_role'] . '">' . $name_rol_uppercase . '</option>';
                                    }
                                }
                            }
                            $roles = null;
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <input type="hidden" name="id_client" value="<?php echo $data['id_client'] ?>">
            <div class="columns">
                <div class="column">
                    <div class="control">
                        <label>Username <span class="requireds">*</span></label>
                        <input class="input" type="text" name="username_client" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required value="<?php echo $data['username_client'] ?>">
                    </div>
                </div>
                <div class="column">
                    <div class="control">
                        <label>Email <span class="requireds">*</span></label>
                        <input class="input" type="email" name="email_client" required value="<?php echo $data['email_client'] ?>">
                    </div>
                </div>
                <div class="column">
                    <div class="control">
                        <label>Company Name <span class="requireds">*</span></label>
                        <input class="input" type="text" name="client_company" pattern="[a-zA-ZÀ-ÿñÑ\\s+@#.,'-]{2,100}" maxlength="30" value="<?php echo $data['client_company'] ?>">
                    </div>
                </div>
                <div class="columns">

                </div>
            </div>
            <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Tax ID Number <span class="requireds">*</span></label>
                    <input class="input" type="text" name="client_nif" pattern="^[a-zA-Z0-9\-\.]{5,20}$" maxlength="20" value="<?php echo $data['client_nif'] ?>">
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Phone Number</label>
                    <input class="input" type="tel" name="client_phone" maxlength="20" value="<?php echo $data['client_phone'] ?>">
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Country & State</label>
                    <input class="input" type="text" name="client_country" pattern="[a-zA-Z0-9\s\.]{4,30}" maxlength="30" placeholder="EE.UU. (California)" value="<?php echo $data['client_country'] ?>">
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>City</label>
                    <input class="input" type="text" name="client_city" pattern="^[a-zA-ZÀ-ÿñÑ\s\-]{2,100}$" maxlength="100" value="<?php echo $data['client_city'] ?>">
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Address</label>
                    <input class="input" type="text" name="client_address" maxlength="100" value="<?php echo $data['client_address'] ?>">
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Postal Code</label>
                    <input class="input" type="text" name="client_p_code" pattern="^[a-zA-Z0-9]{3,10}$" maxlength="10" value="<?php echo $data['client_p_code'] ?>">
                </div>
            </div>
        </div>
            <p class="has-text-centered">
                If you want to update this client's password please fill in the 2 fields. If you do NOT wish to update the password please leave the fields empty.
            </p>
            <br>
            <div class="columns">
                <div class="column">
                    <div class="control">
                        <label>Password</label>
                        <input class="input" type="password" name="client_password_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100">
                    </div>
                </div>
                <div class="column">
                    <div class="control">
                        <label>Repeat password</label>
                        <input class="input" type="password" name="client_password_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100">
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
    $check_client = null;
    ?>


</div>

<!-- ^[a-zA-ZÀ-ÿ\u00f1\u00d1\s\+\@\#\.\-\,\&\_\']{2,100}$ -->

<!-- ^[a-zA-ZÀ-ÿñÑ\s\+\@\#\.\-\,\_\'']{2,100}$ -->