/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var parts = [];

$(function(){

    // this bit is redundant. superceeded by parts manager
    // grab the parts data
    $.getJSON('/parts', function(data){
        $.each( data, function(key, value){
            parts.push(value);
        });
    });
        
    // single page application stuff
    // compile templates
    if(typeof PartsUsedView === 'function'){
        var partsUsedTemplate = $("#parts-used-tpl").html();
        if(partsUsedTemplate!==undefined){
            PartsUsedView.prototype.template = Handlebars.compile(partsUsedTemplate);
        }        
    }

    if(typeof SynchManager === 'function'){
        var manager = new SynchManager();
        
        // pass true to use testData
        manager.initialize(true).done(function () {
            if(typeof router !== 'undefined'){
                if(typeof PartsUsedView === 'function'){
                    
                    var partsUsedView = new PartsUsedView(manager);

                    $(document).on('click', '#add_part', partsUsedView, function(){
                        partsUsedView.addPart();
                    });
                    
                    // add autocomplete for the part numbers
                    $(document).on('focus', '.part_no', function(){
                        var el = $(this);
                        if(el.hasClass('autocomplete')===false){
                            el.autoComplete({
                                minChars: 1,
                                source: partsUsedView.autoCompleteSource, // could we make these this. ?
                                onSelect: partsUsedView.autoCompleteOnSelect
                            });
                            el.addClass('autocomplete');
                        }
                    }); 

                    router.addRoute('', function() {
                        $('body').html(partsUsedView.render().el);
                    });
                }
                router.start();
            }
        });
    }//*/

});