/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var ActiveJobView = function(manager, partsUsedView, id){
    
    var partsUsedView = partsUsedView;

    // define any class attributes
    var customers = [];
    var workers = [];
    var mileage = [];

    // the active job 
    var job;
    var jobWorkers = [];
    var self = this;
    var manager = manager;

    this.initialize = function () { // pass params in here

        // Define a div wrapper for the view (used to attach events)
        this.el = $('<div/>');
        // add validation
        this.el.one('click', '#submit', function(){
            $('#job_form').validate({
                rules: job_form_rules, 
                messages: job_form_messages,
                submitHandler: self.save
            });
        });
        
        this.el.on('click','#job_start_time_btn',setStartTime);
        this.el.on('click','#job_end_time_btn',setEndTime);
        
        // initialise anything else, (if needed by this view)
        this.getData();
        this.setJob(id);
        partsUsedView.setJobId(id);
        this.setupMileage();
        this.markSelected(customers, job.customerId);
        this.markSelected(mileage, job.mileage);
        this.markSelectedWorkers();

        // render the template
        this.render();
    };

    // define any functions needed
    
    // update the local model with the form data
    this.update = function(form){
        // update the job reference number only if there wasn't one to start with
        if(job.referenceNo===undefined || job.referenceNo === 0 || job.referenceNo === ''){
            job.referenceNo = form.reference_no.value;
        }
        job.customerId = form.customer.value;
        job.description = form.description.value;
        job.mileage = form.mileage.value;
        job.jobDate = form.job_date.value;
        job.startTime = form.start_time.value;
        job.endTime = form.end_time.value;
        job.isComplete = form.job_complete.value;
        job.parlourTest = form.parlour_test.value;
        job.notes = form.notes.value;
        
    };
    
    this.updateWorkers = function(form){
        // actually we need to do this after the job has been saved
        // so we are sure the job has an id
        // get all the selected workers
        var selectedWorkers = form.personnel.selectedOptions;
        // clear the existing array
        jobWorkers = [];
        for(i=0; i<selectedWorkers.length; i++){
            jobWorkers.push({
                job_id:job.id, 
                worker_id:selectedWorkers[i].value});
        }
        
    };
    
    this.save = function(form, event){
        // stop the normal form submission
        event.preventDefault();
        // update the local job model with the form
        self.update(form);
        // persist the changes
        var result = manager.jobService.update([job]).done(function(data){

            if((job.id===undefined || job.id===0) && Array.isArray(result) && result.length === 1){
                job.id = data[0].id;
            }
            // having ensured the job has an id, update the jobWorkers
            self.updateWorkers(form);
            // persist the jobWorkers
            manager.jobWorkerService.update(jobWorkers, '');
            // persist the partsUsed
            partsUsedView.save();
            
        });
        
        // at this point everything should be done
        // possibly we could request the manager to sync
        // or schedule a sync
    };
    
    this.render = function() {
        var data = {
            customers:customers,
            workers:workers,
            mileage:mileage,
            job:job
        };
        this.el.html(this.template(data)); // pass params to template here
        if(typeof partsUsedView !== 'undefined' && partsUsedView instanceof PartsUsedView){
            $('#parts-table-container', this.el).html(partsUsedView.el);
        }
        return this;
    };

    this.getData = function(){
        manager.customerService.getAll().done(function (data) {
            customers = data;
        });
        manager.workerService.getAll().done(function (data) {
            workers = data;
        });
    };
    
    this.setupMileage = function(){
        for(i=1; i<11; i++){
            mileage.push({id:i,value:i*10});
        }
    };

    this.setJob = function(id){
        manager.jobService.get(id).done(function (data) {
            job = data;
            manager.jobWorkerService.findByKey('job_id', job.id).done(function (data){
                jobWorkers = data;
            });
        });
    };

    this.markSelected = function(options, id){
        for(i=0; i<options.length; i++){
            options[i].selected = false;
            if(Array.isArray(id)){
                if(id.includes(options[i].id)){
                    options[i].selected = true;
                }
            }else{
                if(parseInt(options[i].id)===parseInt(id)){
                    options[i].selected = true;
                }
            }
        }
    };

    this.markSelectedWorkers = function(){
        var workerIds = [];
        for(i=0; i<jobWorkers.length; i++){
            workerIds.push(jobWorkers[i].worker_id);
        }
        this.markSelected(workers, workerIds);
    };

    function setStartTime(){
        var date = new Date();
        $('#job_start_time')
                .val(date.toLocaleTimeString())
                .removeClass('hidden')
                .prop('disabled', true);
        $('#start_time').val(date.toLocaleTimeString());
        $('#job_start_time_btn')
                .addClass('hidden')
                .prop('disabled', true);
    };

    function setEndTime(){
        var date = new Date();
        $('#job_end_time')
                .val(date.toLocaleTimeString())
                .removeClass('hidden')
                .prop('disabled', true);
        $('#end_time').val(date.toLocaleTimeString());
        $('#job_end_time_btn')
                .addClass('hidden')
                .prop('disabled', true);
    };

    this.initialize();

};