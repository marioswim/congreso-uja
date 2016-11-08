<?php






namespace AppBundle\forms;



class Colaborador
{

	private $key;


	private $nombre;


	private $uri;

    
    private $description;

   
    private $rol;

    public function __construct()
    {
    	$this->key="";
    	$this->nombre="";
    	$this->uri="";
    	$this->description="";
    	$this->rol="";
    }
    /**
     * Set key
     *
     * @param string $key
     * @return Colaborador
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get key
     *
     * @return string 
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Colaborador
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
     * Set uri
     *
     * @param string $uri
     * @return Colaborador
     */
    public function setUri($uri)
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * Get uri
     *
     * @return string 
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Colaborador
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set rol
     *
     * @param string $rol
     * @return Colaborador
     */
    public function setRol($rol)
    {
        $this->rol = $rol;

        return $this;
    }

    /**
     * Get rol
     *
     * @return string 
     */
    public function getRol()
    {
        return $this->rol;
    }
}
