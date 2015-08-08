<?php
/**
*
* Plugin CMS
*
* @versão 4.1.8
* @Desenvolvedor Jeison Frasson <contato@newsmade.com.br>
* @entre em contato com o desenvolvedor <contato@newsmade.com.br> http://www.newsmade.com.br/
* @licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

if(!empty($_POST)){
	require_once("../includes/conection.php"); 
	require_once("../includes/jf.funcoes.php"); 

	if(empty($_POST['senha'])){
		unset($_POST['senha']);
	} else{
		$_POST['senha'] = md5($_POST['senha']."0800");
	}
	
	if(!empty($_FILES['foto']['name'])){
		$dir = '../../uploads/usuarios/';
		$arquivo = $_FILES['foto'];
			
		if(isset($_POST['imagem']))
			@unlink($dir.$_POST['imagem']);
		
		
		$imagemNome = substr($arquivo['name'], -3); // pega a extenção
		$imagemNome = md5(uniqid(time())).'.'.$imagemNome;	
		

		$path =  $dir.$imagemNome;
		move_uploaded_file($arquivo["tmp_name"], $path);
		$_POST['foto'] = $imagemNome;
	} 
	
	if(isset($_POST['imagem']))
		unset($_POST['imagem']);
		
	
	jf_update(PREFIXO."admin", $_POST, array('id' => $_GET['id']));

	($_SESSION['Logado']['id'] == $_GET['id'] ? $_SESSION['Logado']['themer'] = $_POST['themer'] : '');

	$_SESSION['aviso'][0] = "Alteração realizada com sucesso!";
	header('location: ../index.php?usuarios');
}

?>
<style type="text/css" media="screen">
	@import "css/usuarios.css";
</style>
<?php

if(empty($_GET['usuarios'])){
	$botoes[] =	array('href' => 'index.php', 'img' => $plgIcones.'br_prev.png', 'title' => 'Voltar');
	$botoes[] =	array('href' => 'paginas/ajax.novo_usuario.php', 'img' => $plgIcones.'user.png', 'title' => 'Criar usuário', 'attr' => 'class="criar"');
} else {
	$botoes[] =	array('href' => '?usuarios', 'img' => $plgIcones.'br_prev.png', 'title' => 'Voltar');
}

echo app_bar('Painel de usuários', $botoes);

$tabela = PREFIXO."admin";
$consulta = "select * from ".$tabela.($DadosLogado['tipo'] == 1?'':" where tipo = '0'");


if(empty($_GET['usuarios'])){
	$query = $consulta." order by nome ASC";

	$pastas = '';
	$click['link'] = '?usuarios=';
	$click['ico'] = "imagens/layout/user.png";
	$pluginTable = 'plugin_admin';

	jNavigator($query, $pluginTable, $pastas, $mensagemVazio = null, $click);
	
	?>
	<script type="text/javascript">
		$(document).ready(function(){	
			$(".criar").jfbox({abreBox: false}, function(){
				$(document).jfaviso('Novo usuário criado com sucesso!', 1);
			}); 
		});
	</script>
	<?php
} else {
	$consulta = $consulta.($DadosLogado['tipo'] == 1?' where':" and").' id="'.$_GET['usuarios'].'"';
	$dados = mysql_fetch_assoc(mysql_query($consulta));
	
	extract($dados);
	?>

	<div class="boxCenter editUsuario">
		<form method="post" action="paginas/usuarios.php?id=<?php echo $_GET['usuarios']?>"  enctype="multipart/form-data">
			<fieldset>
				<legend>Dados pessoais</legend>
				
				<div>
					<label>Nome <span>(obrigatorio)</span></label>
					<input type="text" value="<?php echo $nome?>" name="nome" />
				</div>
			
				<div>
					<label>E-mail</label>
					<input type="text" value="<?php echo $email?>" name="email" />
				</div>	
			
				<div>
					<label>Twitter</label>
					<input type="text" value="<?php echo $twitter?>" name="twitter" />
				</div>		
			
				<div>
					<label>Foto</label>
					<?php echo (!empty($foto) ? '<input type="hidden" name="imagem" value="'.$foto.'"/>' : '')?>
					<input type="file" name="foto" />
					<span class="ex">Basta selecionar uma nova foto para substituir a atual, <strong>Campo opcional</strong></span>
				</div>				
			</fieldset>
			
			<fieldset>
				<legend>Dados de acesso</legend>
				<div>
					<label>Login <span>(obrigatorio)</span></label>
					<input type="text" value="<?php echo $login?>" name="login" />
				</div>
				
				<div>
					<label>Senha</label>
					<input type="password" value="" name="senha" />
					<span class="ex">Deixe em branco para manter a senha atual. <strong>Campo opcional</strong></span>
				</div>	
				
				<div>
					<label>Tema</label>
					<?php
					$dir = "themer/";
					$dh = opendir($dir);
					?>
					<div class="temas">
						<?php
						while (false !== ($filename = readdir($dh))) {
							if ( $filename != "." && $filename != "..") {
								$caminho = 'themer/'.$filename;
								$fp = fopen($caminho.'/padrao.txt', 'r');
								
								while (!feof($fp)){
									$linha = fgets($fp);
									$linha = explode('=', $linha);
									
									$plg_themer[trim($linha[0])] = trim($linha[1]);
								}
								fclose($fp);								
								?>
								<div class="tema" style="background-image: url('<?php echo $caminho.'/bg.jpg'?>')">
									<div>
										<input  name="themer" <?php echo ((isset($themer) && $filename == $themer) || !isset($themer) &&  $filename == 'default'? 'checked' :'')?> value="<?php echo $filename?>" type="radio" >
										<span class="<?php echo $plg_themer['cores']?>"><?php echo $plg_themer['nome']?></span>							
									</div>
								</div>
								<?php
							}
						}
						?>
					</div>
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
					</div>
					<?php
				}
				?>
			</fieldset>
			
			<span class="botao"><a href="?usuarios">Voltar</a></span>
			
			<span class="botao"><button type="submit">Salvar</button></span>
		</form>
	</div>
	
	<script type="text/javascript">
		$(document).ready(function(){	
			$('.tema').corner('4px')
		});
	</script>
	<?php	
}
?>