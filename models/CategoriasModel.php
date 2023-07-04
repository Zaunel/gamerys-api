<?php

class CategoriasModel{
 private $db;

 public function __construct(){
   $this->db = new PDO('mysql:host=localhost;'.'dbname=gamerys;charset=utf8', 'root', '');

 }

  public function obtenerIdCategoria($categoria){
    $query = $this->db->prepare('SELECT id_categoria FROM categorias WHERE categoria = ?');
    $query->execute([$categoria]);
    $categoria = $query->fetchColumn();
    return $categoria;
  }

  
 

}