<?php



namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="Colaboradores")
*/
class Colaborador
{
    /**
    * @ORM\Id
    * @ORM\Column(type="string",length=60)
    */
    private $id;

    /**
    * @ORM\Column(type="string",length=255)
    */
    private $nombre;

    /**
    * @ORM\Column(type="string")
    */
    private $uri;

    /**
    * @ORM\Column(type="text")
    */
    private $description;

    /**
    * @ORM\Column(type="string")
    */
    private $rol;


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

    /**
     * Set id
     *
     * @param string $id
     * @return Colaborador
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return string 
     */
    public function getId()
    {
        return $this->id;
    }
}
