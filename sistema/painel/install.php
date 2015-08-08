<?php
header("Content-Type: text/html; charset=ISO-8859-1",true);
?>
<h1>Instalando aplicativo</h1>

<div class="install-box">
	<h2>Resumo de processo</h2>
	
	<div class="log">
		<div class="padding">
			<?php
			if(file_exists('../plugins/'.$_GET['app'].'/sys/install.php'))
				require_once('../plugins/'.$_GET['app'].'/sys/install.php');
			else 
				echo "Este aplicativo não possui um arquivo de instalação. <br>Tente fazer a instalação manualmente através das instruções do criador.";
			?>
		</div>
	</div>
</div>

<script>
$().ready(function(){
	$('.log').corner('5px');
});
</script>