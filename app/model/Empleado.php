<?php
/*
Aca hacer los metodos que hacen las queries a la DB*/ 
//require_once 'C:\Users\Yanina Diaz\Documents\UTN\PROGRAMACION 3\tp_programacionIII_comanda\app\database';

class Empleado
{
    public $id;
    public $usuario;
    public $clave;
    public $estado;
    public $sector;

    public function InsertarEmpleado(){

        try{
            $dao = new DAO();
            $query = $dao->prepararConsulta("INSERT INTO empleados (usuario, clave, estado, sector) VALUES (:usuario, :clave, :estado, :sector)");
            $claveHash = password_hash($this->clave, PASSWORD_DEFAULT);     
            $query->bindValue(':usuario', $this->usuario, PDO::PARAM_STR);
            $query->bindValue(':clave', $claveHash);
            $query->bindValue(':estado', $this->estado, PDO::PARAM_STR);
            $query->bindValue(':sector', $this->sector, PDO::PARAM_STR);
            $query->execute();
    
            return $dao->obtenerUltimoId();
        }
        catch(Exception $e){
            throw $e;
        }

    }

    public static function ConsultarEmpleados(){

        try{
            $dao = new DAO();
            $query = $dao->prepararConsulta("SELECT * FROM empleados;");
            $query->execute();
    
            return $query->fetchAll(PDO::FETCH_CLASS, 'Empleado');
        }
        catch(Exception $e){
            throw $e;
        }
    }

    public static function ConsultarEmpleado($usuario){

        try{
            $dao = new DAO();
            $query = $dao->prepararConsulta("SELECT * FROM empleados WHERE usuario = :usuario;");
            $query->bindValue(':usuario', $usuario, PDO::PARAM_STR);
            $query->execute();
    
            return $query->fetchObject('Empleado');
        }
        catch(Exception $e){
            throw $e;
        }
    }

}