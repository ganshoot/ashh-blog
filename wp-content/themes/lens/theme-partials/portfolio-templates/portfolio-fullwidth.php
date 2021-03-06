<div id="main" class="content djax-updatable">
	<?php
	$client_name = '';
	$client_name = get_post_meta( get_the_ID(), wpgrade::prefix() . 'portfolio_client_name', true );
	
	$client_link = get_post_meta( get_the_ID(), wpgrade::prefix() . 'portfolio_client_link', true );
    if($client_link == '') $client_link = '#';

	$gallery_ids = get_post_meta( $post->ID, wpgrade::prefix() . 'portfolio_gallery', true );
	if (!empty($gallery_ids)) {
		$gallery_ids = explode(',',$gallery_ids);
	} else {
		$gallery_ids = array();
	}

    $image_scale_mode = get_post_meta(get_the_ID(), wpgrade::prefix().'portfolio_image_scale_mode', true);
    $slider_transition = get_post_meta(get_the_ID(), wpgrade::prefix().'portfolio_slider_transition', true);
    $slider_autoplay = get_post_meta(get_the_ID(), wpgrade::prefix().'portfolio_slider_autoplay', true);
    if($slider_autoplay)
        $slider_delay = get_post_meta(get_the_ID(), wpgrade::prefix().'portfolio_slider_delay', true);

	if ( !empty($gallery_ids) ) {
		$attachments = get_posts( array(
			'post_type' => 'attachment',
			'posts_per_page' => -1,
			'orderby' => "post__in",
			'post__in'     => $gallery_ids
		) );
	} else {
		$attachments = array();
	}

    if ( !empty($attachments) ) : ?>
    <div class="featured-image">
        <?php
            if ($image_scale_mode == '') {
                $image_scale_mode = 'fill';
            }
            $data_scaling = $image_scale_mode == 'auto' ? 'data-autoheight' : 'data-imagealigncenter data-imagescale="'.$image_scale_mode.'"';
        ?>
        <div class="pixslider js-pixslider" 
            data-bullets 
            data-customarrows
            data-sliderpauseonhover 
            <?php echo $data_scaling; ?> 
            data-slidertransition="<?php echo $slider_transition; ?>"
            <?php if ($slider_autoplay) {
                echo 'data-sliderautoplay="" ';
                echo 'data-sliderdelay='. $slider_delay;
            } ?>            
        >
            <?php
			if (!empty($video)) { ?>
				<div class="pixslider__slide video">
                    <img src="<?php echo $videoimg; ?>" class="rsImg" data-rsVideo="http://www.youtube.com/watch?v=<?php echo $video ?>" />
                </div>
			<?php }
            foreach ( $attachments as $attachment ) :
                $class = "post-attachment mime-" . sanitize_title( $attachment->post_mime_type );
                $thumbimg = wp_get_attachment_image_src( $attachment->ID, 'full' );
                $attachment_fields = get_post_custom( $attachment->ID );

	            // check if this attachment has a video url
	            $video_url = ( isset($attachment_fields['_video_url'][0] ) && !empty( $attachment_fields['_video_url'][0]) ) ? esc_url( $attachment_fields['_video_url'][0] ) : '';

	            //  if there is a video let royal slider know about it
	            if ( !empty($video_url) ) { ?>
		            <div class="pixslider__slide video">
			            <img src="<?php echo $thumbimg[0]; ?>" class="rsImg" data-rsVideo="<?php echo $video_url; ?>" />
		            </div>
	            <?php } else { ?>
	                <div class="pixslider__slide" itemtype="http://schema.org/ImageObject" >
	                    <img src="<?php echo $thumbimg[0]; ?>" class="rsImg" itemprop="contentURL" />
	                </div>
                <?php }
            endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
    <?php $categories = get_the_terms($post->ID, 'lens_portfolio_categories'); ?>   

    <div class="page-content single-portfolio-fullwidth">
        <div class="page-main">
            <article id="post-<?php the_ID(); ?>" <?php post_class('entry__body'); ?>>
                <div class="row">
                    <div class="project--fullwidth__header">
                        <header class="entry__header">
                            <h1 class="entry__title"><?php the_title(); ?></h1>
                            <div class="entry__meta entry__meta--project cf hand-visible">
							<?php if($client_name != '') : ?>
							<div class="entry__meta-box meta-box--client">
								<span class="meta-box__box-title"><?php _e("Client", wpgrade::textdomain()); ?>: </span>
								<a href="<?php echo $client_link; ?>"><?php echo $client_name; ?></a>
							</div>
							<?php endif; ?> 
							<?php if ($categories): ?>                                    
							<div class="entry__meta-box meta-box--categories">
								<span class="meta-box__box-title"><?php _e("Filled under", wpgrade::textdomain()); ?>: </span>
								<?php foreach ($categories as $cat): ?>
								<a href="<?php echo get_category_link($cat); ?>" rel="category">
									<?php echo get_category($cat)->name; ?>
								</a>
								<?php endforeach; ?>
							</div>
							<?php endif; ?> 
                            </div>
                        </header><!-- .entry-header -->
                    </div>
                    <div class="project--fullwidth__content">
                        <div class="entry__content project-entry-content">
                            <?php the_content(); ?>
                        </div><!-- .entry__content -->
                    </div>
                </div>
                <footer class="entry__meta entry__body cf to-hand-visible">

                    <hr class="separator separator--dotted" />

                    <div class="entry__meta entry__meta--project cf">
                        <?php if($client_name != '') : ?>
						<div class="entry__meta-box meta-box--client">
							<span class="meta-box__box-title"><?php _e("Client", wpgrade::textdomain()); ?>: </span>
							<a href="<?php echo $client_link; ?>"><?php echo $client_name; ?></a>
						</div>
                        <?php endif; ?> 
                        <?php if ($categories): ?>                                    
						<div class="entry__meta-box meta-box--categories">
							<span class="meta-box__box-title"><?php _e("Filled under", wpgrade::textdomain()); ?>: </span>
							<?php foreach ($categories as $cat): ?>
							<a href="<?php echo get_category_link($cat); ?>" rel="category">
								<?php echo get_category($cat)->name; ?>
							</a>
							<?php endforeach; ?>
						</div>
                        <?php endif; ?> 
                    </div>                
                </footer>

                <div class="row">
                    <div class="project--fullwidth__separator--header">
                        <hr class="separator separator--striped separator--full-left"/>
                    </div>
                    <div class="project--fullwidth__separator--content">
                        <hr class="separator separator--striped"/>
                    </div>
                </div>

                <footer class="entry__meta  entry__meta--social  entry__body  flexbox  cf">
                    <?php
                    if (function_exists( 'display_pixlikes' )) {
                        display_pixlikes(array('class' => 'likes-box likes-box--footer flexbox__item'));
                    }
        
                    if (wpgrade::option('portfolio_single_show_share_links')): ?>
                        <div class="social-links flexbox__item text--right">
                            <span class="social-links__message"><?php _e("Share", wpgrade::textdomain()); ?>: </span>
                            <ul class="social-links__list">
                                <?php if (wpgrade::option('portfolio_single_share_links_twitter')): ?>
								<li>
									<a href="https://twitter.com/intent/tweet?original_referer=<?php echo urlencode(get_permalink(get_the_ID()))?>&amp;source=tweetbutton&amp;text=<?php echo urlencode(get_the_title())?>&amp;url=<?php echo urlencode(get_permalink(get_the_ID()))?>&amp;via=<?php echo wpgrade::option( 'twitter_card_site' ) ?>" onclick="return popitup(this.href, this.title)"
									   title="<?php _e('Share on Twitter!', wpgrade::textdomain()) ?>">
										<i class="icon-e-twitter-circled"></i>
									</a>
								</li>
                                <?php endif;
                                if (wpgrade::option('portfolio_single_share_links_facebook')): ?>
								<li>
									<a href="http://www.facebook.com/sharer.php?u=<?php echo urlencode(get_permalink(get_the_ID()))?>" onclick="return popitup(this.href, this.title)"
									   title="<?php _e('Share on Facebook!', wpgrade::textdomain()) ?>">
										<i class="icon-e-facebook-circled"></i>
									</a>
								</li>
                                <?php endif;
                                if (wpgrade::option('portfolio_single_share_links_googleplus')): ?>
								<li>
									<a href="https://plus.google.com/share?url=<?php echo urlencode(get_permalink(get_the_ID()))?>" onclick="return popitup(this.href, this.title)"
									   title="<?php _e('Share on Google+!', wpgrade::textdomain()) ?>">
										<i class="icon-e-gplus-circled"></i>
									</a>
								</li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </footer><!-- .entry-meta -->
                <?php // If comments are open or we have at least one comment, load up the comment template
                   if ( comments_open() || '0' != get_comments_number() )
                      comments_template(); ?>
            </article><!-- #post -->
            <?php //	        $yarpp_active = is_plugin_active('yet-another-related-posts-plugin/yarpp.php');
	        // is_plugin_active() is available only in plugins.
	        // you need to include_once(ABSPATH.'wp-admin/includes/plugin.php'); to have this function
	        // and it sucks.
	        //                   andreilupu

	        if ( function_exists('yarpp_related') ) {
		        $yarpp_active = true;
	        } ?>
            <section class="related-projects_container entry__body">
                <header class="related-projects_header">
                    <?php if($yarpp_active) : ?>
                    <h4 class="related-projects_title"><?php _e("Related projects", wpgrade::textdomain()); ?></h4>
                    <?php endif; ?>
                   <nav class="projects_nav">
                       <ul class="projects_nav-list">
                           <li class="projects_nav-item">
                                <?php next_post_link('%link', '<span class="prev">&#8592;</span>' . __('Previous', wpgrade::textdomain()) ); ?>
                            </li>
                           <li class="projects_nav-item">
                                <a href="<?php echo get_portfolio_page_link(); ?>">
                                    <?php _e("All projects", wpgrade::textdomain()); ?>
                                </a>
                            </li>
                            <li class="projects_nav-item">
                                <?php previous_post_link('%link', __('Next', wpgrade::textdomain()). '<span class="next">&#8594;</span>'); ?>
                            </li>
                       </ul>
                   </nav>
                </header>        
                <?php 
                if ($yarpp_active) {
                    yarpp_related();
                }
                ?>
            </section>
        </div>
    </div><!-- #page-content -->
</div><!-- .content -->