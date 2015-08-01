<?php
if(!isset($_SESSION['Logado'])) {
	//	EFETUA LOGIN
	if( (!empty($_POST['usuario'])) AND (!empty($_POST['senha'])) ){
	
		$senha = md5($_POST['senha']."0800");
		$usuario = mLAntiInjection($_POST['usuario']);
		
		if(Login($usuario, $senha)){
			$DadosUser = mysql_query("SELECT * FROM ".SUFIXO."admin WHERE Login = '$usuario' AND Senha = '$senha'") or die(mysql_error());
			
			$DadosUser = mysql_fetch_array($DadosUser);
			
			$_SESSION['Logado'] = array(
									'id' => $DadosUser['id'],
									'nome' => $DadosUser['nome'],
									'tipo' => $DadosUser['tipo']
									);
		} else{
			$loginfalha = 1;
		}
	}
} else {
	switch(!empty($_GET['acao'])){
		case 'logout':
			unset($_SESSION['Logado']);
		break;
	}
}

$DadosLogado  = (isset($_SESSION['Logado'])? $_SESSION['Logado'] : '');


?>