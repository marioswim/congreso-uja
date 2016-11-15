<?php

namespace AppBundle\utils;

class HeadLinks
{
	var $links;
	var $scripts;

	public function __construct()
	{
		$this->scripts=array("js/jquery-1.10.0.min.js");
		$this->links=array(
			array(
				"type"	=>	"image/x-icon",
				"href"	=>	"favicon",
				"rel"	=>	"icon",),
			array(
				"type"	=>	"text/css",
				"href"	=>	"css/bootstrap/css/bootstrap.css",
				"rel"	=>	"stylesheet",),
			array(
				"type"	=>	"text/css",
				"href"	=>	"css/base.css",
				"rel"	=>	"stylesheet",)

			);
	}

	public function getLinks()
	{
		return $this->links;
	}

	public function getScripts()
	{
		return $this->scripts;
	}
	public function addLink($href,$rel,$type="")
	{
		$aux	=	$this->links;
		$item	=	array("type"=>$type,"href"=>$href,"rel"=>$rel);

		array_push($aux, $item);
		$this->links=$aux;
	}

	public function addScript($href)
	{
		$aux=$this->scripts;
		array_push($aux, $href);
		$this->scripts=$aux;
	}


}