<?php


namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;


/**
* @ORM\Entity
* @ORM\Table(name="Asistente")
*/
class Asistente
{
	/**
	* @ORM\Id
	* @ORM\Column(type="string",length=9)
	*/
	private $DNI;

	/**
	* @ORM\Column(type="string",length=60)
	*/

	private $nombre;

	/**
	* @ORM\Column(type="string",length=100)
	*/

	private $apellidos;
	
	/**
	* @ORM\Column(type="string",length=9)
	*/

	private $telefono;

	/**
	* @ORM\Column(type="string",length=200)
	*/
	
	private $email;


    /**
     * Set DNI
     *
     * @param string $dNI
     * @return Asistente
     */
    public function __construct($dni)
    {
    	$this->DNI=$dni;
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
}
