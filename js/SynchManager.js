/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var SynchManager = function() {

    this.customerService;
    this.workerService;
    this.partService;
    this.partUsedService;
    this.jobService;
    this.jobWorkerService;
    this.userService;

    this.initialize = function(testData) {
        var deferred = $.Deferred();
        // Do required initialization stuff
        // first thing we need to do is decided what storage method to use
        // this time we're just going to go with local storage
        this.webStorage();
        if(testData){
            this.initializeStorageTestData();
        }else{
            // of course if we are not using test data
            // then we would need to get it from the server
            // if a connection is available (maybe ?)
            this.initializeStorage();
        }
        deferred.resolve();
        return deferred.promise();
    };

    this.webStorage = function(){
        if(typeof WebStorageService === 'function'){
            this.customerService = new WebStorageService('customers');
            this.workerService = new WebStorageService('workers');
            this.partService = new WebStorageService('parts');
            this.partUsedService = new WebStorageService('partsUsed');
            this.jobService = new WebStorageService('jobs');
            this.jobWorkerService = new WebStorageService('jobWorkers');
            this.userService = new WebStorageService('users');
        }
    };

    this.initializeStorage = function(){
        // call all the storage initialisation functions
        this.customerService.initialize();
        this.workerService.initialize();
        this.partService.initialize();
        this.partUsedService.initialize();
        this.jobService.initialize();
        this.jobWorkerService.initialize();
        this.userService.initialize();
    };

    this.initializeStorageTestData = function(){
        // call all the storage initialize functions, passing test data
        // defined in testdata.js
        if(this.customerService!==undefined && test_customers!==undefined){
            this.customerService.initialize(test_customers);
        }
        if(this.workerService!==undefined && test_workers!==undefined){
            this.workerService.initialize(test_workers);
        }
        if(this.partService!==undefined && test_parts!==undefined){
            this.partService.initialize(test_parts);
        }
        if(this.partUsedService!==undefined && test_parts_used!==undefined){
            this.partUsedService.initialize(test_parts_used);
        }
        if(this.jobService!==undefined && test_jobs!==undefined){
            this.jobService.initialize(test_jobs);
        }
        if(this.jobWorkerService!==undefined && test_jobs_workers!==undefined){
            this.jobWorkerService.initialize(test_jobs_workers);
        }
        if(this.userService!==undefined && test_users!==undefined){
            this.userService.initialize(test_users);
        }
    };

};
