<?php

date_default_timezone_set('America/Mexico_City');

class chatCrea {
    private $reftabla;
    private $idreferencia;
    private $email;
    private $emaildestinatario;
    private $esdirectorio;
    private $nombre;
    private $mensaje;
    private $fechacrea;
    private $leido;
    private $idrol;
    private $emailasesor;
    
    public function __construct($email, $emaildestinatario,$idrol,$emailasesor,$idreferencia) {
        $this->email             = $email;
        $this->emaildestinatario = $emaildestinatario;
        $this->idrol             = $idrol;
        $this->emailasesor       = $emailasesor;
        $this->idreferencia      = $idreferencia;

    }

    public function traerUsuariosChat() {
        //$mysqli = new mysqli('localhost', 'u115752684_desa', '@Chivas11', 'u115752684_desa');
        //$mysqli = new mysqli('localhost', 'root', '', 'u115752684_asesores');
        


        switch ($this->getIdrol()) {
            case 7:
                $sql = "SELECT 
                    u.email, u.nombrecompleto, r.descripcion AS posicion
                FROM
                    dbusuarios u
                        INNER JOIN
                    tbroles r ON r.idrol = u.refroles
                where u.refroles in (2,3,4,11,20,21)";
            break;
            case 20:
                $sql = "SELECT 
                r.email, r.nombrecompleto, r.posicion
            FROM
                (SELECT 
                    da.email COLLATE utf8_spanish_ci AS email,
                        da.razonsocial COLLATE utf8_spanish_ci AS nombrecompleto,
                        a.area COLLATE utf8_spanish_ci AS posicion
                FROM
                    dbdirectorioasesores da
                INNER JOIN tbareasdirectorio a ON a.idareadirectorio = da.refareadirectorios
                INNER JOIN dbasesores ase ON ase.idasesor = da.refasesores
                INNER JOIN dbusuarios u ON u.idusuario = ase.refusuarios
                WHERE
                    u.email = '".$this->getEmailasesor()."'
                        AND a.idareadirectorio IN (2 , 3) UNION ALL SELECT 
                    u.email COLLATE utf8_spanish_ci AS email,
                        u.nombrecompleto COLLATE utf8_spanish_ci AS nombrecompleto,
                        r.descripcion COLLATE utf8_spanish_ci AS posicion
                FROM
                    dbusuarios u
                INNER JOIN tbroles r ON r.idrol = u.refroles
                WHERE
                    (u.refroles IN (2,3,4,11,21)
                        OR (u.refroles = 7
                        AND u.email = '".$this->getEmailasesor()."'))) r";
            break;
            case 21:
                $sql = "SELECT 
                r.email, r.nombrecompleto, r.posicion
            FROM
                (SELECT 
                    da.email COLLATE utf8_spanish_ci AS email,
                        da.razonsocial COLLATE utf8_spanish_ci AS nombrecompleto,
                        a.area COLLATE utf8_spanish_ci AS posicion
                FROM
                    dbdirectorioasesores da
                INNER JOIN tbareasdirectorio a ON a.idareadirectorio = da.refareadirectorios
                INNER JOIN dbasesores ase ON ase.idasesor = da.refasesores
                INNER JOIN dbusuarios u ON u.idusuario = ase.refusuarios
                WHERE
                    u.email = '".$this->getEmailasesor()."'
                        AND a.idareadirectorio IN (2 , 3) UNION ALL SELECT 
                    u.email COLLATE utf8_spanish_ci AS email,
                        u.nombrecompleto COLLATE utf8_spanish_ci AS nombrecompleto,
                        r.descripcion COLLATE utf8_spanish_ci AS posicion
                FROM
                    dbusuarios u
                INNER JOIN tbroles r ON r.idrol = u.refroles
                WHERE
                    (u.refroles IN (2,3,4,11,20)
                        OR (u.refroles = 7
                        AND u.email = '".$this->getEmailasesor()."'))) r";
            break;
            case 2:
                $sql = "SELECT 
                r.email, r.nombrecompleto, r.posicion
            FROM
                (SELECT 
                    da.email COLLATE utf8_spanish_ci AS email,
                        da.razonsocial COLLATE utf8_spanish_ci AS nombrecompleto,
                        a.area COLLATE utf8_spanish_ci AS posicion
                FROM
                    dbdirectorioasesores da
                INNER JOIN tbareasdirectorio a ON a.idareadirectorio = da.refareadirectorios
                INNER JOIN dbasesores ase ON ase.idasesor = da.refasesores
                INNER JOIN dbusuarios u ON u.idusuario = ase.refusuarios
                WHERE
                    u.email = '".$this->getEmailasesor()."'
                        AND a.idareadirectorio IN (2 , 3) UNION ALL SELECT 
                    u.email COLLATE utf8_spanish_ci AS email,
                        u.nombrecompleto COLLATE utf8_spanish_ci AS nombrecompleto,
                        r.descripcion COLLATE utf8_spanish_ci AS posicion
                FROM
                    dbusuarios u
                INNER JOIN tbroles r ON r.idrol = u.refroles
                WHERE
                    (u.refroles IN (21,3,4,11,20)
                        OR (u.refroles = 7
                        AND u.email = '".$this->getEmailasesor()."'))) r";
            break;
            case 3:
                $sql = "SELECT 
                r.email, r.nombrecompleto, r.posicion
            FROM
                (SELECT 
                    da.email COLLATE utf8_spanish_ci AS email,
                        da.razonsocial COLLATE utf8_spanish_ci AS nombrecompleto,
                        a.area COLLATE utf8_spanish_ci AS posicion
                FROM
                    dbdirectorioasesores da
                INNER JOIN tbareasdirectorio a ON a.idareadirectorio = da.refareadirectorios
                INNER JOIN dbasesores ase ON ase.idasesor = da.refasesores
                INNER JOIN dbusuarios u ON u.idusuario = ase.refusuarios
                WHERE
                    u.email = '".$this->getEmailasesor()."'
                        AND a.idareadirectorio IN (2 , 3) UNION ALL SELECT 
                    u.email COLLATE utf8_spanish_ci AS email,
                        u.nombrecompleto COLLATE utf8_spanish_ci AS nombrecompleto,
                        r.descripcion COLLATE utf8_spanish_ci AS posicion
                FROM
                    dbusuarios u
                INNER JOIN tbroles r ON r.idrol = u.refroles
                WHERE
                    (u.refroles IN (2,21,4,11,20)
                        OR (u.refroles = 7
                        AND u.email = '".$this->getEmailasesor()."'))) r";
            break;
            case 4:
                $sql = "SELECT 
                r.email, r.nombrecompleto, r.posicion
            FROM
                (SELECT 
                    da.email COLLATE utf8_spanish_ci AS email,
                        da.razonsocial COLLATE utf8_spanish_ci AS nombrecompleto,
                        a.area COLLATE utf8_spanish_ci AS posicion
                FROM
                    dbdirectorioasesores da
                INNER JOIN tbareasdirectorio a ON a.idareadirectorio = da.refareadirectorios
                INNER JOIN dbasesores ase ON ase.idasesor = da.refasesores
                INNER JOIN dbusuarios u ON u.idusuario = ase.refusuarios
                WHERE
                    u.email = '".$this->getEmailasesor()."'
                        AND a.idareadirectorio IN (2 , 3) UNION ALL SELECT 
                    u.email COLLATE utf8_spanish_ci AS email,
                        u.nombrecompleto COLLATE utf8_spanish_ci AS nombrecompleto,
                        r.descripcion COLLATE utf8_spanish_ci AS posicion
                FROM
                    dbusuarios u
                INNER JOIN tbroles r ON r.idrol = u.refroles
                WHERE
                    (u.refroles IN (2,21,3,11,20)
                        OR (u.refroles = 7
                        AND u.email = '".$this->getEmailasesor()."'))) r";
            break;
            case 1:
                $sql = "SELECT 
                r.email, r.nombrecompleto, r.posicion
            FROM
                (SELECT 
                    da.email COLLATE utf8_spanish_ci AS email,
                        da.razonsocial COLLATE utf8_spanish_ci AS nombrecompleto,
                        a.area COLLATE utf8_spanish_ci AS posicion
                FROM
                    dbdirectorioasesores da
                INNER JOIN tbareasdirectorio a ON a.idareadirectorio = da.refareadirectorios
                INNER JOIN dbasesores ase ON ase.idasesor = da.refasesores
                INNER JOIN dbusuarios u ON u.idusuario = ase.refusuarios
                WHERE
                    u.email = '".$this->getEmailasesor()."'
                        AND a.idareadirectorio IN (2 , 3) UNION ALL SELECT 
                    u.email COLLATE utf8_spanish_ci AS email,
                        u.nombrecompleto COLLATE utf8_spanish_ci AS nombrecompleto,
                        r.descripcion COLLATE utf8_spanish_ci AS posicion
                FROM
                    dbusuarios u
                INNER JOIN tbroles r ON r.idrol = u.refroles
                WHERE
                    (u.refroles IN (2,21,3,11,20,4)
                        OR (u.refroles = 7
                        AND u.email = '".$this->getEmailasesor()."'))) r";
            break;
        }

            
            //die(var_dump($sql));
            
        $res = $this->query($sql,0);

        return $res;

    }

