<?php
 include('../clases/webScrap.php');
 //se instancia la clase auth
 $datos = new webScrap();
 $response= $datos->consultar("SELECT searchlink FROM categorias ORDER BY id ASC ");//se consultan los links de búsqueda para pasarlos al método de web scraping y luego pasarlos a la BD
 //se borra la tabla de anuncios
 $datos->crud('DELETE FROM anuncios');
 foreach ($response as  $value) {
 	$response= $datos->extractAnuncios(trim($value['searchlink'],'/')); //Se hace web scraping de los anuncios y se guarda en la base de datos
 }

 echo $response;

?>        
