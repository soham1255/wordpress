jQuery(document).ready(function($) {
        jQuery(document).on('click','.listing_page .page-numbers a',function(e) {
            e.preventDefault(); 
	     var selectedCategory = jQuery('.event_category.tab_desable').attr('data-type');

			var page_num = jQuery(this).text();
			if(page_num==">>")
			{
				var href = jQuery(this).attr('href'); console.log(href);
				var res = href.split("="); console.log(res);
				var page_num = res[1];
			}
			else if(page_num=="<<")
			{
				var href = jQuery(this).attr('href');
				var res = href.split("=");
				var page_num = res[1];
			}
			else
			{
				var page_num = parseInt(page_num);
			}
			console.log('click');
			console.log(page_num);
			
			$.post(
                ajaxurl, 
                {
                    action: 'event_ajax_pagination',
                    page: page_num, 
                    posts_per_page: 5,
                    'selectedCategory' : selectedCategory,
					
                },
                function(data) {
                   jQuery('.event_listing__block').html(data);
				   
                                jQuery('.page-numbers.current').text('Page '+num);
                                                jQuery('ul.page-numbers li a').each(function() {
                                        var $this = jQuery(this);
                                        if ( $this.hasClass('prev') ) $this.parent('li').addClass('prev-list-item');
                                        if ( $this.hasClass('next') ) $this.parent('li').addClass('next-list-item');      
                                });
                                jQuery('ul.page-numbers li span').each(function() {
                                    var $this = jQuery(this);
                                    if ( $this.hasClass('current') ) $this.parent('li').addClass('pages');
                                    
                                });
                                jQuery('ul.page-numbers li a').each(function() {
                                    var $this = jQuery(this);
                                    if ( $this.hasClass('page-numbers') ) $this.parent('li').addClass('pagenumber');
                                
                                });
                                jQuery('ul.page-numbers li a').each(function() {
                                    var $this = jQuery(this);
                                    if ( $this.hasClass('page-numbers') ) $this.addClass('page_number');
                                
                                });
                                jQuery('ul.page-numbers li').each(function() {
                                    var $this = jQuery(this);
                                    if ( $this.hasClass('next-list-item') ) $this.removeClass('pagenumber');
                                    if ( $this.hasClass('prev-list-item') ) $this.removeClass('pagenumber');
                                });
                                jQuery('li.next-list-item a').removeClass('page_number');
                                jQuery('li.next-list-item a').removeClass('page-numbers');
                                jQuery('li.prev-list-item a').removeClass('page_number');
                                jQuery('li.prev-list-item a').removeClass('page-numbers');
                });
                                
		});
        
    });
