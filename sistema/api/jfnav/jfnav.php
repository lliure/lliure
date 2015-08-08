<?php
header("Content-Type: text/html; charset=ISO-8859-1", true);
require_once('../../includes/conection.php');

$link = $_POST['config'];
$pluginPasta = $_POST['pasta'];

$query = mysql_query(stripslashes($_POST['query']));
if(mysql_num_rows($query) > 0){
	while($dados = mysql_fetch_array($query)){	
		$id = $dados['id'];
		$nome = $dados['nome'];
		
		$pagInp = "name".$id;
		
		if(isset($link['campo'])){			
			$click = $link[$dados[$link['campo']]]['link'].$id;
			$ico = (isset($link[$dados[$link['campo']]]['ico'])?$link[$dados[$link['campo']]]['ico']:"sys/ico.png");
		} else {		
			$click = $link['link'].$id;
			$ico = (isset($link['ico'])?$link['ico']:"sys/ico.png");
		}	
		
		/*
		if(!is_null($ligs)){
			
			$ligModIdint = ($ligModId == "notnull"?" != '' and id = '".$id."'" : "= '".$ligModId.$id."'");
			$consulta = mysql_query("select ".$ligCampo." from ".$ligTabela." where ".$ligCampo." ".$ligModIdint." limit 1");
			if(mysql_num_rows($consulta) > 0){
				$liglink = ($ligUrl == 'off'?'off':$ligUrl.(strpos($ligUrl, "?") != false?"&amp;":"?")."tabela=".$ligTabela."&campo=".$ligCampo."&modid=".$ligModId."&id=".$id);
			} else {
				$liglink = '0';
			}
		} else {
			
		}
		*/
		$liglink = '0';
		$nomelink = (strlen($nome) > 33? substr($nome, 0, 30)."...":$nome);
		?>	
		<div class="listp" id="div<?php echo $pagInp?>" rel="<?php echo $pagInp?>" lig="<?php echo $liglink?>" dclick="<?php echo $click?>">
			<div class="inter">
				<img src="<?php echo $pluginPasta.$ico?>" alt="<?php echo $nome?>" />
				<span id="<?php echo $pagInp?>" title="<?php echo $nome?>"><?php echo $nomelink?></span>
			</div>
		</div>
		<?php
	}
} else { 
	?>
	<script style="text/javascript">
		jfAlert('Nenhum registro encontrado', '0.5');
	</script>
	<?php
}
?>