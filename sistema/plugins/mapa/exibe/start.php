<?php
$pagina = $_GET['mapa'];
$consulta = "select * from ".SUFIXO."mapa where id = '".$pagina."'";
$dados = mysql_fetch_array(mysql_query($consulta));
if(!empty($dados['titulo'])){
	?><span class="h1"><?=$dados['titulo']?></span>
	<?php
}
?>
<div class="paginaDiv">
	<?=$dados['conteudo']?>
</div>
<div id="mapa">
	<?=$dados['embed']?>
</div>
<?php
$consulta = "select * from ".SUFIXO."pictures where  idPag = 'mp".$pagina."'";

$query = mysql_query($consulta);

if(mysql_num_rows($query) > 0){ ?>
	<div class="galfotos">
	<?php
	while($dados = mysql_fetch_array($query)){
		$foto = $dados['foto'];
		$descricao = $dados['descricao'];
		?>
		<span class="foto">
			<a href="../uploads/fotos/<?=$foto?>" rel="lightbox[0]" title="<?=$descricao?>">
				<img src="<?=SISTEMA?>/includes/thumbs.php?imagem=150-../../uploads/fotos/<?=$foto?>-100" alt="" />
			</a>
		</span>
		<?php
	}	 ?>
	</div>
	<?php
}
?>