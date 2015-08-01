
<form method="post" id="form" class="login">
	<span class="h1">Área restrita</span>
	<?php
		if(isset($loginfalha)){ ?>
			<span class="mensagem"><span>Login e/ou senha incoreto(s). Tente novamente</span></span>
		<?php
		}
	?>

	<label>
		<span>Login</span>
		<input type="text" name="usuario" autocomplete="off" />
	</label>	
	
	<label>
		<span>Senha</span>
		<input type="password" name="senha" />
	</label>
	<button type="submit"></button>
	
	<span class="botao"><a href="javascript: document.getElementById('form').submit()">entrar</a></span>
</form>