<?php/**** Plugin CMS** @vers�o 4.2.7* @Desenvolvedor Jeison Frasson <contato@newsmade.com.br>* @entre em contato com o desenvolvedor <contato@newsmade.com.br> http://www.newsmade.com.br/* @licen�a http://opensource.org/licenses/gpl-license.php GNU Public License**/// 	GERA A BARRA DOS APLICATIVOSfunction app_bar($nome, $botoes){	$return = '<div id="appBar"> <h1>'.$nome.'</h1> <div class="botoes">';		if(!empty($botoes))		foreach($botoes as $chave => $valor)			$return .= '<a href="'.$valor['href'].'" title="'.$valor['title'].'" '.(isset($valor['attr']) ? $valor['attr'] : '').'><img src="'.$valor['img'].'" alt=""/>'.$valor['title'].'</a>  ';		$return .= '</div> </div>';			return $return;}?>