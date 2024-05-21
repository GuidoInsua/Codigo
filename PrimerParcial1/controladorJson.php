<?php

require_once 'jsonDeserializable.php';

date_default_timezone_set('America/Argentina/Buenos_Aires');

class controladorJson
{
    //private static $_instancia;
    private $_archivo;

    public function __construct($archivo) {
        // Verificar si $archivo es una cadena no vacía y válida
        if (!is_string($archivo) || empty($archivo)) {
            throw new Exception("Nombre de archivo inválido.");
        }
    
        // Verificar si el archivo termina con la extensión .json
        if (pathinfo($archivo, PATHINFO_EXTENSION) !== 'json') {
            throw new Exception("El nombre de archivo debe terminar con la extensión .json.");
        }
    
        // Verificar si el archivo no existe
        if (!file_exists($archivo)) {
            // Si el archivo no existe, crea uno nuevo vacío
            if (!touch($archivo)) {
                throw new Exception("No se pudo crear el archivo.");
            }
        }
    
        $this->_archivo = $archivo;
    }

    private function obtenerRegistrosDesdeArchivo() {
        // Lee el contenido del archivo JSON
        $json_contenido = file_get_contents($this->_archivo);

        // Verifica si el contenido está vacío
        if (empty($json_contenido)) {
            return []; // Retorna un array vacío
        }
    
        // Verifica si hubo problemas al leer el archivo
        if ($json_contenido === false) {
            throw new Exception("No se pudo leer el archivo.");
        }
    
        // Decodifica el JSON en un array asociativo
        $registros = json_decode($json_contenido, true);
    
        // Verifica si hubo problemas al decodificar el JSON
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Error al decodificar JSON: " . json_last_error_msg());
        }
    
        // Devuelve el array de registros decodificados
        return $registros;
    }

    private function guardarRegistrosEnArchivo(array $registros) {
        // Convertir el array de registros a JSON
        $registros_json = json_encode($registros, JSON_PRETTY_PRINT);
    
        // Verificar si hubo problemas al codificar el JSON
        if ($registros_json === false) {
            throw new Exception("Error al codificar JSON: " . json_last_error_msg());
        }
    
        // Escribir el JSON al archivo con bloqueo exclusivo
        $result = file_put_contents($this->_archivo, $registros_json, LOCK_EX);
    
        // Verificar si hubo problemas al escribir en el archivo
        if ($result === false) {
            throw new Exception("Error al escribir en el archivo.");
        }
    }

    public function agregarRegistroAlArchivo(JsonSerializable $unObjeto) {
        try {
            // Leer los registros existentes del archivo
            $registros = $this->obtenerRegistrosDesdeArchivo();
        } catch (Exception $e) {
            throw new Exception("Error al leer el archivo JSON: " . $e->getMessage());
        }

        // Crear un nuevo registro
        $nuevoRegistro = $unObjeto->jsonSerialize();

        // Añadir el nuevo registro al array de registros
        $registros[] = $nuevoRegistro;

        try {
            // Escribir el array actualizado de registros de vuelta al archivo JSON
            $this->guardarRegistrosEnArchivo($registros);
        } catch (Exception $e) {
            throw new Exception("Error al escribir el archivo JSON: " . $e->getMessage());
        }
    }

    public function convertirRegistrosEnObjetos(string $nombreClaseDeserializable) {
        $objetos = []; // Inicializa un arreglo vacío para almacenar los objetos deserializados.
    
        // Verifica si la clase proporcionada existe y si implementa la interfaz jsonDeserializable.
        if (class_exists($nombreClaseDeserializable) && in_array("jsonDeserializable", class_implements($nombreClaseDeserializable))) {
            try {
                // Intenta leer el contenido del archivo JSON.
                $registros = $this->obtenerRegistrosDesdeArchivo();
            } catch (Exception $e) {
                // Captura y lanza una excepción si ocurre un error al leer el archivo JSON.
                throw new Exception("Error al leer el archivo JSON: " . $e->getMessage());
            }
    
            // Itera sobre cada registro en el archivo JSON y deserializa cada uno a objetos de la clase especificada.
            foreach ($registros as $registro) {
                $objetos[] = $nombreClaseDeserializable::jsonDeserialize($registro);
            }
        }
    
        return $objetos; // Devuelve el arreglo de objetos deserializados.
    }

    public function actualizarRegistrosEnArchivo(array $objetos)
    {
        // Abre el archivo en modo de escritura
        $gestor = fopen($this->_archivo, 'w');

        if ($gestor === false) {
            die('No se pudo abrir el archivo para escritura');
        }

        // Trunca el contenido del archivo a cero
        if (ftruncate($gestor, 0) === false) {
            die('No se pudo vaciar el archivo');
        }

        // Cierra el archivo
        fclose($gestor);

        foreach ($objetos as $objeto) {
            if ($objeto instanceof JsonSerializable) {
                $this->agregarRegistroAlArchivo($objeto);
            }
        }
    }

    // Nada que ver con json, pero bueno
    public static function cargarFoto($archivo, $nombre, $destino)
    {
        try {
            if (isset($archivo) && $archivo['error'] === UPLOAD_ERR_OK) {
                
                // Obtiene la extensión del archivo original
                $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
                
                // Agrega la extensión al nombre específico
                $imagen_nombre_con_extension = $nombre . '.' . $extension;
                
                // Nombre temporal del archivo en el servidor
                $imagen_tmp_name = $archivo['tmp_name'];
                
                // Mueve el archivo desde la ubicación temporal a la carpeta de destino con el nuevo nombre
                if (!move_uploaded_file($imagen_tmp_name, $destino . $imagen_nombre_con_extension)) {
                    throw new Exception("No se pudo subir la imagen.");
                }
            } else {
                throw new Exception("Archivo inválido o error en la carga.");
            }
        } catch (Exception $e) {
            throw new Exception("Error al subir imagen: " . $e->getMessage());
        }
    }
}


?>
