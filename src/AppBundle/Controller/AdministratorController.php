<?php



namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
Use Symfony\Bundle\FrameworkBundle\Controller\Controller;
Use AppBundle\utils\NavBar;
use AppBundle\utils\HeadLinks;
use AppBundle\Entity\Asistente;
use Assetic\Exception\Exception; 

Use AppBundle\forms\AsistenteForm;

class AdministratorController extends Controller
{




public function loginAction()
{

	return $this->redirect("/");
}
public function logoutAction()
{


	$this->container->get('security.context')->setToken(null);
	return $this->redirect("/");	
}

}