session_start();
$hostname_conexao = ".localhost.";
$username_conexao = ".root.";
$password_conexao = ".senha.";
$banco_conexao = ".banco.";  

define("PREFIXO", ".prefixo.");
define("SISTEMA", "sistema");


$conexao = mysql_connect($hostname_conexao, $username_conexao, $password_conexao) or die("Site em manuten��o");
	
mysql_select_db($banco_conexao, $conexao);

$DadosLogado  = (isset($_SESSION['logado'])? $_SESSION['logado'] : '');