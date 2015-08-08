<?php
function mLultimosVideos($album = 0, $qnt = 4, $w = 105, $h = 100){
	$consulta = "select * from ".SUFIXO."video where album != '".$album."' order by id desc limit ".$qnt;

	$query = mysql_query($consulta);
	?>
	<div class="galfotos">
	<?php
	while($dados = mysql_fetch_array($query)){
		extract($dados);
		$img = explode('/', $url);
		$img = array_reverse($img);
		$img = "http://i.ytimg.com/vi/".$img[0]."/default.jpg"; 

		
		?>
		<span class="foto">
			<a href="?video=<?php echo $id?>" title="<?php echo $descricao?>">
				<img src="<?php echo SISTEMA?>/includes/thumbs.php?imagem=<?php echo $w?>-<?php echo $img?>-<?php echo $h?>" alt="" />
			</a>
		</span>
		<?php
	}	 ?>
	</div>
	<?php
}
?>