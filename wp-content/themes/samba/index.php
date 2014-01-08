<?php 
    get_header();
    global $retina_device;
    $retina_flag = $retina_device === "prk_retina" ? true : false;
    //OVERRIDE OPTIONS - ONLY FOR PREVIEW MODE
    if (INJECT_STYLE) {
        include_once(ABSPATH . 'wp-content/plugins/color-manager-samba/style_header.php');  
    }
    $show_sidebar=$prk_samba_frontend_options['right_sidebar'];
    if ($show_sidebar=="yes")
        $show_sidebar=true;
    else
        $show_sidebar=false;
    $show_title=false;
    $data = get_post_meta( $post->ID, '_custom_meta_blog_template', true );
    if (!empty($data))
    {
        if (isset($data['alchemy_show_sidebar']) && $data['alchemy_show_sidebar']=="yes")
        {
            $show_sidebar=true;
        }
        if (isset($data['alchemy_show_sidebar']) && $data['alchemy_show_sidebar']=="no")
        {
            $show_sidebar=false;
        }
        if (isset($data['alchemy_show_title']) && $data['alchemy_show_title']=="yes") {
            $show_title=true;
        }
    }
?>
    <?php
    if ($prk_samba_frontend_options['archives_type']=="classic")
    {
        ?>
       <div id="centered_block" class="prk_inner_block columns centered main_no_sections">
        <div id="main_block" class="row">
            <?php
                if ($show_title==true)
                {
                    prk_output_title($data);
                }
            ?>
        <div id="content">
            <div id="main" class="main_no_sections">
              <div class="twelve prk_inner_block centered">
                <div  class="<?php if ($show_sidebar) {echo "twelve columns sidebarized no_title_page";}else{echo "twelve no_title_page";} ?>">
                <div id="classic_blog_section" class="prk_section">
            <?php 
               $cat = get_term_by('name', single_cat_title('',false), 'category'); 
                        if (!($cat)!=1)
                            $cat_selector=$cat->slug;
                        else
                            $cat_selector="";
                        $tagname = get_query_var('tag');
                        //APPLY FILTERS FOR TAG IF NEEDED
                        if ($tagname!="")
                            $tag_selector=$tagname;
                        else
                            $tag_selector="";
                        $my_query = new WP_Query();
                        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                        $monthnum = (get_query_var('monthnum')) ? get_query_var('monthnum') : "";
                        $yearnum = (get_query_var('year')) ? get_query_var('year') : "";
                        if ($paged>1)
                        {
                            $excluder=get_option("sticky_posts");
                        }
                        else
                        {
                            $excluder="";
                        }
                        $args = array( 
                            'post_type'=>'post', 
                            'paged' => $paged,
                            'category_name'=>$cat_selector,
                            "post__not_in" =>$excluder,
                            'tag'=>$tagname,
                            'year'=>$yearnum,
                            'monthnum'=>$monthnum);
                        $my_query->query($args);
                        $post_counter=($paged-1)*$posts_per_page;
                        if ($my_query->have_posts()) : 
                        $ins=0;
                        echo "<ul id=\"blog_entries\">";
            echo '<div class="next_link_wp">';
              next_posts_link('',$my_query->max_num_pages);
            echo '</div>';
                            while ($my_query->have_posts()) : $my_query->the_post(); 
                            $post_counter++;
              $data = get_post_meta( $post->ID, '_custom_meta', true );
                  if (isset($data['featured_color']) && $data['featured_color']!="")
                  {
                    $featured_color=$data['featured_color'];
                    $featured_class="featured_color ";
                  }
                  else
                  {
                    $featured_color="default";
                    $featured_class="";
                  }
                            ?>
                        <li id="post-<?php the_ID(); ?>" class="<?php echo $featured_class; ?>blog_entry_li cf<?php if ($post_counter == $my_query->post_count) echo " last_li"; ?>" data-color="<?php echo $featured_color; ?>">
              <?php 
              if (has_post_thumbnail( $post->ID ) ):
                //GET THE FEATURED IMAGE
                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), '' );
                $image[0] = get_image_path($image[0]);
                $p_photo_image=wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), '' );
                
              else :
                //THERE'S NO FEATURED IMAGE
                
              endif; 
              ?>
                <div class="blog_content twelve">                               
               <?php 
                if (has_post_thumbnail( $post->ID ) )
                {
                  ?>
                        <a href="<?php the_permalink(); ?>" class="fade_anchor" data-color="<?php echo $featured_color; ?>">
                            <div class="blog_top_image boxed_shadow">
                              <div class="blog_fader_grid">
                                  <div class="navicon-plus titled_link_icon body_bk_color"></div>
                                </div>
                                <?php 
                                    if (!isset($prk_samba_frontend_options['forcesize_news']))
                                        $prk_samba_frontend_options['forcesize_news']='yes';
                                    $height_force=0;
                                    $cropper=false;
                                    if ($prk_samba_frontend_options['forcesize_news']=='yes') {
                                        $height_force=285;
                                        $cropper=true;
                                      }
                                    $vt_image = vt_resize( '', $image[0] , 840, $height_force, $cropper , $retina_flag );
                                    ?>
                                  <img src="<?php echo $vt_image['url']; ?>" width="<?php echo $vt_image['width']; ?>" height="<?php echo $vt_image['height']; ?>" id="home_fader-<?php the_ID(); ?>" class="custom-img grid_image boxed_shadow" alt="" />

                            </div>
                        </a>
                    <?php
                }
                else
                {
                  //CHECK IF THERE'S A VIDEO TO SHOW
                  if (isset($data['image_2']) && substr($data['image_2'],0,6)!="http:/" && substr($data['image_2'],0,6)!="")
                  {
                    $el_class='video-container';
                    if (strpos($data['image_2'],'soundcloud.com') !== false) {
                      $el_class= 'soundcloud-container';
                    }
                    echo "<div class='".$el_class." boxed_shadow'>";
                    echo $data['image_2'];
                    echo "</div>";
                  }
                  else
                  {
                    ?>
                    <div class="blog_top_image zero_margin_bottom">&nbsp;</div> 
                    <?php
                  }
                }
                ?>
                                <div class="clearfix"></div>
                                    <div class="classic_blog_meta prk_titlify_father">
                                    <h3 class="header_font bd_headings_text_shadow">
                                      <a href="<?php the_permalink(); ?>" class="fade_anchor zero_color prk_break_word" data-color="<?php echo $featured_color; ?>">
                                        <?php the_title(); ?>
                                      </a>
                                    </h3>
                                  <div class="clearfix"></div>
                                </div>
                        <div class="single_blog_meta_class header_font">
                            <?php
                              if (is_sticky())
                              {
                                  ?>
                                  <div class="single_blog_meta_div">
                                      <div class="navicon-flag left_floated"></div>
                                      <div class="left_floated default_color sticky_text">
                                          <?php echo($prk_translations['sticky_text']); ?>
                                      </div>
                                  </div>
                                  <?php
                              }
                          ?>
                          <div class="single_blog_meta_div">
                              <div class="navicon-clock-2 left_floated not_zero_color"></div>
                              <div class="left_floated">
                                  <?php echo get_the_time(get_option('date_format')); ?>
                              </div>
                          </div>
                            <?php
                                if ($prk_samba_frontend_options['categoriesby_news']=="yes")
                                {
                                  if (!isset($data['bl_icon'])) {
                                    $data['bl_icon']='icon-link';
                                  }
                                    ?>
                                    <div class="single_blog_meta_div">
                                        <div class="<?php echo $data['bl_icon']; ?> not_zero_color left_floated"></div>
                                        <div class="left_floated default_color blog_categories">
                                            <?php the_category(', '); //CATS WITH LINKS ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            ?>
                                <?php 
                                    if ($prk_samba_frontend_options['postedby_news']=="yes")
                                    {
                                        ?>
                                        <div class="single_blog_meta_div">
                                            <div class="navicon-user-4 left_floated not_zero_color"></div>
                                            <div class="left_floated">
                                                <?php echo($prk_translations['posted_by_text']); ?>
                                                <?php echo " ".get_the_author(); ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                ?>
                                <?php
                                    if ( comments_open() ) :
                                        ?>
                                        <div class="single_blog_meta_div right_floated">
                                            <div class="left_floated default_color">
                                                <a href="<?php comments_link(); ?>" class="fade_anchor">        
                                                    <?php 
                                                        comments_number($prk_translations['comments_no_response'], $prk_translations['comments_one_response'], '% '.$prk_translations['comments_oneplus_response']);
                                                    ?> 
                                                </a>
                                            </div>
                                            <div class="navicon-bubbles-4 left_floated not_zero_color"></div>
                                        </div>
                                        
                                      <?php
                                    endif;
                                ?>
                         <div class="clearfix"></div>
                       </div>
                                <div class="on_colored entry_content prk_break_word">
                  <?php 
                                      echo the_excerpt_dynamic(64);
                                  ?>
                                  <div class="clearfix eight_margin"></div>
                  <?php 
                                     if (is_big_excerpt(64))
                                    {
                                        ?>
                                            <div class="theme_button">
                                            <a href="<?php the_permalink() ?>" class="fade_anchor" data-color="<?php echo $featured_color; ?>">
                                                    <?php echo($prk_translations['read_more']); ?>
                                            </a>
                                            </div> 
                                        <?php
                                    }
                                ?>  
                             <div class="clearfix"></div>
                                </div>
                              </div>
                            
                        </li>
                        <?php $ins++; ?>
                    <?php 
                        endwhile;
                        echo "</ul>";
                    ?>
             <?php endif; 
            //SHOW BUTTON TO SHOW MORE POSTS ONLY IF NEEDED
            if ($paged!=$my_query->max_num_pages)
                {
                    ?>
                    <div class="clearfix"></div>
                      <div id="entries_navigation">
                        <div class="simple_line blog_divider"></div>
                                    <div class="navigation twelve"> 
                                        <div class="next-posts">
                              <div id="nbr_helper" data-pir_curr="<?php echo $paged; ?>" data-pir_max="<?php echo $my_query->max_num_pages; ?>">
                                  <div id="pages_static_nav" class="theme_button">
                                      <a href="#">
                                          <?php echo($prk_translations['load_more']); ?> 
                                      </a>
                                      <div class="clearfix"></div>
                                  </div>
                                  <div id="pir_loader_wrapper" class="cf">
                                      <div class="spinner"><div class="spinner-icon"></div></div>
                                  </div>
                                  <div class="nx_lnk_wp">
                                      <?php next_posts_link('',$my_query->max_num_pages); ?>
                                  </div>
                              </div>
                          </div>
                        </div><!-- navigation -->
                      </div><!-- entries_navigation --> 
                      <div class="clearfix"></div>
                      <div id="no_more" class="header_font">
                        <div class="simple_line blog_divider"></div>
                          <div id="in_no_more"><?php echo($prk_translations['no_more_text']); ?></div>
                          <div class="clearfix"></div>
                      </div>
                <?php
            }
        ?>
 </div>
    </div>
      <?php 
          if ($show_sidebar) 
          {
              ?>
              <aside id="sidebar" class="<?php echo SIDEBAR_CLASSES; ?>" role="complementary">
                  <?php get_sidebar(); ?>
              </aside><!-- /#sidebar -->
              <?php
          }
      ?>
      </div>
      </div>
      </div>
    </div>
</div>
     <?php
    }//CLASSIC
    ?>
     <?php
    if ($prk_samba_frontend_options['archives_type']=="masonry")
    {
        $iso_images_max_w=390;
        $iso_images_min_w=360;
        ?>
        <div id="centered_block">
       <div id="main_block" class="row<?php if ($show_sidebar==true) {echo " big_main_sided";} ?> ms_blog">
    <?php
        $extra_space="";
        if ($show_title==true)
        {
            prk_output_title($data);
            if ($show_sidebar==false)
                $extra_space=" prk_more_space";
        }
    ?>
  <div id="content">
        <div id="main" class="main_no_sections<?php echo $extra_space; ?>">
            <div class="twelve extra_pad columns centered">
                    <div  class="<?php if ($show_sidebar) {echo "twelve columns sidebarized";}else{echo "twelve wided";} ?>">
                    <?php 
                         $cat = get_term_by('name', single_cat_title('',false), 'category'); 
                        if (!($cat)!=1)
                            $cat_selector=$cat->slug;
                        else
                            $cat_selector="";
                        $tagname = get_query_var('tag');
                        //APPLY FILTERS FOR TAG IF NEEDED
                        if ($tagname!="")
                            $tag_selector=$tagname;
                        else
                            $tag_selector="";
                        $my_query = new WP_Query();
                        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                        $monthnum = (get_query_var('monthnum')) ? get_query_var('monthnum') : "";
                        $yearnum = (get_query_var('year')) ? get_query_var('year') : "";
                        if ($paged>1)
                        {
                            $excluder=get_option("sticky_posts");
                        }
                        else
                        {
                            $excluder="";
                        }
                        $args = array( 
                            'post_type'=>'post', 
                            'paged' => $paged,
                            'category_name'=>$cat_selector,
                            "post__not_in" =>$excluder,
                            'tag'=>$tagname,
                            'year'=>$yearnum,
                            'monthnum'=>$monthnum);
                        $my_query->query($args);
                        $post_counter=($paged-1)*$posts_per_page;
                            if ($my_query->have_posts()) : 
                            $ins=0;
                            if (isset ($data['alchemy_th_margin'])) 
                            {
                                $alchemy_th_margin=$data['alchemy_th_margin'];
                            }
                            else
                            {
                                $alchemy_th_margin=20;
                            }
                            ?>
                            <div id="blog_masonry_father">
                            <div id="blog_entries_masonr" data-max-width="<?php echo $iso_images_max_w; ?>" data-min-width="<?php echo $iso_images_min_w; ?>" data-margin="<?php echo $alchemy_th_margin; ?>" class="prk_section clearfix">
                                <?php
                                while ($my_query->have_posts()) : $my_query->the_post(); 
                                    $post_counter++;
                                    $data = get_post_meta( $post->ID, '_custom_meta', true );
                                    if (isset($data['featured_color']) && $data['featured_color']!="")
                                    {
                                        $featured_color=$data['featured_color'];
                                        $featured_class="featured_color ";
                                    }
                                    else
                                    {
                                        $featured_color="default";
                                        $featured_class="";
                                    }
                                    ?>
                                    <div id="post-<?php the_ID(); ?>" class="<?php echo $featured_class; ?>prk_bordered blog_entry_li cf<?php if ($post_counter == $my_query->post_count) echo " last_li"; ?>" data-type="<?php $category= get_the_category();
                                    foreach($category as $test) 
                                    { 
                                        echo $test->slug;echo " ";
                                    }  ?>" data-id="id-<?php echo $post_counter; ?>" data-color="<?php echo $featured_color; ?>">
                                        <?php 
                                            if (has_post_thumbnail( $post->ID ) ):
                                                //GET THE FEATURED IMAGE
                                                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), '' );
                                                $image[0] = get_image_path($image[0]);
                                                $p_photo_image=wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), '' );
                                                
                                            else :
                                                //THERE'S NO FEATURED IMAGE
                                            endif; 
                                            
                                            if (has_post_thumbnail( $post->ID ) )
                                            {
                                                 if (!isset($data['bl_icon'])) {
                                                    $data['bl_icon']='icon-link';
                                                  }
                                                ?>
                                                <a href="<?php the_permalink() ?>" class="fade_anchor" data-color="<?php echo $featured_color; ?>">
                                                    <div class="masonr_img_wp boxed_shadow">
                                                        <div class="blog_fader_grid">
                                                            <div class="navicon-plus titled_link_icon body_bk_color"></div>
                                                        </div>
                                                        <?php        
                                                            $vt_image = vt_resize( '', $image[0] , 680, 0, false , $retina_flag );//620 is for single row on small screens
                                                        ?>
                                                        <img src="<?php echo $vt_image['url']; ?>" width="<?php echo $vt_image['width']; ?>" height="<?php echo $vt_image['height']; ?>" id="home_fader-<?php the_ID(); ?>" class="custom-img grid_image" alt="" />
                                                    </div>
                                                </a>
                                                <?php
                                            }
                                            else
                                            {
                                                //CHECK IF THERE'S A VIDEO TO SHOW
                                                if (isset($data['image_2']) && substr($data['image_2'],0,6)!="http:/" && substr($data['image_2'],0,6)!="")
                                                {
                                                    $count=2;
                                                    $el_class='video-container boxed_shadow';
                                                    if (strpos($data['image_'.$count],'soundcloud.com') !== false) {
                                                        $el_class= 'soundcloud-container';
                                                    }
                                                    echo "<div class='".$el_class."'>";
                                                    echo $data['image_'.$count];
                                                    echo "</div>";
                                                }
                                                else
                                                {
                                                    ?>
                                                    <div class="blog_top_image eight_margin">&nbsp;</div> 
                                                    <?php
                                                }
                                            }
                                            ?>
                                        <div class="entry_title entry_title_single">
                                            <h4 class="masonr_title zero_color bd_headings_text_shadow">
                                                <a href="<?php the_permalink(); ?>" class="fade_anchor prk_break_word" data-color="<?php echo $featured_color; ?>">
                                                    <?php the_title(); ?>
                                                </a>
                                            </h4>
                                            <div class="clearfix"></div>
                                            </div>
                                            <div class="on_colored entry_content">
                                                <div class="masonr_text prk_break_word">
                                                    <?php echo the_excerpt_dynamic(30); ?></div>
                                                 <div class="clearfix"></div>
                                                <?php 
                                                    if (is_big_excerpt(30))
                                                    {
                                                        ?>
                                                        <div class="theme_button small four_margin_tp">
                                                        <a href="<?php the_permalink() ?>" class="fade_anchor" data-color="<?php echo $featured_color; ?>">
                                                                <?php echo($prk_samba_frontend_options['read_more']); ?> 
                                                        </a>
                                                        </div> 
                                                        <div class="clearfix"></div>
                                                        <?php
                                                    }
                                                ?>
                                                </div>
                                           
                                            <div class="simple_line zero_margin_bottom"></div>
                                            <div class="blog_masonry_lower header_font">
                                                <div class="single_blog_meta_div">
                                                    <div class="navicon-clock-2 left_floated not_zero_color"></div>
                                                    <div class="left_floated">
                                                        <?php echo the_time(get_option('date_format')); ?>
                                                    </div>
                                                </div>
                                                 <?php
                                                    if (is_sticky())
                                                    {
                                                        ?>
                                                        <div class="single_blog_meta_div right_floated">
                                                            <div class="left_floated default_color sticky_text">
                                                                <?php echo($prk_translations['sticky_text']); ?>
                                                            </div>
                                                            <div class="navicon-flag left_floated"></div>
                                                        </div>
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        if ($prk_samba_frontend_options['categoriesby_news']=="yes")
                                                        {
                                                          if (!isset($data['bl_icon'])) {
                                                            $data['bl_icon']='icon-link';
                                                          }
                                                            ?>
                                                            <div class="single_blog_meta_div right_floated">
                                                                <div class="left_floated default_color blog_categories">
                                                                    <?php the_category(', '); //CATS WITH LINKS ?>
                                                                </div>
                                                                <div class="<?php echo $data['bl_icon']; ?> titled_link_icon not_zero_color left_floated"></div>
                                                            </div>
                                                            <?php
                                                        }
                                                    }
                                                ?>
                                                <div class="clearfix"></div>
                                            </div>
                                            
                                        </div>
                                    <?php 
                                    $ins++;
                                endwhile;
                                ?>  
                    </div>
                <?php endif; 
                if ($paged!=$my_query->max_num_pages)
            {
                ?>
          <div id="entries_navigation_mason">
            <div class="simple_line blog_divider"></div>
                        <div class="navigation twelve"> 
                            <div class="next-posts">
                  <div id="nbr_helper" data-pir_curr="<?php echo $paged; ?>" data-pir_max="<?php echo $my_query->max_num_pages; ?>">
                      <div id="pages_static_nav" class="theme_button">
                          <a href="#ld_next">
                                  <?php echo($prk_translations['load_more']); ?> 
                          </a>
                          <div class="clearfix"></div>
                      </div>
                      <div id="pir_loader_wrapper" class="cf">
                          <div class="spinner"><div class="spinner-icon"></div></div>
                      </div>
                      <div class="nx_lnk_wp">
                          <?php next_posts_link('',$my_query->max_num_pages); ?>
                      </div>
                  </div>
              </div>
            </div><!-- navigation -->
                </div><!-- entries_navigation --> 
              <div id="no_more" class="header_font">
                <div class="simple_line blog_divider"></div>
                  <div id="in_no_more"><?php echo($prk_translations['no_more_text']); ?></div>
                  <div class="clearfix"></div>
              </div>
                <?php
            }
                ?>
  </div>
  </div>
        <?php 
            if ($show_sidebar) 
            {
                ?>
                <aside id="sidebar" class="<?php echo SIDEBAR_CLASSES; ?> inside right_floated" role="complementary">
                    <?php get_sidebar(); ?>
                </aside><!-- /#sidebar -->
                <?php
            }
        ?>
        <div class="clearfix"></div>
        </div>
        </div>
      </div>
    </div>
</div>
     <?php
    }//MASNORY
    ?>
<?php get_footer(); ?>