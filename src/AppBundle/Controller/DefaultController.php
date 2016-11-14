<?php

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
Use AppBundle\utils\NavBar;
use AppBundle\utils\HeadLinks;
use AppBundle\Entity\Asistente;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        /*$asistente  =   new Asistente("12345678N");
        $asistente  ->  setNombre("sdfs");
        $asistente  ->  setApellidos("gdfg");
        $asistente  ->  setTelefono("sdfsdfsdfsd");
        $asistente  ->  setEmail("sdfgsdgsdgv");*/

        $navbar     =   new NavBar();
        $headlinks  =   new HeadLinks();   
        $links      =   $navbar->getLinks();
        $headlinks_links    = $headlinks->getLinks();
        /* $query=$this->getDoctrine()->getManager();

        $query->persist($asistente);
        $query->flush();*/

        $params=array(
            "title_page"    =>  "inicio", 
            "head_link"     =>  $headlinks_links,
            "content"       =>  "hola",
            "urls"          =>  $links,
        );
        $params["map"]=$this->loadIndexMap();
        return $this->render('default/index.html.twig', $params);
    }
        private function loadIndexMap()
        {


            return 'https://www.google.com/maps/d/embed?mid=1s9Gt2Cp-WvPhIHLDpdZihT8xMHk';

        }
}