    public function traerChatPorUsuario() {
        //$mysqli = new mysqli('localhost', 'u115752684_desa', '@Chivas11', 'u115752684_desa');
        //$mysqli = new mysqli('localhost', 'root', '', 'u115752684_asesores');
        
        $error = '';
        
        $sql = "select
                    r.idchat,
                    r.reftabla,
                    r.idreferencia,
                    r.email,
                    r.emaildestinatario,
                    r.esdirectorio,
                    r.nombre,
                    r.mensaje,
                    r.fechacrea,
                    r.leido,
                    r.lado
                from (
                SELECT 
                    idchat,
                    reftabla,
                    idreferencia,
                    email,
                    emaildestinatario,
                    esdirectorio,
                    nombre,
                    mensaje,
                    fechacrea,
                    leido,
                    0 as lado
                FROM
                    dbchat
                WHERE
                    email = '".$this->getEmail()."'
                        AND emaildestinatario = '".$this->getEmaildestinatario()."'
                        AND idreferencia = ".$this->getIdreferencia()."
                        
                union all
                
                SELECT 
                    idchat,
                    reftabla,
                    idreferencia,
                    email,
                    emaildestinatario,
                    esdirectorio,
                    nombre,
                    mensaje,
                    fechacrea,
                    leido,
                    1 as lado
                FROM
                    dbchat
                WHERE
                    email = '".$this->getEmaildestinatario()."'
                        AND emaildestinatario = '".$this->getEmail()."'
                        AND idreferencia = ".$this->getIdreferencia()."
                ) r
                order by r.fechacrea";

        
        $res = $this->query($sql,0);

        return $res;
            

    }

