<?php
include('../clases/auth.php');

$header='';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {//Este endpoint es solo de tipo GET
    //Se valida que los parámetros tengan información, de otro modo, se asigna vacío
    if (isset($_GET['searchLink'])) {
        $searchlink=$_GET['searchLink'];
    } else {
        $searchlink='';
    }
    if (isset($_GET['titulo'])) {
        $titulo=$_GET['titulo'];
    } else {
        $titulo='';
    }
    if (isset($_GET['descripcion'])) {
        $descripcion=$_GET['descripcion'];
    } else {
        $descripcion='';
    }
    //para ejecutar la consulta, alguno de los parámetros debe contener data
    //se validan los datos para la consulta
    if ($searchlink=='' || $titulo=='' ||  $descripcion!='') {
        $where="WHERE  anuncios.`descripcion` LIKE '%".$descripcion."%' ";
    }
    if ($searchlink=='' || $titulo!='' ||  $descripcion=='') {
        $where="WHERE  anuncios.`titulo` LIKE '%".$titulo."%' ";
    }
    if ($searchlink=='' || $titulo!='' ||  $descripcion!='') {
        $where="WHERE  anuncios.`titulo` LIKE '%".$titulo."%' or anuncios.descripcion LIKE '%".$descripcion."%' ";
    }

    if ($searchlink!='' || $titulo=='' ||  $descripcion=='') {
        $where="WHERE  categorias.searchlink LIKE '%".$searchlink."%' ";
    }

    if ($searchlink!='' || $titulo=='' ||  $descripcion!='') {
        $where="WHERE  categorias.searchlink LIKE '%".$searchlink."%' or anuncios.descripcion LIKE '%".$descripcion."%' ";
    }

    if ($searchlink!='' || $titulo!='' ||  $descripcion=='') {
        $where="WHERE categorias.searchlink LIKE '%".$searchlink."%' or anuncios.titulo LIKE '%".$titulo."%' ";
    }

    if ($searchlink!='' || $titulo!='' ||  $descripcion!='') {
        $where="WHERE categorias.searchlink LIKE '%".$searchlink."%' or anuncios.titulo LIKE '%".$titulo."%' and anuncios.descripcion LIKE '%".$descripcion."%' ";
    }

    if ($searchlink!='' || $titulo!='' ||  $descripcion!='') {
        $datos = new auth();
     
        $response= $datos->consultar("SELECT
    `categorias`.`descripcion`
    , `categorias`.`searchlink`
    , `anuncios`.`titulo`
    , `anuncios`.`descripcion`
FROM
    `rootstack`.`anuncios`
    INNER JOIN `rootstack`.`categorias` 
        ON (`anuncios`.`searchlink_id` = `categorias`.`searchlink`)
          ".$where."     
         ORDER BY anuncios.`titulo`ASC, anuncios.`descripcion`ASC");
    } else {
        $header="HTTP/1.1 422 Unprecessable Entity"; //en el caso de que se haga una petición diferente a post, se arroja este mensaje
        $data= array('response_code'=>'405','message'=>'Debe al menos haber un parámetro para la búsqueda, ya sea link de búsqueda,título o descripcion de anuncio.');
    }
} else {
     $header="HTTP/1.1 405 Method not supported"; //en el caso de que se haga una petición diferente a post, se arroja este mensaje
     $data= array('response_code'=>'405','message'=>'Method not allowed, Método no soportado para este endpoint.');
 }
header($header);
echo json_encode($response);
