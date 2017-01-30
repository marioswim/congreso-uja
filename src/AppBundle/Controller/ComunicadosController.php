<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
Use Symfony\Bundle\FrameworkBundle\Controller\Controller;
Use AppBundle\utils\NavBar;
use AppBundle\utils\HeadLinks;
use AppBundle\Entity\Asistente;
use Assetic\Exception\Exception; 


use AppBundle\utils\Utils;

class ComunicadosController extends Controller
{
	public function indexAction(Request $request)
    {
        $utils      =   new Utils();
        $css        =   array("css/comunicaciones.css");
        $js         =   array();
        
        $params     =   $utils->prepareHeaderAndNavbar("Programa",$css,$js);
        return $this->render("default/comunicados.html.twig",$params);
    }

}
