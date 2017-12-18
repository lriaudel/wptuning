jQuery(document).ready(function() {
	jQuery('#wptunning-default-button').click( function(e){

		// Input Checkbox
		jQuery("input[type='checkbox']").each( function($i) {
			jQuery(this).prop('checked', false);
		});
		jQuery("input[type='checkbox'][data-default='true']").each( function($i) {
			jQuery(this).prop('checked', true);
		});

		// Input TEXT
		jQuery("input[type='text']").each( function($i) {
			dataDefault = jQuery(this).attr('data-default');
			if ( "" == dataDefault ){
				jQuery(this).val("");
			}
			else{
				jQuery(this).val( dataDefault );
			}
		});

	});

}); // end ready
