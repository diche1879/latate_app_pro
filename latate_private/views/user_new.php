<div class="container pb-6 pt-6 p-2">
	<div class="container is-fluid mb-6">
		<h1 class="title">Usuarios</h1>
		<h2 class="subtitle">Nuevo usuario</h2>
	</div>
	<div class="form-rest mb-6 mt-6"></div>

	<form action="./php/user_save.php" method="POST" autocomplete="off" class="FormularioAjax">
		<div class="columns">
			<div class="column">
				<div class="control">
					<label>Name</label>
					<input class="input" type="text" name="name" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required>
				</div>
			</div>
			<div class="column">
				<div class="control">
					<label>Surname</label>
					<input class="input" type="text" name="surname" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required>
				</div>
			</div>
		</div>
		<div class="columns">
			<div class="column">
				<div class="control">
					<label>User</label>
					<input class="input" type="text" name="user" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required>
				</div>
			</div>
			<div class="column">
				<div class="control">
					<label>Email</label>
					<input class="input" type="email" name="email" maxlength="70" required>
				</div>
			</div>
		</div>
		<div class="columns">
			<div class="column">
				<div class="control">
					<label>Password</label>
					<input class="input" type="password" name="password_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
				</div>
			</div>
			<div class="column">
				<div class="control">
					<label>Repeat Password</label>
					<input class="input" type="password" name="password_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
				</div>
			</div>
		</div>
		<p class="has-text-centered">
			<button type="submit" class="button is-info is-rounded">Guardar</button>
		</p>
	</form>
</div>