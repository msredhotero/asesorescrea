<?php

require_once 'conexion.class.php';
require_once 'usuarios.class.php';
date_default_timezone_set('America/Mexico_City');

class clienteCrea extends PDO {

   const TABLA = 'dbclientes';

    private $idcliente;
    private $nombre;
    private $apellidopaterno;
    private $apellidomaterno;
    private $razonsocial;
    private $domicilio;
    private $email;
    private $rfc;
    private $ine;
    private $curp;
    private $fechanacimiento;
    private $numerocliente;
    private $refusuarios;
    private $fechacrea;
    private $fechamodi;
    private $usuariocrea;
    private $usuariomodi;
    private $reftipopersonas;
    private $telefonofijo;
    private $telefonocelular;
    private $idclienteinbursa;
    private $emisioncomprobantedomicilio;
    private $emisionrfc;
    private $vencimientoine;
    private $colonia;
    private $municipio;
    private $codigopostal;
    private $edificio;
    private $nroexterior;
    private $nrointerior;
    private $estado;
    private $ciudad;
    private $genero;
    private $refestadocivil;
    private $reftipoidentificacion;
    private $nroidentificacion;
    public $usuario;

    public function __construct() {
      $usuario = new usuarioCrea();
      $this->usuario = $usuario;
    }

    function generaNroCliente() {
		$sql = "select max(idcliente) from dbclientes";
		$res = $this->query($sql,0);

		if (mysql_num_rows($res) > 0) {
			$idcliente = mysql_result($res,0,0);
			return 'CLI'.substr('0000000'.$idcliente,-7);
		}

		return 'CLI0000001';
	}

   public function cargar($reftipopersonas,$nombre,$apellidopaterno,$apellidomaterno,$razonsocial,$domicilio,$telefonofijo,$telefonocelular,$email,$rfc,$ine,$refusuarios,$usuariocrea,$usuariomodi,$emisioncomprobantedomicilio,$emisionrfc,$vencimientoine,$idclienteinbursa,$colonia,$municipio,$codigopostal,$edificio,$nroexterior,$nrointerior,$estado,$ciudad,$curp,$genero,$refestadocivil,$reftipoidentificacion,$nroidentificacion,$fechanacimiento) {

      $this->setReftipopersonas($reftipopersonas);
      $this->setNombre($nombre);
      $this->setApellidopaterno($apellidopaterno);
      $this->setApellidomaterno($apellidomaterno);
      $this->setRazonsocial($razonsocial);
      $this->setDomicilio($domicilio);
      $this->setTelefonofijo($telefonofijo);
      $this->setTelefonocelular($telefonocelular);
      $this->setEmail($email);
      $this->setRfc($rfc);
      $this->setIne($ine);
      $this->setRefusuarios($refusuarios);
      $this->setUsuariocrea($usuariocrea);
      $this->setUsuariomodi($usuariomodi);
      $this->setEmisioncomprobantedomicilio($emisioncomprobantedomicilio);
      $this->setEmisionrfc($emisionrfc);
      $this->setVencimientoine($vencimientoine);
      $this->setIdclienteinbursa($idclienteinbursa);
      $this->setColonia($colonia);
      $this->setMunicipio($municipio);
      $this->setCodigopostal($codigopostal);
      $this->setEdificio($edificio);
      $this->setNroexterior($nroexterior);
      $this->setNrointerior($nrointerior);
      $this->setEstado($estado);
      $this->setCiudad($ciudad);
      $this->setCurp($curp);
      $this->setGenero($genero);
      $this->setRefestadocivil($refestadocivil);
      $this->setReftipoidentificacion($reftipoidentificacion);
      $this->setNroidentificacion($nroidentificacion);
      $this->setFechanacimiento($fechanacimiento);
      $this->setNumerocliente();
      $this->setFechacrea();
      $this->setFechamodi();
      if (($refusuarios != null) || ($refusuarios >0)) {
         $this->usuario->buscarUsuarioPorId($refusuarios);
      }

   }

   public function validarRFC($rfc) {

      $regex = '/^[A-Z]{3,4}[ \-]?[0-9]{2}((0{1}[1-9]{1})|(1{1}[0-2]{1}))((0{1}[1-9]{1})|([1-2]{1}[0-9]{1})|(3{1}[0-1]{1}))[ \-]?[A-Z0-9]{3}/';
	   return preg_match($regex, $rfc);

   }

