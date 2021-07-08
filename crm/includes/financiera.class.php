<?php
require_once 'conexion.class.php';
date_default_timezone_set('America/Mexico_City');

class financieraCrea extends PDO {
   const TABLA = 'dbcotizacionesfinanciera';

   private $idcotizacionfinanciera;
   private $refcotizaciones;
   private $refsolicitudes;
   private $refestado;
   private $fechacrea;
   private $idusuario;
   private $precio;
   private $descripcion;
   private $error;
   private $descripcionError;

   public function __construct() {

   }

   public function guardar($refcotizaciones,$refsolicitudes,$refestado) {

      $conexion = new Conexion();

      $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $this->cargar($refcotizaciones,$refsolicitudes,$refestado);


      //die(var_dump($this->reftipopersonas));
      $consulta = $conexion->prepare('INSERT INTO '.self::TABLA.'(refcotizaciones,refsolicitudes,refestado,fechacrea) VALUES(:refcotizaciones,:refsolicitudes,:refestado,:fechacrea)');
      $consulta->bindParam(':refcotizaciones', $this->refcotizaciones);
      $consulta->bindParam(':refsolicitudes', $this->refsolicitudes);
      $consulta->bindParam(':refestado', $this->refestado);
      $consulta->bindParam(':fechacrea', $this->getFechacrea());

      try {
          $consulta->execute();
          //die(var_dump($consulta));
      }catch(PDOException $e){
          echo 'Ha surgido un error y no se puede crear la solicitud: ' . $e->getMessage();
          exit;
      }

      $this->setIdcotizacionfinanciera($conexion->lastInsertId());


      $conexion = null;


      $res = $this->idcotizacionfinanciera;

   }

   function servicioSolicitud() {
      $ch = curl_init();
		$url = 'https://financieracrea.com/esf/creditosonline/API/creditoServicios.php';
		$arrayResultado = array();
		$arrayResultado = array();


		$dataUno = array(
         'idUsuarioAsesor' => $this->idusuario,
         'idServicio' => '10',
         'descripcion'=> $this->descripcion,
         'monto' => $this->precio,
         'refPoliza' => ''
      );

      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dataUno));
      //set the content type to application/json
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
      //return response instead of outputting
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      //execute the POST request
      $result = curl_exec($ch);

      $arrayResultado = json_decode($result, true);

      //var_dump($result);
      $arr = json_decode($arrayResultado);

      //die(var_dump($arr->{'error'}));

      if(curl_errno($ch)){
         //throw new Exception(curl_error($ch));
         $this->setError(1);
         $this->setDescripcionError('El servicio no esta funcionando, pruebe nuevamente');
      } else {
         if ($arr->{'error'} == 1) {
            $this->setError(1);
            $this->setDescripcionError($arr->{'error_descripcion'});
         } else {
            $this->setError(0);
            $this->setDescripcionError($arr->{'Se genero correctamente la solicitud del credito'});

            $this->guardar($this->refcotizaciones,$this->refsolicitudes,1);
         }
      }


      curl_close($ch);
   }

   public function cargar($refcotizaciones,$refsolicitudes,$refestado) {

      $this->setRefcotizaciones($refcotizaciones);
      $this->setRefsolicitudes($refsolicitudes);
      $this->setRefestado($refestado);

   }


    /**
     * Get the value of Idcotizacionfinanciera
     *
     * @return mixed
     */
    public function getIdcotizacionfinanciera()
    {
        return $this->idcotizacionfinanciera;
    }

    /**
     * Set the value of Idcotizacionfinanciera
     *
     * @param mixed $idcotizacionfinanciera
     *
     * @return self
     */
    public function setIdcotizacionfinanciera($idcotizacionfinanciera)
    {
        $this->idcotizacionfinanciera = $idcotizacionfinanciera;

        return $this;
    }

    /**
     * Get the value of Refcotizaciones
     *
     * @return mixed
     */
    public function getRefcotizaciones()
    {
        return $this->refcotizaciones;
    }

    /**
     * Set the value of Refcotizaciones
     *
     * @param mixed $refcotizaciones
     *
     * @return self
     */
    public function setRefcotizaciones($refcotizaciones)
    {
        $this->refcotizaciones = $refcotizaciones;

        return $this;
    }

    /**
     * Get the value of Refsolicitudes
     *
     * @return mixed
     */
    public function getRefsolicitudes()
    {
        return $this->refsolicitudes;
    }

    /**
     * Set the value of Refsolicitudes
     *
     * @param mixed $refsolicitudes
     *
     * @return self
     */
    public function setRefsolicitudes($refsolicitudes)
    {
        $this->refsolicitudes = $refsolicitudes;

        return $this;
    }

    /**
     * Get the value of Refestado
     *
     * @return mixed
     */
    public function getRefestado()
    {
        return $this->refestado;
    }

    /**
     * Set the value of Refestado
     *
     * @param mixed $refestado
     *
     * @return self
     */
    public function setRefestado($refestado)
    {
        $this->refestado = $refestado;

        return $this;
    }

    /**
     * Get the value of Fechacrea
     *
     * @return mixed
     */
    public function getFechacrea()
    {
        return $this->fechacrea;
    }

    /**
     * Set the value of Fechacrea
     *
     * @param mixed $fechacrea
     *
     * @return self
     */
    public function setFechacrea()
    {
        $this->fechacrea = date('Y-m-d H:i:s');

        return $this;
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
     * Get the value of Precio
     *
     * @return mixed
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set the value of Precio
     *
     * @param mixed $precio
     *
     * @return self
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get the value of Descripcion
     *
     * @return mixed
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set the value of Descripcion
     *
     * @param mixed $descripcion
     *
     * @return self
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }


    /**
     * Get the value of Error
     *
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Set the value of Error
     *
     * @param mixed $error
     *
     * @return self
     */
    public function setError($error)
    {
        $this->error = $error;

        return $this;
    }


    /**
     * Get the value of Descripcion Error
     *
     * @return mixed
     */
    public function getDescripcionError()
    {
        return $this->descripcionError;
    }

    /**
     * Set the value of Descripcion Error
     *
     * @param mixed $descripcionError
     *
     * @return self
     */
    public function setDescripcionError($descripcionError)
    {
        $this->descripcionError = $descripcionError;

        return $this;
    }

}


?>
