<?php
if(isset($_GET['pagina'])){
	$pagina = $_GET['pagina'];
	$pagina = "id = '".$pagina."'";
} else {
	$pagina = "nome = 'home'";
}

$consulta = "select * from ".SUFIXO."paginas where ".$pagina." limit 1";
$dados = mysql_fetch_array(mysql_query($consulta));
$idPag = $dados['id'];
if(!empty($dados['titulo'])){
	?><span class="h1"><?=$dados['titulo']?></span>
	<?php
}
?>
<div class="paginaDiv">
	<?=$dados['conteudo']?>
</div>
<?php
$consulta = "select * from ".SUFIXO."pictures where  idPag = 'pa".$idPag."'";

$query = mysql_query($consulta);

if(mysql_num_rows($query) > 0){ ?>
	<div class="galfotos">
	<?php
	while($dados = mysql_fetch_array($query)){
		$foto = $dados['foto'];
		$descricao = $dados['descricao'];
		?>
		<span class="foto">
			<a href="uploads/fotos/<?=$foto?>" rel="lightbox[0]" title="<?=$descricao?>">
				<img src="<?=SISTEMA?>/includes/thumbs.php?imagem=145-../../uploads/fotos/<?=$foto?>-100" alt="" />
			</a>
		</span>
		<?php
	}	 ?>
	</div>
	<?php
}
?>