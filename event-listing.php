/**
 * Create short-code for display event listing post type
 */
add_shortcode('event_listing_list', 'event_listing_list');   
function event_listing_list(){
	ob_start(); 
?>


<div class="event_listing_filtering_wrap">
		<div class="all_filter_set">
			<div class="top_filter_section">
				<div class="event_listing_filter event_listing_category_filter">
				<?php
					$taxonomy = 'event_category';
						$terms = get_terms($taxonomy); // Get all terms of a taxonomy
							if ( $terms && !is_wp_error( $terms ) ) {  ?>
							
								
									<?php foreach ( $terms as $term ) { ?>
										<div class="event_category" data-type="<?php echo $term->slug; ?>"><?php echo $term->name; ?></div>
									<?php } ?>
								
					<?php   } 	
				 ?>				
						
				</div>
			</div>
			
		</div>	
</div>
<div class="event_listing_section listing_page">
    <div class="event_listing__wrap">
        <div class="event_listing__block">
			
<?php  $postsPerPage = 5;
	$args = array(
            'post_type' => 'events',
			'posts_per_page' => $postsPerPage,
			'post_status'   => 'publish',
			'order' => 'DESC',
		    'paged' => get_query_var('paged'),
        );

        
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
	 $total_pages = $query->max_num_pages;
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
		}
			
		?>
		</div>
	</div>
</div>
<?php

$html = ob_get_contents();
        
        ob_end_clean();
        
        return $html; 		
}
