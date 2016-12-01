<?php

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
Use AppBundle\utils\NavBar;
use AppBundle\utils\HeadLinks;


class LeyController extends Controller
{


    public function indexAction(Request $request)
    {
        $navbar     =   new NavBar();
        $headlinks  =   new HeadLinks();   
        $links      =   $navbar->getLinks();

        $headlinks->addLink("css/bootstrap/css/bootstrap.min.css","stylesheet","text/css");
        $headlinks->addLink("css/portada.css","stylesheet","text/css");

        $headlinks_links    = $headlinks->getLinks();

        $params=array(
            "title_page"    =>  "Politica de privacidad", 
            "head_link"     =>  $headlinks_links,
            "content"       =>  "hola",
            "scripts"       =>  $headlinks->getScripts(),
            "urls"          =>  $links,
        );
        dump($params);
        return $this->render('default/politica.html.twig', $params);

    }
}
