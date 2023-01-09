function filterevent(){
	//jQuery('.event_listing__block').html("");

	 var selectedCategory = jQuery('.event_category.tab_desable').attr('data-type');
	 
	
	console.log(selectedCategory);

	
	var fields = {
		'action' : 'get_event_listing',
		'selectedCategory' : selectedCategory,
		
	};
	jQuery.ajax({
		type: 'POST',
		url : ajaxurl,
		data: fields,
		success: function(data) {
			console.log(data);
			 jQuery('.event_listing__block').html(data);
        }
			
                });
            
}

jQuery('.event_category').click(function(){
    jQuery('.event_category').removeClass('tab_desable');
    jQuery(this).toggleClass('tab_desable');
    var val = jQuery(this).attr('data-type');
    filterevent();
});
