add_action( 'wp_ajax_event_ajax_pagination', 'event_ajax_pagination' );
add_action( 'wp_ajax_nopriv_event_ajax_pagination', 'event_ajax_pagination' );


function event_ajax_pagination()
{
	 $requested_page = intval($_POST['page']);
    $posts_per_page = intval($_POST['posts_per_page']);
    $selectedCategory = $_POST['selectedCategory'];
    if($selectedCategory!='')
	{
	$args = array(
            'post_type' => 'events',
			'posts_per_page' => $posts_per_page,
			'order' => 'DESC',
			'paged' => $requested_page,
            'tax_query' => array(
                array(
                'taxonomy' => 'event_category',
                'field' => 'slug',
                'terms' => $selectedCategory,
                ),
            )
        );
    }
    if($selectedCategory == '')
	{
        $args = array(
            'post_type' => 'events',
			'posts_per_page' => $posts_per_page,
			'order' => 'DESC',
			'paged' => $requested_page,
           
        );
    }    
        
        $query = new WP_Query( $args );
        if( $query->have_posts() ){
            while( $query->have_posts() ){
                $query->the_post(); 
                global $post;
                $event_date = get_post_meta( $post->ID, 'event_date', true );
                $event_location = get_post_meta( $post->ID, 'event_location', true );
                $event_fees = get_post_meta( $post->ID, 'event_fees', true );
                ?> 
		
        <div class="event_listing_item">
                        <div class="event_listing__link">
                            <div class="event_image_wrp">
                                <img src="<?php echo get_the_post_thumbnail_url(); ?>">
                            </div>
                            <div class="event_title">
                                <h3><?php the_title();?></h3>
                                <p><?php echo wp_trim_words( get_the_content(), 10, '...' ); ?></p>
                            </div>
                            <div class="event_details_wrap">
                                <span>Date: <?php echo  $event_date; ?></span> |
                                <span>Location: <?php echo  $event_location; ?></span> |
                                <span>Fees: <?php echo  $event_fees; ?></span>
                            </div>
                        </div>
                    </div>
           
	<?php  	}
		}
		
	 $total_pages = $query->max_num_pages;
    $big = 999999999;
    if ($total_pages > 1){  
        $current_page = max(1, get_query_var('paged'));  ?>
       <nav class="page-nav" style="margin: auto;">
      <?php echo paginate_links(array(  
            'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'type'               => 'list',	
			'format'    => '?paged=%#%',  
            'current'   => $requested_page,  
            'total'     => $total_pages,  
            'prev_text' => '<<',  
            'next_text' => '>>' 
        ));  
		?>
     </nav> 
  <?php  }
  
     wp_reset_query();
	  exit;
}
