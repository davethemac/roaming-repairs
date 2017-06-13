/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//alert('hi');

function StorageProvider(){
    // constuctor
    // this is a wrapper for the various local storage methods
    // provides a consitent interface for the rest of the application
    // difficulties arise from the differences in setup requirements
    this.attribute = 'value';
};

StorageProvider.prototype.operation = function(){};