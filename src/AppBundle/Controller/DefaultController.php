<?php

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
Use AppBundle\utils\NavBar;
use AppBundle\utils\HeadLinks;
use AppBundle\Entity\Colaborador;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {


        $navbar     =   new NavBar();
        $headlinks  =   new HeadLinks();   
        $links      =   $navbar->getLinks();

        $headlinks->addLink("css/bootstrap/css/bootstrap.min.css","stylesheet","text/css");

        $headlinks->addLink("css/portada.css","stylesheet","text/css");
        $headlinks_links    = $headlinks->getLinks();

        $params=array(
            "title_page"    =>  "inicio", 
            "head_link"     =>  $headlinks_links,
            "content"       =>  "hola",
            "scripts"       =>  $headlinks->getScripts(),
            "urls"          =>  $links,
        );
        $params["patners"]=$this->loadPatners();
        $params["map"]=$this->loadIndexMap();

        return $this->render('default/index.html.twig', $params);
    }
        private function loadIndexMap()
        {


            return 'https://www.google.com/maps/d/embed?mid=1s9Gt2Cp-WvPhIHLDpdZihT8xMHk';

        }

        private function loadPatners()
        {

            $list = $this->getDoctrine()->getManager()->getRepository("AppBundle:Colaborador")->findBy(array(),array("rol"=>"desc","date"=>"asc"));

            $patners=array();

            foreach ($list as $item) 
            {
                $patners[$item->getRol()][$item->getId()]=array("nombre" => $item->getNombre(), "uri" => $item->getPath());                
            }
            return $patners;
        }
}