   public function validarCURP($curp) {

      $regex = '/^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/';
	   return preg_match($regex, $curp);

   }

   public function buscarClientePorCurp($curp) {
      return $this->buscarClientePorValor('curp', $curp);

   }

   public function buscarClientePorValor($campo, $valor) {
      $conexion = new Conexion();

      $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sql = "select idcliente from ".self::TABLA." where ".$campo." = :".$campo." ";

      $consulta = $conexion->prepare($sql);
      $consulta->bindParam(':'.$campo, $valor);

      $consulta->execute();

      $res = $consulta->fetch();

      if($res){

         $this->buscarClientePorId($res['idcliente']);

      }else{
         return false;
      }
   }

   public function buscarClientePorRfc($rfc) {
      return $this->buscarClientePorValor('rfc', $rfc);

   }

   public function buscarClientePorId($id) {
      $conexion = new Conexion();

      $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sql = "SELECT idcliente,
                     nombre,
                     apellidopaterno,
                     apellidomaterno,
                     razonsocial,
                     domicilio,
                     email,
                     rfc,
                     ine,
                     curp,
                     fechanacimiento,
                     numerocliente,
                     refusuarios,
                     fechacrea,
                     fechamodi,
                     usuariocrea,
                     usuariomodi,
                     reftipopersonas,
                     telefonofijo,
                     telefonocelular,
                     idclienteinbursa,
                     emisioncomprobantedomicilio,
                     emisionrfc,
                     vencimientoine,
                     colonia,
                     municipio,
                     codigopostal,
                     edificio,
                     nroexterior,
                     nrointerior,
                     estado,
                     ciudad,
                     genero,
                     refestadocivil,
                     reftipoidentificacion,
                     nroidentificacion
            FROM ".self::TABLA." where idcliente = :idcliente";

      $consulta = $conexion->prepare($sql);

      $consulta->bindParam(':idcliente', $id);

      $consulta->execute();

      $res = $consulta->fetch();

      if($res){
         $this->cargar($res['reftipopersonas'],$res['nombre'],$res['apellidopaterno'],$res['apellidomaterno'],$res['razonsocial'],$res['domicilio'],$res['telefonofijo'],$res['telefonocelular'],$res['email'],$res['rfc'],$res['ine'],$res['refusuarios'],$res['usuariocrea'],$res['usuariomodi'],$res['emisioncomprobantedomicilio'],$res['emisionrfc'],$res['vencimientoine'],$res['idclienteinbursa'],$res['colonia'],$res['municipio'],$res['codigopostal'],$res['edificio'],$res['nroexterior'],$res['nrointerior'],$res['estado'],$res['ciudad'],$res['curp'],$res['genero'],$res['refestadocivil'],$res['reftipoidentificacion'],$res['nroidentificacion'],$res['fechanacimiento']);
         $this->setIdcliente($id);

      }else{
         return false;
      }

   }


