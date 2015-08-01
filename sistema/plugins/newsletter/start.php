<div class="menuSub">
	<a href="<?=$backReal?>" title="voltar"><img src="imagens/icones/back.png" alt="voltar"/><span><?=$backNome?></span></a>  

	
	<div class="both"></div>
</div>
<?php
	$consulta = "select * from ".SUFIXO."newsletter";
	$query = mysql_query($consulta);
	$contato = '';
	$c = 1;
	while ($dados = mysql_fetch_array($query)) {
		$contato .= ($c>1?',':'').$dados['email'];
		$c++;
	?>
	<div class="boxCenter">
		<b>Nome:</b> <?=$dados['nome']?> &nbsp;&nbsp;|&nbsp;&nbsp; <b>E-mail:</b> <?=$dados['email']?> 
		

<?php
	}
?>
	<br /><br />
	<textarea style="width:100%;"><?=$contato?></textarea>
</div>