<?php
require_once('CategoriasModel.php');
class JuegosModel{
 private $db;
 private $CategoriasModel;
 public function __construct(){
   $this->db = new PDO('mysql:host=localhost;'.'dbname=gamerys;charset=utf8', 'root', '');
    $this->CategoriasModel = new CategoriasModel();
 }



 public function eliminarJuego($id){
    $query = $this->db->prepare('DELETE FROM juegos WHERE id_juego = ?');
    $query->execute([$id]);
   }


 public function modificarJuego($imagen,$nombreJuego,$descJuego,$precioJuego,$categoria,$idJuego){
   
    $query = $this->db->prepare('UPDATE juegos SET imagen = ?, juego = ?, descripcion = ?, precio = ?, id_categoria = ? WHERE id_juego = ?');
    $query->execute([$imagen, $nombreJuego,$descJuego, $precioJuego, $categoria, $idJuego]);

  }

 public function subirJuego($imagen, $nombreJuego, $descJuego, $precioJuego, $categoria){
    $query2 = $this->db->prepare('INSERT INTO juegos (imagen, juego, descripcion, precio, id_categoria) VALUES (?, ?, ?, ?, ?)');
    $query2->execute([$imagen, $nombreJuego, $descJuego, $precioJuego, $categoria]);
    return $this->db->lastInsertId();
  }

 public function obtenerJuegos(){
    $query = $this->db->prepare('SELECT * FROM juegos');
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
  }

  public function obtenerJuego($id_juego){
    $query = $this->db->prepare('SELECT * FROM juegos WHERE id_juego = ?');
    $query->bindParam(1,$id_juego);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
  }



 public function obtenerJuegosXcategoria($id_categoria){
    $query = $this->db->prepare('SELECT * FROM juegos WHERE id_categoria = ?');
    $query->execute([$id_categoria]);
    return $query->fetchAll(PDO::FETCH_OBJ);
  }

  public function orderXColumna($columna, $orden)
  {
      $sentencia = $this->db->prepare("SELECT * FROM juegos ORDER BY $columna $orden");
      $sentencia->execute();
      $oderXColumna = $sentencia->fetchAll(PDO::FETCH_OBJ);
      return $oderXColumna;
  }
  
 

}