<?php


namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
Use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
        $headlinks_links    = $headlinks->getLinks();

        $params=array(
            "title_page"    =>  "Prueba", 
            "head_link"     =>  $headlinks_links,
            "content"       =>  "prueba",
            "urls"          =>  $links,
        );
		

		$form 	= 	$this->createMyForm();
		$form 	=	$form->getForm();

		$form -> handleRequest($request);

	    if($form->isSubmitted() && $form->isValid()) 
	    {	        
	       	$this->insert($form->getData());
	    }

	    $params["form"]	=	$form->createView();
	    return $this->render('forms/colaborador.html.twig', $params);

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
			->add("description","textarea",array("label"=>"Descripción"))
			->add("file","file", array("label"=>"Logo Colaborador"))
			->add('save', 'submit', array('label' => 'Guardar'));
		return $form;
	}

	private function  insert($dataForm)
	{
		$dir 	=  '/var/www/congreso/web/files/images/';
		$file 	=  $dataForm->getFile();
		$name 	=  $dataForm->getKey().".".$file->guessExtension();
		$file 	-> move($dir,$name);
		
		$colaborador = new Colaborador();

		$colaborador -> setNombre($dataForm->getNombre());
		$colaborador -> setRol($dataForm->getRol());
		$colaborador -> setId($dataForm->getKey());
		$colaborador -> setDescription($dataForm->getDescription());
		$colaborador -> setUri('files/images/'.$name);
		
		


		

		$em = $this->getDoctrine()->getManager();
		$em -> persist($colaborador);
		$em -> flush();


	}

}