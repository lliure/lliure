<?php
function trazMenuCatalogo($idLig = 0) {
	$sql = "SELECT id,nome FROM ".SUFIXO."catalogo_categorias where idLig = '".$idLig."'";
	$qry = mysql_query($sql);
	while ($dados = mysql_fetch_array($qry)) {
		?>
		<li><a href="?catalogo&amp;cat=<?php echo $dados['id']?>"><?php echo $dados['nome']?></a></li>
		<?php
	}
}

function destaqueCatalogo($limit = 3){
	$sql = "SELECT a.nome, a.id, b.foto FROM 
		".SUFIXO."catalogo a
		
		LEFT JOIN ".SUFIXO."pictures b
		on a.firtPhoto = b.id
		
		where destaque = '1'
		order by RAND() limit $limit
		";


	$qry = mysql_query($sql);
	
	while ($dados = mysql_fetch_array($qry)) {
		extract($dados);
		?>
		<span class="produto_destaque">
			<a href="?catalogo&prod=<?php echo $id?>" title="<?php echo $nome?>">
				<img src="sistema/includes/thumbs.php?imagem=145-../../uploads/fotos/<?php echo $foto?>-100" alt="" />
			</a>
			<span><?php echo $nome?></span>
		</span>
		<?php
	}	
}
?>