<?php
session_start();
/* TLClass
 * Um Framework para desenvolvimento PHP 
 * Por: Luciano Zangeronimo
 * 2017
 */

$raiz = $_SERVER['DOCUMENT_ROOT'];
$raiz_src = $raiz;

//Includes da plataforma
include_once $raiz . "/_System/Others/pagging.php";
include_once $raiz . "/_System/Start.php";
include_once $raiz . "/_System/TLClass.php";
include_once $raiz . "/_System/ClasseDoMomento.php";

include_once $raiz . "/vendor/auth/token.php";
$api = new token();

include_once $raiz . '/source/comum.php';
$comum = new comum();

//Redireciona para página inicial
//if($_SERVER['REQUEST_URI']=='/') {
//	header("Location: /home");
//	exit;
//}

//Instancio o motor do framework
new Start();
?>