<?php
function trazMenuCatalogo($idLig = 0) {
	$sql = "SELECT id,nome FROM ".SUFIXO."catalogo_categorias where idLig = '".$idLig."'";
	$qry = mysql_query($sql);
	while ($dados = mysql_fetch_array($qry)) {
		?>
		<li><a href="?catalogo&amp;cat=<?=$dados['id']?>"><?=$dados['nome']?></a></li>
		<?php
	}
}

function destaqueCatalogo($limit = 3){
	$sql = "SELECT a.nome, a.id, a.valor, b.foto FROM 
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
		<div class="produto_listagem" >
			<a href="?catalogo&prod=<?=$dados['id']?>">
				
				<? if (is_file('uploads/produtos/'.$dados['foto'])) { ?>
					<div class="img">
						<img src="<?=SISTEMA?>/includes/thumbs.php?imagem=130-../../uploads/produtos/<?=$dados['foto']?>-100" alt="<?=$dados['nome']?>" />
					</div>
				<? } else { ?>
				<div class="img">
					<div class="noPhoto">
						<span>
							Sem foto!
						</span>
					</div>
				</div>
				<?php 
				} ?>
				
				<span class="tituloProd" ><?=$dados['nome']?></span>
				
				<span class="dinheiro">
					<? if ($dados['valor'] == '0.00' || $dados['valor'] == '0' || $dados['valor'] == '0.0') { ?>
						Consulte-nos
					<? } else { ?>
						R$ <?=number_format($dados['valor'],2,',','.')?>
					<? } ?>
				</span>
			</a>
		</div>
		<?php
	}	
}
?>