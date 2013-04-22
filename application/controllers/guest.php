<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Guest extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -  
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function index() {
        echo $this->twig->twig_environment->render('Guest/index.html.twig', array(
        ));
    }
    
    public function login() {
        $em = $this->doctrine->em;
        echo $this->twig->twig_environment->render('Guest/login.html.twig', array(
        ));
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
