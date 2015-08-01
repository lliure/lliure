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
				<a href="?plugin=<?=$pasta?>"><img src="plugins/<?=$pasta?>/ico.png" alt="<?=$nome?>" /></a>
				<a href="?plugin=<?=$pasta?>"><span><?=$nome?></span></a>
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