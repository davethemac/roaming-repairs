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
 * Description of PartController
 *
 * @author davethemac
 */
class PartController {

    public function index(Request $request, Application $app) {
        $json = array();
        $parts = $app['model.parts']->getAll();
        foreach($parts as $part){
            $json[] = array(
                'id' => $part->getId(),
                'part_no' => $part->getPartNumber(),
                'desc' => $part->getDescription()
            );
        }
        return $app->json($json);
    }

}
