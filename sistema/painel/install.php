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

header("Content-Type: text/html; charset=ISO-8859-1",true);

switch(isset($_GET['ac']) ? $_GET['ac'] : ''){
default:
	?>
	<h1>Instalando aplicativo</h1>

	<div class="install-box">
		<h2>Resumo de processo</h2>
		
		<div class="log">
			<div class="padding">
				<?php
				if(file_exists('../plugins/'.$_GET['app'].'/sys/install.php')){
					require_once('../plugins/'.$_GET['app'].'/sys/install.php');

				} elseif(file_exists('../plugins/'.$_GET['app'].'/sys/bd.sql')){
					echo 'Este aplicativo possui um arquivo de Banco de dados. <br>Para instalar preencha o campo abaixo.';
					?>
					<form action="painel/install.php?ac=instalar&amp;app=<?php echo $_GET['app']?>" class="jfbox">
						<fieldset>
							<div>
								<label>Nome</label>
								<input type="text" name="nome"/>
							</div>
							<span class="botao"><button type="submit">Instalar</button></span>
						</fieldset>
					</form>
					<?php
				} else {
					echo "Este aplicativo não possui um arquivo de instalação. <br>Tente fazer a instalação manualmente através das instruções do criador. <br><br>";
				}
				?>
			</div>
		</div>
	</div>

	<script>
	$().ready(function(){
		$('.log').corner('5px');
	});
	</script>

	<?php
break;

case 'instalar':
	require_once("../includes/conection.php"); 
	require_once("../includes/jf.funcoes.php"); 
	require_once("../includes/class.leitor_sql.php"); 
	
	$_POST =  jf_iconv('UTF-8', 'ISO-8859-1', $_POST);
	
	
	$bd = '../plugins/'.$_GET['app'].'/sys/bd.sql';
	$tp = new leitor_sql($bd);
	
	if(file_exists('../plugins/'.$_GET['app'].'/sys/.folder')){
		$dirbase = '../../uploads/';
		$folders = file('../plugins/'.$_GET['app'].'/sys/.folder');
		
		foreach($folders as $key => $folder)
			@mkdir($dirbase.trim($folder), 0777);
		
	}
		
	
	jf_insert(PREFIXO.'plugins', array('nome' => $_POST['nome'], 'pasta' => $_GET['app']));
	?><br><br>
	<span><strong>Instalação realizada com sucesso!</strong></span><br><br>
	<span style="font-size: 11px;">Esta instalação foi referente apenas ao banco de dados e pastas, não foram arquivos de configuração, leia com atenção o arquivo sobre a instalação deste aplicativo para seu pleno funcionamento</span><br><br>
	
	<a href="index.php?plugin">Atualizar lista de aplicativos</a>
	<?php
break;
}
?>