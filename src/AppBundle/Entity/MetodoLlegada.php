<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="MetodosLlegada")
*/

class MetodoLlegada
{
	/**
	* @ORM\Id
	* @ORM\Column(type="string",length=30)
	*/	
	private $id;
        
    /**
    * @ORM\Column(type="string",length=30)
    */
    private $nombre;





	/**
    * @ORM\Column(type="text")
	*/
	private $text;




    /**
     * Set id
     *
     * @param string $id
     * @return MetodoLlegada
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
     * Set text
     *
     * @param string $text
     * @return MetodoLlegada
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return MetodoLlegada
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
}
