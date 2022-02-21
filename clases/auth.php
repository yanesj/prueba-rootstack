<?php
/*Esta clase es para manejar las autenticaciones y cruds hacia la base de datos*/
include('conexion.php');//Se incluyen los parámetro de conexión

class auth
{
    protected $bd;
    protected $msg;

    public function login($email, $pass)//función para autenticar a un usuario
    {
  
        $pwd=md5($pass);//password cirado en md5
        $query = "SELECT name,last_name FROM users WHERE email = '$email' AND PASSWORD = '$pwd' "; //consulta hacia la BD
        $row= $this->consultar($query);
  
        return $row;
    }

    public function consultar($query)//Método para consultar en la base de datos
    {
        include('../params/params.php');
        $this->bd= new conexion($server, $user, $password, $db, $port);
        $link=$this->bd->conectar();


        $resultado = $link->query($query);
        if ($resultado) {
            if ($resultado->num_rows>0) {
                $i=0;
                while ($row = $resultado->fetch_assoc()) {
                    $this->msg[]=$row;
                    $i++;
                }
                $this->msg[$i-1]['code_response']='00'; //respuesta en caso de que haya tuplas asociadas
            } else {
                $this->msg[0]['code_response']='01'; //respuesta en caso de que no haya tuplas asociadas
            }
        }
        else{
           $this->msg[0]['code_response']=$link->error;//En el caso de que haya un error a nivel de la consulta o el motor
        }
        $this->bd->desconectar();
        return $this->msg; //Se retorna un array con la respuesta obtenida
    }

    public function crud($query)//Metodo para hacer crud en la base de datos
    {
        include('../params/params.php');
        $this->bd= new conexion($server, $user, $password, $db, $port);
        $link=$this->bd->conectar();

        $resultado = $link->query($query);
        if ($resultado) {//si no hay errores todo ok
            $this->msg[0]['code_response']='00';
        } else {
            $this->msg[0]['code_response']=$link->error; //se captura el error en caso de haber alguno
        }
        $this->bd->desconectar();
        return $this->msg;
    }



}
?> 