/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var JobSearchView = function(manager){

    var jobListView;
    var users;
    var userId;
    var customers;
    var customerId;

    this.initialize = function () { // pass params in here

        // Define a div wrapper for the view (used to attach events)
        this.el = $('<div/>');
        // attach any event handlers (that call functions defined in this view)
        // delegate event assignment
        // event, element, function
        this.el.on('change', '#user', this, this.setUserId);
        this.el.on('change', '#customer', this, this.setCustomerId);
        this.el.on('click', '#display', this.findJobs);
        // initialise anything else, (if needed by this view)
        this.getUsers();
        this.getCustomers();
        jobListView = new JobListView();
        // render the template
        this.render();
    };

    // define any functions needed

    this.render = function() {
        var data = {users:users, customers:customers};
        if(typeof this.template === 'function'){
            this.el.html(this.template(data)); // pass params to template here
            if(typeof jobListView !== 'undefined' && jobListView instanceof JobListView){
                $('.content', this.el).html(jobListView.el);
            }
        }
        return this;
    };

    this.getUsers = function(){
        var self = this;
        if(manager.userService!==undefined){
            manager.userService.getAll().done(function (data) {
                users = data;
                self.render();
            });
        }
    };

    this.getCustomers = function(){
        var self = this;
        if(manager.customerService!==undefined){
            manager.customerService.getAll().done(function (data){
                customers = data;
                self.render();
            });
        }
    };

    this.setCustomerId = function(event){
        customerId = parseInt($(this).val());
        event.data.unmark(users);
        event.data.markSelected(customers, customerId);
    };

    this.setUserId = function(event){
        userId = parseInt($(this).val());
        event.data.unmark(users);
        event.data.markSelected(users, userId);
    };

    this.unmark = function(options){
        for(i=0; i<options.length; i++){
            options[i].selected = false;
        }

    };

    this.markSelected = function(options, id){
        for(i=0; i<options.length; i++){
            if(Array.isArray(id)){
                if(id.includes(options[i].id)){
                    options[i].selected = true;
                }
            }else{
                if(options[i].id===id){
                    options[i].selected = true;
                }
            }
        }
    };

    this.findJobs = function(event){
        event.preventDefault();
        var params = [];
        if(userId){
            params.push({key:'assignedTo', value:userId});
        }
        if(customerId){
            params.push({key:'customerId', value:customerId});
        }
        manager.jobService.find(params).done(function (jobs){
            jobListView.setJobs(jobs);
        });
    };

    this.initialize();

};
