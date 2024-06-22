<?php 
$techup_enable_testimonial_section = get_theme_mod( 'techup_enable_testimonial_section', false );
$techup_testimonial_title= get_theme_mod( 'techup_testimonial_title','What People Say');
$techup_testimonial_subtitle= get_theme_mod( 'techup_testimonial_subtitle');

if($techup_enable_testimonial_section == true ) {
	$techup_testimonials_no        = 6;
	$techup_testimonials_pages      = array();
	for( $i = 1; $i <= $techup_testimonials_no; $i++ ) {
		 $techup_testimonials_pages[] = get_theme_mod('techup_testimonial_page'.$i);
	}
	$techup_testimonials_args  = array(
	'post_type' => 'page',
	'post__in' => array_map( 'absint', $techup_testimonials_pages ),
	'posts_per_page' => absint($techup_testimonials_no),
	'orderby' => 'post__in'
	); 
	$techup_testimonials_query = new WP_Query( $techup_testimonials_args );
?>
 	<!-- ======= Testimonials Section ======= -->

    <section id="testimonials" class="testimonials-5">
      <div class="container">
        <div class="section-title-5">
        	<?php if($techup_testimonial_title) : ?>
          <h2 class="title"><?php echo esc_html($techup_testimonial_title); ?></h2>
          <?php endif; ?>
          <div class="separator"></div>
          <?php if($techup_testimonial_subtitle) : ?>
          <p><?php echo esc_html($techup_testimonial_subtitle); ?></p>
          <?php endif; ?>
        </div>
      </div>
      <div class="container">
        <div class="row">
          <div class="testimonials-content owl-carousel owl-theme">
          			<?php
				          $count = 0;
				          while($techup_testimonials_query->have_posts() && $count <= 5 ) :
				          $techup_testimonials_query->the_post();
				        ?>
            <article class="testimonial-block wow fadeInLeft" data-wow-delay="300ms" data-wow-duration="3000ms">
              <figure class="thumbnail">
                <?php the_post_thumbnail(); ?>
              </figure>
              <div class="testimonial-content">
                <p>"<?php echo esc_html(get_the_excerpt()); ?>"</p>
                <cite class="name"><?php the_title(); ?></cite>
                <span class="position"><?php get_the_author(); ?></span>
              </div>
            </article>
            	<?php
        				$count = $count + 1;
        				endwhile;
        				wp_reset_postdata();
        			?>
          </div>
        </div>
      </div>
    </section>
    
    <!-- End Testimonials Section ---->

	
<?php } ?>