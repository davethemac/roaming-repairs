/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var PartsUsedView = function(manager){
    
    var jobId;
    var partsUsed = [];
    var parts = [];
    var self = this;
    var manager = manager;

    this.initialize = function() {
        this.el = $('<div/>');
        this.getData();
        this.render();
    };
    
    this.partNumberFromId = function(id){
        for(i=0; i < parts.length; i++){
            if(parseInt(parts[i].id)===parseInt(id)){
                return parts[i].part_number;
            }
        }
        return '';
    };
    
    this.addPartNumbers = function(){
        for(i=0; i < partsUsed.length; i++){
            partsUsed[i].part_number = this.partNumberFromId(partsUsed[i].id);
        }
    };

    this.setJobId = function(id) {
        jobId = id;
        manager.partUsedService.findByKey('job_id', id).done(function (data){
            partsUsed = data;
            self.addPartNumbers();
            self.render();
        });
    };

    this.render = function() {
        if(typeof this.template === 'function'){
            this.el.html(this.template({partsUsed:partsUsed}));
        }
        return this;
    };

    this.getData = function(){
        // maybe better to just pass in the parts service
        // cos service locator anti pattern
        if(manager.partService!==undefined){
            manager.partService.getAll().done(function (data) {
                parts = data;
            });
        }
    };
    
    this.addPart = function(){
        var empty = {
            part_number:'',
            description:'',
            quantity:'',
            office_a:'',
            office_b:''
        };
        partsUsed.push(empty);
        this.render();
    };
    
    this.addPartValidation = function(){
        var index = partsUsed.length - 1;
        $('#part_no_' + index).rules('add',{
            'skip_or_fill_minimum':[3, '.part_used_' + index]
        });
        $('#part_desc_' + index).rules('add',{
            'skip_or_fill_minimum':[3, '.part_used_' + index]
        });
        $('#part_quantity_' + index).rules('add',{
            'skip_or_fill_minimum':[3, '.part_used_' + index],
            'messages':{'skip_or_fill_minimum':'blah blah blah'}
        });
    };
    
    this.update = function(event){
        // here we need to work out what thing was changed, and update the 
        // parts used array
        // but we don't want to persist any changes in the same way as it 
        // save was hit
        var id = event.target.id;
        // get the index
        var index = parseInt(id.substr(event.target.id.lastIndexOf('_') + 1 ));
        if(id.indexOf('part_quantity') > -1){
            partsUsed[index].quantity = event.target.value;
        }
        if(id.indexOf('part_no') > -1){
            // is this right?
            // could get the part.id from a look up of the part_number
            partsUsed[index].part_number = event.target.value;
        }
        if(id.indexOf('part_desc') > -1){
            // this is really 'part usage description'
            partsUsed[index].description = event.target.value;
        }
    };
    
/*
var test_parts_used = [
    {
        id:1,
        job_id:1,
        part_id:1,
        description:'Widget: blah',
        quantity:1,
        office_a:'',
        office_b:''
    },
];

var test_parts = [
    {id:1, part_number:'01', description:'Widget'},
    {id:2, part_number:'02', description:'Geegaw'},
    {id:3, part_number:'03', description:'Dongle'},
];
    */
    
    this.save = function(){
        var toUpdate = [];
        for(i=0; i<partsUsed.length; i++){
            // add part_id
            partsUsed[i].part_id = this.partIdFromPartNumber(partsUsed[i].part_number);
            // add job_id (if needed)
            partsUsed[i].job_id = jobId;
            // remove part_no
            delete partsUsed[i].part_number;
            if(partsUsed[i].job_id > 0){
                toUpdate.push(partsUsed[i]);
            }
        }
        //
        manager.partUsedService.update(toUpdate);
    };
    
    this.partIdFromPartNumber = function(partNumber){
        for(i=0; i < parts.length; i++){
            if(parts[i].part_number===partNumber){
                return parts[i].id;
            }
        }
        return 0;
    };

    // get just the part numbers for the auto-complete
    this.getPartChoices = function(){
        var data = [];
        for(i=0; i<parts.length; i++){
            data.push(parts[i].part_number);
        }
        return data;
    }
    
    // return part descriptions given the part number
     this.getPartNoDesc = function(term){
        for(i=0; i<parts.length; i++){
            if(parts[i].part_number === term){
                return parts[i].description;
            }
        }
    }

    // main auto complete function
    this.autoCompleteSource = function(term, suggest){
        term = term.toLowerCase();
        var choices = self.getPartChoices();
        var suggestions = [];
        for (i=0;i<choices.length;i++){
            if (choices[i].toLowerCase().indexOf(term) > -1){
                suggestions.push(choices[i]);
            }
        }
        suggest(suggestions);
    };
    
    // event handler to insert part descriptions
    this.autoCompleteOnSelect = function (event, term){
        // get the the position of this row in the partsUsed table
        // part_used_row_
        var row_no = $(event.target).closest('tr').attr('id').substr(14);

        // check to see if there is something already in the textarea
        var currentText = $('#part_desc_' + row_no).val();
        var appendText = '';
        if(currentText !== undefined && currentText.length > 0){
            // probably has something in there already, so remove the previous part desc if there is one
            var colonPosition = currentText.indexOf(': ');
            if(colonPosition > 0){
                appendText = currentText.substr(currentText.indexOf(': '));
            }
        }

        // set the textarea with the part description and any text that was already in there
        $('#part_desc_' + row_no)
                .val(self.getPartNoDesc(term) + appendText); // this works, but need to make it more user friendly, 
        /*$('#part_desc_' + row_no)
                .valid();*/
        $('#part_desc_' + row_no).change();
       
    };

    this.initialize();
    
};
