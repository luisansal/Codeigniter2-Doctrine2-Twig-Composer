<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

use models\Entity\User as UserEntity;

class User extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *     	http://example.com/index.php/welcome
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
    public function add_new() {
        $em = $this->doctrine->em;
        $rules = array(
            array(
                'field' => 'name',
                'label' => 'name',
                'rules' => 'required'
            ),
            array(
                'field' => 'lastName',
                'label' => 'last_name',
                'rules' => 'required'
            ),
            array(
                'field' => 'dateBorn',
                'label' => 'date_born',
                'rules' => 'required'
            ),
            array(
                'field' => 'phone',
                'label' => 'phone'
            ),
            array(
                'field' => 'phoneMovil',
                'label' => 'phone_movil'
            ),
            array(
                'field' => 'email',
                'label' => 'email',
                'rules' => 'required'
            ),
            array(
                'field' => 'address',
                'label' => 'address',
                'rules' => 'required'
            ),
            array(
                'field' => 'code',
                'label' => 'code',
                'rules' => 'required'
            ),
            array(
                'field' => 'password',
                'label' => 'password',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == true) {
            $user = new UserEntity();
            foreach ($this->input->post() as $postK => $postV) {
                if ($postK != "btnRegister") {
                    //contains date
                    if (preg_match("/.*date.*/", $postK)) {
                        $date = new \DateTime;
                        $dateBorn = $date->setTimestamp(time($postV));
                        $user->{'set' . ucfirst($postK)}($dateBorn);
                    } else {
                        $user->{'set' . ucfirst($postK)}($postV);
                    }
                }
            }
            $em->persist($user);
            $em->flush();
            redirect('user/show/' . $user->getId());
        }

        echo $this->twig->twig_environment->render('User/add_new.html.twig', array(
        ));
    }

    public function show($id) {
        $em = $this->doctrine->em;
        $user = $em->getRepository("models\Entity\User")->find($id);
        if (!$user) {
            throw new Exception("Not user found");
        }
        echo $this->twig->twig_environment->render('User/show.html.twig', array(
            'user' => $user
        ));
    }

    public function edit($id) {
        $em = $this->doctrine->em;
        $user = $em->getRepository("models\Entity\User")->find($id);
        if (!$user) {
            throw new Exception("Not user found");
        }
        $rules = array(
            array(
                'field' => 'name',
                'label' => 'name',
                'rules' => 'required'
            ),
            array(
                'field' => 'lastName',
                'label' => 'last_name',
                'rules' => 'required'
            ),
            array(
                'field' => 'dateBorn',
                'label' => 'date_born',
                'rules' => 'required'
            ),
            array(
                'field' => 'phone',
                'label' => 'phone'
            ),
            array(
                'field' => 'phoneMovil',
                'label' => 'phone_movil'
            ),
            array(
                'field' => 'email',
                'label' => 'email',
                'rules' => 'required'
            ),
            array(
                'field' => 'address',
                'label' => 'address',
                'rules' => 'required'
            ),
            array(
                'field' => 'code',
                'label' => 'code',
                'rules' => 'required'
            ),
            array(
                'field' => 'password',
                'label' => 'password',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == true) {
            print_r($this->input->post());
            foreach ($this->input->post() as $postK => $postV) {
                if ($postK != "btnEdit") {
                    //contains date
                    if (preg_match("/.*date.*/", $postK)) {
                        $date = new \DateTime;
                        $dateBorn = $date->setTimestamp(time($postV));
                        $user->{'set' . ucfirst($postK)}($dateBorn);
                    } else {
                        $user->{'set' . ucfirst($postK)}($postV);
                    }
                }
            }
            $em->persist($user);
            $em->flush();
            redirect('user/edit/' . $user->getId());
        }
        echo $this->twig->twig_environment->render('User/edit.html.twig', array(
            'user' => $user
        ));
    }

    public function lists() {
        $em = $this->doctrine->em;
        $users = $em->getRepository("models\Entity\User")->findAll();
        echo $this->twig->twig_environment->render('User/lists.html.twig', array(
            'users' => $users
        ));
    }

    public function delete($id) {
        $em = $this->doctrine->em;
        $user = $em->getRepository("models\Entity\User")->find($id);
        if (!$user) {
            throw new Exception("Not user found");
        }
        $em->remove($user);
        $em->flush();
        redirect('user/lists');
    }
    
    public function reports(){
//        $celu = $this->doctrine->em->getRepository('models\Entity\Tbcelu')->find(51);
        echo $this->twig->twig_environment->render("User/reports.html.twig");
    }

}
