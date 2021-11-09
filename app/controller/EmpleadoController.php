<?php
require_once './model/Empleado.php';

class EmpleadoController{

    public function CrearEmpleado($request, $response, $args){
        /*Voy a validar en el MDW
        - que existan todos los datos
        - que el usuario aun no este registrado
        - que el sector sea valido
        */
        
        $parametros = $request->getParsedBody();
        $empleado = new Empleado();
        $empleado->usuario = $parametros['usuario'];
        $empleado->clave = $parametros['clave'];
        $empleado->estado = $parametros['estado'];
        $empleado->sector = $parametros['sector'];

        try{
            $empleado->InsertarEmpleado();
            $payload = json_encode(array("mensaje" => $empleado));
        }
        catch(Exception $e){
            $payload = json_encode(array("Error" => $e));
        }

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function ListarEmpleados($request, $response, $args){
        
        try{
            $empleados = Empleado::ConsultarEmpleados();
            $payload = json_encode(array("empleados" => $empleados));
        }
        catch(Exception $e){
            $payload = json_encode(array("Error" => $e));
        }        

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function ObtenerEmpleado($request, $response, $args){

        $usuarioEmpleado = $args['usuario'];

        try{
            $empleado = Empleado::ConsultarEmpleado($usuarioEmpleado);
            if($empleado){
                $payload = json_encode($empleado);
            }
            else{
                $payload = json_encode(array("Usuario $usuarioEmpleado no existe"));
            }
        }
        catch(Exception $e){
            $payload = json_encode(array("Error" => $e));
        }

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
}
?>