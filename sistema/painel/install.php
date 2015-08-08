<?php
/**
*
* Plugin CMS
*
* @vers�o 4.1.8
* @Desenvolvedor Jeison Frasson <contato@newsmade.com.br>
* @entre em contato com o desenvolvedor <contato@newsmade.com.br> http://www.newsmade.com.br/
* @licen�a http://opensource.org/licenses/gpl-license.php GNU Public License
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
				if(file_exists('../plugins/'.$_GET['app'].'/sys/bd.sql')){
					?>
					<form action="painel/install.php?ac=instalar&amp;app=<?php echo $_GET['app']?>" class="jfbox">
						<?php
						echo '<div class="fase"><div class="msm">Arquivo de configura��o do Banco de dados: OK</div></div>';
						if(file_exists('../plugins/'.$_GET['app'].'/sys/config.plg')){
							echo '<div class="fase"><div class="msm">Arquivo de configura��o interna: OK</div></div>';
						} else {
							echo '<div class="fase"><div class="msm msmE">Arquivo de configura��o interna: ERRO</div><span class="msmex">Por favor adicione manualmente o nome do aplicativo</span>';
							?>
							<div>
								<label>Nome</label>
								<input type="text" name="nome"/>
							</div>
							<?php
							echo "</div>";
						}
						?>							
						<span class="botao"><button type="submit">Instalar Aplicativo</button></span>
					</form>
					<?php
				} else {
					echo "Este aplicativo n�o possui um arquivo de instala��o. <br>Tente fazer a instala��o manualmente atrav�s das instru��es do criador. <br><br>";
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
	
	if(file_exists('../plugins/'.$_GET['app'].'/sys/config.plg')){
		$appConfig = simplexml_load_file('../plugins/'.$_GET['app'].'/sys/config.plg');
		
		$aplicativo_nome = $appConfig->nome;
	} else {
		$aplicativo_nome = $_POST['nome'];
	}
		
	
	jf_insert(PREFIXO.'plugins', array('nome' => $aplicativo_nome, 'pasta' => $_GET['app']));
	?><br><br>
	<span><strong>Instala��o realizada com sucesso!</strong></span><br><br>
	<span style="font-size: 11px;">Esta instala��o foi referente apenas ao banco de dados e pastas, n�o foram arquivos de configura��o, leia com aten��o o arquivo sobre a instala��o deste aplicativo para seu pleno funcionamento</span><br><br>
	
	<a href="index.php?plugin">Atualizar lista de aplicativos</a>
	<?php
break;
}
?>