/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var WebStoragePartUsedService = function(key){

    WebStoragePartUsedService.prototype = Object.create(WebStorageService.prototype);

    WebStorageService.call(this, key);

    this.findByKey = function(keyName, id) {
        var deferred = $.Deferred(),
            items = JSON.parse(window.localStorage.getItem(this.key)),
            results = [],
            l = items.length;

        for (var i = 0; i < l; i++) {
            if (items[i][keyName] === id) {
                results.push(items[i]);
                break;
            }
        }

        deferred.resolve(results);
        return deferred.promise();

    };

};

//WebStoragePartUsedService.inherits(WebStorageService);
