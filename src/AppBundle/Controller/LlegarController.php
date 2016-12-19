<?php



namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
Use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\MetodoLlegada;
use Assetic\Exception\Exception; 

use AppBundle\utils\Utils;


class LlegarController extends Controller
{


	public function indexAction()
	{
		$utils      =   new Utils();

        $css        =   array("css/llegar.css");
        
        $params     =   $utils->prepareHeaderAndNavbar("Como llegar",$css);
        

		$em			=	$this->getDoctrine()->getRepository("AppBundle:MetodoLlegada");		
		$content	=	$em->findAll();

		$params["content"]=$content;


		$securityContext = $this->container->get('security.authorization_checker');


		if ($this->get('security.context')->isGranted('ROLE_ADMIN')) 
		{
		   	return $this->render('administration/comollegar.html.twig', $params);
		}
		else
		{
			return $this->render('default/comollegar.html.twig', $params);
		}
	    
		
	}


	public function addAction(Request $request)
	{
		$utils      =   new Utils();

        $css        =   array("css/llegar.css");
        $js			=	array("ckeditor/ckeditor.js");
        $params     =   $utils->prepareHeaderAndNavbar("Añadir Medio transporte",$css,$js);
        

		$form 	= 	$this->comoLlegarForm();
		$form 	=	$form->getForm();

		$form -> handleRequest($request);

	    if($form->isSubmitted() && $form->isValid()) 
	    {	        
	      
	     
	      
	      $this->add($form->getData());
	      return $this->redirect("/como-llegar");
	      

	      
	    }

	    $params["form"]	 =	$form->createView();
	    return $this->render('forms/default.html.twig', $params);
	}

	public function editAction(Request $request,$keyword)
	{
		$utils      =   new Utils();

        $css        =   array("css/llegar.css");
        $js			=	array("ckeditor/ckeditor.js");


		$em = $this->getDoctrine()->getRepository("AppBundle:MetodoLlegada");

		$content=$em->findById($keyword);
		$content=$content[0];

        $params     =   $utils->prepareHeaderAndNavbar("Editar ".$content->getNombre(),$css,$js);


		$form = $this->comoLlegarForm($content);
		$form = $form->add('delete', 'submit', array(
				'label' => 'Eliminar',
				"attr" => array("class" => "btn btn-danger")
				));

		$form=$form->getForm();

		$form -> handleRequest($request);

		if($form->isSubmitted() && $form->isValid()) 
	    {	        
	      
	     
	      	switch ($form->getClickedButton()->getName()) 
			{
	      	case 'delete':
	      		return $this->redirect("/admin/como-llegar/".$keyword."/delete");
	      		break;
	      	
	      	case "save":
	      		$this->update($form->getData(),$keyword);
	      		return $this->redirect("/como-llegar");
	      		break;
	      	};
	      
	      

	      
	    }
		$params["form"]	 =	$form->createView();
	    return $this->render('forms/default.html.twig', $params);


	}
	public function deleteAction(Request $request,$keyword)
	{

		$em = $this->getDoctrine()->getManager();

		$prod=$em->getRepository("AppBundle:MetodoLlegada")->find($keyword);
		
		$em->remove($prod);
		$em->flush();	
				
	    return $this->redirect("/como-llegar");
	}
	private function comoLlegarForm($lleg = null)
	{
		if(is_null($lleg))
			$lleg =new MetodoLlegada();

		$form = $this->createFormBuilder($lleg)
			->add("id","choice",
				array("choices" => 
					array(
						"avion" 	=> "Avión"	,
						"autobus" 	=> "Autobús" 	,
						"urbano" 	=> "Autobús Urbano",
						"coche" 	=> "Coche"		,
						"tren" 		=> "Tren" 		,
						)
					,"label"=>"Medio de transporte","data" => $lleg->getId())
				)
			->add("text","textarea",array("label"=>"Descripción",
				"required" => false,"attr" => array("class"=>"ckeditor"),"data" => $lleg->getText()))
			->add('save', 'submit', array(
				'label' => 'Guardar',
				"attr" => array("class" => "btn btn-primary")
				));

		return $form;
	}

	private function add($form)
	{
		$names=array(	"avion" 	=> "Avión"	,
						"autobus" 	=> "Autobús" 	,
						"urbano" 	=> "Autobús Urbano",
						"coche" 	=> "Coche"		,
						"tren" 		=> "Tren");

		$form->setNombre($names[$form->getId()]);

		$em=$this->getDoctrine()->getManager();
		$em->persist($form);
		$em->flush();
	}
	private function update($data,$keyword)
	{
		$em=$this->getDoctrine()->getManager();
		$met=$em->getRepository("AppBundle:MetodoLlegada")->find($keyword);

		$met->setText($data->getText());
		$em->flush();

	}
}