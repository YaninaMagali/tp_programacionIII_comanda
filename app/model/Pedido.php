<?php

class Pedido
{
    public $id;
    public $codigo;
    public $estado;
    public $imagen;
    public $nombreCliente;
    public $idMesa;
    public $totalAPagar;
    public $itemsMenu;

    public function InsertarPedido(){

        try{
            $dao = new DAO();
            $query = $dao->prepararConsulta("INSERT INTO pedidos (codigo, estado, imagen, nombreCliente, idMesa) VALUES (:codigo, :estado, :imagen, :nombreCliente, :idMesa)");
            $codigo = GenerarCodigoAlfanumerico(5);   
            $query->bindValue(':codigo', $codigo, PDO::PARAM_STR);
            $query->bindValue(':estado', $this->estado, PDO::PARAM_STR);
            $query->bindValue(':imagen', $this->imagen, PDO::PARAM_STR);
            $query->bindValue(':nombreCliente', $this->nombreCliente, PDO::PARAM_STR);
            $query->bindValue(':idMesa', $this->idMesa, PDO::PARAM_INT);
            $query->execute();

            return $dao->obtenerUltimoId();
        }
        catch(Exception $e){
            throw $e;
        }

    }

    
    public function InsertarMenuPedido($id_pedido){

        try{
            $dao = new DAO();
            $query = $dao->prepararConsulta("INSERT INTO menu_pedido (id_pedido, id_item_menu, cantidad) VALUES (:id_pedido, :id_item_menu, :cantidad)");
            foreach($this->itemsMenu as $item){
                $query->bindValue(':id_pedido', $id_pedido, PDO::PARAM_INT);
                $query->bindValue(':id_item_menu', $item['id_item_menu'], PDO::PARAM_INT);
                $query->bindValue(':cantidad', $item['cantidad'], PDO::PARAM_INT);
                $query->execute();
                
                // return $dao->obtenerUltimoId();
            }

        }
        catch(Exception $e){
            throw $e;
        }

    }

    public static function ConsultarPedidos(){

        try{
            $dao = new DAO();
            $query = $dao->prepararConsulta("SELECT * FROM pedidos;");
            $query->execute();
    
            return $query->fetchAll(PDO::FETCH_CLASS, 'Pedido');
        }
        catch(Exception $e){
            throw $e;
        }
    }

}
?>