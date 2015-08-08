<?php
header("Content-Type: text/html; charset=ISO-8859-1",true);
require_once("../../includes/conection.php"); 
require_once("../../includes/mLfunctions.php"); 

$tabelaAtu = PREFIXO.$_GET['tabela']."_fotos";
$retorno = $_GET['retorno'];

if(!empty($_POST)){
	$_POST =  jf_iconv('UTF-8', 'ISO-8859-1', $_POST);

	$campos['descricao'] = $_POST['descricao'];
	$alter['id'] = $_GET['foto'];
	
	mLupdate($tabelaAtu, $campos, $alter);
	?>
	Descrição alterada com sucesso!
	<script type="text/javascript">
		$(document).ready(function() {
			setTimeout("fechaJfbox()", 500);
			
		});
	</script>
	<?php
} else {
	$sql = "SELECT * FROM ".$tabelaAtu." WHERE id='".$_GET['foto']."'";
	$dados = mysql_fetch_array(mysql_query($sql));
	$foto = $dados['foto'];
	$nome = (!empty($dados['descricao'])?$dados['descricao']:"");

	$dir = $_GET['dir']."/";
	?>	
	<div style="width: 320px;">
		<img src="includes/thumb.php?i=../<?php echo $dir.$foto?>:325:200:c" />
		
		<form method="post" class="form jfbox" action="api/fotos/refotos.php?tabela=<?php echo $_GET['tabela']?>&amp;foto=<?php echo $_GET['foto']?>">
			<div>
				<input type="text" name="descricao" value="<?php echo $nome?>">
			</div>
			<span class="botao"><button type="submit">vai</button></span>
		</form>
	</div>
	<?php
}
?>