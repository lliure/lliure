<?php
$idCat = $_GET['id'];

$filtro = '';

if(isset($_GET['ordem'])){
	$ordemPor = $_GET['ordem'];
	$ordemModo = (isset($_GET['modo'])? $_GET['modo'] : 'asc');
	$montaOrdem = " order by ".$ordemPor." ".$ordemModo;
	$mudaLinkOrdem = ($ordemModo == "asc"?'&amp;modo=desc':'');
	
	$filtro .= "&amp;ordem=".$ordemPor."&amp;modo=".$ordemModo;
} else {
	$montaOrdem = " order by id desc";
	$mudaLinkOrdem = '';
}

$consulta = "select * from ".$pluginTable." where categoria = '".$idCat."'".$montaOrdem;
$query = mysql_query($consulta);
$tr = mysql_num_rows($query); 
?>
<div class="menuSub">
	<a href="<?=$backReal?>" title="voltar"><img src="imagens/icones/back.png" alt="voltar"/><span><?=$backNome?></span></a>  
	
	<a href="<?=$pluginHome?>&amp;acoes=noticia&amp;nova=<?=$idCat?>"><img src="<?=$pluginPasta?>img/new.png" alt="Nova noticia"/><span>Nova noticia</span></a>	
	


	<div class="both"></div>
</div>

<div class="listNav">

<?php
$titulo = mysql_fetch_array(mysql_query("select titulo from ".SUFIXO."noticias_categorias where id = '".$idCat."'"));
$titulo = $titulo['0'];
?>
<span class="h2"><?=$titulo?> 	<a href="<?=$pluginHome?>&amp;acoes=titulo&amp;id=<?=$idCat?>" title="Alterar titulo"><img src="imagens/icones/edit2.png" alt="Alterar titulo"/></a></span>
<?php

	if($tr > 0){
		$total_reg = "10";

		if (!isset($_GET['pag'])) {
			$pc = "1";
		} else {
			$pc = $_GET['pag'];
		} 
		
		$inicio = $pc - 1;
		$inicio = $inicio * $total_reg; 
				
		$tp = ceil($tr / $total_reg); 
		
		$limite = mysql_query($consulta." LIMIT $inicio,$total_reg ");
	?>
	<table class="table">
		<tr>
			<th><a href="<?=$pluginHome?>&amp;acoes=noticiario&amp;id=<?=$idCat?>&amp;ordem=titulo<?=$mudaLinkOrdem?>" title="Ordernar por nome"><img src="imagens/icones/order.gif" alt="Ordernar por nome"/></a> Noticia</th>		
			<th class="ico">Editar</th>		
			<th class="ico">Excluir</th>		
		</tr>
	
	<?php
		$i = 1;
		while($dados = mysql_fetch_array($limite)){
			$alterna = ($i%2?'0':'1');
			$titulo = $dados['titulo'];
			?>
			<tr class="alterna<?=$alterna?>">
				<td><?=$titulo?></td>
				<td class="ico"><a href="<?=$pluginHome?>&amp;acoes=noticia&amp;id=<?=$dados['id']?>"><img src="imagens/icones/edit.gif" alt="editar"/></a></td>
				<td class="ico"><a href="<?=$pluginHome?>&amp;acoes=apaga&amp;id=<?=$dados['id']?>&amp;cat=<?=$idCat?>"><img src="imagens/icones/excluir.png" alt="excluir"/></a></td>
			</tr>
			<?php		
			$i++;
		}
	?>
	</table>
		<?php
		if($tr > $total_reg){ ?>
			<div class="paginacao">
				<?php
				$anterior = $pc -1;
				$proximo = $pc +1;
				
				if ($pc>1) {
					echo " <a href='".$pluginHome."&amp;acoes=noticiario&amp;id=".$idCat."&amp;pag=".$anterior.$filtro."'>« Anterior</a> ";
				} else {
					echo "<span>« Anterior</span> ";
				}

				if($tp > 2){
					$tm = 3;
					
					$ini = $pc-$tm;
					if($ini < 1){
						$ini = 1;
					}

					$ult = $pc+$tm;
					if($ult > $tp){
						$ult = $tp;
					}		
				
					for($i = $ini; $i <= $ult; $i++){
						
						echo "<a href='".$pluginHome."&amp;acoes=noticiario&amp;id=".$idCat."&amp;pag=".$i.$filtro."'>$i</a> ";
						
						if ($i < $ult) {	
							echo "| ";
						}
					}
				} else {
					echo "<span>| </span>";
				}


				if ($pc<$tp) {
					echo "<a href='".$pluginHome."&amp;acoes=noticiario&amp;id=".$idCat."&amp;pag=".$proximo.$filtro."'>Próxima »</a>";
				} else {
					echo "<span >Próxima »</span>";
				}
				?>
			</div>
		<?php
		}
	} else {
		echo mensagemAviso('nenhuma noticia encontrada');
	}
?>
</div>