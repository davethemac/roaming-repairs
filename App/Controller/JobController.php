<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\ChoiceInterface;
use App\Validator\Constraints\MyDate;
use App\Validator\Constraints\MyTime;
use App\Provider\JobProvider;
use App\Provider\PartUsedProvider;
use Symfony\Component\HttpKernel\HttpKernelInterface;


/**
 * Description of JobController
 *
 * @author david.mccart
 */
class JobController {
    //put your code here

    public function index(Request $request, Application $app) {
        return 'jobs index';
    }

    public function job(Request $request, Application $app, $id = 1) {

        // get the job
        $job = $app['model.jobs']->get($id);

        $customers = $app['model.customers']->getAll();
        if(count($customers)===0){
            // add some test data
            $app['model.customers']->addTestCustomers();
            $customers = $app['model.customers']->getAll();
        }
        $workers = $app['model.workers']->getAll();
        if(count($workers)===0){
            $app['model.workers']->addTestWorkers();
            $workers = $app['model.workers']->getAll();
        }
        $parts = $app['model.parts']->getAll();
        if(count($parts)===0){
            $app['model.parts']->addTestParts();
            $parts = $app['model.parts']->getAll();
        }

        for($i=1; $i<11; $i++){
            $mileages[] = array('id' => $i, 'value' => $i * 10);
        }

        $data = [
            'job' => $job,
            'customers' => $customers,
            'workers' => $workers,
            'mileages' => $mileages,
            'rules' => $this->validationRules(),
            'msgs' => $this->validationMessages(),
        ];

        //return $app['twig']->render('activejob.html.twig', $data);
        return $app['twig']->render('index.html.twig', $data);
    }

    public function post(Request $request, Application $app) {

        $data = $request->request->all();

        $errors = $this->validateJob($app['validator'], $data);

        // extract the parts used list from the raw data
        $parts_used_list = $this->formatPartsUsedList($data);

        // validate the parts used table
        $parts_list_errors = $this->validatePartsUsedList($app['validator'], $app['model.parts'], $parts_used_list);

        if (count($errors) > 0 || count($parts_list_errors) > 0) {
            // this needs improving...
            // some sort of flash message then forward to JobController::job()
            foreach ($errors as $error) {
                echo $error->getPropertyPath().' '.$error->getMessage()."\n";
            }
            foreach ($parts_list_errors as $error) {
                echo $error->getPropertyPath().' '.$error->getMessage()."\n";
            }
        } else {
            //echo 'The form is valid';
            $job = $this->updateJob($app['model.jobs'], $data);
            $this->updatePartsUsed($app['model.partsused'], $parts_used_list, $job->getId());

            // is the job complete?
            if($job->getIsComplete()){
                // possibly add an additional method and use that, i.e. is job complete and validated, or something
                // forward to PDFController
                $subRequest = Request::create('/pdf/'.$job->getId(), 'GET');
                $app->handle($subRequest, HttpKernelInterface::SUB_REQUEST);
                // then idk what we would do...
                // for now we could send it back to the JobCOntroller::job()
                // but other candidates would be the as yet imaginary job list view
            }
        }

        // for now we could send it back to the JobCOntroller::job()
        $forward = Request::create('/jobs/'.$job->getId(), 'GET');
        return $app->handle($forward, HttpKernelInterface::SUB_REQUEST);
        //return '<pre>' . print_r($request->request->all(), true) . '</pre>' ;
    }

    protected function formatPartsUsedList(array $data){
        $parts_used_list = array();
        $count = (int)$data['parts_list_count'];
        for($i=0; $i < $count; $i++ ){
            $parts_used_list[] = array(
                'part_used_id' => isset($data['part_used_id_' . $i])?$data['part_used_id_' . $i]:0,
                'part_no' => $data['part_no_' . $i],
                'part_desc' => $data['part_desc_' . $i],
                'part_quantity' => $data['part_quantity_' . $i],
            );
        }
        return $parts_used_list;
    }

