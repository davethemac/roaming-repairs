<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\FormType;

/**
 * Description of UserController
 *
 * @author david.mccart
 */
class UserController {
    //put your code here
    
    public function login(Request $request, Application $app) {
        $data = array();
        $form = $app['form.factory']->createBuilder(FormType::class, $data)
                ->add('_username')
                ->add('_password')
                ->getForm();
        $form->handleRequest($request);
        if($form->isValid()){
            // do login stuffs
        }
        
        return $app['twig']->render('login.html.twig', array(
            //'form' => $form->createView(),
            'error' => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username')
                ));
        //return 'this is the login page';
    }
    
}
