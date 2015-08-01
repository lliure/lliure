<?php 
	require_once("../includes/conection.php"); 
	require_once("includes/functions.php"); 
	require_once("includes/acoes.php"); 
	
	if(!empty($_GET)){
		$keyGet = array_keys($_GET);
		if($keyGet['0'] == 'plugin' and $_GET['plugin']){
			$pageatual = '?'.$_SERVER['QUERY_STRING'];
			
			if(isset($_SESSION['historicoNav'])){
				if(isset($_GET['goback'])){
					array_pop($_SESSION['historicoNav']);
				} elseif(isset($keyGet[1])){
					if(in_array($pageatual, $_SESSION['historicoNav']) == false){
						$_SESSION['historicoNav'][] = $pageatual;
					}
				} else {
					unset($_SESSION['historicoNav']);
					$_SESSION['historicoNav'][0] = $pageatual;
				}
				
				$historico = $_SESSION['historicoNav'];				
			} else {
				$_SESSION['historicoNav'][0] = $pageatual;
				$historico = $_SESSION['historicoNav'];
			}
			
		retornaLink($historico);
		}
	} else{
		if(isset($_SESSION['historicoNav'])){
			unset($_SESSION['historicoNav']);
		}		
	}
	

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	
	<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript" src="js/funcoes.js"></script>
	<script type="text/javascript" src="js/javaNavigator.js"></script>
	
<title>Plugin site manager</title>

<style type="text/css" media="screen">
	@import "css/base.css";
	@import "css/principal.css";
	@import "css/paginas.css";
	@import "css/predifinidos.css";
</style>


</head>

<body onkeyup="disparaPorTec(event)">
<div id="tudo">
	<div id="topo">
		<div class="left">
			<a href="index.php"><img src="imagens/layout/logo.png" /></a>
		</div>
		<?php
		if(!empty($DadosLogado)){ ?>
		<div class="right">
			<ul class="menu">
				<li><a href="index.php">Home</a></li>
				<li><a href="?usuarios">Usuarios</a></li>
			<?php
			if($DadosLogado['tipo'] == 1){ 
				?>
				<li><a href="?plugin">Plugins</a></li>
				<?php
			}
			?>
				<li><a href="?acao=logout">Sair</a></li>
			</ul>
			<?php 
			
			if($DadosLogado['tipo'] == 1){
				?>
				<ul class="start">
				<?php
					$consulta = "select a.idPlug, b.pasta, b.nome from 
						".SUFIXO."start as a
						
						left join ".SUFIXO."plugins as b
						on a.idPlug = b.id
					";
					$query = mysql_query($consulta);
					
					if(mysql_num_rows($query) > 0){
						while($dados = mysql_fetch_array($query)){
						$folder= $dados['pasta'];
						?>
						<li>
							<a href="?plugin=<?=$folder?>" title="<?=$dados['nome']?>">
								<img src="plugins/<?=$folder?>/ico.png" alt="" />
							</a>
						</li>
						<?php
						}
					} ?>
					
				</ul>
				<?php
				if(!empty($_GET)){
					$keyGet = array_keys($_GET);
					if($keyGet['0'] == 'plugin' and  !empty($_GET['plugin'])){
					?>
				<a href="javascript: void(0);" onclick="mLExectAjax('includes/desktop.php');" class="desktop" title="adicionar essa página ao descktop"><img src="imagens/layout/adddesktop.png" alt="" /></a>
					<?php 
					}
				} 
			} 
		?>
		</div>
		<?php	
		}
		?>
	</div>

	<div id="conteudo">
		<div class="marding">
			<?php require_once(requirePage()); ?>
			<div class="both"></div>
		</div>
	</div>
	
	<div id="rodape">
		<span class="desenvolvidopor">
			<a href="http://www.newsmade.com.br">Desenvolvido por Newsmade</a>
		</span>
	</div>

</div> 

</body>

</html>