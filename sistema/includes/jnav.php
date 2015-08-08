<?php
function jNavigator($query, $pluginTable, $pastas, $mensagemVazio, $link, $ligs = null){
/*
Documenta��o da fun��o

$query
	Exemplo de utiliza��o
	$consulta = "select * from tabela";
	$query = mysql_query($consulta);
	
$pluginTable
	Exemplo de utiliza��o
	$pluginTable = 'tabela'; // B�sicamente � a tabela que est� sendo utilizada o motivo de ter que mostra-lo � que ser� utilizado pelo JS
	
$Pastas
	Exemplo de utiliza��o
	$pastas = 'sistema/pasta'; // B�sicamente � a pasta em que est� o plugin, � utilizado para selecionar icones
	
	ou 
	
	$pastas['pp'] = Pasta do Plugin // igual o acima;
	$pastas['plp'] = Pasta que o plugin faz intera��o, essa caso n�o exista o sistema retorna uma mensagem dizendo que a pasta n�o existe
	
$mensagemVazio
	Exemplo de utiliza��o
	$mensagemVazio = 'nada foi encontrado'; 	//� a mensagem exibida caso n�o seja encontrado nenhum resultado na busca		

$link
	Exemplo de utiliza��o
	$link['campo'] = 'tipo';		// � o diferencial entre os dois tipos de itens no caso ter� � o campo que os diferencia na base de dados

	$link['t1']['link'] = "?acoes=editar&amp;id="; 	//$link['Y']['link'] onde Y � o mesmo que o anterior
	$link['t1']['ico'] = "/img/album.png";			//$link['Y']['ico'] onde Y � o mesmo que o anterior

	$link['t2']['link'] = "?gal=";					//$link['t2']['link'] = ao link que o usuario ser� direcionado em caso click	
	$link['t2']['ico'] = "/img/book.png";			//$link['t2']['ico'] = � a imagem 
*/

	$pluginPasta = (is_array($pastas)?$pastas['pp']:$pastas);
	?>
	<script type="text/javascript">
		$().ready(function() {
			$('#bodyhome').jfnav();
		});
	</script>
	
	<input id="namTable" type="hidden" value="<?php echo $pluginTable?>"/>
	<input type="hidden" id="idPag" value="" />
	<input type="hidden" id="linked" value="" />

	<div class="bodyhome" id="bodyhome">
		<?php
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
				
				if(!is_null($ligs)){
					$ligModIdint = ($ligModId == "notnull"?" != '' and id = '".$id."'" : "= '".$ligModId.$id."'");
					$consulta = mysql_query("select ".$ligCampo." from ".$ligTabela." where ".$ligCampo." ".$ligModIdint." limit 1");
					if(mysql_num_rows($consulta) > 0){
						$liglink = ($ligUrl == 'off'?'off':$ligUrl.(strpos($ligUrl, "?") != false?"&amp;":"?")."tabela=".$ligTabela."&campo=".$ligCampo."&modid=".$ligModId."&id=".$id);
					} else {
						$liglink = '0';
					}
				} else {
					$liglink = '0';
				}
				
				$nomelink = (strlen($nome) > 33? substr($nome, 0, 30)."...":$nome);
				?>	
				<div class="listp" id="div<?php echo $pagInp?>" rel="<?php echo $pagInp?>" click="<?php echo $liglink?>" dclick="<?php echo $click?>">
					<div class="inter">
						<img src="<?php echo $pluginPasta.$ico?>" alt="<?php echo $nome?>" />
						<span id="<?php echo $pagInp?>"  rel="<?php echo $pagInp?>" title="<?php echo $nome?>"><?php echo $nomelink?></span>
					</div>
				</div>
				<?php
			}
		} else { 
			if(is_array($pastas) and isset($pastas['plp'])) {
				if(file_exists($pastas['plp']) != true){
					if(@mkdir($pastas['plp'], 0777 ) == true){
						$mensagemVazio = "O sistema criou automaticamente a pasta ".$pastas['plp'];
						$tempo = 2;
					} else{
						$mensagemVazio = "O sistema n�o conseguiu criar a pasta <strong>".$pastas['plp']."</strong>. Crie manualmente em seu sistema para o funcionamento correto do plugin";
						$tempo = 60;
					}
				}
			}
		
			?><img src="error.jpg" onerror="mLaviso('<?php echo $mensagemVazio?>', '<?php echo $tempo?>')" class="imge" alt="" /><?php
		}
		?>
	</div>
	
	<?php
}

function jNavigatorInner($ultimo_id, $ondblclick, $icone, $nome){
	$nomelink = (strlen($nome) > 33? substr($nome, 0, 30)."...":$nome);
	
	return '<div class="listp" id="divname'.$ultimo_id.'" rel="name'.$ultimo_id.'" click="0" dclick="'.$ondblclick.$ultimo_id.'">'
				.'<div class="inter">'
					.'<img src="'.$icone.'" alt="'.$nome.'" />'
					.'<span id="name'.$ultimo_id.'" rel="name'.$ultimo_id.'"  title="'.$nome.'">'.$nomelink.'</span>'
				.'</div>'
			.'</div>';
}
?>