<?php



namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
Use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\StreamedResponse;
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
            "title_page"    =>  "Inscripción", 
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
	    	dump($form->getData());
	      

	      
	    }

	    $params["form"]	=	$form->createView();
	    return $this->render('forms/inscripcion.html.twig', $params);

	}
		private function insert($data)
		{
			$dir="files/images/inscritos/";

			

			$file 	=	$data->getFile();
			$dni 	= 	$data->getDNI();
			$date 	= new \DateTime("now");

			$fileName 	= 	$date->format("dmYHis").".".$file->guessExtension();

			

			$asistente 	=	new Asistente();

			$asistente 	->	setDNI($data 		->	getDNI());
			$asistente 	->	setNombre($data 	->	getNombre());
			$asistente 	->	setApellidos($data 	->	getApellidos());
			$asistente 	->	setEmail($data 		->	getEmail());
			$asistente 	->	setTelefono($data 	->	getTelefono());
			$asistente 	->	setPublic($data 	->	getPublic());
			$asistente 	-> 	setCodPostal($data 	->	getCp());
			$asistente 	-> 	setUniversidad($data ->	universidad);
			$asistente 	-> 	setDireccion($data 	->	getDir());
			$asistente 	-> 	setCargo($data 		-> 	cargo);
			$asistente 	-> 	setProvincia($data 	->	getProvincia());
			$asistente 	-> 	setCena($data 		->	cena);
			$asistente 	-> 	setDate();
			$asistente 	->	setImage($dir."".$fileName);
			$asistente 	->	setTaller($data 	->	taller);
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
			"universidad" 	=> 	$asistente->getUniversidad(),
			"cargo"			=>	$asistente->getCargo(),
			"direccion"		=> 	$asistente->getDireccion(),
			"cod_postal"	=> 	$asistente->getCodPostal(),
			"provincia"		=>	$asistente->getProvincia(),
			"taller"		=>	$asistente->getTaller(),
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

        $headlinks->addScript("js/asistentes.js");
        $headlinks->addLink("css/asistentes.css","stylesheet","text/css");

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

		$securityContext = $this->container->get('security.authorization_checker');		

		if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) 
		{			
		   	return $this->render('administration/asistentes.html.twig', $params);
		}
		elseif ($securityContext->isGranted('IS_AUTHENTICATED_ANONYMOUSLY')) 
		{
			return $this->render('default/asistentes.html.twig', $params);
		}

	}

	public function adminShowAction()
	{


		$navbar     =   new NavBar();
        $headlinks  =   new HeadLinks();   
        $links      =   $navbar->getLinks();
        $headlinks_links    = $headlinks->getLinks();     
		

		$params=array(
            "title_page"    =>  "Asistentes", 
            "head_link"     =>  $headlinks_links,
            "scripts"		=>	$headlinks->getScripts(),            
            "urls"          =>  $links,
        );

		$all = $this->getDoctrine()->getManager()->getRepository("AppBundle:Asistente")->findBy(array(),array("date" => "asc"));

		$params["content"]=$all;


		return $this->render('administration/asistentes_tabla.html.twig', $params);
		dump($all);

	}
	public function downloadAction()
	{

		

        $container = $this->container;
        $response = new StreamedResponse(function() use($container) 
        {
			$all = $this->getDoctrine()->getManager()->getRepository("AppBundle:Asistente")->findBy(array(),array("date" => "asc"));

            
            $file = fopen('php://output', 'r+');
            $title_row=array("DNI","Nombre","Apellidos","Dirección","Código Postal","Provincia","Universidad","Cargo","Teléfono","Email","Perfil Público","Cena","Pagado","Fecha Inscripción","Taller","\n");
			$title_row=implode(";",$title_row);
			fwrite($file, $title_row);

					foreach ($all as $asis) 
					{
						$date=$asis->getDate();
						$date_string=$date->format("d-m-Y H:i:s");
						$info=array(
							$asis->getDNI(),
							$asis->getNombre(),
							$asis->getApellidos(),
							$asis->getDireccion(),
							$asis->getCodPostal(),
							$asis->getProvincia(),
							$asis->getUniversidad(),
							$asis->getCargo(),
							$asis->getTelefono(),
							$asis->getEmail(),
							$asis->getPublic(),
							$asis->getCena(),
							$asis->getPagado(),
							$asis->getTaller(),
							$date_string,"\n");

						$aux=implode(";", $info);
						fwrite($file, $aux);
					}

			

            fclose($file);
        });

        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set('Content-Disposition','attachment; filename="export.csv"');

        return $response;


		



	}
	private function singUpForm()
	{
		$asis = new AsistenteForm();

		$form = $this->createFormBuilder($asis)
			->add("nombre","text",array("label"=>false,"attr"=>array("id" => "nombre","class" => "datos","placeholder"=>"Nombre","maxlength" => 100)))
			->add("apellidos","text",array("label"=>false,"attr"=>array("id" => "apellidos","class" => "datos","placeholder"=>"Apellidos","maxlength" => 100)))
			->add("DNI","text",array("label"=>false,"attr"=>array("id" => "dni","class" => "datos","placeholder"=>"DNI","maxlength" => 9)))
			->add("universidad","text",array("label"=>false,"attr"=>array("id" => "uni","class" => "procedencia","placeholder"=>"Universidad","maxlength" => 200)))
			->add("cargo","text",array("label"=>false,"attr"=>array("id" => "cargo","class" => "procedencia","placeholder"=>"Cargo")))
			->add("telefono","text",array("label"=>false,"attr"=>array("id" => "telefono","class" => "contact","placeholder"=>"Teléfono","maxlength" => 9)))
			->add("email","text",array("label"=>false,"attr"=>array("id" => "email","class" => "contact","placeholder"=>"Email","maxlength" => 100)))
			->add("dir","text",array("label"=>false,"attr"=>array("id" => "direcion","class" => "location","placeholder"=>"Dirección")))
			->add("cp","text",array("label"=>false,"attr"=>array("id" => "cp","class" => "location","placeholder"=>"Código Postal","maxlength"=>"5")))
			->add("provincia","text",array("label"=>false,"attr"=>array("id" => "provincia","class" => "location","placeholder"=>"Provincia","maxlength" => 200)))
			->add("file","file", array("label"=>"Foto Identificativa"))
			

			->add("taller","choice",array(
				"label"=>false,
				"choices"=>array
					(	"taller 1"	=>	"Taller 1",
						"taller 2"	=>	"Taller 2"),
				"attr" 		=> array("class" => "talleres"),
				"multiple"	=>false,
				"expanded"	=>true,
				"required"	=>true
				))

			->add("cena","checkbox",array("label"=>"Deseo Asistir a la cena del Jueves 9 de febrero.",
				"required" => false,"attr"=> array("class"=>"opciones")))
			->add("polity","checkbox",array("label"=>"He leido y acepto los condiciones",
				"required" => True,"attr"=> array("class"=>"opciones")))
			->add("public","checkbox",array("label"=>"Permito que mi asistencia se publique en el listado de asistentes",
				"required" => false,"attr"=> array("class"=>"opciones")))


			->add('save', 'submit', array(
				'label' => 'Guardar',
				"attr" => array("class" => "btn btn-primary")
				));
		return $form;
	}



}