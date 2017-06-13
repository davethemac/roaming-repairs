/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){
 
    // these maybe should be elsewhere
    jQuery.validator.addMethod('myDate', function(value, element){
        var bits, check;
        if(value.indexOf('/') > -1){
            bits = value.split('/');
            check = value;
        }else if(value.indexOf('-') > -1){
            bits = value.split('-');
            check = value.replace(/-/g, '/');
        }else if(value.indexOf(':') > -1){
            bits = value.split(':');
            check = value.replace(/:/g, '/');
        }else if(value.indexOf('.') > -1){
            bits = value.split('.');
            check = value.replace(/./g, '/');
        }
                
        if(Array.isArray(bits) === false){
            return false;
        }
        if(bits.length!==3){
            return false;
        }

        var d = new Date(bits[2], bits[1] - 1, bits[0]);
        return d.toLocaleDateString('en-GB') === check;
    }, 'This field requires a valid date');
    // this one could definetlty invoked from the additional validator methods file
    $.validator.addMethod( "skip_or_fill_minimum", function( value, element, options ) {
	var $fields = $( options[ 1 ], element.form ),
		$fieldsFirst = $fields.eq( 0 ),
		validator = $fieldsFirst.data( "valid_skip" ) ? $fieldsFirst.data( "valid_skip" ) : $.extend( {}, this ),
		numberFilled = $fields.filter( function() {
			return validator.elementValue( this );
		} ).length,
		isValid = numberFilled === 0 || numberFilled >= options[ 0 ];

	// Store the cloned validator for future validation
	$fieldsFirst.data( "valid_skip", validator );

	// If element isn't being validated, run each skip_or_fill_minimum field's validation rules
	if ( !$( element ).data( "being_validated" ) ) {
		$fields.data( "being_validated", true );
		$fields.each( function() {
			validator.element( this );
		} );
		$fields.data( "being_validated", false );
	}
	return isValid;
}, $.validator.format( "Please either skip these fields or fill at least {0} of them." ) );

        
    // compile templates
    if(typeof ActiveJobView === 'function'){
        var activeJobTemplate = $("#active-job-tpl").html();
        if(activeJobTemplate!==undefined){
            ActiveJobView.prototype.template = Handlebars.compile(activeJobTemplate);
        }
    }
    if(typeof PartsUsedView === 'function'){
        var partsUsedTemplate = $("#parts-used-tpl").html();
        if(partsUsedTemplate!==undefined){
            PartsUsedView.prototype.template = Handlebars.compile(partsUsedTemplate);
        }        
    }
    if(typeof JobSearchView === 'function'){
        var jobSearchTemplate = $("#search-jobs-tpl").html();
        if(jobSearchTemplate!==undefined){
            JobSearchView.prototype.template = Handlebars.compile(jobSearchTemplate);
        }
    }
    if(typeof JobListView === 'function'){
        var jobListTemplate = $("#job-list-tpl").html();
        if(jobListTemplate!==undefined){
            JobListView.prototype.template = Handlebars.compile(jobListTemplate);
        }
    }
    // other templates would be
    // login (no idea if that could even work)
    // list jobs
    // list users

    if(typeof SynchManager === 'function'){

        // create and initialise the synchmanager, so we can pass it to the 
        // views that need it
        var manager = new SynchManager();       
        // pass true to use testData
        manager.initialize(true).done(function () {

            // create views now if we need them in delegate event handlers
            var partsUsedView = new PartsUsedView(manager);
            
            // event handler for the add part button
            $(document).on('click', '#add_part', function(){
                // insert the html
                partsUsedView.addPart();
                // add validation now the new elements are part of the document
                partsUsedView.addPartValidation();
            });
            
            // change event handler to update the model
            $(document).on('change', '.part_used_elem', function(event){
                // defer handling and just pass the event to the view object
                partsUsedView.update(event);
            });

            // add autocomplete for the part numbers
            $(document).on('focus', '.part_no', function(){
                var el = $(this);
                // use this kludge to avoid repeatedly invoking the auto complete function
                if(el.hasClass('autocomplete')===false){
                    el.autoComplete({
                        minChars: 1,
                        source: partsUsedView.autoCompleteSource, // could we make these this. ?
                        onSelect: partsUsedView.autoCompleteOnSelect
                    });
                    // add this class so we don't invoke the autocomplete again on this element
                    el.addClass('autocomplete');
                }
            }); 

            if(typeof router !== 'undefined'){
                
                // possibly replace this with other views
                // i.e. 'my jobs'
                if(typeof JobSearchView === 'function'){
                    router.addRoute('', function() {
                        $('body').html(new JobSearchView(manager).render().el);
                    });
                }
                if(typeof ActiveJobView === 'function'){
                    router.addRoute('job/:id', function(id) {
                        // pass in the PartsUsedView, cos it has a composite relationship with the JobView
                        $('body').html(new ActiveJobView(manager, partsUsedView, id).render().el);
                    });
                }
                router.start();
            }
        });
    }
});