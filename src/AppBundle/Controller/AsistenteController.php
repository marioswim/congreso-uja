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
        
        $headlinks->addLink("css/inscripcion.css","stylesheet","text/css");

        $headlinks_links    = $headlinks->getLinks();

        $params=array(
            "title_page"    =>  "Registro", 
            "head_link"     =>  $headlinks_links,
	        "scripts"		=>	null,    
            "urls"          =>  $links,
        );
		
		$form 	= 	$this->singUpForm();
		$form 	=	$form->getForm();

		$form -> handleRequest($request);

	    if($form->isSubmitted() && $form->isValid()) 
	    {	        
	      
	     
	      $this->insert($form->getData());
	      return $this->redirect("/como-llegar");
	      

	      
	    }

	    $params["form"]	=	$form->createView();
	    return $this->render('forms/inscripcion.html.twig', $params);

	}
		private function insert($data)
		{
			$dir="files/images/inscritos/";

			

			$file 	=	$data->getFile();
			$dni 	= 	$data->getDNI();
			dump($file);

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
            "scripts"		=>	$headlinks->getScripts(),
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
			->add("nombre","text",array("label"=>false,"attr"=>array("id" => "nombre","class" => "datos","placeholder"=>"Nombre")))
			->add("apellidos","text",array("label"=>false,"attr"=>array("id" => "apellidos","class" => "datos","placeholder"=>"Apellidos")))
			->add("DNI","text",array("label"=>false,"attr"=>array("id" => "dni","class" => "datos","placeholder"=>"DNI")))
			->add("telefono","text",array("label"=>false,"attr"=>array("id" => "telefono","class" => "contact","placeholder"=>"Teléfono")))
			->add("email","text",array("label"=>false,"attr"=>array("id" => "email","class" => "contact","placeholder"=>"Email")))
			->add("dir","text",array("label"=>false,"attr"=>array("id" => "direcion","class" => "location","placeholder"=>"Dirección")))
			->add("cp","text",array("label"=>false,"attr"=>array("id" => "cp","class" => "location","placeholder"=>"Código Postal")))
			->add("provincia","text",array("label"=>false,"attr"=>array("id" => "provincia","class" => "location","placeholder"=>"Provincia")))
			->add("file","file", array("label"=>"Foto Identificativa"))
			




			->add("polity","checkbox",array("label"=>"He leido y acepto los condiciones",
				"required" => True,))
			->add("public","checkbox",array("label"=>"Permito que mi asistencia se publique en el listado de asistentes",
				"required" => false,))


			->add('save', 'submit', array(
				'label' => 'Guardar',
				"attr" => array("class" => "btn btn-primary")
				));
		return $form;
	}



}