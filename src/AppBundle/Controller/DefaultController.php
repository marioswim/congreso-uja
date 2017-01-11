<?php

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Colaborador;

use AppBundle\utils\Utils;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $utils      =   new Utils();

        $css        =   array("css/bootstrap/css/bootstrap.min.css","css/portada.css");
        $js         =   array("js/portada.js");
        
        $params     =   $utils->prepareHeaderAndNavbar("Inicio",$css,$js);
        
        $params["patners"]  =   $this->loadPatners();
        $params["map"]      =   $this->loadIndexMap();

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
    public function alojamientosAction()
    {

        $utils      =   new Utils();

        $css        =   array("css/bootstrap/css/bootstrap.min.css","css/mapa.css");
        
        $params     =   $utils->prepareHeaderAndNavbar("Alojamiento",$css);
        
        $params["map"]      =   $this->hotelesMap();

        return $this->render('default/mapa.html.twig', $params);
    }
        private function hotelesMap()
        {
            return "https://www.google.com/maps/d/embed?mid=1gVTR-v_Wv_ZoYSPsxqTzCiP7nsc";
        }
    public function saludoRectorAction()
    {
        $utils      =   new Utils();
        $css        =   array();
        $js         =   array();
        
        $params     =   $utils->prepareHeaderAndNavbar("Saludo del Rector",$css,$js);
        return $this->render("default/saludo.html.twig",$params);
    }
}
