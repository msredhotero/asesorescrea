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
        $mysqli = new mysqli('localhost', 'u115752684_desa', 'u115752684_desa', '@Chivas11');
        //$mysqli = new mysqli('localhost', 'root', '', 'u115752684_asesores');
        

        if ($mysqli->connect_errno) {
            $error = "No se pudo establecar una conexcion.";
            return $error;
        } else {

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
                        u.email, u.nombrecompleto, r.descripcion AS posicion
                    FROM
                        dbusuarios u
                            INNER JOIN
                        tbroles r ON r.idrol = u.refroles
                    where (u.refroles in (2,3,4,11,21) or (u.refroles = 7 and u.email = '".$this->getEmailasesor()."'))";
                break;
                case 21:
                    $sql = "SELECT 
                        u.email, u.nombrecompleto, r.descripcion AS posicion
                    FROM
                        dbusuarios u
                            INNER JOIN
                        tbroles r ON r.idrol = u.refroles
                    where (u.refroles in (2,3,4,11,20) or (u.refroles = 7 and u.email = '".$this->getEmailasesor()."'))";
                break;
                case 2:
                    $sql = "SELECT 
                        u.email, u.nombrecompleto, r.descripcion AS posicion
                    FROM
                        dbusuarios u
                            INNER JOIN
                        tbroles r ON r.idrol = u.refroles
                    where (u.refroles in (21,3,4,11,20) or (u.refroles = 7 and u.email = '".$this->getEmailasesor()."'))";
                break;
                case 3:
                    $sql = "SELECT 
                        u.email, u.nombrecompleto, r.descripcion AS posicion
                    FROM
                        dbusuarios u
                            INNER JOIN
                        tbroles r ON r.idrol = u.refroles
                    where (u.refroles in (2,21,4,11,20) or (u.refroles = 7 and u.email = '".$this->getEmailasesor()."'))";
                break;
                case 4:
                    $sql = "SELECT 
                        u.email, u.nombrecompleto, r.descripcion AS posicion
                    FROM
                        dbusuarios u
                            INNER JOIN
                        tbroles r ON r.idrol = u.refroles
                    where (u.refroles in (2,21,3,11,20) or (u.refroles = 7 and u.email = '".$this->getEmailasesor()."'))";
                break;
                case 1:
                    $sql = "SELECT 
                        u.email, u.nombrecompleto, r.descripcion AS posicion
                    FROM
                        dbusuarios u
                            INNER JOIN
                        tbroles r ON r.idrol = u.refroles
                    where (u.refroles in (2,21,3,11,20,4) or (u.refroles = 7 and u.email = '".$this->getEmailasesor()."'))";
                break;
            }

            
            //die(var_dump($sql));
            
            if (!$resultado = $mysqli->query($sql)) {
                
                echo "Error: La ejecución de la consulta falló debido a: \n";
                echo "Query: " . $sql . "\n";
                echo "Errno: " . $mysqli->errno . "\n";
                echo "Error: " . $mysqli->error . "\n";
                
            } else {
                // no hay filas
                if ($resultado->num_rows === 0) {
                    return 0;
                } else {
                    
                    return $mysqli->query($sql);

                }
            }
            


        }
        //$resultado->free();
        $mysqli->close();
    }

    public function traerChatPorUsuario() {
        $mysqli = new mysqli('localhost', 'u115752684_desa', 'u115752684_desa', '@Chivas11');
        //$mysqli = new mysqli('localhost', 'root', '', 'u115752684_asesores');
        
        $error = '';
        if ($mysqli->connect_errno) {
            $error = "No se pudo establecar una conexcion.";
            return $error;
        } else {
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

            
            if (!$resultado = $mysqli->query($sql)) {
                
                echo "Error: La ejecución de la consulta falló debido a: \n";
                echo "Query: " . $sql . "\n";
                echo "Errno: " . $mysqli->errno . "\n";
                echo "Error: " . $mysqli->error . "\n";
                
            } else {
                // no hay filas
                if ($resultado->num_rows === 0) {
                    return 0;
                } else {
                    
                    return $mysqli->query($sql);

                }
            }
            


        }
        //$resultado->free();
        $mysqli->close();
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
}

































?>