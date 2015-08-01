<?php
$idMenu = $_GET['id'];
?>	
<div class="menuSub">
		<a href="<?=$pluginHome?>&amp;local=menus&amp;id=<?=$_GET['id']?>" title="voltar"><img src="imagens/icones/back.png" alt="voltar"/><span>Voltar</span></a>
		<div class="both"></div>
	</div>
	
<?php
if(isset($_GET['case'])){
	switch($_GET['case']){
		case 'save':
			echo mensagemAviso("Alteração realizada com sucesso.");
			
			if (isset($_POST['item']) && is_array($_POST['item'])) {
				foreach ($_POST['item'] as $k=>$v) {
					$up = "UPDATE ".SUFIXO."menu set ordem = '".$v."' where id = '".$k."'";
					mysql_query($up);
				}
			}
			?>
				<meta http-equiv="refresh" content="1; URL=<?=$pluginHome?>&amp;local=menus&amp;id=<?=$_GET['id']?>">
			<?php
		break;
	}
}

?>
	
<div class="boxCenter">
<span class="h2">Ordenar menu</span>

<script type="text/javascript">
	function Save(){
		document.getElementById('form').action="<?=$pluginHome?>&local=ordenar&id=<?=$idMenu?>&case=save";
		document.getElementById('form').submit();
	}
</script>
	
<form id="form" class="form" method="post">
<table class="table">
<tr>
	<th width="600px">
		Item
	</th>
	
	<th width="50px">
		Ordem
	</th>
</tr>
<?php
$consulta = "select * from ".SUFIXO."menu where idMe = '".$idMenu."' order by ordem asc";
$query = mysql_query($consulta);
while($dados = mysql_fetch_array($query)){
	?>
	<tr>
		<td>
			<?=$dados['nome']?>
		</td>		
		
		<td >
			<input type="text" name="item[<?=$dados['id']?>]" value="<?=$dados['ordem']?>" style="width:50px; text-align:center" />
		</td>
	</tr>
	<?php
}
?>
</table>
		<a href="javascript: void(0)" onclick="Save()" title="salvar" class="a"><img src="imagens/icones/save.png" alt="salvar"	/></a>
</form>
</div>