<?php
$consulta = "select * from ".$pluginTable." order by nome asc";
$query = mysql_query($consulta);
?>

<div class="menuSub">
	<a href="<?=$backReal?>" title="voltar"><img src="imagens/icones/back.png" alt="voltar"/><span><?=$backNome?></span></a>  

	<div class="both"></div>
</div>


<?php
		
$total = count($banners);
for($i = 1; $i <= $total;$i++){
	if(file_exists($pluginPasta."/img/".$banners[$i].".png")){
		$imagem = $banners[$i];
	} else {
		$imagem = "120x60";	
	}
	?>
	<div class="listp">
		<div class="inter">
			<a href="?plugin=banner&amp;acoes=banners&amp;id=<?=$i?>"><img src="<?=$pluginPasta?>/img/<?=$imagem?>.png" alt="" /></a>
			<a href="?plugin=banner&amp;acoes=banners&amp;id=<?=$i?>"><span><?=$banners[$i]?></span></a>
		</div>
	</div>
	<?php
}
?>
