<?php


namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
Use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Symfony\Component\Form\FormError;
use AppBundle\Entity\Colaborador;

use AppBundle\utils\Utils;


class ColaboradorController extends Controller
{


	


	public function addAction(Request $request)
	{
		$utils 	= 	new Utils();

        $js 	= 	array("ckeditor/ckeditor.js");
        $css 	= 	array("css/colaboradorForm.css");
        
        $params =	$utils->prepareHeaderAndNavbar("Añadir Colaborador",$css,$js);


		$form 	= 	$this->createMyForm();
		$form 	=	$form->getForm();

		$form -> handleRequest($request);

	    if($form->isSubmitted() && $form->isValid()) 
	    {	        
	       	$aux	=	$this->insert($form->getData());

	       	if(is_string($aux))

	       		$this->errorForm($aux,$form);
	       	
	       	else
	       		return $aux;
	    }

	    $params["form"]	=	$form->createView();
	    return $this->render('forms/default.html.twig', $params);

	}

	public function editAction(Request $request,$keyword)
	{

        
        $utils 	= 	new Utils();

        $js 	= 	array("ckeditor/ckeditor.js");
        $css 	= 	array("css/colaboradorForm.css");        
       
		$em  	= 	$this->getDoctrine()->getRepository("AppBundle:Colaborador");

		$content 	=	$em->findById($keyword);
		$content 	=	$content[0];

        $params 	=	$utils->prepareHeaderAndNavbar("Editar ".$content->getRol()." ".$content->getNombre(),$css,$js);



		$form = $this->createMyForm($content);
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
	      		return $this->redirect("/admin/colaborador/".$keyword."/delete");
	      		break;
	      	
	      	case "save":
	      		$this->update($form->getData(),$keyword);
	      		return $this->redirect("/");
	      		break;
	      	};
	      
	      

	      
	    }
		$params["form"]	 =	$form->createView();
	    return $this->render('forms/default.html.twig', $params);


	
	}
	public function deleteAction(Request $request,$keyword)
	{
		    
		$em = $this->getDoctrine()->getManager();

		$prod=$em->getRepository("AppBundle:Colaborador")->find($keyword);
		$prod->deleteFile();
		$em->remove($prod);
		$em->flush();	
		
				
	    return $this->redirect("/");
	}
	private function createMyForm($colaborador=null)
	{
		if(is_null($colaborador))
		{
			$colaborador = new Colaborador();
			$flag=true;
		}
		else
		{
			$flag=false;
		}	
		
		$form = $this->createFormBuilder($colaborador)
			->add("nombre","text",array("label"=>"Nombre"))
			->add("id","text",array("label"=>"KeyWord para URL"))
			->add("rol","choice",
				array("choices"=> 
					array(
						"Colaborador" => "Colaborador",
						"Patrocinador"=>"Patrocinador",
						"Organizador" => "Organizador"
						),
					"label" => "Rol en el congreso"
					)
				)
			->add("description","textarea",array("label"=>"Descripción","attr" => array("class"=>"ckeditor")))
			->add("file","file", array(
				"required" => $flag,
				"label"			=>	"Logo Colaborador",
				"data_class" => null)) //To Do mejorar gestion imagen
			->add('save', 'submit', array(
				'label' => 'Guardar',
				"attr" => array("class" => "btn btn-primary")
				)
			);
		return $form;
	}

	private function  insert($colaborador)
	{
		$colaborador->setPath();
		$colaborador->setDate();
		

		$em = $this->getDoctrine()->getManager();
		$em -> persist($colaborador);

		try
		{
			$em -> flush();			
			
			$colaborador->upload();
			return $this->redirect("/");

		}
		catch(\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e)
		{
			switch ($e->getPrevious()->getErrorCode()) 
			{
				case 1062:
					return "Keyword existente, utilice otra.";
					break;
				
				default:
					# code...
					break;
			}

		}
	}
	private function update($data,$keyword)
	{

		$em=$this->getDoctrine()->getManager();
		$colaborador=$em->getRepository("AppBundle:Colaborador")->find($keyword);

		$colaborador->setNombre($data->getNombre());
		$colaborador->setRol($data->getRol());
		$colaborador->setId($data->getId());
		$colaborador->setDescription($data->getDescription());
		$colaborador->setFile($data->getFile());
		$colaborador->setPath();
		$colaborador->upload();
		$em->flush();

	}
	private function errorForm($text, &$form)
	{
		$error=new FormError($text,null,array("key"));
		$form->addError($error);
	}

}