<?php
 include('../clases/auth.php');
 $user= new auth();
 $x= $user->insertar("INSERT INTO categorias (descripcion,id_categoria)VALUES('Motores',1)");
 var_dump($x);
?>
