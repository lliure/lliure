<?php
$filtro = '';
$where = '';

$pluginTable = SUFIXO."bairros";

if (isset($_POST['del']) && is_array($_POST['del'])) {
	$del = "DELETE FROM ".$pluginTable." where id in (".in($_POST['del']).")";
	mysql_query($del);
}
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
if (isset($_GET['idCat'])) {
	$where .= " and a.idCidade = '".$_GET['idCat']."'";
}
$consulta = "select a.* from ".$pluginTable." a
where 1=1 $where
".$montaOrdem;
$query = mysql_query($consulta);
$tr = mysql_num_rows($query); 
?>
<script type="text/javascript">
	function cform(msg,formulario) {
		if (typeof msg == 'undefined') {
			msg = 'Tem certeza que deseja excluir o(s) registro(s) selecionado(s)?';
		}
		if (typeof form == 'undefined') {
			formulario = 'form1';
		}
		if (confirm(msg)) {
			document.form1.submit();	
		} else {
			return false;
		}
		
	}
</script>

<div class="menuSub">
	<a href="<?=$backReal?>" title="voltar"><img src="imagens/icones/back.png" alt="voltar"/><span>Voltar</span></a>
	

	<a href="<?=$pluginHome?>&amp;acoes=novoprod"><img src="<?=$pluginPasta?>img/newprod.png" alt="Novo Bairro"/><span>Novo Bairro</span></a>
	
	<a href="javascript:void(0)" onclick="javascript:cform()" style="float:right"><span style="margin-right:10px">Excluir selecionados</span> <img src="<?=$pluginPasta?>img/exc.png" alt="Excluir selecionados"/></a>
	<div class="both"></div>
</div>
<div class="listNav">
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
	<form method="POST" name="form1" id="form1">
	<table class="table">
		<tr>
			<th><a href="<?=$pluginHome?>&amp;acoes=produtos&amp;ordem=nome<?=$mudaLinkOrdem?>" title="Ordernar por nome"><img src="imagens/icones/order.gif" alt="Ordernar por nome"/></a> Bairros</th>		
			<th class="ico">Editar</th>		
			
			<th class="ico"><input type="checkbox" name="" onClick="selecionartodos(this.checked)" /></th>			
		</tr>
	
	<?php
		$i = 1;
		while($dados = mysql_fetch_array($limite)){
			$alterna = ($i%2?'0':'1');
			$titulo = $dados['nome'];
			?>
			<tr class="alterna<?=$alterna?>">
				<td><a href="<?=$pluginHome?>&amp;acoes=produtos&amp;id=<?=$dados['id']?>&amp;editar"><?=$titulo?></a></td>
				<td class="ico"><a href="<?=$pluginHome?>&amp;acoes=produtos&amp;id=<?=$dados['id']?>&amp;editar"><img src="imagens/icones/edit.gif" alt="editar"/></a></td>
				
				<th class="ico"><input type="checkbox" name="del[]" value="<?=$dados['id']?>"  /></th>	
			</tr>
			<?php		
			$i++;
		}
	?>
	</table>
	</form>
		<?php
		if($tr > $total_reg){ ?>
			<div class="paginacao">
				<?php
				$anterior = $pc -1;
				$proximo = $pc +1;
				
				if ($pc>1) {
					echo " <a href='".$pluginHome."&amp;acoes=produtos&amp;id=".$idCat."&amp;pag=".$anterior.$filtro."'>« Anterior</a> ";
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
						
						echo "<a href='".$pluginHome."&amp;acoes=produtos&amp;id=".$idCat."&amp;pag=".$i.$filtro."'>$i</a> ";
						
						if ($i < $ult) {	
							echo "| ";
						}
					}
				} else {
					echo "<span>| </span>";
				}


				if ($pc<$tp) {
					echo "<a href='".$pluginHome."&amp;acoes=produtos&amp;id=".$idCat."&amp;pag=".$proximo.$filtro."'>Próxima »</a>";
				} else {
					echo "<span >Próxima »</span>";
				}
				?>
			</div>
			
		<?php
		}
	} else {
		echo mensagemAviso('Nenhum bairro encontrado');
	}
?>
</div>