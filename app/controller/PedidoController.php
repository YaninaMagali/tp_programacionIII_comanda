<?php
require_once './model/Pedido.php';
require_once './utils/Archivador.php';
require_once './middleware/JsonBodyParserMiddleware.php';

class PedidoController{

    public function CrearPedido($request, $response, $args){

        $parametros = $request->getParsedBody();
        $pedido = new Pedido();
        $pedido->estado = $parametros['estado'];
        $pedido->imagen = 'ruta/archivo/pepe';
        $pedido->nombreCliente = $parametros['nombreCliente'];
        $pedido->idMesa = $parametros['idMesa'];
        $pedido->itemsMenu = $parametros['menu'];

        try{
            $idPedido = $pedido->InsertarPedido();
            $pedido->InsertarMenuPedido($idPedido);
            $payload = json_encode(array("Se creo el pedido: " => $pedido));
        }
        catch(Exception $e){
            $payload = json_encode(array("Error" => $e));
        }

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
}

?>