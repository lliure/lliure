<span class="h2">Painel de plugins</span>
<style type="text/css">#conteudo{background: none;}</style>
<div class="menuSub">
	<a href="<?php echo $backReal?>" title="voltar"><img src="imagens/icones/back.png" alt="voltar"/><span><?php echo $backNome?></span></a>  
	<a href="<?php echo $backReal?>" title="voltar"><img src="painel/img/installer.png" alt="voltar"/><span>Instalar/Desinstalar plugins</span></a>  
	<div class="both"></div>
</div>

<?php
	$consulta = "select * from ".SUFIXO."plugins";
	$query = mysql_query($consulta);
	
	if(mysql_num_rows($query) > 0){
		while($dados = mysql_fetch_array($query)){
		$nome = $dados['nome'];
		$pasta = $dados['pasta'];
		?>
		<div class="listp">
			
			<div class="inter">
				<a href="?plugin=<?php echo $pasta?>"><img src="plugins/<?php echo $pasta?>/sys/ico.png" alt="<?php echo $nome?>" /></a>
				<a href="?plugin=<?php echo $pasta?>"><span><?php echo $nome?></span></a>
			</div>
			
		</div>
		<?php
		}
	} else {
		?>
		<span class="mensagem"><span>Nenhum plugin instalado</span></span>
		<?php
	}
	
?>