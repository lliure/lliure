$hostname_conexao = ".localhost.";
$username_conexao = ".root.";
$password_conexao = ".senha.";
$banco_conexao = ".banco.";  

define("PREFIXO", ".prefixo.");
define("SISTEMA", "sistema");

session_name($banco_conexao);
session_start();

$conexao = @mysql_connect($hostname_conexao, $username_conexao, $password_conexao) or die("<strong>N�o foi possivel realizar a conex�o com banco de dados</strong><br>verifique as configura��es do arquivo bdconf.php em /etc");
	
mysql_select_db($banco_conexao, $conexao);

$DadosLogado  = (isset($_SESSION['logado'])? $_SESSION['logado'] : '');
