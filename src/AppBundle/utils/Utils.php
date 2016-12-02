<?php


namespace AppBundle\utils;


class Utils
{

	public function prepareHeaderAndNavbar($title,$css=array(),$js=array())
	{


		$navbar     =   new NavBar();
        $headlinks  =   new HeadLinks();   
        $links      =   $navbar->getLinks();

        foreach ($css as $value) 
        {
        	$headlinks->addLink($value,"stylesheet","text/css");        
        }
        foreach ($js as $value) 
        {
        	$headlinks->addScript($value);        
        }
        $params=array(
            "title_page"    =>  $title, 
            "head_link"     =>  $headlinks->getLinks(),
	        "scripts"		=>	$headlinks->getScripts(),    
            "urls"          =>  $links,
        );
		

        return $params;


	}
}