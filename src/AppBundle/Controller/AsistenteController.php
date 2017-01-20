<?php



namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
Use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\StreamedResponse;

use AppBundle\Entity\Asistente;
use Assetic\Exception\Exception; 

Use AppBundle\forms\AsistenteForm;

use AppBundle\utils\Utils;

class AsistenteController extends Controller
{



	public function singUpAction(Request $request)
	{

		$utils 	= 	new Utils();

		$css 	=	array("css/inscripcion.css");
		$js 	=	array("js/inscripcion.js");

		$params =	$utils->prepareHeaderAndNavbar("Inscripción",$css,$js);

		$form 	= 	$this->singUpForm();
		$form 	=	$form->getForm();

		$form 		-> 	handleRequest($request);

		

	    if($form->isSubmitted() && $form->isValid()) 
	    {	        
	      
	     	$data 			= $form->getData();
	      	$status_insert	= $this->insert($data);

	      	$this->showStatus($status_insert);
    		if($status_insert==1)
		    {
		    	
		    	$status_mail = $this->sendSignUpMail($data);

				$this->showStatus($status_mail);

				$this->sendPaymentMail($data);

		      	return $this->redirect("/");	      	
	      	}
	      

	      
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
			$em 	= 	$this->getDoctrine()->getManager();

			$em->persist($asistente);
			
			try 
			{
				
				$em 	->	flush();
			} 
			catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) 
			{
					
					return 1001;
			}

			$data 	-> 	setFile($dir."".$fileName);				
			$file 	->	move("/var/www/congreso/".$dir,$fileName);

			return 1;

		}

		private function sendMail($to,$subject,$template,$params=array("key"=>array(),"value"=>array()))
		{

			
			$message = \Swift_Message::newInstance();

			if(isset($params["file"]))
			{

				$message->attach(\Swift_Attachment::fromPath($params["file"]));				
			}
	        
	        $message->setSubject($subject)
	        ->setFrom('no-reply@ujaen.es')
	        ->setTo($to)
	        ->setBody(        	    	
	            $this->renderView(
	                // app/Resources/views/Emails/registration.html.twig
	                $template,
	                array($params["key"] => $params["value"])
	            ),
	            'text/html'
	        );

		    return $this->get('mailer')->send($message);

		}
		private function prepareSignUpMail($asistente)
		{
			$params=array(
				"Nombre"		=>	$asistente->getNombre(),
				"Apellidos" 	=>	$asistente->getApellidos(),
				"direccion"		=> 	$asistente->getDir(),
				"cp"			=> 	$asistente->getCp(),
				"mail" 			=>	$asistente->getEmail(),
				"telefono"		=>	$asistente->getTelefono(),
				"universidad" 	=> 	$asistente->universidad,
				"cargo"			=>	$asistente->cargo,
				"prov"			=>	$asistente->getProvincia(),
				"facturacion"	=> 	$asistente->factura,
				
				);
			if($asistente->factura)
			{
				$params["fact"]=array(
					"razon"		=> 	$asistente->razon_social,
					"cif"		=>	$asistente->cif_nif,
					"dir"		=>	$asistente->dir_social,
					"cp"		=>	$asistente->cp_factura,
					"localidad" =>	$asistente->pob_social,
					"prov"		=>	$asistente->prov_social,
					"pais" 		=>	$asistente->pais,
					);
			}
			$aux=$params;
			$params["value"]	=	$aux;
			$params["key"]		=	"asis";
			$params["file"]		=	$asistente->getFile();
			return $params;

		}
	public function showPublicAction()
	{
		
		$utils 	= 	new Utils();

        $js		=	array("js/asistentes.js");
        $css 	=	array("css/asistentes.css");

		$params = 	$utils->prepareHeaderAndNavbar("Asistentes",$css,$js);
        
		$em 	= 	$this->getDoctrine()->getRepository("AppBundle:Asistente");
		$public =	$em->findByPublic(1);
		$params["publics"]= $public;
		


		if ($this->get('security.context')->isGranted('ROLE_ADMIN')) 
		{			
		   	return $this->render('administration/asistentes.html.twig', $params);
		}
		else
		{
			return $this->render('default/asistentes.html.twig', $params);
		}

	}

	public function adminShowAction()
	{


		
		$utils 	= 	new Utils();

        $css 	=	array("css/admin/asistente_tabla.css");
         
		
        $params	=	$utils->prepareHeaderAndNavbar("Asistentes",$css);
		

		$all = $this->getDoctrine()->getManager()->getRepository("AppBundle:Asistente")->findBy(array(),array("date" => "asc"));

		$params["content"]=$all;


		return $this->render('administration/asistentes_tabla.html.twig', $params);
	}

