<?php


require_once 'conexion.class.php';
date_default_timezone_set('America/Mexico_City');

class usuarioCrea extends PDO {
   const TABLA = 'dbusuarios';

   private $idusuario;
   private $usuario;
   private $password;
   private $refroles;
   private $email;
   private $nombrecompleto;
   private $activo;
   private $refsocios;
   private $validaemail;
   private $validamovil;
   private $validasignatura;
   private $usuarioexterno;

   public function __construct() {

   }

   public function guardar($usuario,$password,$refroles,$email,$nombrecompleto,$activo,$refsocios,$validaemail,$validamovil,$validasignatura,$usuarioexterno) {

      $conexion = new Conexion();

      $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $this->cargar($usuario,$password,$refroles,$email,$nombrecompleto,$activo,$refsocios,$validaemail,$validamovil,$validasignatura,$usuarioexterno);


      //die(var_dump($this->reftipopersonas));
      $consulta = $conexion->prepare('INSERT INTO '.self::TABLA.'(idusuario,usuario,password,refroles,email,nombrecompleto,activo,refsocios,validaemail,validamovil,validasignatura,usuarioexterno) VALUES(:idusuario,:usuario,:password,:refroles,:email,:nombrecompleto,:activo,:refsocios,:validaemail,:validamovil,:validasignatura,:usuarioexterno)');
      $consulta->bindParam(':idusuario', $this->idusuario);
      $consulta->bindParam(':usuario', $this->usuario);
      $consulta->bindParam(':password', $this->password);
      $consulta->bindParam(':refroles', $this->refroles);
      $consulta->bindParam(':email', $this->email);
      $consulta->bindParam(':nombrecompleto', $this->nombrecompleto);
      $consulta->bindParam(':activo', $this->activo);
      $consulta->bindParam(':refsocios', $this->refsocios);
      $consulta->bindParam(':validaemail', $this->validaemail);
      $consulta->bindParam(':validamovil', $this->validamovil);
      $consulta->bindParam(':validasignatura', $this->validasignatura);
      $consulta->bindParam(':usuarioexterno', $this->usuarioexterno);

      try {
          $consulta->execute();
          //die(var_dump($consulta));
      }catch(PDOException $e){
          echo 'Ha surgido un error y no se puede crear el cliente: ' . $e->getMessage();
          exit;
      }

      $this->setIdusuario($conexion->lastInsertId());


      $conexion = null;


      $res = $this->idusuario;

   }

   public function cargar($usuario,$password,$refroles,$email,$nombrecompleto,$activo,$refsocios,$validaemail,$validamovil,$validasignatura,$usuarioexterno) {

      $this->setUsuario($usuario);
      $this->setPassword($password);
      $this->setRefroles($refroles);
      $this->setEmail($email);
      $this->setNombrecompleto($nombrecompleto);
      $this->setActivo($activo);
      $this->setRefsocios($refsocios);
      $this->setValidaemail($validaemail);
      $this->setValidamovil($validamovil);
      $this->setValidasignatura($validasignatura);
      $this->setUsuarioexterno($usuarioexterno);

   }

   public function buscarUsuarioPorValor($campo, $valor) {
      $conexion = new Conexion();

      $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sql = "select idusuario from ".self::TABLA." where ".$campo." = :".$campo." ";

      $consulta = $conexion->prepare($sql);
      $consulta->bindParam(':'.$campo, $valor);

      $consulta->execute();

      $res = $consulta->fetch();

      if($res){

         $this->buscarUsuarioPorId($res['idusuario']);

      }else{
         return false;
      }
   }

   public function buscarUsuarioPorId($id) {
      $conexion = new Conexion();

      $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sql = "SELECT idusuario,
                     usuario,
                     password,
                     refroles,
                     email,
                     nombrecompleto,
                     activo,
                     refsocios,
                     validaemail,
                     validamovil,
                     validasignatura,
                     usuarioexterno
            FROM ".self::TABLA." where idusuario = :idusuario";

      $consulta = $conexion->prepare($sql);

      $consulta->bindParam(':idusuario', $id);

      $consulta->execute();

      $res = $consulta->fetch();

      if($res){
         $this->cargar($res['usuario'],$res['password'],$res['refroles'],$res['email'],$res['nombrecompleto'],$res['activo'],$res['refsocios'],$res['validaemail'],$res['validamovil'],$res['validasignatura'],$res['usuarioexterno']);
         $this->setIdusuario($id);

      }else{
         return false;
      }

   }

