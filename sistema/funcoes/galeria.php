<?php
function mLUltFotos($qnt = 3, $w = 150, $h = 100){
	$consulta = "select * from ".SUFIXO."pictures where  idPag like 'gl%' limit $qnt";

	$query = mysql_query($consulta);
	?>
	<div class="galfotos">
	<?php
	while($dados = mysql_fetch_array($query)){
		$foto = $dados['foto'];
		$descricao = $dados['descricao'];
		?>
		<span class="foto">
			<a href="../uploads/fotos/<?php echo $foto?>" rel="lightbox[0]" title="<?php echo $descricao?>">
				<img src="<?php echo SISTEMA?>/includes/thumbs.php?imagem=<?php echo $w?>-../../uploads/fotos/<?php echo $foto?>-<?php echo $h?>" alt="" />
			</a>
		</span>
		<?php
	}	 ?>
	</div>
	<?php
}


function mLUltGal($qnt = 3, $w = 150, $h = 100){
	$consulta = "select a.*, b.foto from 
			".SUFIXO."galeria as a

			".SUFIXO."pictures as b
			on a.firtPhoto = b.foto
			
			where idPag like 'gl%' limit $qnt";

	$query = mysql_query($consulta);
	?>
	<div class="galfotos">
	<?php
	while($dados = mysql_fetch_array($query)){
		$foto = $dados['foto'];
		$descricao = $dados['descricao'];
		?>
		<span class="foto">
			<a href="../uploads/fotos/<?php echo $foto?>" rel="lightbox[0]" title="<?php echo $descricao?>">
				<img src="<?php echo SISTEMA?>/includes/thumbs.php?imagem=<?php echo $w?>-../../uploads/fotos/<?php echo $foto?>-<?php echo $h?>" alt="" />
			</a>
		</span>
		<?php
	}	 ?>
	</div>
	<?php
}
?>