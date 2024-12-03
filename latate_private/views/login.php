<div class="main-container main-conatiner-dos">
    <a href="../index.php" class="back-arrow">
        <p>Go Back</p>
        <img src="../img/back_112351.svg" alt="back-arrow">
    </a>
    <header class="prime">
        <h2>LaTaTe</h2>
        <h1>PRIVATE ACCESS</h1>
    </header>
    <form class="box login" action="" method="POST" autocomplete="off">
        <h5 class="title is-5 has-text-centered is-uppercase">Sign In</h5>

        <div class="field">
            <label class="label">User</label>
            <div class="control">
                <input class="input different" type="text" name="login_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required>
            </div>
        </div>

        <div class="field">
            <label class="label">Password</label>
            <div class="control">
                <input class="input different" type="password" name="login_clave" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
            </div>
        </div>

        <p class="has-text-centered mb-4 mt-3">
            <button type="submit" class="button is-info is-rounded">Iniciar sesion</button>
        </p>

        <?php
        if (isset($_POST['login_usuario']) && isset($_POST['login_clave'])) {
            // Validar usuario y contraseña
            require_once "./php/main.php";
            require_once "./php/start_session.php";
        }
        ?>
    </form>

</div>