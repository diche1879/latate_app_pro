<?php
require_once "./php/main.php";

$id = (isset($_GET['user_id_up'])) ? $_GET['user_id_up'] : 0;
$id = cleanString($id);
?>

<div class="container is-fluid mb-6">
	<?php if ($id == $_SESSION['id']) { ?>

		<h1 class="title">My account</h1>
		<h2 class="subtitle">Update my account</h2>

	<?php } else { ?>
		<h1 class="title">User</h1>
		<h2 class="subtitle">Update user data</h2>
	<?php } ?>
</div>

<div class="container pb-6 pt-6">
	<?php
	/* Incluir el botón de volver atrás */
	include "./inc/btn_back.php";

	$check_user = conection();
	$check_user = $check_user->query("SELECT * FROM usuario WHERE id_user = '$id'");

	if ($check_user->rowCount() > 0) {
		$data = $check_user->fetch();
	?>

		<div class="form-rest mb-6 mt-6"></div>
		<form action="./php/user_update.php" method="POST" class="FormularioAjax" autocomplete="off">

			<input type="hidden" value="<?php echo $data['id_user'] ?>" name="id_user" required>

			<div class="columns">
				<div class="column">
					<div class="control">
						<label>Name</label>
						<input class="input" type="text" name="user_name" value="<?php echo $data['user_name'] ?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required>
					</div>
				</div>
				<div class="column">
					<div class="control">
						<label>Surname</label>
						<input class="input" type="text" name="user_surname" value="<?php echo $data['user_surname'] ?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required>
					</div>
				</div>
			</div>
			<div class="columns">
				<div class="column">
					<div class="control">
						<label>User</label>
						<input class="input" type="text" name="user" value="<?php echo $data['user'] ?>" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required>
					</div>
				</div>
				<div class="column">
					<div class="control">
						<label>Email</label>
						<input class="input" type="email" name="user_mail" value="<?php echo $data['user_mail'] ?>" maxlength="70">
					</div>
				</div>
			</div>
			<br><br>
			<p class="has-text-centered">
			If you want to update this user's password please fill in the 2 fields. If you do NOT wish to update the password please leave the fields empty.
			</p>
			<br>
			<div class="columns">
				<div class="column">
					<div class="control">
						<label>Password</label>
						<input class="input" type="password" name="password_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100">
					</div>
				</div>
				<div class="column">
					<div class="control">
						<label>Repeat password</label>
						<input class="input" type="password" name="password_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100">
					</div>
				</div>
			</div>
			<br><br><br>
			<p class="has-text-centered">
			In order to update this user's details please enter your USERNAME and PASSWORD with which you are logged in.
			</p>
			<div class="columns">
				<div class="column">
					<div class="control">
						<label>User</label>
						<input class="input" type="text" name="admin_user" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required>
					</div>
				</div>
				<div class="column">
					<div class="control">
						<label>Password</label>
						<input class="input" type="password" name="admin_key" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
					</div>
				</div>
			</div>
			<p class="has-text-centered">
				<button type="submit" class="button is-success is-rounded">Update</button>
			</p>
		</form>
	<?php
	}else{
		include "./inc/error_alert.php";
	}
	$check_user = null;
	?>
</div>