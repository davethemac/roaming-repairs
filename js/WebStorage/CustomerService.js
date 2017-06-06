/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


var WebStorageCustomerService = function(){

    this.initialize = function($data) {
        var deferred = $.Deferred();

        // set up the store - should we not check if it exists first?
        if(this.checkStore('customers') === false){
            // Store sample data in Local Storage
            window.localStorage.setItem('customers', JSON.stringify($data));
        }

        deferred.resolve();
        return deferred.promise();
    };

    this.checkStore = function(key){
        // get the number of keys in the store
        for(var i=0; i<window.localStorage.length; i++){
            if(key===window.localStorage.key(i)){
                return true;
            }
        }
        return false;
    }

    this.get = function (id) {

        var deferred = $.Deferred(),
            customers = JSON.parse(window.localStorage.getItem("customers")),
            customer = null,
            l = customers.length;

        for (var i = 0; i < l; i++) {
            if (customers[i].id === id) {
                customer = customers[i];
                break;
            }
        }

        deferred.resolve(customer);
        return deferred.promise();
    };

    this.getAll = function(){
        var deferred = $.Deferred(),
            customers = JSON.parse(window.localStorage.getItem("customers"));
        deferred.resolve(customers);
        return deferred.promise();
    };

};