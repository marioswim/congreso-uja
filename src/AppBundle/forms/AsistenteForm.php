<?php



namespace AppBundle\forms;


class AsistenteForm
{
	private $DNI;

	private $nombre;

	private $apellidos;

	private $telefono;

	
	private $email;

    private $file;

    private $public;

    private $polity;

    private $dir;

    private $cp;

    private $provincia;
    /**
     * Set DNI
     *
     * @param string $dNI
     * @return Asistente
     */
    public function __construct()
    {
    	$this->DNI="";
    	$this->nombre="";
    	$this->apellidos="";
    	$this->telefono="";
    	$this->email="";
    	$this->file="";
    }
    public function setDNI($dNI)
    {
        $this->DNI = $dNI;

        return $this;
    }

    /**
     * Get DNI
     *
     * @return string 
     */
    public function getDNI()
    {
        return $this->DNI;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Asistente
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apellidos
     *
     * @param string $apellidos
     * @return Asistente
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string 
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Asistente
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Asistente
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set file
     *
     * @param string $file
     * @return Asistente
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return string 
     */
    public function getFile()
    {
        return $this->file;
    }

    public function setPublic($public)
    {
        $this->public = $public;

        return $this;
    }

    /**
     * Get public
     *
     * @return string 
     */
    public function getPublic()
    {
        return $this->public;
    }

    public function setPolity($polity)
    {
        $this->polity = $polity;

        return $this;
    }

    /**
     * Get public
     *
     * @return string 
     */
    public function getPolity()
    {
        return $this->polity;
    }

    public function setDir($dir)
    {
        $this->dir = $dir;

        return $this;
    }

    /**
     * Get public
     *
     * @return string 
     */
    public function getDir()
    {
        return $this->dir;
    }

    public function setCp($cp)
    {
        $this->cp = $cp;

        return $this;
    }

    /**
     * Get public
     *
     * @return string 
     */
    public function getCp()
    {
        return $this->cp;
    }
    public function setProvincia($provincia)
    {
        $this->provincia= $provincia;

        return $this;
    }

    /**
     * Get public
     *
     * @return string 
     */
    public function getProvincia()
    {
        return $this->provincia;
    }
}
