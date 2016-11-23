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
	* @ORM\Column(type="string",length=100)
	*/
	
	private $email;
    /**
    * @ORM\Column(type="string")
    */
    private $direccion;
    /**
    * @ORM\Column(type="string",length=5)
    */
    private $cod_postal;
    /**
    * @ORM\Column(type="string",length=100)
    */
    private $provincia;
    /**
    * @ORM\Column(type="string",length=200)
    */
    private $universidad;
    /**
    * @ORM\Column(type="string",length=200)
    */
    private $cargo;
    /**
    * @ORM\Column(type="string")
    */
    private $image;

    /**
    * @ORM\Column(type="boolean")
    */

    private $public;

    /**
    * @ORM\Column(type="boolean")
    */
    private $cena;

    /**
    * @ORM\Column(type="boolean",nullable=true)
    */

    private $pagado;

    /**
    * @ORM\Column(type="datetime")
    */
    private $date;
    /**
    * @ORM\Column(type="string",length=10)
    */
    private $taller;
    

    /**
     * Set DNI
     *
     * @param string $dNI
     * @return Asistente
     */
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
     * Set direccion
     *
     * @param string $direccion
     * @return Asistente
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set cod_postal
     *
     * @param string $codPostal
     * @return Asistente
     */
    public function setCodPostal($codPostal)
    {
        $this->cod_postal = $codPostal;

        return $this;
    }

    /**
     * Get cod_postal
     *
     * @return string 
     */
    public function getCodPostal()
    {
        return $this->cod_postal;
    }

    /**
     * Set provincia
     *
     * @param string $provincia
     * @return Asistente
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get provincia
     *
     * @return string 
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * Set universidad
     *
     * @param string $universidad
     * @return Asistente
     */
    public function setUniversidad($universidad)
    {
        $this->universidad = $universidad;

        return $this;
    }

    /**
     * Get universidad
     *
     * @return string 
     */
    public function getUniversidad()
    {
        return $this->universidad;
    }

    /**
     * Set cargo
     *
     * @param string $cargo
     * @return Asistente
     */
    public function setCargo($cargo)
    {
        $this->cargo = $cargo;

        return $this;
    }

    /**
     * Get cargo
     *
     * @return string 
     */
    public function getCargo()
    {
        return $this->cargo;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Asistente
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set public
     *
     * @param boolean $public
     * @return Asistente
     */
    public function setPublic($public)
    {
        $this->public = $public;

        return $this;
    }

    /**
     * Get public
     *
     * @return boolean 
     */
    public function getPublic()
    {
        return $this->public;
    }

    /**
     * Set cena
     *
     * @param boolean $cena
     * @return Asistente
     */
    public function setCena($cena)
    {
        $this->cena = $cena;

        return $this;
    }

    /**
     * Get cena
     *
     * @return boolean 
     */
    public function getCena()
    {
        return $this->cena;
    }

    /**
     * Set pagado
     *
     * @param boolean $pagado
     * @return Asistente
     */
    public function setPagado($pagado)
    {
        $this->pagado = $pagado;

        return $this;
    }

    /**
     * Get pagado
     *
     * @return boolean 
     */
    public function getPagado()
    {
        return $this->pagado;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Asistente
     */
    public function setDate()
    {
        $this->date = new \DateTime("now");;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set taller
     *
     * @param string $taller
     * @return Asistente
     */
    public function setTaller($taller)
    {
        $this->taller = $taller;

        return $this;
    }

    /**
     * Get taller
     *
     * @return string 
     */
    public function getTaller()
    {
        return $this->taller;
    }
}
