<?php

namespace AppBundle\Controller;


Use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
Use Symfony\Component\HttpFoundation\Response;
Use Symfony\Bundle\FrameworkBundle\Controller\Controller;

Use AppBundle\utils\NavBar;
use AppBundle\utils\HeadLinks;



Class PruebaController extends Controller
{

	function indexAction()
	{
		$navbar     =   new NavBar();
        $headlinks  =   new HeadLinks();   
        $links      =   $navbar->getLinks();
        $headlinks_links    = $headlinks->getLinks();

        $params=array(
            "title_page"    =>  "Prueba", 
            "head_link"     =>  $headlinks_links,
            "content"       =>  "prueba",
            "urls"          =>  $links,
        );
        return $this->render('default/index.html.twig', $params);
	}
}
