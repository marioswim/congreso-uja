<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
Use Symfony\Bundle\FrameworkBundle\Controller\Controller;
Use AppBundle\utils\NavBar;
use AppBundle\utils\HeadLinks;


use Assetic\Exception\Exception; 

Use AppBundle\forms\ContactForm;


class ContactoController extends Controller
{




	public function indexAction(Request $request)
	{
		$navbar     =   new NavBar();
        $headlinks  =   new HeadLinks();   
        $links      =   $navbar->getLinks();
        
        $headlinks->addLink("css/contacto.css","stylesheet","text/css");
        
        $headlinks_links    = $headlinks->getLinks();

        $params=array(
            "title_page"    =>  "Contacto", 
            "head_link"     =>  $headlinks_links,
	        "scripts"		=>	null,    
            "urls"          =>  $links,
        );
		
		$form 	= 	$this->contactForm();
		$form 	=	$form->getForm();

		$form 		-> 	handleRequest($request);
		
	    if($form->isSubmitted() && $form->isValid()) 
	    {	        
	      
	     
	    	$code=$this->gestionarDestinatarios($form->getData());      

	      
	    }

	    $params["form"]	=	$form->createView();

	    return $this->render('forms/contacto.html.twig', $params);

	
	}
	private function gestionarDestinatarios($form)
	{
		$reciver="quesada@ujaen.es";
		$code=$this->sendMail($form,$reciver);
		
		if($code && $form->copia)
			$code=$this->sendMail($form,$form->email);


	}
	private function sendMail($form,$to)
	{
		$sender		=	"quesada@ujaen.es";

		$content=array(
			"nombre"		=>	$form->nombre,
			"apellidos" 	=>	$form->apellidos,
			"mail" 			=>	$form->email,
			"telefono"		=>	$form->telefono,
			
			"mensaje"		=>	$form->mensaje,
			);
		

		$message = \Swift_Message::newInstance()
        ->setSubject('[WebForm][FeedBack]: '.$form->asunto)
        ->setFrom($sender)
        ->setTo($to)
        ->setBody(        	    	
            $this->renderView(
                'Emails/contacto.html.twig',
                array('content' => $content)
            ),
            'text/html'
        );

	    return $this->get('mailer')->send($message);
	}

	private function contactForm()
	{
		$contactForm = new ContactForm();

		$form = $this->createFormBuilder($contactForm)
			->add(
				"nombre","text",array(
					"required" 	=> true,
					"attr" 		=> array(
						"class" 		=> "persona",
						"placeholder" 	=> "Nombre")))
			
			->add("apellidos","text",array(
					"required" 		=> true,
					"attr" 			=> array(
						"class" 			=> "persona",
						"placeholder" 		=> "Apellidos")))
			
			->add("email","text",array(
					"required" 	=> true,
					"attr" 		=> array(
						"class" 		=> "contacto",
						"placeholder" 	=> "Email")))
			
			->add("telefono","text",array(
					"required" 	=> true,
					"attr"		=> array(
						"class" 		=> "contacto",
						"placeholder" 	=> "Teléfono",
						"maxlength"		=>9,)))
			
			->add("asunto","text",array(
					"required" 	=> true,
					"attr" 		=> array(
						"class" 		=> "correo",
						"placeholder" 	=> "Asunto")))
			
			->add("mensaje","textarea",array(
					"required" 	=> true,
					"attr" 		=> array(
						"class" 		=> "correo",
						"placeholder" 	=> "Mensaje")))

			->add("copia","checkbox",array(
					"required" 	=> false,
					"label"		=> "Deseo Recibir una copia",
					"attr" 		=> array(
						"class" 		=> "copia",
						"placeholder" 	=> "")))

			->add("save","submit",array(
					'label' => 'Guardar',
					"attr" => array(
						"class" => "btn btn-primary")));

			return $form;
	}


}