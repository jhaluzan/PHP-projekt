<?php
	session_start();
	
	unset($_POST);
	unset($_SESSION['korisnik']);

    $_SESSION['korisnik']['valid'] = 'false';
	$_SESSION['message'] = '<p>Uspješno ste odjavljeni!</p>';
	
	header("Location: index.php?menu=7");
	exit;
?>