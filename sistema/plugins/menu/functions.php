<?php
function autoIncrementLetter($atual = 0){
	$letras = array('0','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
	
	$posit = array_flip($letras);
	$posit = $posit[$atual];
	
	$posit += 1;
	return $letras[$posit];
}
?>