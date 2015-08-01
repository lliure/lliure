<?php
$where = '';
if (isset($_GET['cat'])) {
	$where .= " and a.idCat = '".$_GET['cat']."'";
	$sql = "SELECT nome FROM ".SUFIXO."catalogo_categorias where id = '".$_GET['cat']."'";
	$titulo = mysql_fetch_array(mysql_query($sql));
	$titulo = $titulo['nome'];
}
if (isset($_GET['imoveis'])) {
	$where .= " and b.tipo = '".$_GET['imoveis']."'";
	$titulo = "Imóveis para ".($_GET['imoveis']=='v'?"venda":'locação');
}

$sql = "SELECT b.*,c.foto FROM 
		".SUFIXO."catalogo_relacao a
		LEFT JOIN ".SUFIXO."catalogo b
		on a.idProd = b.id
		LEFT JOIN ".SUFIXO."pictures c
		on b.firtPhoto = c.id
		where 1=1 $where
";
$qry = mysql_query($sql);
?>
<span class="h1"><?=$titulo?></span>
<span class="espaco"></span>
<? while ($dados=mysql_fetch_array($qry)) { ?>
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
<? } ?>