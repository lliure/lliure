<?php
	$idAlbum = $_GET['id'];
?>
<div class="boxCenter">
	<span class="h2">Album de videos</span>


	<div class="boxPassos">
		<form class="addVid" action="<?=$pluginHome?>&amp;acoes=add&amp;id=<?=$idAlbum?>" method="post">
			<label>
				<span>URL de vídeo do <a href="http://www.youtube.com" class="link">YouTube</a>:</span> <input type="text" name="url" autocomplete="off"/>
			</label>
			<span class="botao"><button>Adicionar video</button></span>
			<div class="both"></div>
		</form>
	</div>
	
	<?php
	$consulta = "select * from ".SUFIXO."video where album = '".$idAlbum."' order by id desc";
	$query = mysql_query($consulta);
	while($dados = mysql_fetch_array($query)){
		?>
		<div class="vidVideo">
			<div class="object">
				<object width="300" height="250">
				<param name="movie" value="<?=$dados['url']?>">
				<param name="wmode" value="transparent">
				<embed src="<?=$dados['url']?>" type="application/x-shockwave-flash" wmode="transparent" pluginspage="http://www.macromedia.com/go/getflashplayer" width="300" height="250">
				</object>
			</div>
			<div class="info">
				<span class="nome"><?=$dados['nome']?></span>
				<span class="descricao"><?=$dados['descricao']?></span>
				<span class="botao"><a href="<?=$pluginHome?>&amp;acoes=edit&amp;id=<?=$dados['id']?>">Editar</a></span>
				<span class="botao"><a href="<?=$pluginHome?>&amp;acoes=del&amp;id=<?=$idAlbum?>&amp;video=<?=$dados['id']?>">Excluir</a></span>
			</div>
			
			<div class="both"></div>
		</div>	
		<?php
	}
	?>
</div>