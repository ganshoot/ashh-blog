<?php 
  get_header(); 
  $show_sidebar=$prk_samba_frontend_options['right_sidebar'];
  if ($show_sidebar=="yes")
    $show_sidebar=true;
  else
    $show_sidebar=false;
  $data = get_post_meta( $post->ID, '_custom_meta_reg-page_template', true );
  if (!empty($data))
  {
      if (isset($data['alchemy_show_sidebar']) && $data['alchemy_show_sidebar']=="yes") {
        $show_sidebar=true;
      }
    if (isset($data['alchemy_show_sidebar']) && $data['alchemy_show_sidebar']=="no") {
      $show_sidebar=false;
    }
  }
?>
<div id="centered_block" class="prk_inner_block columns centered main_no_sections">
<div id="main_block" class="row page-<?php echo get_the_ID(); ?>">
    <?php
        prk_output_title($data);
    ?>
    <div id="content">
        <div id="main" role="main" class="main_no_sections prk_normal_page">
          <?php
            if ($show_sidebar)
            {
              echo '<div class="twelve columns sidebarized">';
            }
            else
            {
              echo '<div class="twelve columns unsidebarized">';
            }
            echo '<div class="prk_no_composer">';
            while (have_posts()) : the_post(); ?>
              <?php the_content(); ?>     
          <?php endwhile; /* End loop */ ?>
           <div class="clearfix"></div>
            </div>
            </div>
            <?php 
              if ($show_sidebar) 
              {
                  ?>
                <aside id="sidebar" class="<?php echo SIDEBAR_CLASSES; ?> inside right_floated zero_right" role="complementary">
                    <?php get_sidebar(); ?>
                </aside>
                <?php
              }
              else
              {
                echo '<div class="clearfix"></div>';
              }
            ?>
          </div>
          <div class="clearfix"></div>
        </div>
    </div>
</div>
<?php get_footer(); ?>