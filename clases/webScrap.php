<?php
   include('auth.php');
   //La clase webscrap es la encargada de gestionar el scraping a la página web
   class webScrap extends auth //Se extiende a la clase auth para heredar sus métodos
   {
       protected $url;
       protected $message;
    
   
       public function extractCatSubCat($url) //Este médoto es el que se utiliza para hacer el webscraping
       {
           //se borran las tablas de categoría y subcategoría
           $this->crud("DELETE FROM categorias");
           $this->crud("DELETE FROM subcategorias");

           //Se recibe la URL por parámetro
           $url = file_get_contents($url);

           


         
           //creamos nuevo DOMDocument y cargamos la url
           $dom = new \DOMDocument();
           @$dom->loadHTML($url);
           $xpath = new \DomXPath($dom);
           //Se hace la consulta en estos nodos para sacar las categorías con sus ID's
           $nodes = $xpath->query('//div[@class="ma-CategoriesContainer-list"]//div[@class="ma-CategoriesCategory"]//a[@class="ma-MainCategory-mainCategoryNameLink"]');

           //Lista de categorias
           foreach ($nodes as $categoryList) {
               $id=$categoryList->getAttribute('data-test-maincategory-namelink');//Este es el id de cada categoría
               $searchLink=trim($categoryList->getAttribute('href'),'/');//Este es el link de búsqueda para aunicios
               //Se insertan las categorías

               $msn= $this->crud("INSERT INTO categorias (descripcion,id_categoria,searchlink)VALUES('".utf8_decode($categoryList->nodeValue)."',".$id.",'".$searchLink."')");
               if ($msn[0]['code_response']=='00') {//Si todo sale sin errores
                   $this->message ='Proceso generado con éxito';
               } else {
                   $this->message =$msn[0]['code_response'];//en caso de error, se lanza el tipo de error y se detiene el proceso
                   return $this->message;
                   exit();
               }
               //Se hace la consulta en estos nodos, para sacar las subcategorías a cada categoría asociada
               $nodes2 = $xpath->query('//div[@class="ma-CategoriesContainer-list"]//div[@data-test-categoriescategory='.$id.']//nav//ol//li//a');
               foreach ($nodes2 as $subcategory) {
                   //Se insertan las subcategorías
                   $msn=$this->crud("INSERT INTO subcategorias (descripcion,categoria_id)VALUES('".utf8_decode($subcategory->nodeValue)."',".$id.")");
                   if ($msn[0]['code_response']=='00') {
                       $this->message ='Proceso generado con éxito';
                   } else {
                       $this->message =$msn[0]['code_response'];
                       return $this->message;
                       exit();
                   }
               }
           }
           return $this->message;
       }

       public function extractAnuncios($nomCategoria)
       {
        
          //Se recibe la URL por parámetro
           $url = file_get_contents('https://www.milanuncios.com/'.$nomCategoria);
           //creamos nuevo DOMDocument y cargamos la url
           $dom = new \DOMDocument();
           @$dom->loadHTML($url);
           $xpath = new \DomXPath($dom);

           //se obtienen los títulos de los anuncios
           $titulos= $xpath->query('//div[@class="ma-AdList"]//div[@class="ma-AdCard-body"]//div[@class="ma-AdCard-title"]//a[@class="ma-AdCard-titleLink"]');
           $vector=array();
           foreach ($titulos as $value) {
               array_push($vector, utf8_decode($value->nodeValue));
           }
           $vector = array_unique($vector);
      
   
        
           //Se obtiene la descripción de los anuncios
           $vector2=array();
           $descripciones =  $xpath->query('//div[@class="ma-AdList"]//div[@class="ma-AdCard-body"]//div[@class="ma-AdCardDescription"]//p[@data-testid="AD_CARD_DESCRIPTION"]');
           foreach ($descripciones as $value) {
               array_push($vector2, utf8_decode($value->nodeValue));
           }
         

           //se insertan los anuncios en la tabla de anuncios
           $i=0;
    
           //En este bucle, se inserta la información de la tabla anuncios

           while ($i<sizeof($vector)) {
               if (isset($vector[$i])) {
                   $titulo=$vector[$i];
               }
               else{
                $titulo=$vector[$i+1];
               }
               $descripcion=$vector2[$i];
          
               // echo $i;
                
               $msn= $this->crud("INSERT INTO anuncios (searchlink_id,titulo,descripcion)VALUES('".$nomCategoria."','".$titulo."','".$descripcion."')");
               if ($msn[0]['code_response']=='00') {//Si todo sale sin errores
                   $this->message ='Proceso generado con éxito';
               } else {
                   $this->message =$msn[0]['code_response'];//en caso de error, se lanza el tipo de error y se detiene el proceso
                   return $this->message;
                   exit();
               }
               $i++;
           }
           return $this->message;
       }
   }
