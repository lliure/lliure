<?php
$idCat = $_GET['noticias'];
$consulta = mysql_fetch_array(mysql_query("select titulo from ".SUFIXO."noticias_categorias where id = '".$idCat."'"));
?>
<h1><?=$consulta['0']?></h1>

<?php
if(!isset($_GET['id'])){
	$consulta = "select * from ".SUFIXO."noticias where categoria = '".$idCat."'";
	$query = mysql_query($consulta);
	$tr = mysql_num_rows($query); 
	?>

	<div class="Noticias">
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
			
			while($dados = mysql_fetch_array($limite)){
				$titulo = $dados['titulo'];
				?>
				<div class="noticias">
					<span class="titulo"><a href="?noticias=1&id=<?=$dados['id']?>"><?=$dados['titulo']?></a></span>
					<div class="texto">
					<?=mLsubstrFull($dados['texto'], 300)?>
					<span class="vejamais"><a href="?noticias=1&id=<?=$dados['id']?>">[Leia mais]</a></span>
					</div>
				</div>
				<?php		
			} 
			
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
			?>
			<span class="mensagem"><span>Nenhuma noticia encontrada</span></span>
			<?php
		}
	?>
	</div>
	<?php
} else {
	$consultaNoticias = "SELECT * FROM ".SUFIXO."noticias order by id desc limit 1";
	$dadosNoticias = mysql_fetch_array(mysql_query($consultaNoticias));
	?>
	<div class="noticias">
		<span class="titulo"><?=$dadosNoticias['titulo']?></span>
		<div class="texto">
		<?=$dadosNoticias['texto']?>
		</div>
	</div>
	<?php
	$consulta = "select * from ".SUFIXO."pictures where  idPag = 'pa".$dadosNoticias['id']."'";

	$query = mysql_query($consulta);

	if(mysql_num_rows($query) > 0){ ?>
		<div class="galfotos">
		<?php
		while($dados = mysql_fetch_array($query)){
			$foto = $dados['foto'];
			$descricao = $dados['descricao'];
			?>
			<span class="foto">
				<a href="../uploads/fotos/<?=$foto?>" rel="lightbox[0]" title="<?=$descricao?>">
					<img src="<?=SISTEMA?>/includes/thumbs.php?imagem=150-../../uploads/fotos/<?=$foto?>-100" alt="" />
				</a>
			</span>
			<?php
		}	 ?>
		</div>
		<?php
	}
}
?>