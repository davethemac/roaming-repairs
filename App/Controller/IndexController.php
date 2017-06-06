<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of indexcontroller
 *
 * @author david.mccart
 */
class IndexController {
    //put your code here
    public function index() {
        return 'hello';
    }

    public function test(Request $request, Application $app){
        $data = [
            'job' => ['partsUsed' => []],
            'rules' => [],
            'msgs' => []
            ];
        return $app['twig']->render('test.html.twig', $data);
    }
}
