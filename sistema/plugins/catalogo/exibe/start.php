<?php
if (isset($_GET['cat'])) {
	include('categoria.php');
} elseif (isset($_GET['prod'])) {
	include('produto.php');
} elseif(isset($_GET['carrinho'])){
	include('carrinho.php');
}
?>