<?php
/**
*
* lliure WAP
*
* @Versão 4.6.2
* @Desenvolvedor Jeison Frasson <contato@grapestudio.com.br>
* @Entre em contato com o desenvolvedor <contato@grapestudio.com.br> http://www.grapestudio.com.br/
* @Licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

if(!empty($_POST)){
	require_once("../etc/bdconf.php"); 
	require_once("../includes/jf.funcoes.php"); 
	require_once("../api/fileup/inicio.php"); 

	if(empty($_POST['senha'])){
		unset($_POST['senha']);
	} else{
		$_POST['senha'] = md5($_POST['senha']."0800");
	}
	
	$file = new fileup; 								// incia a classe
	$file->diretorio = '../../uploads/usuarios/';		// pasta para o upload (lembre-se que o caminho é apartir do arquivo onde estiver sedo execultado)
	$file->up(); 										// executa a classe
	
	if(isset($_POST['imagem']))
		unset($_POST['imagem']);
		
	
	jf_update(PREFIXO."admin", $_POST, array('id' => $_GET['id']));

	($_SESSION['Logado']['id'] == $_GET['id'] ? $_SESSION['Logado']['themer'] = $_POST['themer'] : '');

	$_SESSION['aviso'][0] = "Alteração realizada com sucesso!";
	header('location: ../index.php?'.(isset($_GET['minhaconta']) ? 'minhaconta' : 'usuarios' ));
}

?>
<style type="text/css" media="screen">
	@import "css/usuarios.css";
</style>
<?php

if(empty($_GET['usuarios'])){
	$botoes[] =	array('href' => $backReal, 'img' => $plgIcones.'br_prev.png', 'title' => $backNome);
	$botoes[] =	array('href' => 'paginas/ajax.novo_usuario.php', 'img' => $plgIcones.'user.png', 'title' => 'Criar usuário', 'attr' => 'class="criar"');
} else {
	$botoes[] =	array('href' => '?'.(isset($_GET['minhaconta']) ? 'desk' : 'usuarios') , 'img' => $plgIcones.'br_prev.png', 'title' => 'Voltar');
}

echo app_bar('Painel de usuários', $botoes);

$tabela = PREFIXO."admin";
$consulta = 'select * from '.$tabela;


if(empty($_GET['usuarios'])){
	$query = $consulta.' where id != "'.$_SESSION['logado']['id'].'"'.(ll_tsecuryt() ? '' : ' and grupo != "dev"').' order by nome ASC';

	$pastas = '';
	$click['link'] = '?usuarios=';
	$click['ico'] = "imagens/layout/user.png";
	$pluginTable = 'plugin_admin';

	jNavigator($query, $pluginTable, $pastas, $mensagemVazio = null, $click);
	
	?>
	<script type="text/javascript">
		$(document).ready(function(){	
			$(".criar").jfbox({abreBox: false}, function(){
				jfAlert('Novo usuário criado com sucesso!', 1);
			}); 
		});
	</script>
	<?php
} else {
	$consulta = $consulta.' where id = "'.$_GET['usuarios'].'"';
	
	$dados = mysql_fetch_assoc(mysql_query($consulta));
	
	extract($dados);
	?>

	<div class="boxCenter editUsuario">
		<form method="post" action="paginas/usuarios.php?id=<?php echo $_GET['usuarios'].(isset($_GET['minhaconta']) ? '&minhaconta' : '');?>"  enctype="multipart/form-data">
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
					<?php
					$file = new fileup; 					//inicia a classe
					$file->titulo = 'Foto'; 				//titulo da Label
					$file->rotulo = 'Selecionar imagem'; 	// texto do botão
					$file->registro = $foto;
					$file->campo = 'foto'; 					//campo do banco de dados (no retorno no formulario ele irá retornar um $_POST com essa chave, no caso do exemplo $_POST['imagem'])
					$file->extencao = 'png jpg'; 			//extenções permitidas para o upload, se deixar em branco será aceita todas
					$file->form(); 				 			// executa a classe
					?>
				</div>				
			</fieldset>
			
			<fieldset>
				<legend>Dados de acesso</legend>
				<div>
					<label>Login <span>(obrigatorio)</span></label>
					<input type="text" <?php echo !empty($login) ? 'value="'.$login.'" readonly class="inatv"' : ''; ?> name="login" />
					<span class="ex">Não poderá ser alterado posteriormente.</span>
				</div>
				
				<div>
					<label>Senha</label>
					<input type="password" value="" name="senha" />
					<span class="ex">Deixe em branco para manter a senha atual.</span>
				</div>	
			
				<?php	
				if(ll_tsecuryt('admin') && $_GET['usuarios'] != $_SESSION['logado']['id']){
					?>
					<div>
						<label>Grupo de usuário</label>
						<select name="grupo">
							<?php
							$grupos = array('admin' => 'Administrador', 'user' => 'Usuário');
							ll_tsecuryt() ? $grupos['dev'] = 'Desenvolvedor' : '';
							
							
							if($llconf){
								$grupos_add = jf_iconv("UTF-8", "ISO-8859-1", (array) $llconf->usua_grup);
								
								if(!empty($grupos_add)){
									echo '<optgroup label="Sub-grupos">';
									foreach($grupos_add as $indice => $valor)
										echo '<option value="'.$indice.'" '.($grupo == $indice?'selected':'').'>'.$valor.'</option>';
									
									echo '</optgroup>';
								}
							}
							
							echo '<optgroup label="Grupos principais">';
							foreach($grupos as $indice => $valor)
								echo '<option value="'.$indice.'" '.($grupo == $indice?'selected':'').'>'.$valor.'</option>';					
							echo '</optgroup>';
							?>
						</select>
					</div>
					<?php
				}
				?>
			</fieldset>
			
			<span class="botao"><a href="<?php echo  $backReal;?>">Voltar</a></span>
			
			<span class="botao"><button type="submit">Salvar</button></span>
		</form>
	</div>
	<?php	
}
?>
