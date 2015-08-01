<?php
$idGal = $_GET['galeria'];
$idAlbum = (isset($_GET['album'])?$_GET['album']:'');

if(isset($_GET['album'])){ 
	$consulta = "select nome, id from ".SUFIXO."galeria where id like '".$idAlbum."'";
	$query = mysql_query($consulta);
	$dados = mysql_fetch_array($query)
	?>
	<span class="h1">Album <?=$dados['nome']?></span>
	<div class="galfotos">
		<?php
		$consulta = "select * from ".SUFIXO."pictures where idPag = 'gl".$idAlbum."'";
		$query = mysql_query($consulta);
		while($dados = mysql_fetch_array($query)){
			$foto = $dados['foto'];
			$descricao = $dados['descricao'];
			?>
			<span class="foto">
				<a href="uploads/fotos/<?=$foto?>" rel="lightbox[0]" title="<?=$descricao?>">
					<img src="<?=SISTEMA?>/includes/thumbs.php?imagem=110-../../uploads/fotos/<?=$foto?>-100" alt="" />
				</a>
			</span>
			<?php
		}	 ?>
	</div>
	<?php
} else { ?>
	<span class="h1">Galerias</span>
	<?php
	$consulta = "select a.*, b.foto from 
			".SUFIXO."galeria as a
			
			left join sgs_pictures as b
			on a.firtPhoto = b.id
			
			where galeria like '".$idGal."' order by id desc";

	$query = mysql_query($consulta);
	?>
	<div class="galfotos">
	<?php
	while($dados = mysql_fetch_array($query)){
		$foto = $dados['foto'];
		?>
		<span class="foto">
			<a href="?galeria=<?=$dados['galeria']?>&amp;album=<?=$dados['id']?>">
				<img src="<?=SISTEMA?>/includes/thumbs.php?imagem=150-../../uploads/fotos/<?=$foto?>-100" alt="" />
			</a>
			
			<a href="?galeria=<?=$dados['galeria']?>&amp;album=<?=$dados['id']?>">
				<?=mLsubstrFull($dados['nome'], 20)?>
			</a>
		</span>
		<?php
	}	 ?>
	</div>
	<?php
}
?>