   public function getActivoStr() {
      return ($this->getActivo() == '1' ? 'Si' : 'No');
   }

   public function getValidaemailStr() {
      return ($this->getValidaemail() == '1' ? 'Si' : 'No');
   }

   public function getValidamovilStr() {
      return ($this->getValidamovil() == '1' ? 'Si' : 'No');
   }

   public function getValidasignaturaStr() {
      return ($this->getValidasignatura() == '1' ? 'Si' : 'No');
   }

   public function getUsuarioexternoStr() {
      return ($this->getUsuarioexterno() == '1' ? 'Si' : 'No');
   }


    /**
     * Get the value of Idusuario
     *
     * @return mixed
     */
    public function getIdusuario()
    {
        return $this->idusuario;
    }

    /**
     * Set the value of Idusuario
     *
     * @param mixed $idusuario
     *
     * @return self
     */
    public function setIdusuario($idusuario)
    {
        $this->idusuario = $idusuario;

        return $this;
    }

    /**
     * Get the value of Usuario
     *
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set the value of Usuario
     *
     * @param mixed $usuario
     *
     * @return self
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get the value of Password
     *
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of Password
     *
     * @param mixed $password
     *
     * @return self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of Refroles
     *
     * @return mixed
     */
    public function getRefroles()
    {
        return $this->refroles;
    }

    /**
     * Set the value of Refroles
     *
     * @param mixed $refroles
     *
     * @return self
     */
    public function setRefroles($refroles)
    {
        $this->refroles = $refroles;

        return $this;
    }

    /**
     * Get the value of Email
     *
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of Email
     *
     * @param mixed $email
     *
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of Nombrecompleto
     *
     * @return mixed
     */
    public function getNombrecompleto()
    {
        return $this->nombrecompleto;
    }

    /**
     * Set the value of Nombrecompleto
     *
     * @param mixed $nombrecompleto
     *
     * @return self
     */
    public function setNombrecompleto($nombrecompleto)
    {
        $this->nombrecompleto = $nombrecompleto;

        return $this;
    }

    /**
     * Get the value of Activo
     *
     * @return mixed
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set the value of Activo
     *
     * @param mixed $activo
     *
     * @return self
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get the value of Refsocios
     *
     * @return mixed
     */
    public function getRefsocios()
    {
        return $this->refsocios;
    }

    /**
     * Set the value of Refsocios
     *
     * @param mixed $refsocios
     *
     * @return self
     */
    public function setRefsocios($refsocios)
    {
        $this->refsocios = $refsocios;

        return $this;
    }

    /**
     * Get the value of Validaemail
     *
     * @return mixed
     */
    public function getValidaemail()
    {
        return $this->validaemail;
    }

    /**
     * Set the value of Validaemail
     *
     * @param mixed $validaemail
     *
     * @return self
     */
    public function setValidaemail($validaemail)
    {
        $this->validaemail = $validaemail;

        return $this;
    }

    /**
     * Get the value of Validamovil
     *
     * @return mixed
     */
    public function getValidamovil()
    {
        return $this->validamovil;
    }

    /**
     * Set the value of Validamovil
     *
     * @param mixed $validamovil
     *
     * @return self
     */
    public function setValidamovil($validamovil)
    {
        $this->validamovil = $validamovil;

        return $this;
    }

    /**
     * Get the value of Validasignatura
     *
     * @return mixed
     */
    public function getValidasignatura()
    {
        return $this->validasignatura;
    }

    /**
     * Set the value of Validasignatura
     *
     * @param mixed $validasignatura
     *
     * @return self
     */
    public function setValidasignatura($validasignatura)
    {
        $this->validasignatura = $validasignatura;

        return $this;
    }

    /**
     * Get the value of Usuarioexterno
     *
     * @return mixed
     */
    public function getUsuarioexterno()
    {
        return $this->usuarioexterno;
    }

    /**
     * Set the value of Usuarioexterno
     *
     * @param mixed $usuarioexterno
     *
     * @return self
     */
    public function setUsuarioexterno($usuarioexterno)
    {
        $this->usuarioexterno = $usuarioexterno;

        return $this;
    }

}


?>
