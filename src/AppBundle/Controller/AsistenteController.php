<?php



namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
Use Symfony\Bundle\FrameworkBundle\Controller\Controller;
Use AppBundle\utils\NavBar;
use AppBundle\utils\HeadLinks;
use AppBundle\Entity\Asistente;
use Assetic\Exception\Exception; 

Use AppBundle\forms\AsistenteForm;

class AsistenteController extends Controller
{



	public function singUpAction(Request $request)
	{

		$navbar     =   new NavBar();
        $headlinks  =   new HeadLinks();   
        $links      =   $navbar->getLinks();
        
        $headlinks_links    = $headlinks->getLinks();

        $params=array(
            "title_page"    =>  "Registro", 
            "head_link"     =>  $headlinks_links,
            
            "urls"          =>  $links,
        );
		
		$form 	= 	$this->singUpForm();
		$form 	=	$form->getForm();

		$form -> handleRequest($request);

	    if($form->isSubmitted() && $form->isValid()) 
	    {	        
	      
	     
	      
	      $this->insert($form->getData());
	      return $this->redirect("/");
	      

	      
	    }

	    $params["form"]	=	$form->createView();
	    return $this->render('forms/colaborador.html.twig', $params);

	}
		private function insert($data)
		{
			$dir="files/images/inscritos/";

			$file 	=	$data->getFile();
			$dni 	= 	$data->getDNI();

			$fileName 	= 	$dni.".".$file->guessExtension();

			

			$asistente 	=	new Asistente();

			$asistente 	->	setDNI($data 		->	getDNI());
			$asistente 	->	setNombre($data 	->	getNombre());
			$asistente 	->	setApellidos($data 	->	getApellidos());
			$asistente 	->	setEmail($data 		->	getEmail());
			$asistente 	->	setTelefono($data 	->	getTelefono());
			$asistente 	->	setPublic($data 	->	getPublic());

			$asistente 	->	setImage($dir."".$fileName);

			$em 	= 	$this->getDoctrine()->getManager();

			$em->persist($asistente);


			$em 	->	flush();

			

			$file 	->	move("/var/www/congreso/".$dir,$fileName);
			$this	->	sendMail($asistente);
			


		}
	private function sendMail($asistente)
	{

		$params=array(
			"nombre"		=>	$asistente->getNombre(),
			"apellidos" 	=>	$asistente->getApellidos(),
			"mail" 			=>	$asistente->getEmail(),
			"telefono"		=>	$asistente->getTelefono(),
			"file"			=> 	$asistente->getImage(),
			);

		$message = \Swift_Message::newInstance()
		->attach(\Swift_Attachment::fromPath($params["file"]))
        ->setSubject('[Jornadas]: Inscripción '.$asistente->getDNI())
        ->setFrom('quesada@ujaen.es')
        ->setTo('quesada@ujaen.es')
        ->setBody(        	    	
            $this->renderView(
                // app/Resources/views/Emails/registration.html.twig
                'Emails/inscripcion.html.twig',
                array('asis' => $params)
            ),
            'text/html'
        );

	    return $this->get('mailer')->send($message);

	}

	public function showPublicAction()
	{
		
		$navbar     =   new NavBar();
        $headlinks  =   new HeadLinks();   
        $links      =   $navbar->getLinks();
        $headlinks_links    = $headlinks->getLinks();
        
		$em 	= 	$this->getDoctrine()->getRepository("AppBundle:Asistente");
		$public =	$em->findByPublic(1);

		$params=array(
            "title_page"    =>  "Asistentes", 
            "head_link"     =>  $headlinks_links,
            "publics"		=>	$public,
            "urls"          =>  $links,
        );

		return $this->render('default/asistentes.html.twig', $params);

	}

	public function publicAction()
	{



	}

	private function singUpForm()
	{
		$asis = new AsistenteForm();

		$form = $this->createFormBuilder($asis)
			->add("DNI","text",array("label"=>"DNI"))
			->add("nombre","text",array("label"=>"Nombre"))
			->add("apellidos","text",array("label"=>"Apellidos"))
			->add("telefono","text",array("label"=>"Teléfono"))
			->add("email","text",array("label"=>"Email"))
			->add("public","checkbox",array("label"=>"Permito que mi asistencia se publique en el listado de asistentes",
				"required" => false,))
			->add("file","file", array("label"=>"Foto Identificativa"))
			->add('save', 'submit', array(
				'label' => 'Guardar',
				"attr" => array("class" => "btn btn-primary")
				));
		return $form;
	}



}