<?php
	$tBanner = $_GET['id'];
?>
<div class="menuSub">
	<a href="<?=$pluginHome?>" title="voltar"><img src="imagens/icones/back.png" alt="voltar"/><span>Voltar</span></a>

	<a href="<?=$pluginHome?>&amp;acoes=editar&tban=<?=$tBanner?>"><img src="<?=$pluginPasta?>img/newban.png" alt="adicionar banner"/><span>Adicionar banner</span></a>	
	
	<div class="both"></div>
</div>

<div>
<span class="h2">Banners <?=$banners[$tBanner]?></span>
<?php
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
	
	$consulta = "select * from ".$pluginTable." where tipo = '".$tBanner."'".$montaOrdem;
	$query = mysql_query($consulta);
	$tr = mysql_num_rows($query); 

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
			$nome = $dados['nome'];
			?>
			<tr class="alterna<?=$alterna?>">
				<td><?=$nome?></td>
				<td class="ico"><a href="<?=$pluginHome?>&amp;acoes=editar&amp;id=<?=$dados['id']?>"><img src="imagens/icones/edit.gif" alt="editar"/></a></td>
				<td class="ico"><a href="<?=$pluginHome?>&amp;acoes=apaga&amp;id=<?=$dados['id']?>&amp;tban=<?=$tBanner?>&amp;arq=<?=$dados['imagem']?>"><img src="imagens/icones/excluir.png" alt="excluir"/></a></td>
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
		echo mensagemAviso('nenhum banner encontrado');
	}
?>
</div>