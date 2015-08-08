<?php
/**
*
* lliure WAP
*
* @Versão 4.9.1
* @Desenvolvedor Jeison Frasson <jomadee@lliure.com.br>
* @Entre em contato com o desenvolvedor <contato@grapestudio.com.br> http://www.grapestudio.com.br/
* @Licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

require_once('../etc/bdconf.php');
require_once('../includes/jf.funcoes.php');

if(isset($_SESSION['logado'])){
	
	header('location: rotinas.php');
	
} elseif(!empty($_POST)){
	require_once('../includes/jf.funcoes.php');
	
	$falha = true;
	
	if( (!empty($_POST['usuario'])) && (!empty($_POST['senha'])) && jf_token($_POST['token'])){	
		
		$senha = md5($_POST['senha']."0800");
		$usuario = jf_anti_injection($_POST['usuario']);
		
		
		if(file_exists('../etc/llconf.ll') && ($llconf = @simplexml_load_file('../etc/llconf.ll')) && isset($llconf->senhaDev)){
			
			$senhaDev = trim(isset($llconf->senhaDev->senha) ? $llconf->senhaDev->senha : $llconf->senhaDev);
			$usuarioDev = isset($llconf->senhaDev->usuario) ? $llconf->senhaDev->usuario : 'dev';
			
			if($usuario == $usuarioDev){
				if(($senhaDev = @file_get_contents($senhaDev)) != false){
					
					$senhaDev = trim($senhaDev);							
					$senha = md5($_POST['senha']);			

					if($senhaDev == $senha){
						$dadosLogin = array(
								'id' => '0',
								'nome' => 'Desenvolvedor',
								'grupo' => 'dev',
								'tema' => 'default'
							);
					}							
				}
			}
		}
		
		
		if(!isset($dadosLogin)){
			$dadosUser = mysql_query('select * from '.PREFIXO.'admin where login = "'.$usuario.'" and senha = "'.$senha.'" limit 1');
			
			if(mysql_num_rows($dadosUser) > 0){
				$dadosUser = mysql_fetch_assoc($dadosUser);
				$dadosLogin = $dadosUser;
			} 
		}
		
		if(isset($dadosLogin)){
			$tema_default = 'lliure';
			
			if(file_exists('../temas/'.$dadosLogin['themer'].'/dados.ll') == false)
				$dadosLogin['themer'] = 'default';
				
			if($dadosLogin['themer'] == 'default')
				$dadosLogin['themer'] = $tema_default;
			
			$_SESSION['logado'] = array(
				'id' => $dadosLogin['id'],
				'nome' => $dadosLogin['nome'],
				'grupo' => $dadosLogin['grupo'],
				'tema' => $dadosLogin['themer']
			);
			
			$falha = false;
		}

	}
	
	if($falha == false)
		header('location: rotinas.php');
	else	
		header('location: login.php?rt=falha');
}
?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="../css/base.css" />
	<link rel="stylesheet" type="text/css" href="../css/login.css" />
	
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/funcoes.js"></script>
	
	<title>lliure Web Application Platform</title>
</head>

<body>
<div id="login">
	<img src="../imagens/layout/logo.png" class="logo" alt="Plugin" />
	<?php
	if(isset($_GET['rt']) && $_GET['rt'] == 'falha')
		echo '<span class="mensagem">Login e/ou senha incorreto(s). Tente novamente</span>';
	
	$_SESSION['token'] = uniqid(md5(time()));
	jf_token('novo');
	?>
	
	<div id="loginBox">
		<form method="post" action="login.php" id="form">
			<input type="hidden" name="token" value="<?php echo jf_token('exibe'); ?>">
			<fieldset>
				<div>
					<label>Usuário</label>
					<input type="text" name="usuario" class="user" autocomplete="off" />
				</div>	
				
				<div>
					<label>Senha</label>
					<input type="password" name="senha" />
				</div>
			</fieldset>
			<span class="botao"><button type="submit">Entrar</button></span>
		</form>
		<div class="both"></div>
	</div>
</div>	

</body>

<head>
	<script type="text/javascript">
	$(document).ready(function(){
		$('.user').focus();
		
		<?php		
		if(isset($_GET['rt']) && $_GET['rt'] == 'falha'){
			echo '
				var tempo = 150;
				var left = -50;
				var right = 50;

				$("#loginBox").animate({
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
			';
		} else {
			echo 'gsqul();';
		}
		?>
	});
	</script>
</head>
</html>