   public function guardar($reftipopersonas,$nombre,$apellidopaterno,$apellidomaterno,$razonsocial,$domicilio,$telefonofijo,$telefonocelular,$email,$rfc,$ine,$refusuarios,$usuariocrea,$usuariomodi,$emisioncomprobantedomicilio,$emisionrfc,$vencimientoine,$idclienteinbursa,$colonia,$municipio,$codigopostal,$edificio,$nroexterior,$nrointerior,$estado,$ciudad,$curp,$genero,$refestadocivil,$reftipoidentificacion,$nroidentificacion,$fechanacimiento) {

      $conexion = new Conexion();

      $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $this->cargar($reftipopersonas,$nombre,$apellidopaterno,$apellidomaterno,$razonsocial,$domicilio,$telefonofijo,$telefonocelular,$email,$rfc,$ine,$refusuarios,$usuariocrea,$usuariomodi,$emisioncomprobantedomicilio,$emisionrfc,$vencimientoine,$idclienteinbursa,$colonia,$municipio,$codigopostal,$edificio,$nroexterior,$nrointerior,$estado,$ciudad,$curp,$genero,$refestadocivil,$reftipoidentificacion,$nroidentificacion,$fechanacimiento);


         //die(var_dump($this->reftipopersonas));
         $consulta = $conexion->prepare('INSERT INTO '.self::TABLA.'(reftipopersonas,nombre,apellidopaterno,apellidomaterno,razonsocial,domicilio,telefonofijo,telefonocelular,email,rfc,ine,numerocliente,refusuarios,fechacrea,fechamodi,usuariocrea,usuariomodi,emisioncomprobantedomicilio,emisionrfc,vencimientoine,idclienteinbursa,colonia,municipio,codigopostal,edificio,nroexterior,nrointerior,estado,ciudad,curp,genero,refestadocivil,reftipoidentificacion,nroidentificacion,fechanacimiento) VALUES(:reftipopersonas,:nombre,:apellidopaterno,:apellidomaterno,:razonsocial,:domicilio,:telefonofijo,:telefonocelular,:email,:rfc,:ine,:numerocliente,:refusuarios,:fechacrea,:fechamodi,:usuariocrea,:usuariomodi,:emisioncomprobantedomicilio,:emisionrfc,:vencimientoine,:idclienteinbursa,:colonia,:municipio,:codigopostal,:edificio,:nroexterior,:nrointerior,:estado,:ciudad,:curp,:genero,:refestadocivil,:reftipoidentificacion,:nroidentificacion,:fechanacimiento)');
         $consulta->bindParam(':reftipopersonas', $this->reftipopersonas);
         $consulta->bindParam(':nombre', $this->nombre);
         $consulta->bindParam(':apellidopaterno', $this->apellidopaterno);
         $consulta->bindParam(':apellidomaterno', $this->apellidomaterno);
         $consulta->bindParam(':razonsocial', $this->razonsocial);
         $consulta->bindParam(':domicilio', $this->domicilio);
         $consulta->bindParam(':telefonofijo', $this->telefonofijo);
         $consulta->bindParam(':telefonocelular', $this->telefonocelular);
         $consulta->bindParam(':email', $this->email);
         $consulta->bindParam(':rfc', $this->rfc);
         $consulta->bindParam(':ine', $this->ine);
         $consulta->bindParam(':numerocliente', $this->numerocliente);
         $consulta->bindParam(':refusuarios', $this->refusuarios);
         $consulta->bindParam(':fechacrea', $this->fechacrea);
         $consulta->bindParam(':fechamodi', $this->fechamodi);
         $consulta->bindParam(':usuariocrea', $this->usuariocrea);
         $consulta->bindParam(':usuariomodi', $this->usuariomodi);
         $consulta->bindParam(':emisioncomprobantedomicilio', $this->emisioncomprobantedomicilio);
         $consulta->bindParam(':emisionrfc', $this->emisionrfc);
         $consulta->bindParam(':vencimientoine', $this->vencimientoine);
         $consulta->bindParam(':idclienteinbursa', $this->idclienteinbursa);
         $consulta->bindParam(':colonia', $this->colonia);
         $consulta->bindParam(':municipio', $this->municipio);
         $consulta->bindParam(':codigopostal', $this->codigopostal);
         $consulta->bindParam(':edificio', $this->edificio);
         $consulta->bindParam(':nroexterior', $this->nroexterior);
         $consulta->bindParam(':nrointerior', $this->nrointerior);
         $consulta->bindParam(':estado', $this->estado);
         $consulta->bindParam(':ciudad', $this->ciudad);
         $consulta->bindParam(':curp', $this->curp);
         $consulta->bindParam(':genero', $this->genero);
         $consulta->bindParam(':refestadocivil', $this->refestadocivil);
         $consulta->bindParam(':reftipoidentificacion', $this->reftipoidentificacion);
         $consulta->bindParam(':nroidentificacion', $this->nroidentificacion);
         $consulta->bindParam(':fechanacimiento', $this->fechanacimiento);

         try {
            $consulta->execute();
            //die(var_dump($consulta));
         }catch(PDOException $e){
            echo 'Ha surgido un error y no se puede crear el cliente: ' . $e->getMessage();
            exit;
         }

         $this->setIdcliente($conexion->lastInsertId());

         $conexion = null;

         $res = $this->idcliente;

   }

