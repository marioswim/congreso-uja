<?php

namespace AppBundle\utils;


class NavBar{

	
	var $links;

	public function __construct()
	{

		$this->links= array(
			array(
				"url"	=>	"/",
				"title" => 	"Inicio"),
			array(
				"url" 	=> 	"/saludo-rector",
				"title" =>	"Saludo del Rector"),
			array(
				"url" 	=> 	"/inscripcion",
				"title" =>	"Inscripción"),
			array(
				"url"	=> 	"/programa",
				"title"	=>	"Programa",
				),
			array(
				"url" 	=> 	"/asistentes",
				"title" =>	"Asistentes"),
			array(
				"url" 	=>	"/alojamiento",
				"title"	=>	"Alojamiento",
				),
			array(
				"url" 	=> 	"/comunicaciones",
				"title"	=>	"Comunicaciones"),
			array(
				"url" 	=> 	"/streaming",
				"title"	=>	"Streaming"),
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