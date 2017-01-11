<?php

namespace AppBundle\utils;


class NavBar{

	
	var $links;

	public function __construct()
	{

		$this->links= array(
			array(
				"url"	=>	"/",
				"title" => 	"inicio"),
			array(
				"url" 	=> 	"/saludo-rector",
				"title" =>	"Saludo Rector"),
			array(
				"url" 	=> 	"/inscripcion",
				"title" =>	"Inscripción"),
			array(
				"url" 	=> 	"/asistentes",
				"title" =>	"Asistentes"),
			/*array(
				"url"	=>	"/prueba", 
				"title" =>	"prueba"),*/
			/*array(
				"url" 	=>	"colaborador/add",
				"title"	=>	"Añadir Partner",
				),*/
			array(
				"url" 	=>	"/como-llegar",
				"title"	=>	"Como Llegar",
				),
			array(
				"url" 	=>	"/alojamiento",
				"title"	=>	"Alojamiento",
				),
			array(
				"url" 	=>	"/contacto",
				"title"	=>	"Contacto",
				)
		);
	}

	public function getLinks()
	{
		return $this->links;
	}
}