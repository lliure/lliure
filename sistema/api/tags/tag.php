<?php
/**
*
* tags - lliure
*
* @Versão 1.0
* @Desenvolvedor Rodrigo Dechen <rodrigo@lliure.com.br>
* @Entre em contato com o desenvolvedor <rodrigo@lliure.com.br>
* @Licença http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

header ('Content-type: text/html; charset=ISO-8859-1');

define('BASEPATH', realpath(dirname(__FILE__). '/../../'));

require_once BASEPATH. '/etc/bdconf.php';
require_once BASEPATH. '/includes/functions.php';
require_once 'inicio.php';

$dados = rawurldecode($_GET['d']);
$dados = jf_decode($_SESSION['logado']['token'], $dados);
$dados = unserialize($dados);

//function processo($r){
//    $d = array();
//    $p = 0;
//    while($l = mysql_fetch_assoc($r)){
//        foreach ($l as $key => $value)
//            $d[$p][$key] = rawurlencode($value);
//        $p++;
//    }
//    return $d;
//}
//
//while (true){
//    
//    switch ($_GET['tag']){
//
//        case 'get':
//
//            if(!isset($dados['buscaTable']))
//                $r = 'SELECT id, '. $dados['campoDeTag']. ' as tag FROM '. $dados['tabela']. ' WHERE '. $dados['campoDeLigacao']. '="'. $dados['idDeLigacao']. '"';
//            
//            else
//                $r = 'SELECT a.id, b.'. $dados['buscaTableTag']. ' as tag FROM '. $dados['tabela']. ' a LEFT JOIN '. $dados['buscaTable']. ' b ON a.'. $dados['campoDeTag']. ' = b.'. $dados['buscaTableId']. ' WHERE a.'. $dados['campoDeLigacao']. '="'. $dados['idDeLigacao']. '"';
//            
//            //echo '<pre>'. $r. '</pre>';
//            
//            $r = mysql_query($r);
//                
//            $d = processo($r);
//
//            echo json_encode($d);
//
//        break;
//
//        case 'query':
//            
//            //echo '<pre>'. print_r($dados, true). '</pre>';
//            
//            if(!isset($dados['buscaTable']))
//                $r = ('SELECT id, '. $dados['campoDeTag']. ' as tag FROM '. $dados['tabela']. ' WHERE '. $dados['campoDeLigacao']. ' not in(SELECT id FROM '. $dados['tabela']. ' WHERE '. $dados['campoDeLigacao']. '="'. $dados['idDeLigacao']. '") and '. $dados['campoDeTag']. ' LIKE "%'. jf_anti_injection($_GET['query']).'%"');
//            
//            else
//                $r = ('SELECT '. $dados['buscaTableId']. ' as id, '. $dados['buscaTableTag']. ' as tag FROM '. $dados['buscaTable']. ' WHERE '. $dados['buscaTableId']. ' not in(SELECT '. $dados['campoDeTag']. ' FROM '. $dados['tabela']. ' WHERE '. $dados['campoDeLigacao']. '="'. $dados['idDeLigacao']. '" GROUP BY '. $dados['campoDeTag']. ') and '. $dados['buscaTableTag']. ' LIKE "%'. jf_anti_injection($_GET['query']).'%"');
//
//            //echo '<pre>'. $r. '</pre>';
//            
//            $r = mysql_query($r);
//                
//            $d = processo($r);
//
//            echo json_encode($d);
//
//        break;
//
//        case 'del':
//
//            jf_delete($dados['tabela'], array('id' => jf_anti_injection($_GET['del'])));
//
//            $_GET['tag'] = 'get';
//            
//        continue 2;
//
//        case 'set':
//
//            if(!isset($dados['buscaTable'])){
//                jf_insert($dados['tabela'], array($dados['campoDeLigacao'] => $dados['idDeLigacao'], $dados['campoDeTag'] => $_GET['set']));
//            
//            }else{
//                
//                if (isset($_GET['id']) && $_GET['id'] != NULL){
//                    jf_insert($dados['tabela'], array($dados['campoDeLigacao'] => $dados['idDeLigacao'], $dados['campoDeTag'] => $_GET['id']));
//                    
//                }else{
//                    jf_insert($dados['buscaTable'], array($dados['buscaTableTag'] => $_GET['set']));
//                    jf_insert($dados['tabela'], array($dados['campoDeLigacao'] => $dados['idDeLigacao'], $dados['campoDeTag'] => mysql_insert_id()));
//                    
//                }
//                
//            }
//
//            $_GET['tag'] = 'get';
//            
//        continue 2;
//
//    }
//    
//    break;
//}


class tag_server extends tag_abstract{

    public function get() {
        
        global $dados;

        if(!isset($dados['buscaTable']))
            $r = 'SELECT id, '. $dados['campoDeTag']. ' as tag FROM '. $dados['tabela']. ' WHERE '. $dados['campoDeLigacao']. '="'. $dados['idDeLigacao']. '"';

        else
            $r = 'SELECT a.id, b.'. $dados['buscaTableTag']. ' as tag FROM '. $dados['tabela']. ' a LEFT JOIN '. $dados['buscaTable']. ' b ON a.'. $dados['campoDeTag']. ' = b.'. $dados['buscaTableId']. ' WHERE a.'. $dados['campoDeLigacao']. '="'. $dados['idDeLigacao']. '"';

        $r = mysql_query($r);
        $row = array();
        while($row[] = mysql_fetch_assoc($r) || array_pop($row));
        return $row;
        
    }

    public function query() {
        
        global $dados;
        
        if(!isset($dados['buscaTable']))
            $r = ('SELECT id, '. $dados['campoDeTag']. ' as tag FROM '. $dados['tabela']. ' WHERE '. $dados['campoDeLigacao']. ' not in(SELECT id FROM '. $dados['tabela']. ' WHERE '. $dados['campoDeLigacao']. '="'. $dados['idDeLigacao']. '") and '. $dados['campoDeTag']. ' LIKE "%'. jf_anti_injection($_GET['query']).'%"');

        else
            $r = ('SELECT '. $dados['buscaTableId']. ' as id, '. $dados['buscaTableTag']. ' as tag FROM '. $dados['buscaTable']. ' WHERE '. $dados['buscaTableId']. ' not in(SELECT '. $dados['campoDeTag']. ' FROM '. $dados['tabela']. ' WHERE '. $dados['campoDeLigacao']. '="'. $dados['idDeLigacao']. '" GROUP BY '. $dados['campoDeTag']. ') and '. $dados['buscaTableTag']. ' LIKE "%'. jf_anti_injection($_GET['query']).'%"');

        $r = mysql_query($r);
        $row = array();
        while($row[] = mysql_fetch_assoc($r) || array_pop($row));
        return $row;
        
    }
    
    public function del() {
        
        global $dados;

        if(($erro = jf_delete($dados['tabela'], array('id' => jf_anti_injection($_GET['del'])))))
            return array('erro' => $erro);
        
        return 'ok';
        
    }

    public function set() {
        
        global $dados;

        if(!isset($dados['buscaTable'])){
            if(($erro = jf_insert($dados['tabela'], array($dados['campoDeLigacao'] => $dados['idDeLigacao'], $dados['campoDeTag'] => $_GET['set']))))
                return array('erro' => $erro);

        }else{

            if (isset($_GET['id']) && $_GET['id'] != NULL){
                if(($erro = jf_insert($dados['tabela'], array($dados['campoDeLigacao'] => $dados['idDeLigacao'], $dados['campoDeTag'] => $_GET['id']))))
                    return array('erro' => $erro);

            }else{
                if(
                    ($erro = jf_insert($dados['buscaTable'], array($dados['buscaTableTag'] => $_GET['set']))) ||
                    ($erro = jf_insert($dados['tabela'], array($dados['campoDeLigacao'] => $dados['idDeLigacao'], $dados['campoDeTag'] => mysql_insert_id())))
                )
                    return array('erro' => $erro);
            }

        }
        
        return 'ok';
        
    }
    
    public function rum($obj){
        parent::rum(__CLASS__);
    }

}

//tag_server::rum();