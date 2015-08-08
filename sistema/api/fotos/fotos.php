<?php
/**
*
* Plugin CMS
*
* @versão 4.2.7
* @Desenvolvedor Jeison Frasson <contato@newsmade.com.br>
* @entre em contato com o desenvolvedor <contato@newsmade.com.br> http://www.newsmade.com.br/
* @licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

require_once('../../includes/conection.php');
require_once('../../includes/jf.funcoes.php');

extract($_GET);

$sql = "SELECT * FROM ".PREFIXO.$tabela."_fotos WHERE ".$campo."='".$id."'";

$query = mysql_query($sql) or print mysql_error();
if(mysql_num_rows($query) < 1){
	?>
	<div class="mensagem"><span>Nenhuma foto encontrada</span></div>
	<?php
} else {

	if(isset($capa_campo)){
		$slt = mysql_fetch_assoc(mysql_query('select a.'.$capa_campo.', b.id
							from '.PREFIXO.$tabela.' a
							
							left join '.PREFIXO.$tabela.'_fotos b
							on b.id = a.'.$capa_campo.'
							
							where a.id = '.$id));
		
		if(empty($slt['id'])){
			$principal = mysql_fetch_assoc(mysql_query($sql.' order by RAND() limit 1'));
			
			jf_update(PREFIXO.$tabela, array($capa_campo => $principal['id']), array('id' => $id));
			$capa_foto = $principal['id'];
				
			echo '<div class="mensagem"><span>Foi selecionada aleatoriamente uma foto como principal. Para alterar basta posicionar o cursor em cima da foto desejada e clicar em  <img src="api/fotos/star_fav.png" alt="Marcar capa" /></span></div>';
		} else {
			$capa_foto = $slt['id'];
		}
	}
		

	while($dados = mysql_fetch_array($query)){
		$idFoto = $dados['id'];
		$file = "../../".$dir."/".$dados['foto'];
		
		?>
		<div class="galdiv" id="div<?php echo $idFoto?>">
			<div class="divblock">
				<a href="javascript: void(0)" idfoto="<?php echo $idFoto?>" arquivo="<?php echo $file?>" class="trash" title="Apagar Imagem"><img src="api/fotos/delete.png" alt="apagar" /></a>
			
			<?php 
			if(isset($capa_foto)){ 
				?>
				<a href="javascript: void(0)" idfoto="<?php echo $idFoto?>" class="favorite" title="Marcar como principa"><img src="api/fotos/star_fav.png" alt="Marcar capa" /></a>	
				<?php 
			} 
			?>
			</div>
			
			<a href="api/fotos/refotos.php?tabela=<?php echo $tabela?>&amp;dir=<?php echo $dir?>&amp;foto=<?php echo $idFoto?>" class="renomeiaFoto" title="editar">			
				<img src="includes/thumb.php?i=../<?php echo $dir?>/<?php echo $dados['foto']?>:70:60:c" class="img" />
			</a>
			
		</div>
		<?php
	}
	
	?>
	<script>
	$(function(){
		<?php
		if(isset($capa_foto)){
			?>
			capa = <?php echo (empty($capa_foto)? 0 : $capa_foto )?>;
			$('#div'+capa).css('background', '#fa0');
			
			$('.favorite').click(function(){
				var id = $(this).attr('idfoto');
				
				$().jfbox({carrega: 'api/fotos/firstimg.php?tabela=<?php echo $tabela?>&campo=<?php echo $capa_campo?>&fk=<?php echo $id?>&foto='+id, abreBox: false}, function(){
					$('#div'+capa).css('background', '#fff');			
					$('#div'+id).css('background', '#fa0');					
					capa = id;
				});
			});	
			<?
		}
		?>
	
		$(".renomeiaFoto").jfbox({width: 325, height: 270}); 
		
		$('.galdiv').bind({
			mouseenter :function(){
				($(this).children('.divblock')).show();
			},
			
			mouseleave :function(){
				($(this).children('.divblock')).fadeOut(150);
			}
		});
		
		$('.trash').click(function(){
			var id = $(this).attr('idfoto');
			
			$().jfbox({carrega: 'api/fotos/deletimg.php?tabela=<?php echo $tabela?>&id='+id+'&arquivo='+$(this).attr('arquivo'), abreBox: false}, function(){
				$('#div'+id).fadeOut(200);
			});
		});	
	});
	</script>
	<?php
}

?>	