    public function contruirChat() {
        $cad = '
        <div class="containerchatcrea">
            <div class="messaging">
                <div class="inbox_msg">
                    <div class="inbox_people">
                    <div class="headind_srch" style="display:none;">
                        <div class="recent_heading">
                        <h4>Recent</h4>
                        </div>
                        <div class="srch_bar">
                        <div class="stylish-input-group">
                            <input type="text" class="search-bar"  placeholder="Search" >
                            <span class="input-group-addon">
                            <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                            </span> </div>
                        </div>
                    </div>
                    <div class="inbox_chat">
                        
                        
                    </div>
                    </div>
                    <div class="mesgs">
                    <div class="msg_history">
                        
                    </div>
                    <div class="type_msg">
                        <div class="input_msg_write">
                        <input type="text" class="write_msg" placeholder="Escriba aqui el mensaje" />
                        <button class="msg_send_btn" type="button"><i class="material-icons">send</i></button>
                        </div>
                    </div>
                    </div>
                </div>
                
                </div></div>
        ';

        return $cad;
    }

    /**
     * Get the value of reftabla
     */ 
    public function getReftabla()
    {
        return $this->reftabla;
    }

    /**
     * Set the value of reftabla
     *
     * @return  self
     */ 
    public function setReftabla($reftabla)
    {
        $this->reftabla = $reftabla;

        return $this;
    }

    /**
     * Get the value of idreferencia
     */ 
    public function getIdreferencia()
    {
        return $this->idreferencia;
    }

    /**
     * Set the value of idreferencia
     *
     * @return  self
     */ 
    public function setIdreferencia($idreferencia)
    {
        $this->idreferencia = $idreferencia;

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
     * Get the value of emaildestinatario
     */ 
    public function getEmaildestinatario()
    {
        return $this->emaildestinatario;
    }

    /**
     * Set the value of emaildestinatario
     *
     * @return  self
     */ 
    public function setEmaildestinatario($emaildestinatario)
    {
        $this->emaildestinatario = $emaildestinatario;

        return $this;
    }

    /**
     * Get the value of esdirectorio
     */ 
    public function getEsdirectorio()
    {
        return $this->esdirectorio;
    }

    /**
     * Set the value of esdirectorio
     *
     * @return  self
     */ 
    public function setEsdirectorio($esdirectorio)
    {
        $this->esdirectorio = $esdirectorio;

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
     * Get the value of mensaje
     */ 
    public function getMensaje()
    {
        return $this->mensaje;
    }

    /**
     * Set the value of mensaje
     *
     * @return  self
     */ 
    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;

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
    public function setFechacrea($fechacrea)
    {
        $this->fechacrea = date('Y-m-d H:i:s');

        return $this;
    }

    /**
     * Get the value of leido
     */ 
    public function getLeido()
    {
        return $this->leido;
    }

    /**
     * Set the value of leido
     *
     * @return  self
     */ 
    public function setLeido($leido)
    {
        $this->leido = $leido;

        return $this;
    }

    /**
     * Get the value of idrol
     */ 
    public function getIdrol()
    {
        return $this->idrol;
    }

    /**
     * Set the value of idrol
     *
     * @return  self
     */ 
    public function setIdrol($idrol)
    {
        $this->idrol = $idrol;

        return $this;
    }

    /**
     * Get the value of emailasesor
     */ 
    public function getEmailasesor()
    {
        return $this->emailasesor;
    }

    /**
     * Set the value of emailasesor
     *
     * @return  self
     */ 
    public function setEmailasesor($emailasesor)
    {
        $this->emailasesor = $emailasesor;

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
}

































?>