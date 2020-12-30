(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	 	 $(document).on("click","#career-insert", function(){
	 	 	InsertContainer();
	 	 });

	 	 function InsertContainer() {
	 			// let's obtain the values of the fields
	 			var searchbar = '';
	 			var link = '';
	 			var desc = '';
	 			var layout = '';
	 			var id = '';
	 			var posted = '';
	 			var ref = '';
	 			var expiry = '';
	 			var apply = '';
	 			var comp = '';
	 			var type = '';

	 			

	 			if ($("#wprem_careers_id").val()){
	 				id = ' id="'+$("#wprem_careers_id").val()+'"';
	 			}

	 			if ($("#wprem_careers_link").val()){
	 				link = ' link="'+$("#wprem_careers_link").val()+'"';
	 			}

	 			if ($("#wprem_careers_desc").val()){
	 				desc = ' desc="'+$("#wprem_careers_desc").val()+'"';
	 			}

	 			if ($("#wprem_careers_layout").val()){
	 				layout = ' layout="'+$("#wprem_careers_layout").val()+'"';
	 			}

	 			if ($('#wprem_careers_searchbar').is(':checked')){
	 				searchbar = ' searchbar=1';
	 			}

	 			if ($('#wprem_careers_posted').is(':checked')){
	 				posted = ' posted=1';
	 			}

	 			if ($('#wprem_careers_ref').is(':checked')){
	 				ref = ' ref=1';
	 			}

	 			if ($('#wprem_careers_exp').is(':checked')){
	 				expiry = ' exp=1';
	 			}

	 			if ($('#wprem_careers_apply').is(':checked')){
	 				apply = ' apply=1';
	 			}

	 			if ($('#wprem_careers_comp').is(':checked')){
	 				comp = ' comp=1';
	 			}

	 			if ($('#wprem_careers_type').is(':checked')){
	 				type = ' type=1';
	 			}


	 			window.send_to_editor("[wprem_careers"+id+""+link+""+desc+""+searchbar+""+layout+""+posted+""+ref+""+expiry+""+apply+""+comp+""+type+"]");
	 		}


	 		$(function(){

	 			$('.wpremC-enable-slider').click(function(){
	      	// alert(1);
	      		var cBox = $(this).parent().find('input:checkbox');
	      		var int = cBox.val();
	      		cBox.trigger('click');

	      	 	if(!cBox.val() || cBox.val() === '0'){
	      			cBox.val('1');
	      	 	}else{
	      	 		cBox.val('0');
	      	 	}

	      	 	if($(this).hasClass('disable-toggle')){
	      			$(this).closest('fieldset').next().toggleClass('option-disabled');
	      	 	}

	      	});

	 		});

})( jQuery );
