<?php
/**
*
* lliure CMS
*
* @Versão 4.5.2
* @Desenvolvedor Jeison Frasson <contato@grapestudio.com.br>
* @Entre em contato com o desenvolvedor <contato@grapestudio.com.br> http://www.grapestudio.com.br/
* @Licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

require_once("../includes/jf.funcoes.php"); 
switch(isset($ac) ? $ac : 'index'){
case 'index':
	session_start();
	?>
	<html>
	<head>
		<title>Intalador lliure</title>
		
		<style  type="text/css">
			@import "../css/base.css";
			@import "css.css";
		</style>
		
	</head>
	<body>
		<div class="container">
			<h1>Instalação do lliure</h1>
			<div class="instalador">
				<?php
				$ac = (isset($_GET['p']) ? $_GET['p'] : 'home');
				require('index.php');
				?>				
			</div>
		</div>
	</body>
	</html>
	<?php
break;

case 'home':
	?>
	<form method="post" action="index.php?p=instalar">
		<input type="hidden" name="token" value="<?php echo jf_token('novo'); ?>"/>
		<div class="testes">
			<h2>Revisão de configurações</h2>
			<?php		
			if(!is_writeable('../etc')){
				echo '	<span class="mens"><span class="erro ret">Erro</span> - A pasta <strong>/site/sistema/etc</strong> não tem permissão para escrita
							<span class="reso">Altere a permissão da pasta <strong>/.../sistema/etc</strong> para escrita e leitura (777) </span>
						</span>';
			} else {
				echo '<span class="mens"><span class="ok ret">Ok</span> - A pasta <strong>/.../sistema/etc</strong> está configurada corretamente</span>
						<input type="hidden" name="etc" value="ok"/>
						';
			}
			
			if(!file_exists('../../uploads')){
				echo '	<span class="mens"><span class="erro ret">Erro</span> - A pasta <strong>/.../uploads</strong> não encontrada
							<span class="reso">Crie manualmente a pasta /.../uploads com permissão de escrita e leitura (777)</span>
						</span>';
			} else {
				if(!is_writeable('../../uploads')){
					echo '	<span class="mens"><span class="erro ret">Erro</span> - A pasta <strong>/.../uploads</strong> não tem permissão para escrita
								<span class="reso">Altere a permissão da pasta <strong>/site/uploads</strong>  para escrita e leitura (777)</span>
							</span>';
				} else {
					echo '<span class="mens"><span class="ok ret">Ok</span> - A pasta <strong>/.../uploads</strong> está configurada corretamente</span>
						<input type="hidden" name="uploads" value="ok"/>
						';
				}
			}
			?>
		</div>
	
	
		<h2>Configurações do banco de dados</h2>
		<fieldset>
			<div>
				<label>Host</label>
				<input name="host" value="localhost" />
			</div>
			<div>
				<label>Login</label>
				<input name="login" />
			</div>
			<div>
				<label>Senha</label>
				<input type="password" name="senha" />
			</div>			
			<div>
				<label>Tabela</label>
				<input name="tabela" />
			</div>		
		</fieldset>	
		<button type="submit">Instalar</button>
	</form>
	
	<?php
break;	


case 'instalar':
	if(!file_exists('../etc/bdconf.php')){	
		if(empty($_POST['host']) || empty($_POST['login']) || empty($_POST['senha']) || empty($_POST['tabela']) || !isset($_POST['uploads']) || !isset($_POST['etc']) || jf_token($_POST['token']) != true){
			echo 'Por favor preencha todos os campos, <a href="index.php">voltar</a>';
			break;
		}
			
		echo '<h2>Progresso de instalação</h2>';
	
		/*********************	INSTALA AS BASES	**/
		require_once("../includes/class.leitor_sql.php"); 
		
		$conexao = mysql_connect($_POST['host'], $_POST['login'], $_POST['senha']);
		
		if(mysql_query('CREATE DATABASE '.$_POST['tabela']))
			echo '<span style="font-size: 13px;">- Criando banco <strong>'.$_POST['tabela'].'</strong>: <span style="color: #080;">OK!</span> <br/></span>';
		else
			echo '<span style="font-size: 13px;">- Criando banco <strong>'.$_POST['tabela'].'</strong>: <span style="color: #f00;">ERRO!</span> <br/></span>';
			
		mysql_select_db($_POST['tabela'], $conexao);

		$tp = new leitor_sql('bd.sql');	
		
		/*********************	CRIA A PASTA UPLOADS	**/		
		if(!file_exists('../../uploads/usuarios')){
			if(@mkdir('../../uploads/usuarios', 0777))
				echo '<span style="font-size: 13px;">- Criar pasta <strong>../../uploads/usuarios</strong>: <span style="color: #080;">OK!</span> <br/></span>';
			else
				echo '<span style="font-size: 13px;">- Criar pasta <strong>../../uploads/usuarios</strong>: <span style="color: #f00;">ERRO!</span> <br/></span>';
		} else {
			echo '<span style="font-size: 13px;">- Criar pasta <strong>../../uploads/usuarios</strong>: <span style="color: #f00;">ERRO!</span> <br/></span>';
		}
		
		if(!file_exists('../../uploads/thumb.php')){
			if(@copy('../includes/thumb.php', '../../uploads/thumb.php'))
				echo '<span style="font-size: 13px;">- Copiar aquivo <strong>thumb.php</strong>: <span style="color: #080;">OK!</span> <br/></span>';
			else
				echo '<span style="font-size: 13px;">- Copiar aquivo <strong>thumb.php</strong>: <span style="color: #f00;">ERRO!</span> <br/></span>';
		} else {
			echo '<span style="font-size: 13px;">- Copiar aquivo <strong>thumb.php</strong>: <span style="color: #f00;">ERRO! </span> <br/></span>';
		}
		
		/*********************	CRIA O ARQUIVO DE CONEXÃO	**/			
		$fd = fopen('conection_base.txt', "r");

		$in = "<?php\n";
		while(!feof( $fd )){
			$in .= fread( $fd, 1024 );
			
		}
		$in .= '?>';
		
		$in = str_replace(array('.localhost.', '.root.', '.senha.', '.banco.'), array($_POST['host'], $_POST['login'], $_POST['senha'], $_POST['tabela']), $in);
		
		fclose($fd);	
		
		if(($fp = @fopen('../etc/bdconf.php', "w")) != false){
			fwrite($fp, $in);
			fclose($fp);
			echo '<span style="font-size: 13px;">- Criar arquivo <strong>bdconfig.php</strong>: <span style="color: #080;">OK!</span> <br/></span>';
		} else {
			echo '<span style="font-size: 13px;">- Criar arquivo <strong>conection.php</strong>: <span style="color: #f00;">ERRO! </span> <br/></span>
					<span>O sistema por algum motivo não consegiu criar o arquivo de configuração, crie manualmente um arquivo com o nome <strong>bdconf.php</strong> na pasta <strong>/.../sistema/etc</strong> com o seguinte conteúdo:</span>
					<textarea class="conteud" onclick="this.select()">'.$in.'</textarea>
					<span>Depois de criar o arquivo atualize está tela</span>
					';
		}
		
	} else {
		echo '<span style="font-size: 13px; color: #f00;">O Lliure já foi instalado!</span>';
	}
	?>
	<div style="padding-top: 10px;">
		<span style="font-size: 14px; font-weight: bold;"><a href="../index.php">Voltar para painel</a></span>
	</div>
	<?php
break;

default:
	echo 'página não encontrada';
break;
}
?>
