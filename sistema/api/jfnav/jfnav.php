<?php
/**
*
* API jfnav - Plugin CMS
*
* @Versão 4.6.2
* @Desenvolvedor Jeison Frasson <contato@grapestudio.com.br>
* @Entre em contato com o desenvolvedor <contato@grapestudio.com.br> http://www.grapestudio.com.br/
* @Licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

header("Content-Type: text/html; charset=ISO-8859-1", true);
require_once('../../etc/bdconf.php');

$configs = $_POST['config'];
$pluginPasta = $_POST['pasta'];

$query = mysql_query(stripslashes($_POST['query']));

if(mysql_error() != false)
	die('Erro na consulta mysql: <strong>'.$_POST['query'].'</strong>');
	
if(mysql_num_rows($query) > 0){
	$exibicoes = array('icone', 'lista');
	
	switch(in_array($_POST['exibicao'], $exibicoes) ? $_POST['exibicao'] : 'icone'){
		
	
	case 'icone':	// Exibição em icones -----------------------------------------------------
		while($dados = mysql_fetch_assoc($query)){	
			$id = $dados['id'];
			$config = isset($configs['campo']) ? $configs[$dados[$configs['campo']]] : $configs;
			
			$nome = isset($config['coluna']) ? $dados[$config['coluna']] : $dados['nome'];		
			$nomelink = (strlen($nome) > 33? substr($nome, 0, 30)."...":$nome);
			
			$pagInp = "name".$id;
		
			$click = isset($config['s_link']) ? $dados[$config['s_link']] : $config['link'].$id;

			$ico = $pluginPasta.'sys/ico.png';

			if(isset($config['ico'])){				
				if(is_array($config['ico'])){
					if(isset($config['ico']['c']) && !empty($dados[$config['ico']['c']])) // se exitir e não for vázio o campo em que irá puxar o icone
						$ico = 'includes/thumb.php?i='.$config['ico']['p'].$dados[$config['ico']['c']].':32:32:o';
					elseif(isset($config['ico']['a'])) // se possuir um alternativo
						$ico = $pluginPasta.$config['ico']['a'];
					elseif(isset($config['ico']['i'])) // se possuir um icone definido
						$ico = $dados[$config['ico']['i']];
				} else {
					$ico = $pluginPasta.$config['ico'];
				}
			}
			
			
			?>
			
			<div class="listp" id="div<?php echo $pagInp?>" rel="<?php echo $pagInp?>" <?php echo (isset($config['tabela']) ? 'tabela="'.$config['tabela'].'"' : '').' '.(isset($config['id']) ? 'c_id = "'.$dados[$config['id']].'"' : '').' '.(isset($config['coluna']) ? 'coluna="'.$config['coluna'].'"' : ''); ?> dclick="<?php echo $click?>">
				<div class="inter">
					<img src="<?php echo $ico?>" alt="<?php echo $nome; ?>" />
					<span id="<?php echo $pagInp?>" title="<?php echo $nome?>"><?php echo $nomelink; ?></span>
				</div>
			</div>
			<?php
		}		
		break;

	case 'lista': // Exibição em lista -----------------------------------------------------

		$ico = false;
		if(isset($configs['campo'])){
			$ico = $configs;
			$ico = array_pop($ico);
			$ico = (isset($ico['ico']) ? true : false);
		}
		
		echo '<table id="jfnList">
			<tr>
				'. ($ico == true ? '<th style="width: 20px;"></th>' : '' ).'
				<th style="width: 60px;">Cod.</th>
				<th>Titulo</th>';
				
		if(isset($configs['botoes']))
			for($i = 1; $i <= count($configs['botoes']); $i++)
				echo '<th style="width: 20px;"></th>';
				
		echo	'<th style="width: 20px;"></th>
			</tr>
			';
		
		while($dados = mysql_fetch_array($query)){	
			$pagInp = "name".$dados['id'];
			$config = isset($configs['campo']) ? $configs[$dados[$configs['campo']]] : $configs;
			
			$click = $config['link'].$dados['id'];

			$nome = isset($config['coluna']) ? $dados[$config['coluna']] : $dados['nome'];
	
			$nomelink = (strlen($dados['nome']) > 33 ? substr($nome, 0, 30) : $nome);
			
			echo '<tr id="div'.$pagInp.'"
					class="listp"
					rel="'.$pagInp.'"
					dclick="'.$click.'"
					'.(isset($config['tabela']) ? 'tabela="'.$config['tabela'].'"' : '').'
					'.(isset($config['id']) ? 'c_id = "'.$dados[$config['id']].'"' : '').'
					'.(isset($config['coluna']) ? 'coluna="'.$config['coluna'].'"' : '').'>
					
					'. ($ico == true ? '<td><a href="'.$click.'"><img src="'.$config['ico'].'"></a></td>' : '' ).'
					<td>'.str_pad($dados['id'], 7, 0, STR_PAD_LEFT).'</td>					
					<td class="inter"><span id="'.$pagInp.'" title="'.$nome.'">'.$nomelink.'</span></td>';
			
			if(isset($config['botoes']))
				foreach($config['botoes'] as $valor)
					echo '<td><a href="'.$valor['link'].$dados['id'].'"><img src="'.$valor['ico'].'" alt="'.$valor['nome'].'" /></td>';				
					
			echo '<td class="jfnav_del"><img src="api/jfnav/imagens/trash.png"></td>
				</tr>
				';
		}
		
		echo '</table>
			<script type="text/javascript">
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
