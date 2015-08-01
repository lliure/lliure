<div class="mLEventos">
<?php
$consulta = "select a.*, b.foto from 
		".SUFIXO."eventos as a
		
		left join ".SUFIXO."pictures as b
		on a.firtPhoto = b.id
		
		order by data desc";
$query = mysql_query($consulta);

if(empty($_GET['eventos'])){
	while($dados = mysql_fetch_array($query)){
	?>
		<div class="evento">
			<span class="titulo"><a href="?eventos=<?=$dados['id']?>"><?=$dados['titulo']?></a></span>
			<a href="<?=SISTEMA?>/plugins/galeria/uploads/<?=$dados['foto']?>" rel="lightbox[0]"><img src="<?=SISTEMA?>/includes/thumbs.php?imagem=137-../plugins/galeria/uploads/<?=$dados['foto']?>-137" alt="" class="foto" /></a>
			<span class="data">Data: <?=$dados['data']?></span>
			<span class="local"><strong>Local:</strong> <?=$dados['local']?></span>
			<span class="detalhes"><strong>Mais detalhes</strong> <br/><?=mLsubstrFull($dados['comentario'], 100)?> <br/><span><a href="?eventos=<?=$dados['id']?>">Mais informações</a></span></span>
		</div>
		<div class="both10"></div>
	<?php
	}
} else { // lista os eventos
	$idEvent = $_GET['eventos'];
	$consulta = "select a.*, b.foto from 
		".SUFIXO."eventos as a
		
		left join ".SUFIXO."pictures as b
		on a.firtPhoto = b.id
		
		where a.id = '".$idEvent."'";
$query = mysql_query($consulta);
	$dados = mysql_fetch_array($query);
	?> 
	<div class="eventoFull">
		<div class="left"><a href="<?=SISTEMA?>/plugins/galeria/uploads/<?=$dados['foto']?>" rel="lightbox[0]"><img src="<?=SISTEMA?>/includes/thumbs.php?imagem=198-../plugins/galeria/uploads/<?=$dados['foto']?>-280" alt="" class="foto" /></a></div>
		
		<div class="right">
			<span class="titulo"><?=$dados['titulo']?></span>
			<span class="data">Data: <?=$dados['data']?></span>
			<span class="local"><strong>Local:</strong> <?=$dados['local']?></span>
			<span class="detalhes"><strong>Mais detalhes</strong> <br/><?=$dados['comentario']?></span>
		</div>
		<div class="both"></div>
	</div>
<?php
}
?>
</div>
