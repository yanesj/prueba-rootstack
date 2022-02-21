<?php
 include('../clases/auth.php');
 //se instancia la clase auth
 $datos = new auth();
 //Se obtienen las subcategorias de la base de datos
 $response= $datos->consultar("SELECT subcategorias.descripcion FROM subcategorias JOIN categorias ON(categorias.`id_categoria`=subcategorias.`categoria_id`)
WHERE subcategorias.`categoria_id`='$_GET[id]'
ORDER BY subcategorias.`descripcion` ASC");//se corre la consulta
 echo json_encode($response);//se obtiene la respuesta en formato JSON

 //consulta para ver los anuncios

?>        
