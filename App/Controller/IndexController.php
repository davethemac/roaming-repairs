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
 * @author davethemac
 */
class IndexController {
    //put your code here
    public function index() {
        return 'hello';
    }
}
