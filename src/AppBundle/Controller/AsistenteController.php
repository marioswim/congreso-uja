<?php



namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
Use Symfony\Bundle\FrameworkBundle\Controller\Controller;
Use AppBundle\utils\NavBar;
use AppBundle\utils\HeadLinks;
use AppBundle\Entity\Asistente;

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
	       	$aux	=	$this->insert($form->getData());

	       	/*if(is_string($aux))

	       		$this->errorForm($aux,$form);
	       	
	       	else
	       		return $aux;*/
	    }

	    $params["form"]	=	$form->createView();
	    return $this->render('forms/colaborador.html.twig', $params);
		//
			//insert
			//mover foto
			//mandar correo irene


	}
		private function insert($data)
		{
			$dir="files/images/inscritos/";

			$file 	=	$data->getFile();
			$dni 	= 	$data->getDNI();

			$fileName 	= 	$dni.".".$file->guessExtension();

			
			dump($file);

			$asistente 	=	new Asistente();

			$asistente 	->	setDNI($data 		->	getDNI());
			$asistente 	->	setNombre($data 	->	getNombre());
			$asistente 	->	setApellidos($data 	->	getApellidos());
			$asistente 	->	setEmail($data 		->	getEmail());
			$asistente 	->	setTelefono($data 	->	getTelefono());

			$asistente 	->	setImage($dir."".$fileName);

			$em 	= 	$this->getDoctrine()->getManager();

			$em->persist($asistente);

			//$em 	->	flush();

			$file 	->	move("/var/www/congreso/".$dir,$fileName);
			$this	->	sendMail($asistente);

		}
	private function sendMail($asistente)
	{

		$message = \Swift_Message::newInstance()
        ->setSubject('Inscripción '.$asistente->getDNI())
        ->setFrom('quesada@ujaen.es')
        ->setTo('quesada@ujaen.es')
        ->setBody(

        	"D\Dña ".$asistente->getNombre()." ".$asistente->getApellidos()." se ha inscrito con la siguiente información:<br>".
			"<ul>
				<li>Telefono:".$asistente->getTelefono()." </li>
				<li>Telefono:".$asistente->getEmail()." </li>
			</ul>"        	
            /*$this->renderView(
                // app/Resources/views/Emails/registration.html.twig
                'Emails/registration.html.twig',
                array('name' => $name)
            ),
            'text/html'*/
        );
	        /*
	         * If you also want to include a plaintext version of the message
	        ->addPart(
	            $this->renderView(
	                'Emails/registration.txt.twig',
	                array('name' => $name)
	            ),
	            'text/plain'
	        )
	        */

	    $this->get('mailer')->send($message);

	    dump($message);
	}

	public function showAction()
	{
		//cargar Asistentes


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
			->add("file","file", array("label"=>"Foto Identificativa"))
			//añadir checkbox para permitir que se publique su nombre en un listado.
			->add('save', 'submit', array(
				'label' => 'Guardar',
				"attr" => array("class" => "btn btn-primary")
				));
		return $form;
	}



}