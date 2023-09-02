<?php
header('Content-Type: application/xml; charset=utf-8');
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
include_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/auth/token.php';
$api = new token();
$produtos = $api->get("/web/produto");
if(count($produtos)>0) {
	foreach($produtos as $values) {
		echo "<url><loc>https://www.agrovr.com.br/produtos/".$values['codigo']."/".preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $values['url'])."</loc></url>";
	}
}
$servicos = $api->get("/web/servico");
if(count($servicos)>0) {
	foreach($servicos as $values) {
		echo "<url><loc>https://www.agrovr.com.br/servicos/".$values['codigo']."/".preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $values['url'])."</loc></url>";
	}
}
$galerias = $api->get("/web/album");
if(count($galerias)>0) {
	foreach($galerias as $values) {
		echo "<url><loc>https://www.agrovr.com.br/galerias/".$values['codigo']."/".preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $values['desc'])."</loc></url>";
	}
}
$anuncios = $api->get("/web/anuncio");
if(count($anuncios)>0) {
	foreach($anuncios as $values) {
		echo "<url><loc>https://www.agrovr.com.br/anuncios/".$values['codigo']."/".preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $values['desc'])."</loc></url>";
	}
}
$artigos = $api->get("/web/artigo");
if(count($artigos)>0) {
	foreach($artigos as $values) {
		echo "<url><loc>https://www.agrovr.com.br/artigos/".$values['codigo']."/".preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $values['url'])."</loc></url>";
	}
}
echo "</urlset>";
?>
 