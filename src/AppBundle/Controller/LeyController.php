<?php

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\utils\Utils;


class LeyController extends Controller
{


    public function indexAction(Request $request)
    {
        $utils      =   new Utils();

        $css        =   array("css/bootstrap/css/bootstrap.min.css","css/base.css");
        
        $params     =   $utils->prepareHeaderAndNavbar("Politica de privacidad",$css);
       
        return $this->render('default/politica.html.twig', $params);

    }
}