		public function downloadAction()
		{

			

	        $container = $this->container;
	        $response = new StreamedResponse(function() use($container) 
	        {
				$all = $this->getDoctrine()->getManager()->getRepository("AppBundle:Asistente")->findBy(array(),array("date" => "asc"));

	            
	            $file = fopen('php://output', 'r+');
	            $title_row=array("DNI","Nombre","Apellidos","Dirección","Código Postal","Provincia","Universidad","Cargo","Teléfono","Email","Perfil Público","Cena","Fecha Inscripción","Pagado","\n");
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
								($asis->getPublic() == 1)? "Si":"No",
								($asis->getCena() 	== 1)? "Si":"No",
								$date_string,
								$asis->getPagado(),
								"\n");

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
			


			->add("factura","checkbox",array("required"=> false,"label"=>false,"attr" => array("id" => "pedir_factura")))
			->add("razon_social","text",array("required"=> false,"label"=>false,"attr" => array("placeholder" => "Razón Social","class" => "facturacion")))
			->add("cif_nif","text",array("required"=> false,"label"=>false,"attr" => array("placeholder" => "CIF/NIF","class" => "facturacion","maxlength" => 9)))
			->add("dir_social","text",array("required"=> false,"label"=>false,"attr" => array("placeholder" => "Dirección","class" => "facturacion")))
			->add("pob_social","text",array("required"=> false,"label"=>false,"attr" => array("placeholder" => "Localidad","class" => "facturacion")))
			->add("prov_social","text",array("required"=> false,"label"=>false,"attr" => array("placeholder" => "Provincia","class" => "facturacion")))
			->add("pais","text",array("required"=> false,"label"=>false,"attr" => array("placeholder" => "País","class" => "facturacion")))
			->add("cp_factura","text",array("required"=> false,"label"=>false,"attr" => array("placeholder" => "Código Postal", "class" => "facturacion","maxlength" => 5)))


			->add("cena","checkbox",array("label"=>"Deseo Asistir a la cena del Jueves 9 de febrero.",
				"required" => true,"attr"=> array("class"=>"opciones")))
			->add("polity","checkbox",array("label"=>'He leido y acepto las <a href="/politica-de-privacidad">condiciones</a>',
				"required" => True,"attr"=> array("class"=>"opciones")))
			->add("public","checkbox",array("label"=>"Permito que mi asistencia se publique en el listado de asistentes",
				"required" => false,"attr"=> array("class"=>"opciones")));
/**



*/
			if((time()>=strtotime("24-01-2017 13:00:00"))&&(time()<=strtotime("08-02-2017 00:00:00")))
			{
				$form->add('save', 'submit', array(
				'label' => 'Guardar',
				"attr" => array("class" => "btn btn-primary")
				));
			}
			
			
			
		return $form;
	}



	private function showStatus($code)
	{
		$this->get("session")->getFlashBag()->clear();
		switch ($code) 
		{
			
			case 0:
					$this->addFlash("warning","No se ha podido enviar el correo.");
				break;
			case 1:
					$this->addFlash("success","Registro realizado correctamente");
				break;
			case 1001:
					$this->addFlash("danger","El DNI ya ha sido registrado.");
				break;
			default:
				# code...
				break;
		}
	}
	private function sendSignUpMail($asistente)
	{

      	$params		= $this	->	prepareSignUpMail($asistente);

		$subject 	= "[Jornadas]: Inscripción ".$asistente->getDNI();

		$status_mail = $this	->	sendMail("emple@ujaen.es",$subject,'Emails/inscripcion.html.twig',$params);

		return $status_mail;
	}
	private function sendPaymentMail($asistente)
	{

      	$params		= $this	->	preparePaymentMail($asistente);

		$subject 	= "[Jornadas]: Inscripción ".$asistente->getDNI();

		$status_mail = $this	->	sendMail($asistente->getEmail(),$subject,'Emails/pago.html.twig',$params);

		return $status_mail;
	}

	private function preparePaymentMail($asistente)
	{
		$params=array(
				"Nombre"		=>	$asistente->getNombre(),
				"Apellidos" 	=>	$asistente->getApellidos(),
				"direccion"		=> 	$asistente->getDir(),
				"dni"			=> 	$asistente->getDNI(),
				);
		$aux=$params;
		$params["value"]	=	$aux;
		$params["key"]		=	"asis";

		return $params;
	}

}