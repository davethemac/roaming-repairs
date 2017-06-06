<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Dompdf\Dompdf;
use Swift_Message;
use Swift_Attachment;

/**
 * Description of PDFController
 *
 * @author david.mccart
 */
class PDFController {
    //put your code here

    public function job(Request $request, Application $app, $id = 1) {

        // get the job
        $job = $app['model.jobs']->get($id);

        // get the customer
        $customer = $app['model.customers']->get($job->getCustomerId());

        $data = [
            'job' => $job,
            'customer_name' => $customer->getName(),
            'path' => ROOT,
        ];

        $html =  $app['twig']->render('pdfjob.html.twig', $data);

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // output the pdf
        $output = $dompdf->output();

        // create an attachment
        $attachment = Swift_Attachment::newInstance($output, 'job.pdf', 'application/pdf');

        // create email
        $message = Swift_Message::newInstance()
                ->setSubject('Roaming Repair PDF Email Test') // this could be better. perhaps include the job ref_no
                ->setFrom(array('roaming-repairs@localhost')) // need to get these from some sort of config
                ->setTo(array('davthemac@hotmail.co.uk')) // need to get these from some sort of config
                ->setBody('The pdf should be attached') // some sort of text/lang control?
                ->attach($attachment);

        // send the email
        $app['mailer']->send($message);
    }
}
