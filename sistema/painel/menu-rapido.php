<?php
/**
*
* Plugin CMS
*
* @versão 4.1.8
* @Desenvolvedor Jeison Frasson <contato@newsmade.com.br>
* @entre em contato com o desenvolvedor <contato@newsmade.com.br> http://www.newsmade.com.br/
* @licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

header("Content-Type: text/html; charset=ISO-8859-1",true);
require_once("../includes/conection.php"); 
require_once("../includes/mLfunctions.php");

$caminho = 'painel/menu-rapido.php';

if(isset($_GET['d'])){
	mLdelete(PREFIXO.'start', array('idPlug' => $_GET['d']));
	?>
	<script>
	$().ready(function(){
		$('#appR-<?php echo $_GET['d']?>').remove();
	});
	</script>
	<?php
}
if(isset($_GET['a'])){
	mLinsert(PREFIXO.'start', array('idPlug' => $_GET['a']));
	
	$dados = mysql_fetch_array(mysql_query('select * 
						from plugin_plugins 
						where id = "'.$_GET['a'].'"
						limit 1'));
	?>
	<script>
	$().ready(function(){
		$('#appRapido').append('<li id="appR-<?php echo $_GET['a']?>"><a href="?plugin=<?php echo $dados['pasta']?>" title="<?php echo $dados['nome']?>"><img src="plugins/<?php echo $dados['pasta']?>/sys/ico.png" alt="" /></a></li>');
	});
	</script>
	<?php
}
?>

<h1>Acesso rápido</h1>

<h2>Na Barra</h2>
<div class="ARTem ARbox">
	<?php
	$query = mysql_query('select b.*
						from plugin_start a
						
						left join plugin_plugins b
						on b.id = a.idPlug
						order by b.nome');
	if(mysql_num_rows($query) > 0){
		while($dados = mysql_fetch_array($query)){
			?>
			<span class="app">
				<img src="plugins/<?php echo $dados['pasta']?>/sys/ico.png" alt="" />
				<a href="<?php echo $caminho.'?d='.$dados['id']?>" class="jfbox"><img src="imagens/icones/preto/round_delete.png"></a>
			</span>
			<?php
		}
		$bar = true;
	} else {
		echo "(vazia)";
		$bar = false;
	}
	?>
	<div class="both"></div>
</div>

<h2>Disponíveis</h2>
<div class="ARTem ARbox">
	<?php
	$query = mysql_query('select * 
						from plugin_plugins 
						where id not in((select idPlug from plugin_start))
						order by nome');
	if(mysql_num_rows($query) > 0){
		while($dados = mysql_fetch_array($query)){
			?>
			<span class="app">
				<img src="plugins/<?php echo $dados['pasta']?>/sys/ico.png" alt="" />
				<a href="<?php echo $caminho.'?a='.$dados['id']?>" class="jfbox"><img src="imagens/icones/preto/round_checkmark.png"></a>
			</span>
			<?php
		}
	} else {
		echo $bar == true ?'Todos aplicativos disponíveis já foram adcionados' : 'Você não possui aplicativos instalados';
	}
	?>
	<div class="both"></div>
</div>

<script>
$('.app').mouseover(function(){
	$(this).children('a').show();
}).mouseout(function(){
	$(this).children('a').hide();
});

$().ready(function(){
	$('.ARbox').corner('5px');
});
</script>