    protected function validateJob(ValidatorInterface $validator, $data){
        // build constraints
        $constraint = new Assert\Collection(array(
            'fields' => array(
                'reference_no' => new Assert\Type('digit'),
                'customer' => array(new Assert\Type('digit'), new Assert\GreaterThan(0)),
                'job_description' => new Assert\NotBlank(),
                'job_date' => new MyDate(),
                'mileage' => array( new Assert\Type('digit'), new Assert\GreaterThan(0)),
                'start_time' => array(new Assert\NotBlank(), new MyTime()),
                'end_time' => new MyTime(),
                'personnel' => array(new Assert\Type('array'),new Assert\All(array(new Assert\Type('digit'))),
                    new Assert\Count(array('min' => 1))),
                'job_complete' => new Assert\Choice(array('0','1')),
                'parlour_test' => new Assert\Choice(array('0','1')),
                ),
            'allowExtraFields' => true,
            ));
        // invoke validatior with data and constraint object
        return $validator->validate($data, $constraint);

    }

    protected function validatePartsUsedList(ValidatorInterface $validator, ChoiceInterface $choices, $data){
        // build constraints
        $constraint = new Assert\All(array(
            new Assert\Collection(array(
                'fields' => array(
                    'part_used_id' => new Assert\Type('numeric'),
                    'part_no' => array(new Assert\NotBlank(), new Assert\NotNull(), new Assert\Type('graph'),
                        new Assert\Choice(array(
                            'callback' => array($choices, 'getChoices')
                        ))
                    ),
                    'part_desc' => array(new Assert\NotBlank(), new Assert\NotNull(), new Assert\Type('print')),
                    'part_quantity' => array(new Assert\Type('digit'), new Assert\GreaterThan(0))
                    )
                ))
            ));
        // invoke validatior with data and constraint object
        return $validator->validate($data, $constraint);
    }

    protected function updateJob(JobProvider $provider, array $data){
        $job = $provider->getByReferenceNo($data['reference_no']);
        $job->setReferenceNo($data['reference_no'])
                ->setCustomerId($data['customer'])
                ->setDescription($data['job_description'])
                ->setJobDate($data['job_date'])
                ->setMileage(10 * (int)$data['mileage'])
                ->setStartTime($data['start_time'])
                ->setNotes($data['notes']);

        if(isset($data['end_time'])){
            $job->setEndTime($data['end_time']);
        }
        // personel
        foreach($data['personnel'] as $worker){
            $job->addWorkerId((int)$worker);
        }
        $job->setIsComplete(isset($data['job_complete'])?(int)$data['job_complete']:false);
        $job->setParlourTest(isset($data['job_complete'])?(int)$data['parlour_test']:false);

        $provider->persist($job);
        return $job;
    }

    protected function updatePartsUsed(PartUsedProvider $provider, array $data, $jobId){
        foreach($data as $part_used){
            $partUsed = $provider->get((int)$part_used['part_used_id']);
            $partUsed->setJobId($jobId)
                    ->setPartId($provider->getPartIdFromPartNo($part_used['part_no']))
                    ->setDescription($part_used['part_desc'])
                    ->setQuantity($part_used['part_quantity']);
            $provider->persist($partUsed);
        }
    }

    protected function validationRules() {
        // define rules for jquery.validate
        $rules = [
            'reference_no' => ['required' => true, 'min' => 1,],
            'customer' => ['required' => true, 'min' => 1,],
            'job_description' => ['required' => true, 'minlength' => 1, /*'maxlength' => 200,*/],
            'job_date' => ['required' => true, 'myDate' => true,],
            'mileage' => ['required' => true, 'min' => 1,],
            'start_time' => ['required' => true,],
            'personnel[]' => ['required' => true, 'minlength' => 1,],
            'job_complete' => ['required' => true, 'minlength' => 1, 'maxlength' => 1,],
            'parlour_test' => ['required' => true, 'minlength' => 1, 'maxlength' => 1,],
            'part_no_0' => ['skip_or_fill_minimum' => [3, '.part_used_0']],
            'part_desc_0' => ['skip_or_fill_minimum' => [3, '.part_used_0']],
            'part_quantity_0' => ['skip_or_fill_minimum' => [3, '.part_used_0']],
            ];
        return json_encode($rules);
    }

    protected function validationMessages(){
        // define error messages for jquery.validate
        $msgs = [
            'reference_no' => 'Please enter a job reference number',
            'customer' => 'Please select a customer',
            'job_description' => 'Please enter a description for this job',
            'job_date' => 'Please enter a date',
            'mileage' => 'Please select the mileage',
            'start_time' => 'There is no start time!',
            'personnel[]' => 'Please select at least 1 worker',
            'job_complete' => 'Please say if this job is complete',
            'parlour_test' => 'Please say if there was a parlour test',
            ];
        return json_encode($msgs);
    }

}
