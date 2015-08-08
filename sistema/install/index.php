<?php
	$conection = "../includes/conection.php";
	require_once($conection);
	if(@mysql_select_db("$banco_conexao", $conexao) == true){
		$_GET['passo'] = (isset($_GET['passo'])?$_GET['passo']:'bases');
	} else {
		unset($_GET['passo']);
	}
?>
<html>
<style type="text/css" media="screen">
	@import "css.css";
</style>

<body>
	<div class="body">	
		<div class="margin">
			<div class="top">
				<h1>Intalação Sistema Plugin</h1>
			</div>
			
			<div class="pass">
				<h2>Passos:</h2>
			</div>
			
			<div class="inter">
			<?php
			if(isset($_GET['passo'])){
				require_once($_GET['passo'].".php");
			} else {
				require_once("home.php");
			}
			?>
			</div>
	</div>
	</div>
</body>
</html>