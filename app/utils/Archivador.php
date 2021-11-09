<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

class Archivador
{
    function GuardarArchivo($archivo, $dir_subida, $newName)
    {
        // echo "/////////////////// archiov <br>";
        echo $archivo . "<br>";
        //echo "//////////// dir subida <br>";
        //echo $dir_subida . "<br>";
        $pudoGuardar = false;

        $fichero_subido = $dir_subida . basename($_FILES[$archivo][$newName]);


        if(is_file($fichero_subido))
        {
            echo "existe el file \n";
            die();
        }

        // if (!file_exists($dir_subida)) {
        //     mkdir($dir_subida, 0777, true);
            
        // }

        if (move_uploaded_file($_FILES[$archivo]['tmp_name'], "$fichero_subido/$newName")) 
        {
            $pudoGuardar = true;
            echo "Se subió con éxito.\n";
        } 
        else  
        {
            echo "Error!\n";
        }
        return $pudoGuardar;
    }


    function CambiarDeDirectorio($origen, $destino)
    {
        if(is_file($origen))
        {
            try
            {
                echo "origen: ".$origen;
                echo "destino: ".$destino;
                copy($origen, $destino);
                unlink($origen);
            }
            catch(Exception $e)
            {
                echo "Error en CambiarDeDirectorio<br>";
                var_dump($e);
            }
        }

    }

}
?>
