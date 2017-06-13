/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var JobListView = function () {

    var jobs;

    this.initialize = function() {
        this.el = $('<div/>');
        this.render();
    };

    this.setJobs = function(list) {
        jobs = list;
        this.render();
    };

    this.render = function() {
        if(typeof this.template === 'function'){
            this.el.html(this.template({jobs:jobs}));
        }
        return this;
    };

    this.initialize();

};

