<?php


namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
Use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Form\FormError;
use AppBundle\Entity\Colaborador;
use AppBundle\forms\ColaboradorForm;

Use AppBundle\utils\NavBar;
use AppBundle\utils\HeadLinks;

class ColaboradorController extends Controller
{


	


	public function addAction(Request $request)
	{
		$navbar     =   new NavBar();
        $headlinks  =   new HeadLinks();   
        $links      =   $navbar->getLinks();

        $headlinks->addScript("ckeditor/ckeditor.js");
        
        $headlinks_links    = $headlinks->getLinks();

        $params=array(
            "title_page"    =>  "Inscripción", 
            "head_link"     =>  $headlinks_links,
            "content"       =>  "prueba",
            "scripts"		=> 	$headlinks->getScripts(),
            "urls"          =>  $links,
        );
		
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


	private function createMyForm()
	{
		$colaborador = new ColaboradorForm();

		$form = $this->createFormBuilder($colaborador)
			->add("nombre","text",array("label"=>"Nombre"))
			->add("key","text",array("label"=>"KeyWord para URL"))
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
			->add("file","file", array("label"=>"Logo Colaborador"))
			->add('save', 'submit', array(
				'label' => 'Guardar',
				"attr" => array("class" => "btn btn-primary")
				)
			);
		return $form;
	}

	private function  insert($dataForm)
	{
		$dir 	=  '/var/www/congreso/web/files/images/';
		$file 	=  $dataForm->getFile();
		$name 	=  $dataForm->getKey().".".$file->guessExtension();
		
		$colaborador = new Colaborador();

		$colaborador -> setNombre($dataForm->getNombre());
		$colaborador -> setRol($dataForm->getRol());
		$colaborador -> setId($dataForm->getKey());
		$colaborador -> setDescription($dataForm->getDescription());
		$colaborador -> setUri('files/images/'.$name);
		

		$em = $this->getDoctrine()->getManager();
		$em -> persist($colaborador);

		try
		{
			$em -> flush();			
			$file 	-> move($dir,$name);
			return $this->redirect("homepage");

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

	private function errorForm($text, &$form)
	{
		$error=new FormError($text,null,array("key"));
		$form->addError($error);
	}

}