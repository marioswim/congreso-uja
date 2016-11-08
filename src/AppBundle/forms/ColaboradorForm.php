<?php






namespace AppBundle\forms;



class ColaboradorForm
{

	private $key;


	private $nombre;


	private $file;

    
    private $description;

   
    private $rol;

    public function __construct()
    {
    	$this->key="";
    	$this->nombre="";
    	$this->file="";
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
     * Set file
     *
     * @param string $file
     * @return Colaborador
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
