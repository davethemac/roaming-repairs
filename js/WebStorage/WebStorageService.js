/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var WebStorageService = function(key){

    // set the key
    this.key = key;

    this.initialize = function(data) {
        var deferred = $.Deferred();


        //this.key = key;

        // set up the store - should we not check if it exists first?
        if(this.checkStore(this.key) === false){
            this.createStore();
            if(data){
                this.insertData(data);
            }
            // Store sample data in Local Storage
            //window.localStorage.setItem(this.key, JSON.stringify(data));
        }

        deferred.resolve();
        return deferred.promise();
    };

    this.checkStore = function(){
        // get the number of keys in the store
        for(var i=0; i<window.localStorage.length; i++){
            if(this.key===window.localStorage.key(i)){
                // this is not enough
                // need to check if key is undefined...
                // which it will be if no data has been added
                return true;
            }
        }
        return false;
    };

    this.get = function (id) {

        var deferred = $.Deferred(),
            items = JSON.parse(window.localStorage.getItem(this.key)),
            item = null,
            l = items.length;

            var keyValue = parseInt(id);
        for (var i = 0; i < l; i++) {
            if (parseInt(items[i].id) === keyValue) {
                item = items[i];
                break;
            }
        }

        deferred.resolve(item);
        return deferred.promise();
    };

    this.getAll = function(){
        var deferred = $.Deferred(),
            items = JSON.parse(window.localStorage.getItem(this.key));
        deferred.resolve(items);
        return deferred.promise();
    };

    this.findByKey = function(keyName, id) {
        var deferred = $.Deferred(),
            items = JSON.parse(window.localStorage.getItem(this.key)),
            results = [],
            l = items.length;

            var keyValue = parseInt(id);
        for (var i = 0; i < l; i++) {
            if (parseInt(items[i][keyName]) === keyValue) {
                results.push(items[i]);
            }
        }

        deferred.resolve(results);
        return deferred.promise();

    };

    this.find = function(params){

        if(Array.isArray(params) === false){
            return 'bad parameter, should be an array';
        }
        if(params.length === 0){
            return 'bad parameter, array was empty';
        }
        if(params.length === 1){
            return this.findByKey(params[0].key,params[0].value);
        }

        var deferred = $.Deferred(),
            items = JSON.parse(window.localStorage.getItem(this.key)),
            results = [],
            l = items.length;


        for (var i = 0; i < l; i++) {
            var match = true;
            for(var j = 0; j < params.length; j++){
                if(parseInt(items[i][params[j].key]) !== parseInt(params[j].value)){
                    match = false;
                    break;
                }
            }
            if (match) {
                results.push(items[i]);
            }
        }

        deferred.resolve(results);
        return deferred.promise();

    };

    this.update = function(objects, key){
        var deferred = $.Deferred();
        // only try and parse json if there is some
        if(localStorage[this.key]!==undefined){
            items = JSON.parse(localStorage[this.key]);
        }
        if(items===undefined || Array.isArray(items)===false){
            items = [];
        }
        
        
        var results = [], l = items.length;

        if(key===undefined){
            key = 'id';
        }
        // this both does update and insert
        // but can we make it loop?
        for (var i=0; i<objects.length; i++){

            var append = true;
            var keyValue = parseInt(objects[i][key]);
            for (var j = 0; j < l; j++) {
                // search for the matching object
                if (parseInt(items[j][key]) === keyValue) {
                    // replace that object with this object
                    items[j] = objects[i];
                    append = false;
                    break;
                }
            }
            if(append){
                // assign an id
                objects[i].id = items.length;
                // add the object on the end
                items.push(objects[i]);
            }

        }

        localStorage[this.key] = JSON.stringify(items);
        //window.localStorage.setItem(this.key, JSON.stringify(items));

        deferred.resolve(objects);
        return deferred.promise();

        //var checkins = JSON.parse(localStorage["checkins"]);
        // if no match
        // just add this object to the store
    };

    this.insertData = function(data){
        // pour data in there...
        // used when initialize(data) is passed
        // used in syncing.. (or is it?)
            window.localStorage.setItem(this.key, JSON.stringify(data));
    };

    this.removeItem = function(id){
        // def use when synching
    };

    this.createStore = function(){
        // create table
        window.localStorage.setItem(this.key, JSON.stringify(''));
    };

    this.removeStore = function(){
        // i.e. delete table
        window.localStorage.removeItem(this.key);
    };

    this.removeAll = function(){
        // i.e. delete database
        // probably never want to use this in a class like this
        // way more appropriate for part of the synch manager
        window.localStorage.clear();
    };

};
