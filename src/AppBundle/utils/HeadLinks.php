<?php

namespace AppBundle\utils;

class HeadLinks
{
	var $links;


	public function __construct()
	{
		$this->links=array(
			array(
				"type"	=>	"image/x-icon",
				"href"	=>	"favicon",
				"rel"	=>	"icon",),
			array(
				"type"	=>	"text/css",
				"href"	=>	"css/bootstrap/css/bootstrap.css",
				"rel"	=>	"stylesheet",),

			);
	}

	public function getLinks()
	{
		return $this->links;
	}

	public function addLink($href,$rel,$type="")
	{
		$aux	=	$this->links;
		$item	=	array("type"=>$type,"href"=>$href,"rel"=>$rel);

		array_push($aux, $item);
		$this->links=$aux;
	}


}