<?php
retornaLink($_SESSION['historicoNav'], 'save');
?>
<div class="boxCenter">
	<span class="h2">Alterar titulo</span>
	<?php
	$id = $_GET['id'];
		if(!empty($_POST)){
			$campos['titulo'] = $_POST['titulo'];
			$alter['id'] = $id;
			
			$pluginTable = $pluginTable."_categorias";
			
			mLupdate($pluginTable, $campos, $alter);
				
			echo mensagemAviso("Titulo alterado com sucesso!");
			echo loadPage($backReal, 1);
		} else {
			
			$consulta = mysql_fetch_array(mysql_query("select titulo from ".SUFIXO."noticias_categorias where id = '".$id."'"));
			$titulo = $consulta['0'];
		?>
		<form method="post" id="form" class="form">
			<div class="label">
				<span>Titulo</span>
				<input type="text" value="<?=$titulo?>" name="titulo"/>
			</div>
			<button type="submit"></button>
			
			<a href="javascript: void(0)" onclick="submit('form')" title="salvar" class="a"><img src="imagens/icones/save.png" alt="salvar"	/></a>
			<a href="<?=$backReal?>" title="Voltar" class="a"><img src="imagens/icones/back.png" alt="voltar"/></a>
			
		</form>
		<?php
		}
	?>
</div>