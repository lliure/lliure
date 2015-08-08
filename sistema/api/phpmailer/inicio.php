<?php
/**
*
* API PHP Mailer - Plugin WAP
*
* @Versão 4.7.1
* @Desenvolvedor Jeison Frasson <contato@grapestudio.com.br>
* @Entre em contato com o desenvolvedor <contato@grapestudio.com.br> http://www.grapestudio.com.br/
* @Licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

require_once("class.phpmailer.php");

if(!defined('ll_dir')){
	if(strstr(__DIR__ , '/'))
		$dir = explode('/', __DIR__);
	else 
		$dir = explode('\\', __DIR__);
		
	array_pop($dir);
	array_pop($dir);
	
	if(strstr(__DIR__ , '/'))
		$dir = implode('/', $dir).'/';
	else 
		$dir = implode('\\', $dir).'\\';
	
	define("ll_dir", $dir);
	}

function limpaMail($in){
	if(strstr($in, '<')){
		$in = str_replace(array(' <', '>'), array('<', ''), $in);
		$in = explode('<', $in);
		
		$out['mail'] = $in[1];
		$out['nome'] = $in[0];
	} else{
		$out['mail'] = $in;
		$out['nome'] = '';
	}
	
	return $out;
}


function pm_mail($destinatario = null, $assunto = null, $menssagem = null, $header = null){	
	$to = limpaMail($destinatario);
	
	if(($llconf = simplexml_load_file(ll_dir . 'etc/llconf.ll')) == false)
		$llconf = false;
		
	
	$mail = new PHPMailer();

	$mail->IsSMTP(); 
	$mail->Host = $llconf->smtp->host;	
		
	if(isset($llconf->smtp->autenticacao))
		$mail->SMTPAuth = (boolean) $llconf->smtp->autenticacao;	
	
	
	if(isset($llconf->smtp->porta))
		$mail->Port = (int) $llconf->smtp->porta;	
		
	/*
	//if(isset($llconf->smtp->seguranca))
		//$mail->SMTPSecure = $llconf->smtp->seguranca;	
	*/
	$mail->Username = $llconf->smtp->usuario;
	$mail->Password = $llconf->smtp->senha;
	

	// remetente
	
	if(isset($header['from'])) {
		$from = limpaMail($header['from']);
	} else {
		$from['mail'] = $llconf->smtp->usuario;
		$from['nome'] = '';
	}
	
	$mail->From = $from['mail']; // Seu e-mail
	$mail->FromName = $from['nome']; // Seu nome
	
	if(isset($header['replyTo'])){
		$reply = limpaMail($header['replyTo']);
		$mail->AddReplyTo($reply['mail'], $reply['nome']); 
	}
	

	// Define os destinatário(s)
	// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	$mail->AddAddress($to['mail'], $to['nome']);
	
	//$mail->AddAddress('ciclano@site.net');
	//$mail->AddCC('ciclano@site.net', 'Ciclano'); // Copia
	//$mail->AddBCC('fulano@dominio.com.br', 'Fulano da Silva'); // Cópia Oculta

	// Define os dados técnicos da Mensagem
	// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	$mail->IsHTML(true);


	// Define a mensagem (Texto e Assunto)
	// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	$mail->Subject  = $assunto; // Assunto da mensagem
	$mail->Body = $menssagem;

	$mail->AltBody = nl2br(strip_tags($menssagem));

	// Define os anexos (opcional)
	// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	//$mail->AddAttachment("c:/temp/documento.pdf", "novo_nome.pdf");  // Insere um anexo

	// Envia o e-mail
	$enviado = $mail->Send();

	// Limpa os destinatários e os anexos
	$mail->ClearAllRecipients();
	$mail->ClearAttachments();

	// Exibe uma mensagem de resultado
	if ($enviado) {
		return true;
	} else {
		return $mail->ErrorInfo;
	}

}
?>