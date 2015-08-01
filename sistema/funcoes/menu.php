<?php
function trazMenu($menu = 'a', $arvore = '0', $separador = '0'){
	$sql = "SELECT b.* FROM 
		".SUFIXO."menu as a
		
		left join ".SUFIXO."menu as b
		on a.id = b.categoria
		
		where a.idMe = '".$menu."' 
		";
	
	$cont = 1;	
	
	$separador = ($separador == 1? "<li class=\"separador\"><img src=\"".SISTEMA."/imagens/layout/blank.gif\" alt=\"\" /></li>" : "");
	
	if($arvore == 1){
		$qry = mysql_query($sql);

		while ($dados = mysql_fetch_array($qry)) {
			$nome = $dados['nome'];
			$id = $dados['id'];
			$link = $dados['link'];
			
			echo ($cont > 1? $separador : "");
			?>
				<li>
					<?php
					$arvor = mysql_query("SELECT * FROM ".SUFIXO."menu  where categoria = '$id'");
					if(mysql_num_rows($arvor) > 0){
						?><span><?=$nome?></span>
						<ul>
						<?php
						
						while ($dados = mysql_fetch_array($arvor)) { 
							$nome = $dados['nome'];
							$link = $dados['link'];
						?>	<li><a href="<?=$link?> "> <?=$nome?> </a></li>
						<?php
							
						}
						?></ul>	
						<?php					
					} else {
					?>	<li><a href="<?=$link?>"><?=$nome?></a></li>
					<?php
					}
					?>
					
				</li>
				<?php
			$cont++;
		}
	} else {
		$qry = mysql_query($sql." order by ordem Asc, Nome Asc");

		while ($dados = mysql_fetch_array($qry)) {
			$nome = $dados['nome'];
			$link = $dados['link'];
			$tipo = $dados['tipo'];
			$altena = ($cont%2 == 1? "class='alterna'": '');
			if(empty($tipo)){
				?>
				<li class="top"><?=$nome?></li>
				<?php
				
			} else {
			echo ($cont > 1? $separador: "");
				?>
				<li <?=$altena?>><a href="<?=$link?>"><?=$nome?></a></li>
				<?php
			}
			$cont++;
		}
	}
}
?>