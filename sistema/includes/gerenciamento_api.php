<?php/**** lliure WAP** @Vers�o 4.6.2* @Desenvolvedor Jeison Frasson <contato@grapestudio.com.br>* @Entre em contato com o desenvolvedor <contato@grapestudio.com.br> http://www.grapestudio.com.br/* @Licen�a http://opensource.org/licenses/gpl-license.php GNU Public License**/class api {	public $css;	public $js;		public function iniciaApi($var){		require_once('api/'.$var.'/inicio.php');	}		function setVar($var, $hash){		if(!empty($this->$var))			$this->$var .= "\n";				switch($var){			case 'css':				$this->$var .= '<link rel="stylesheet" type="text/css" href="api/'.$hash.'" />';			break;						case 'js':				$this->$var .= '<script type="text/javascript" src="api/'.$hash.'"></script>';			break;		}	}}$apigem = new api; $apigem->iniciaApi('jfnav');$apigem->setVar('css', 'jfnav/estilo.css');// $apigem->setVar('js', 'jfnav/jfnav.js');$apigem->iniciaApi('appbar');$apigem->setVar('css', 'appbar/estilo.css');$apigem->iniciaApi('fileup');$apigem->setVar('css', 'fileup/estilo.css');?>