    function traerClientesPorId($id) {
		$sql = "select idcliente,reftipopersonas,nombre,apellidopaterno,apellidomaterno,razonsocial,domicilio,telefonofijo,telefonocelular,email,rfc,ine,numerocliente,refusuarios,fechacrea,fechamodi,usuariocrea,usuariomodi,idclienteinbursa,emisioncomprobantedomicilio,emisionrfc,vencimientoine,colonia,municipio,codigopostal,edificio,nroexterior,nrointerior,estado,ciudad,curp,fechanacimiento,genero,refestadocivil,reftipoidentificacion,nroidentificacion from dbclientes where idcliente =".$id;
		$res = $this->query($sql,0);

	}

    /**
     * Get the value of idcliente
     */
    public function getIdcliente()
    {
        return $this->idcliente;
    }

    /**
     * Set the value of idcliente
     *
     * @return  self
     */
    public function setIdcliente($idcliente)
    {
        $this->idcliente = $idcliente;

        return $this;
    }

    /**
     * Get the value of nombre
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of apellidopaterno
     */
    public function getApellidopaterno()
    {
        return $this->apellidopaterno;
    }

    /**
     * Set the value of apellidopaterno
     *
     * @return  self
     */
    public function setApellidopaterno($apellidopaterno)
    {
        $this->apellidopaterno = $apellidopaterno;

        return $this;
    }

    /**
     * Get the value of apellidomaterno
     */
    public function getApellidomaterno()
    {
        return $this->apellidomaterno;
    }

    /**
     * Set the value of apellidomaterno
     *
     * @return  self
     */
    public function setApellidomaterno($apellidomaterno)
    {
        $this->apellidomaterno = $apellidomaterno;

        return $this;
    }

    /**
     * Get the value of razonsocial
     */
    public function getRazonsocial()
    {
        return $this->razonsocial;
    }

    /**
     * Set the value of razonsocial
     *
     * @return  self
     */
    public function setRazonsocial($razonsocial)
    {
        $this->razonsocial = $razonsocial;

        return $this;
    }

    /**
     * Get the value of domicilio
     */
    public function getDomicilio()
    {
        return $this->domicilio;
    }

