<?php
/**
*
* Plugin CMS
*
* @versão 4.0.1
* @Desenvolvedor Jeison Frasson <contato@newsmade.com.br>
* @entre em contato com o desenvolvedor <contato@newsmade.com.br> http://www.newsmade.com.br/
* @licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
switch(isset($ac) ? $ac : 'index'){
case 'index':
	?>
	<html>
	<head>
		<title>Intalador Plugin</title>
		
		<style  type="text/css">
			@import "../css/base.css";
			@import "css.css";
		</style>
		
	</head>
	<body>
		<div class="container">
			<h1>Instalação do plugin</h1>
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
	if(empty($_POST['host']) || empty($_POST['login']) || empty($_POST['senha']) || empty($_POST['tabela'])){
		echo 'Por favor preencha todos os campos, <a href="index.php">voltar</a>';
		break;
	}
			
	echo '<h2>Progresso de instalação</h2>';
	
	if(!file_exists('../includes/conection.php')){
		/*********************	INSTALA AS BASES	**/
		require_once("../includes/class.leitor_sql.php"); 
		require_once("../includes/jf.funcoes.php"); 

		$conexao = mysql_connect($_POST['host'], $_POST['login'], $_POST['senha']);
		
		if(mysql_query('CREATE DATABASE '.$_POST['tabela']))
			echo '<span style="font-size: 13px;">- Criando banco <strong>'.$_POST['tabela'].'</strong>: <span style="color: #080;">OK!</span> <br/></span>';
		else
			echo '<span style="font-size: 13px;">- Criando banco <strong>'.$_POST['tabela'].'</strong>: <span style="color: #f00;">ERRO!</span> <br/></span>';
			
		mysql_select_db($_POST['tabela'], $conexao);

		$tp = new leitor_sql('bd.sql');	
		
		/*********************	CRIA A PASTA UPLOADS	**/
		if(!file_exists('../../uploads')){
			if(mkdir('../../uploads', 0777))
				echo '<span style="font-size: 13px;">- Criar pasta <strong>uploads</strong>: <span style="color: #080;">OK!</span> <br/></span>';
			else
				echo '<span style="font-size: 13px;">- Criar pasta <strong>uploads</strong>: <span style="color: #f00;">ERRO!</span> <br/></span>';
		} else {
			echo '<span style="font-size: 13px;">- Criar pasta <strong>uploads</strong>: <span style="color: #f00;">ERRO!</span> <br/></span>';
		}
		
		if(!file_exists('../../uploads/usuarios')){
			if(mkdir('../../uploads/usuarios', 0777))
				echo '<span style="font-size: 13px;">- Criar pasta <strong>usuarios</strong>: <span style="color: #080;">OK!</span> <br/></span>';
			else
				echo '<span style="font-size: 13px;">- Criar pasta <strong>usuarios</strong>: <span style="color: #f00;">ERRO!</span> <br/></span>';
		} else {
			echo '<span style="font-size: 13px;">- Criar pasta <strong>usuarios</strong>: <span style="color: #f00;">ERRO!</span> <br/></span>';
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
		
		$fp = fopen('../includes/conection.php', "a");		// inicia um arquivo novo
		fwrite($fp, $in);				// copia o arquivo
		fclose($fp);										// fecha o arquivo
		
	} else {
		echo '<span style="font-size: 13px; color: #f00;">O Plugin já foi instalado!</span>';
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