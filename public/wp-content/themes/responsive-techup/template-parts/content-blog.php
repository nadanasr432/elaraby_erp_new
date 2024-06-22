<?php
$techup_enable_blog_section = get_theme_mod( 'techup_enable_blog_section', true );
$techup_blog_cat 		= get_theme_mod( 'techup_blog_cat', 'uncategorized' );
if($techup_enable_blog_section == true) 
{
	$techup_blog_title 	= get_theme_mod( 'techup_blog_title', esc_html__( 'Our News & Blogs','responsive-techup'));
	$techup_blog_subtitle 	= get_theme_mod( 'techup_blog_subtitle', esc_html__( 'Latest News','responsive-techup') );
	$techup_rm_button_label 	= get_theme_mod( 'techup_rm_button_label', esc_html__( 'Read More','responsive-techup'));
	$techup_blog_count 	 = apply_filters( 'techup_blog_count', 3 );
?> 	
	<!-- blog start-->
	<section class="blog-5">
        <div class="container">
          <div class="section-title-5">
          	<?php if($techup_blog_title) : ?>
            <h2><?php echo esc_html( $techup_blog_title ); ?></h2>
            <?php endif; ?>
            <div class="separator"></div>
            <?php if($techup_blog_subtitle) : ?>
            <p><?php echo esc_html( $techup_blog_subtitle ); ?></p>
            <?php endif; ?>
        </div>
            <div class="row">
            	<?php 
				if( !empty( $techup_blog_cat ) ) 
					{
					$blog_args = array(
						'post_type' 	 => 'post',
						'category_name'	 => esc_attr( $techup_blog_cat ),
						'posts_per_page' => absint( $techup_blog_count ),
					);

					$blog_query = new WP_Query( $blog_args );
					if( $blog_query->have_posts() ) 
					{
						while( $blog_query->have_posts() ) 
						{
							$blog_query->the_post();
				?>
                  <div class="col-lg-4 col-md-6 col-sm-12">
                    <article class="blog-item blog-1 wow fadeInLeft" data-wow-delay="300ms" data-wow-duration="3000ms">
                        <div class="post-img">
                          	<?php if(the_post_thumbnail()): ?>
                            <?php the_post_thumbnail_url(); ?>
                            <?php endif; ?>
                          <div class="date-box" >
                            <div class="m"><?php echo esc_html(get_the_date( 'j' ));?></div>
                            <div class="d"><?php echo esc_html(get_the_date( 'M' ));?></div>
                          </div>
                        </div>
                        <div class="post-content pt-4 text-left">
                            <h5>
                                <a class="heading" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h5>
                            <p class="text-left"><?php the_excerpt(); ?></p>
                            <div class="btn-wraper">
                            	<?php if($techup_rm_button_label):?>
                              <a href="<?php the_permalink(); ?>" class="read-more-btn"><?php echo esc_html($techup_rm_button_label); ?> <i class="fa fa-hand-o-right"></i></a>
                              <?php endif; ?>
                            </div>
                        </div>
                    </article>
                  </div> 
                  <?php
						}
					}
					wp_reset_postdata();
				} ?> 
            </div>
        </div>
    </section>

        <!-- blog end-->	

<?php } ?>