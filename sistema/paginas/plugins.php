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