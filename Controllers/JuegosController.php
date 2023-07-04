<?php
require_once 'models/JuegosModel.php';
require_once 'models/CategoriasModel.php';
require_once 'Views/APIView.php';
class JuegosController
{
    private $model;
    private $modelCategoria;
    private $view;
    private $data;

    function __construct()
    {
        $this->modelCategoria = new CategoriasModel();
        $this->model = new JuegosModel();
        $this->view = new APIView();
        $this->data = file_get_contents("php://input");
    }

    function getData()
    {
        return json_decode($this->data);
    }

    function asignarGet(){
        if (isset($_GET['columna']) && isset($_GET['order'])) {
            $this->orderXColumna();
        }elseif(isset($_GET['categoria'])){
            $this->filtroXCategoria();
        }  
            else{
            $this->obtenerJuegos();
        }
    }

    function obtenerJuegos($params = [])
    {
        if (empty($params)) {

            $juegos = $this->model->obtenerJuegos();
            if (!empty($juegos)) {
                return $this->view->response($juegos, 200);
            } else {
                return $this->view->response("No hay juegos", 404);
            }
        } else {
            $juego = $this->model->obtenerJuego($params[":ID"]);
            if (!empty($juego)) {
                return $this->view->response($juego, 200);
            } else {
                return $this->view->response("No se ha encontrado el juego con id: " . $params[":ID"], 404);
            }
        }
    }

    function agregarJuego()
    {
        $body = $this->getData();

        $params = ['imagen', 'juego', 'descripcion', 'precio', 'id_categoria'];
        foreach ($params as $parametros) {
            if (!property_exists($body, $parametros)) {
                return $this->view->response("Falta algun/os parametro/s", 400);
            }
        }

        $imagen = $body->imagen;
        $juego = $body->juego;
        $descripcion = $body->descripcion;
        $precio = $body->precio;
        $id_categoria = $body->id_categoria;

        if (!empty($imagen) && !empty($juego) && !empty($descripcion) && !empty($precio) && !empty($id_categoria)) {
            $id_juego = $this->model->subirJuego($imagen, $juego, $descripcion, $precio, $id_categoria);
            $juegoNuevo = $this->model->obtenerJuego($id_juego);
        }
        if ($juegoNuevo) {
            $this->view->response($juegoNuevo, 201);
        } else {
            $this->view->response("Ha ocurrido un error al insertar", 400);
        }
    }

    public function borrarJuego($params = [])
    {
        $id_juego = $params[":ID"];
        $juego = $this->model->obtenerJuego($id_juego);
        
        if ($juego) {
            $this->model->eliminarJuego($id_juego);
            $juegos = $this->model->obtenerJuegos();
            $this->view->response($juegos, 200);
        } else {
            $this->view->response("El juego con id: " . $id_juego . " no fue encontrada", 404);
        }
    }

    public function modificarJuego($params = [])
    {
        $id_juego = $params[":ID"];
        $juego = $this->model->obtenerJuego($id_juego);
        if ($juego) {
            $body = $this->getData();

            $params = ['imagen', 'juego', 'descripcion', 'precio', 'id_categoria'];
            foreach ($params as $parametros) {
                if (!property_exists($body, $parametros)) {
                    return $this->view->response("Falta algun/os parametro/s", 400);
                }
            }
            $imagen = $body->imagen;
            $juego = $body->juego;
            $descripcion = $body->descripcion;
            $precio = $body->precio;
            $id_categoria = $body->id_categoria;

            if (!empty($imagen) && !empty($juego) && !empty($descripcion) && !empty($precio) && !empty($id_categoria)) {
                $this->model->modificarJuego($imagen, $juego, $descripcion, $precio, $id_categoria, $id_juego);
                $juegoNuevo = $this->model->obtenerJuego($id_juego);
            }
            if ($juegoNuevo) {
                $this->view->response($juegoNuevo, 201);
            }
        } else {
            $this->view->response("No se encuentra el juego con la id " . $id_juego, 404);
        }
    }

    public function filtroXCategoria()
    {
        if (isset($_GET['categoria'])) {
            $categoria = $_GET['categoria'];
            $id_categoria = $this->modelCategoria->obtenerIdCategoria($categoria);
            $filtroXColumna = $this->model->obtenerJuegosXcategoria($id_categoria);
            return $this->view->response($filtroXColumna, 200);
        } else {
            return $this->view->response("Parametro no seteado", 400);
        }
    }

    public function orderXColumna()
    {
        
            $columna = '';
            $orden = '';
            switch ($_GET['columna']) {
                case 'juego':
                    $columna = 'juego';
                    break;
                case 'precio':
                    $columna = 'precio';
                    break;
                default:
                    return $this->view->response("Columna inexistente", 404);
            }
            switch ($_GET['order']) {
                case 'asc':
                    $orden = "asc";
                    break;
                case 'desc':
                    $orden = "desc";
                    break;
                default:
                    return $this->view->response("Orden inexistente", 404);
            }
            $orderXColumna = $this->model->orderXColumna($columna, $orden);
            return $this->view->response($orderXColumna, 200);
            
            
        
    }
}
