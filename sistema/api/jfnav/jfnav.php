<?php
/**
*
* API jfnav - Plugin CMS
*
* @versão 4.3.3
* @Desenvolvedor Jeison Frasson <contato@newsmade.com.br>
* @entre em contato com o desenvolvedor <contato@newsmade.com.br> http://www.newsmade.com.br/
* @licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

header("Content-Type: text/html; charset=ISO-8859-1", true);
require_once('../../etc/bdconf.php');

$config = $_POST['config'];
$pluginPasta = $_POST['pasta'];

$query = mysql_query(stripslashes($_POST['query']));

if(mysql_error() != false)
	die('Erro na consulta mysql: <strong>'.$_POST['query'].'</strong>');
	
if(mysql_num_rows($query) > 0){	
	$exibicoes = array('icones', 'lista');
	
	switch(in_array($_POST['exibicao'], $exibicoes) ? $_POST['exibicao'] : 'icones'){
		
	
	case 'icones':	
		while($dados = mysql_fetch_array($query)){	
			$id = $dados['id'];
			$nome = $dados['nome'];
			
			$pagInp = "name".$id;
			
			if(isset($config['campo'])){			
				$click = $config[$dados[$config['campo']]]['link'].$id;
				$ico = (isset($config[$dados[$config['campo']]]['ico'])?$config[$dados[$config['campo']]]['ico']:"sys/ico.png");
			} else {		
				$click = $config['link'].$id;
				$ico = (isset($config['ico'])?$config['ico']:"sys/ico.png");
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
	break;

	case 'lista':		
		echo '<table id="jfnList">
			<tr>
				<th style="width: 60px;">Cod.</th>
				<th>Titulo</th>';
				
		if(isset($config['botoes']))
			for($i = 1; $i <= count($config['botoes']); $i++)
				echo '<th style="width: 20px;"></th>';
				
		echo	'<th style="width: 20px;"></th>
			</tr>
			';			
		while($dados = mysql_fetch_array($query)){	
			$pagInp = "name".$dados['id'];
					
			if(isset($config['campo']))		
				$click = $config[$dados[$config['campo']]]['link'].$dados['id'];
			else 	
				$click = $config['link'].$dados['id'];
			
			$nomelink = (strlen($dados['nome']) > 33? substr($dados['nome'], 0, 30)."...":$dados['nome']);
			echo '<tr id="div'.$pagInp.'" class="listp" rel="'.$pagInp.'" dclick="'.$click.'">
					<td>'.str_pad($dados['id'], 7, 0, STR_PAD_LEFT).'</td>
					<td class="inter"><span id="'.$pagInp.'" title="'.$dados['nome'].'">'.$nomelink.'</span></td>';
					
			if(isset($config['botoes']))
				foreach($config['botoes'] as $valor)
					echo '<td><a href="'.$valor['link'].$dados['id'].'"><img src="'.$valor['ico'].'" alt="'.$valor['nome'].'" /></td>';				
					
			echo' <td class="jfnav_del"><img src="api/jfnav/imagens/trash.png"></td>
				</tr>
				';
		}
		echo '</table>
			<script>
				$(\'.jfnav_del\').click(function(){
					jfnav_clickDelReg($(this).closest(\'tr\').attr(\'rel\'));
				});
			</script>';
		
	break;
	}
} else { 
	?>
	<script style="text/javascript">
		jfAlert('Nenhum registro encontrado', '0.5');
	</script>
	<?php
}

?>
