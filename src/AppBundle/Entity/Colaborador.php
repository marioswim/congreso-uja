<?php


//To Do Mejorar gestion imagen
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
    * @ORM\Column(type="string")
    */
    private $rol;
    /**
    * @ORM\Column(type="string",length=255)
    */
    private $nombre;


    /**
    * @ORM\Column(type="text")
    */
    private $description;

    /**
    * @ORM\Column(type="string")
    */
    private $path;

    /**
    * @ORM\Column(type="blob")
    */
    private $file;    

    /**
    * @ORM\Column(type="datetime")
    */
    private $date;

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
     * Set path
     *
     * @param string $path
     * @return Colaborador
     */
    public function setPath()
    {

        $this->path = "files/images/patners/".$this->id.".".$this->file->getClientOriginalExtension();

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set file
     *
     * @param \file $file
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
     * @return \file 
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Colaborador
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
    
    public function upload()
    {
        $this->getFile()->move("/var/www/congreso/files/images/patners/",$this->id.".".$this->file->getClientOriginalExtension());
        $this->setFile(file_get_contents($this->path));

    }

    public function deleteFile()
    {
        return unlink($this->path);
    }

}
