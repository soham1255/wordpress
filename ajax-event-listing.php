add_action("wp_ajax_get_event_listing", "get_event_listing");
add_action("wp_ajax_nopriv_get_event_listing", "get_event_listing");


function get_event_listing(){

    $selectedCategory = $_POST['selectedCategory'];
    if($selectedCategory!='')
	{
		$posts = new WP_Query(array(
			'post_type' => 'events',
			 'post_status'   => 'publish',
			'posts_per_page' => 5,
			'paged' => get_query_var('paged'),
			'tax_query' => array(
			array(
			'taxonomy' => 'event_category',
			'field' => 'slug',
			'terms' => $selectedCategory,
			),
		)));
	}

    if ($posts->have_posts()) {

      
        while ($posts->have_posts()):
        $posts->the_post();
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
	
        
    <?php	endwhile;
    
      $total_pages = $posts->max_num_pages;
        $big = 999999999;
        if ($total_pages > 1){  
            $current_page = max(1, get_query_var('paged'));  ?>
           <nav class="page-nav" style="margin: auto;">
          <?php echo paginate_links(array(  
                'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'type'               => 'list',
                'format'    => '?paged=%#%',  
                'current'   => $current_page,  
                'total'     => $total_pages,  
                'prev_text' => '<<',  
                'next_text' => '>>' 
            ));  
            ?>
         </nav> 
      <?php  
            } 
    die();
        }
        else{
        
            echo "<p style='text-align:center;font-weight:bold;margin: 20px auto;font-size:18px'>No event listing found.</p>";
            die;
        }

}
