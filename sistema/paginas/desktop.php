<?php
/**
*
* Plugin CMS
*
* @vers�o 4.0.1
* @Desenvolvedor Jeison Frasson <contato@newsmade.com.br>
* @entre em contato com o desenvolvedor <contato@newsmade.com.br> http://www.newsmade.com.br/
* @licen�a http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

$pluginTable = PREFIXO."desktop";
$consulta = "select * from ".$pluginTable." order by nome asc";
$query = mysql_query($consulta);
?>

<script type="text/javascript">
	$().ready(function() {
		$('.bodyhome').jfnav();
		$('.listp').corner('4px');
	});
</script>

<div class="bodyhome">
	<?php
	if(mysql_num_rows($query) > 0){
		?>
		<input id="namTable" type="hidden" value="<?php echo $pluginTable?>"/>
		<input type="hidden" id="idPag" value="" />
		<input type="hidden" id="linked" value="" />

		<?php
		while($dados = mysql_fetch_array($query)){
			extract($dados);
			
			$pagInp = "name".$id;

			$ico = (isset($link['ico'])?$link['ico']:"ico.png");
			
			$nomelink = (strlen($nome) > 33? substr($nome, 0, 30)."...":$nome);
			
			?>
			<div class="listp" id="div<?php echo $pagInp?>" rel="<?php echo $pagInp?>" lig="0" dclick="<?php echo $link?>">
				<div class="inter">
					<img src="<?php echo $imagem?>" alt="<?php echo $nome?>" />
					<span id="<?php echo $pagInp?>" rel="<?php echo $pagInp?>" title="<?php echo $nome?>"><?php echo $nomelink?></span>
				</div>
			</div>
			<?php
		}
	} else { 
		?>
		<img src="error.jpg" onerror="mLaviso('N�o foi encontrado nenhum item em sua �rea de trabalho')" class="imge" alt="" /> 
		<div style="height: 30px; width: 1px;"></div>
		<?php
	}
	?>
</div>