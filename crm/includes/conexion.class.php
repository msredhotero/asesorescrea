<?php
 class Conexion extends PDO {
   private $tipo_de_base = 'mysql';
   private $host = 'localhost';

   public $server;

   $server = 1;

   if ($server == 0) {
      private $nombre_de_base = 'u115752684_asesores';
      private $usuario = 'root';
      private $contrasena = '';
   } else {
      private $nombre_de_base = 'u115752684_desa';
      private $usuario = 'u115752684_desa';
      private $contrasena = '@Chivas11';
   }
   public function __construct() {
      //Sobreescribo el método constructor de la clase PDO.
      try{
          //die(var_dump($this->usuario));
         parent::__construct("{$this->tipo_de_base}:dbname={$this->nombre_de_base};host={$this->host};charset=utf8", $this->usuario, $this->contrasena);
      }catch(PDOException $e){
         echo 'Ha surgido un error y no se puede conectar a la base de datos. Detalle: ' . $e->getMessage();
         exit;
      }
   }
 }
?>
