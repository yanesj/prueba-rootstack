<?php
 include('../clases/webScrap.php');
  //Se llena la base de datos luego de hacer el scraping
 $webScrap= new webScrap();
 $response= $webScrap->extractCatSubCat('https://www.milanuncios.com/');

  //se instancia la clase auth

 $response= $webScrap->consultar("SELECT searchlink FROM categorias ORDER BY id ASC ");//se consultan los links de búsqueda para pasarlos al método de web scraping y luego pasarlos a la BD

 //se borra la tabla de anuncios
 $webScrap->crud('DELETE FROM anuncios');
 foreach ($response as  $value) {
     if(isset($value['searchlink'])){
 	   $response= $webScrap->extractAnuncios(trim($value['searchlink'],'/')); //Se hace web scraping de los anuncios y se guarda en la base de datos
     }
 }

echo $response;

?>