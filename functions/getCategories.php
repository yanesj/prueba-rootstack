<?php
 include('../clases/auth.php');
 //Se obtienen las categorías guardadas en la base de datos
 $datos = new auth();
 $response= $datos->consultar("SELECT id_categoria,descripcion,searchlink FROM categorias ORDER BY descripcion ASC");
 echo json_encode($response);

?>        
