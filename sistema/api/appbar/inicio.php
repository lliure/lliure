<?php/**** lliure WAP** @Vers�o 5.0* @Desenvolvedor Jeison Frasson <jomadee@lliure.com.br>* @Entre em contato com o desenvolvedor <jomadee@lliure.com.br> http://www.lliure.com.br/* @Licen�a http://opensource.org/licenses/gpl-license.php GNU Public License**/// 	GERA A BARRA DOS APLICATIVOSfunction app_bar($nome, $botoes){	$return = '<div id="appBar">				<div class="appBar_inter">					<h1>'.$nome.'</h1> <div class="botoes">';		if(!empty($botoes))		foreach($botoes as $chave => $valor)			$return .= '<a href="'.$valor['href'].'" title="'.$valor['title'].'" '.(isset($valor['attr']) ? $valor['attr'] : '').'><img src="'.$valor['img'].'" alt=""/>'.$valor['title'].'</a>  ';		$return .= '</div><div class="both"></div> </div> </div>';			return $return;}function app_bar_add($valor = null){	$return = "<a href='".$valor['href']."' title='".$valor['title']."' ".(isset($valor['attr']) ? $valor['attr'] : "")."><img src='".$valor['img']."' alt=''/>".$valor['title']."</a>";		return 	 '<script type="text/javascript">				$("#appBar .appBar_inter .botoes").append("'.$return.'");			  </script>';}?>