<?php
require_once("../../../includes/conection.php"); 
require_once("../../includes/functions.php"); 
$id = $_GET['id'];
$del = "DELETE FROM ".SUFIXO."formularios_campos where id = '".$id."'";
mysql_query($del);
?>
<img src="" onerror="document.getElementById('campos_identificacao_<?=$id?>').value='';" alt="" class="imge"/>
<img src="" onerror="show_hide('campos_<?=$id?>')" alt="" class="imge"/>