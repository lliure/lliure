<h2>Configurando Banco de dados</h2>
<div class="plugInt">
	<?php
	$veryf = 0;
	if (is_writable($conection)) {
		echo '<span class="ok">O arquivo <strong>'.$conection.'</strong>  possui permissão de escrita</span>';
		$veryf = 1;
	} else {
		echo '<span class="err">O arquivo <strong>'.$conection.'</strong> não  possui permissão de escrita, entre em sua pasta FTP e altere suas permições (CHMOD) para 777</span>';
	}
	
	$pastafiles = "../../files";
	if (is_writable($pastafiles)) {
		echo '<span class="ok">O pasta <strong>'.$pastafiles.'</strong>  possui permissão de escrita</span>';
		$veryf = ($veryf == 0?0:1);
	} else {
		echo '<span class="err">O pasta <strong>'.$pastafiles.'</strong> não  possui permissão de escrita, entre em sua pasta FTP e altere suas permições (CHMOD) para 777</span>';
	}
	
	?>

</div>
<?php
if((isset($_POST['host']) and isset($_POST['user']) and isset($_POST['senha']) and isset($_POST['base'])) and $veryf == '1'){
	$sufix = $_POST['prefix'];
	
	$texto = '<?php
session_start();

$hostname_conexao = "'.$_POST['host'].'";
$username_conexao = "'.$_POST['user'].'";
$password_conexao = "'.$_POST['senha'].'";
$banco_conexao = "'.$_POST['base'].'";  

define("FILES", "../files");
define("SUFIXO", "'.$sufix.'");
define("SISTEMA", "sistema");

if(($conexao = @mysql_pconnect($hostname_conexao, $username_conexao, $password_conexao)) == false){
	echo "Falha na conexão: Servidor, login ou senha incorretos <br>";
}
if(@mysql_select_db("$banco_conexao", $conexao) == false){
	echo "Falha na conexão: base de dados não encontrada";
}
?>';
		$file = fopen("$conection", "w");

		if(!$file) {
			echo "Erro<br /><br />Nao foi possivel abrir o arquivo.";
		}

		if(!fwrite($file, $texto)) {
			echo "Erro<br /><br />Nao foi possivel gravar as informacoes no arquivo.";
		}

		?>
		<span class="ok"><strong>Arquivo de conexão configurado com sucesso!</strong><span/>
		<div class="both"><br/></div>
		<a href="?passo=bases">Instalar Bases</a>		
		<?php

		fclose($file);
	
} else { 	
	?>
	<div>
	<form method="post" class="config">
		<div class="label">
			<span>Host:</span>
			<input type="text" autocomplete="off" name="host" value="localhost" />
		</div>		
		
		<div class="label">
			<span>Usuario:</span>
			<input type="text" autocomplete="off" name="user" />
		</div>		
		
		<div class="label">
			<span>Senha:</span>
			<input type="password" autocomplete="off" name="senha" />
		</div>	
		
		<div class="label">
			<span>Base:</span>
			<input type="text" autocomplete="off" name="base" />
		</div>	
		
		<div class="label">
			<span>Prefeixo para as tabelas:</span>
			<input type="text" autocomplete="off" name="prefix" value="plugin_" />
		</div>		
		
		<button type="subimit">Instalar</button>
	</form>
<?php
}
?>