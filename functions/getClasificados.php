<?php
 include('../clases/auth.php');
 //se instancia la clase auth
 $datos = new auth();
 //Se obtienen las subcategorias de la base de datos
 $response= $datos->consultar("SELECT titulo,descripcion FROM anuncios WHERE searchlink_id = '$_GET[id]' ORDER BY descripcion ASC");//se corre la consulta
 echo json_encode($response);//se obtiene la respuesta en formato JSON

 //consulta para ver los anuncios

?>        