    /**
     * Set the value of domicilio
     *
     * @return  self
     */
    public function setDomicilio($domicilio)
    {
        $this->domicilio = $domicilio;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of rfc
     */
    public function getRfc()
    {
        return $this->rfc;
    }

    /**
     * Set the value of rfc
     *
     * @return  self
     */
    public function setRfc($rfc)
    {
        $this->rfc = $rfc;

        return $this;
    }

    /**
     * Get the value of ine
     */
    public function getIne()
    {
        return $this->ine;
    }

    /**
     * Set the value of ine
     *
     * @return  self
     */
    public function setIne($ine)
    {
        $this->ine = $ine;

        return $this;
    }

    /**
     * Get the value of curp
     */
    public function getCurp()
    {
        return $this->curp;
    }

    /**
     * Set the value of curp
     *
     * @return  self
     */
    public function setCurp($curp)
    {
        $this->curp = $curp;

        return $this;
    }

    /**
     * Get the value of fechanacimiento
     */
    public function getFechanacimiento()
    {
        return $this->fechanacimiento;
    }

    /**
     * Set the value of fechanacimiento
     *
     * @return  self
     */
    public function setFechanacimiento($fechanacimiento)
    {
        $this->fechanacimiento = $fechanacimiento;

        return $this;
    }

    /**
     * Get the value of numerocliente
     */
    public function getNumerocliente()
    {
        return $this->numerocliente;
    }

    /**
     * Set the value of numerocliente
     *
     * @return  self
     */
    public function setNumerocliente()
    {
        $this->numerocliente = $this->generaNroCliente();

        return $this;
    }

    /**
     * Get the value of refusuarios
     */
    public function getRefusuarios()
    {
        return $this->refusuarios;
    }

    /**
     * Set the value of refusuarios
     *
     * @return  self
     */
    public function setRefusuarios($refusuarios)
    {
        $this->refusuarios = $refusuarios;

        return $this;
    }

    /**
     * Get the value of fechacrea
     */
    public function getFechacrea()
    {
        return $this->fechacrea;
    }

    /**
     * Set the value of fechacrea
     *
     * @return  self
     */
    public function setFechacrea()
    {
        $this->fechacrea = date('Y-m-d H:i:s');

        return $this;
    }

    /**
     * Get the value of fechamodi
     */
    public function getFechamodi()
    {
        return $this->fechamodi;
    }

    /**
     * Set the value of fechamodi
     *
     * @return  self
     */
    public function setFechamodi()
    {
        $this->fechamodi = date('Y-m-d H:i:s');

        return $this;
    }

    /**
     * Get the value of reftipopersonas
     */
    public function getReftipopersonas()
    {
        return $this->reftipopersonas;
    }

    /**
     * Set the value of reftipopersonas
     *
     * @return  self
     */
    public function setReftipopersonas($reftipopersonas)
    {
        $this->reftipopersonas = $reftipopersonas;

        return $this;
    }

    /**
     * Get the value of telefonofijo
     */
    public function getTelefonofijo()
    {
        return $this->telefonofijo;
    }

    /**
     * Set the value of telefonofijo
     *
     * @return  self
     */
    public function setTelefonofijo($telefonofijo)
    {
        $this->telefonofijo = $telefonofijo;

        return $this;
    }

    /**
     * Get the value of telefonocelular
     */
    public function getTelefonocelular()
    {
        return $this->telefonocelular;
    }

    /**
     * Set the value of telefonocelular
     *
     * @return  self
     */
    public function setTelefonocelular($telefonocelular)
    {
        $this->telefonocelular = $telefonocelular;

        return $this;
    }

    /**
     * Get the value of idclienteinbursa
     */
    public function getIdclienteinbursa()
    {
        return $this->idclienteinbursa;
    }

    /**
     * Set the value of idclienteinbursa
     *
     * @return  self
     */
    public function setIdclienteinbursa($idclienteinbursa)
    {
        $this->idclienteinbursa = $idclienteinbursa;

        return $this;
    }

    /**
     * Get the value of emisioncomprobantedomicilio
     */
    public function getEmisioncomprobantedomicilio()
    {
        return $this->emisioncomprobantedomicilio;
    }

    /**
     * Set the value of emisioncomprobantedomicilio
     *
     * @return  self
     */
    public function setEmisioncomprobantedomicilio($emisioncomprobantedomicilio)
    {
        $this->emisioncomprobantedomicilio = $emisioncomprobantedomicilio;

        return $this;
    }

    /**
     * Get the value of emisionrfc
     */
    public function getEmisionrfc()
    {
        return $this->emisionrfc;
    }

    /**
     * Set the value of emisionrfc
     *
     * @return  self
     */
    public function setEmisionrfc($emisionrfc)
    {
        $this->emisionrfc = $emisionrfc;

        return $this;
    }

    /**
     * Get the value of vencimientoine
     */
    public function getVencimientoine()
    {
        return $this->vencimientoine;
    }

    /**
     * Set the value of vencimientoine
     *
     * @return  self
     */
    public function setVencimientoine($vencimientoine)
    {
        $this->vencimientoine = $vencimientoine;

        return $this;
    }

    /**
     * Get the value of colonia
     */
    public function getColonia()
    {
        return $this->colonia;
    }

    /**
     * Set the value of colonia
     *
     * @return  self
     */
    public function setColonia($colonia)
    {
        $this->colonia = $colonia;

        return $this;
    }

    /**
     * Get the value of municipio
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }

    /**
     * Set the value of municipio
     *
     * @return  self
     */
    public function setMunicipio($municipio)
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * Get the value of codigopostal
     */
    public function getCodigopostal()
    {
        return $this->codigopostal;
    }

    /**
     * Set the value of codigopostal
     *
     * @return  self
     */
    public function setCodigopostal($codigopostal)
    {
        $this->codigopostal = $codigopostal;

        return $this;
    }

    /**
     * Get the value of edificio
     */
    public function getEdificio()
    {
        return $this->edificio;
    }

    /**
     * Set the value of edificio
     *
     * @return  self
     */
    public function setEdificio($edificio)
    {
        $this->edificio = $edificio;

        return $this;
    }

    /**
     * Get the value of nroexterior
     */
    public function getNroexterior()
    {
        return $this->nroexterior;
    }

    /**
     * Set the value of nroexterior
     *
     * @return  self
     */
    public function setNroexterior($nroexterior)
    {
        $this->nroexterior = $nroexterior;

        return $this;
    }

    /**
     * Get the value of nrointerior
     */
    public function getNrointerior()
    {
        return $this->nrointerior;
    }

    /**
     * Set the value of nrointerior
     *
     * @return  self
     */
    public function setNrointerior($nrointerior)
    {
        $this->nrointerior = $nrointerior;

        return $this;
    }

    /**
     * Get the value of estado
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set the value of estado
     *
     * @return  self
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get the value of ciudad
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     * Set the value of ciudad
     *
     * @return  self
     */
    public function setCiudad($ciudad)
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    /**
     * Get the value of genero
     */
    public function getGenero()
    {
        return $this->genero;
    }

    /**
     * Set the value of genero
     *
     * @return  self
     */
    public function setGenero($genero)
    {
        $this->genero = $genero;

        return $this;
    }

    /**
     * Get the value of refestadocivil
     */
    public function getRefestadocivil()
    {
        return $this->refestadocivil;
    }

    /**
     * Set the value of refestadocivil
     *
     * @return  self
     */
    public function setRefestadocivil($refestadocivil)
    {
        $this->refestadocivil = $refestadocivil;

        return $this;
    }

    /**
     * Get the value of reftipoidentificacion
     */
    public function getReftipoidentificacion()
    {
        return $this->reftipoidentificacion;
    }

    /**
     * Set the value of reftipoidentificacion
     *
     * @return  self
     */
    public function setReftipoidentificacion($reftipoidentificacion)
    {
        $this->reftipoidentificacion = $reftipoidentificacion;

        return $this;
    }

    /**
     * Get the value of nroidentificacion
     */
    public function getNroidentificacion()
    {
        return $this->nroidentificacion;
    }

    /**
     * Set the value of nroidentificacion
     *
     * @return  self
     */
    public function setNroidentificacion($nroidentificacion)
    {
        $this->nroidentificacion = $nroidentificacion;

        return $this;
    }

    public function query($sql,$accion) {



		require_once 'appconfig.php';

		$appconfig	= new appconfig();
		$datos		= $appconfig->conexion();
		$hostname	= $datos['hostname'];
		$database	= $datos['database'];
		$username	= $datos['username'];
		$password	= $datos['password'];

		$conex = mysql_connect($hostname,$username,$password) or die ("no se puede conectar".mysql_error());

		mysql_select_db($database);

		        $error = 0;
		mysql_query("BEGIN");
		$result=mysql_query($sql,$conex);
		if ($accion && $result) {
			$result = mysql_insert_id();
		}
		if(!$result){
			$error=1;
		}
		if($error==1){
			mysql_query("ROLLBACK");
			return false;
		}
		 else{
			mysql_query("COMMIT");
			return $result;
		}

	}

    /**
     * Get the value of usuariocrea
     */
    public function getUsuariocrea()
    {
        return $this->usuariocrea;
    }

    /**
     * Set the value of usuariocrea
     *
     * @return  self
     */
    public function setUsuariocrea($usuariocrea)
    {
        $this->usuariocrea = $usuariocrea;

        return $this;
    }

    /**
     * Get the value of usuariomodi
     */
    public function getUsuariomodi()
    {
        return $this->usuariomodi;
    }

    /**
     * Set the value of usuariomodi
     *
     * @return  self
     */
    public function setUsuariomodi($usuariomodi)
    {
        $this->usuariomodi = $usuariomodi;

        return $this;
    }

   public function calculaedad(){
      list($ano,$mes,$dia) = explode("-",$this->getFechanacimiento());
      $ano_diferencia  = date("Y") - $ano;
      $mes_diferencia = date("m") - $mes;
      $dia_diferencia   = date("d") - $dia;
      if (($dia_diferencia < 0 || $mes_diferencia < 0) && ($ano != date("Y")))
         $ano_diferencia--;
      return $ano_diferencia;
   }
}

?>
