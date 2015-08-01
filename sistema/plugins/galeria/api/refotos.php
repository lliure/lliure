<?php
	$idfoto = $_GET['foto'];
	$tabelaAtu = SUFIXO."pictures";
	$retorno = $_GET['retorno'];
?>
	
<script type="text/javascript">
		function Save(){
			document.getElementById('form').action="<?=$pluginHome?>&acoes=rfotos&foto=<?=$idfoto?>&retorno=<?=$retorno?>";
			document.getElementById('form').submit();
		}		
	</script>

<div class="boxCenter">
	<span class="h2">Editar foto</span>
<?php
	if(!empty($_POST)){
		$retorno = str_replace('*', '&', $retorno);
		
		$campos['descricao'] = $_POST['nfoto'];
		$alter['id'] = $idfoto;
		mLupdate($tabelaAtu, $campos, $alter);
		
		echo mensagemAviso("Foto renomeada com sucesso!");
		?>
		<meta http-equiv="refresh" content="1; URL=?<?=$retorno?>">
		<?php
	} else {
	$sql = "SELECT * FROM ".$tabelaAtu." WHERE id='".$idfoto."'";
	$dados = mysql_fetch_array(mysql_query($sql));
	$foto = $dados['foto'];
	$nome = (!empty($dados['descricao'])?$dados['descricao']:"");
	
	
	$volt = str_replace('*', '&', $retorno);
	$dir = $_GET['dir']."/";
?>	
	<div class="ediFoto">
		<div class="galdiv">
			<img src="includes/thumbs.php?imagem=300-../<?=$dir.$foto?>-200" />
		</div>
		
		<form method="post" id="form" class="form">
			<div class="label">
				<input type="text" value="<?=$nome?>" name="nfoto"/>
			</div>
			<button type="submit"></button>
			
			<a href="javascript: void(0)" onclick="Save()" title="salvar" class="a"><img src="imagens/icones/save.png" alt="salvar"	/></a>
			<a href="?<?=$volt?>" title="Voltar" class="a"><img src="imagens/icones/back.png" alt="voltar"/></a>
			
		</form>
	</div>
<?php
	}
	?>
</div>