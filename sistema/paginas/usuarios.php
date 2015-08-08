<?php

if(!empty($_POST)){
	require_once("../includes/conection.php"); 
	require_once("../includes/mLfunctions.php"); 

	if(empty($_POST['senha'])){
		unset($_POST['senha']);
	} else{
		$_POST['senha'] = md5($_POST['senha']."0800");
	}
	($_SESSION['Logado']['id'] == $_GET['id'] ? $_SESSION['Logado']['themer'] = $_POST['themer'] : '');
	
	mLupdate(PREFIXO."admin", $_POST, array('id' => $_GET['id']));
	
	$_SESSION['aviso'][0] = "Alteração realizada com sucesso!";
	header('location: ../index.php?usuarios');
}

echo $extendeTopPlugin;

$tabela = PREFIXO."admin";
$consulta = "select * from ".$tabela.($DadosLogado['tipo'] == 1?'':" where tipo = '0'");

$campos = array (
		'nome' => '',
		'login' => '',
		'senha' => '',
		'themer' => '',
		'tipo' => ''
		);
		
if(empty($_GET['usuarios'])){
	$query = mysql_query($consulta." order by nome ASC");
	?>
	<script type="text/javascript">
		$(document).ready(function(){	
			$(".jfbox").jfbox({abreBox: false}, function(){
				$(document).jfaviso('Novo usuário criado com sucesso!', 1);
			}); 
		});
	</script>
	<br>
	<span class="botao"><a href="paginas/ajax.novo_usuario.php" class="jfbox">Criar usuário</a></span>
	<br>
	<br>
	<br>
	<?php

	$pastas = 'paginas';
	$click['link'] = '?usuarios=';
	$click['ico'] = "../../imagens/layout/user.png";
	$pluginTable = 'plugin_admin';
	
	$mensagemVazio = "Nenhum usuário encontrado.";
	jNavigator($query, $pluginTable, $pastas, $mensagemVazio, $click, $ligs);

} else {
	$consulta = $consulta.($DadosLogado['tipo'] == 1?' where':" and").' id="'.$_GET['usuarios'].'"';
	$query = mysql_query($consulta);
	$dados = mysql_fetch_array($query);
	
	foreach($campos as $chave => $valor){
		$$chave = $dados[$chave];
	}
	?>
	
	<div class="boxCenter">
		<form method="post" class="form" action="paginas/usuarios.php?id=<?php echo $_GET['usuarios']?>">
			<div>
				<label>Nome</label>
				<input type="text" value="<?php echo $nome?>" name="nome" />
				<span class="ex">Nome do usuario. <strong>Campo obrigatorio</strong></span>
			</div>
			
			<div>
				<label>Login</label>
				<input type="text" value="<?php echo $login?>" name="login" />
				<span class="ex">Login utilizado para acessar o painel. <strong>Campo obrigatorio</strong></span>
			</div>
			
			<div>
				<label>Senha</label>
				<input type="password" value="" name="senha" />
				<span class="ex">Deixe em branco para manter a senha atual. <strong>Campo opcional</strong></span>
			</div>		
			
			<div>
				<label>Tema</label>
				<select name="themer">
					<?php
					$dir = "themer/";
					$dh = opendir($dir);

					while (false !== ($filename = readdir($dh))) {
						if ( $filename != "." && $filename != "..") {
							echo '<option '.($filename == $plgThemer ? 'selected' :'').'>'.$filename.'</optino>';
						}
					}
					?>
				</select>
			</div>
			<?php				
			if($DadosLogado['tipo'] == 1){
				?>
				<div>
					<label>Tipo</label>
					<select name="tipo">
						<option value="0">Usuário</option>
						<option value="1" <?php echo ($tipo == 1?'selected':'')?>>Desenvolvedor</option>
					</select>
					<span class="ex">Nivel do usuário. <strong>Campo opcional</strong></span>
				</div>
				<?php
			}
			?>
			<span class="botao"><a href="?usuarios">Voltar</a></span>
			
			<span class="botao"><button type="submit">Salvar</button></span>
		</form>
	</div>
	<?php	
}
?>