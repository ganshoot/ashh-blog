<?php
	global $prk_samba_frontend_options;
	global $prk_translations;
	//OVERRIDE OPTIONS - ONLY FOR PREVIEW MODE
	if (INJECT_STYLE)
	{
		include_once(ABSPATH . 'wp-content/plugins/color-manager-samba/style_header.php');	
	}
?>
<?php function samba_comment($comment, $args, $depth) {
	global $prk_samba_frontend_options;
	global $prk_translations;
  	$GLOBALS['comment'] = $comment; ?>
  <li <?php comment_class(); ?>>
    <article id="comment-<?php comment_ID(); ?>" class="cf single_comment">
      <header class="comment-author vcard">
        <?php echo get_avatar($comment, $size = '44'); ?>
      </header>
      <div class="comment_floated colored_bg">
      	<div class="prk_inner_tip"></div>
      	<div class="comments_meta_wrapper">
        <?php printf(__('<div class="fn author_name left_floated zero_color">%s</div>', 'samba_lang'), get_comment_author_link()); ?>
	        <span class="pir_divider_cmts left_floated zero_color">|</span>
	        <time datetime="<?php echo comment_date('c'); ?>" class="comment_date left_floated zero_color">
					<?php 
						echo get_comment_date(); 
						echo " @ ";
						echo get_comment_time(); 
	                ?>
	       	</time>
        </div>
        <div class="theme_button_inverted small right_floated comments_special_button">
      		<?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => $prk_translations['reply_text']))); ?>
		</div>
        
        
      <?php if ($comment->comment_approved == '0') { ?>
        <div class="alert alert-block fade in">
          <a class="close" data-dismiss="alert">&times;</a>
          <p><?php _e('Your comment is awaiting moderation.', 'samba_lang'); ?></p>
        </div>
      <?php } ?>
      <section class="comment comment_text left_floated">
        <?php comment_text() ?>
      </section>
      <div class="clearfix"></div>
		</div>
    </article>
<?php } ?>

<?php if (post_password_required()) { ?>
  <div id="comments">
    <div class="alert alert-block fade in">
      <a class="close" data-dismiss="alert">&times;</a>
      <p><?php _e('This post is password protected. Enter the password to view comments.', 'samba_lang'); ?></p>
    </div>
  </div><!-- /#comments -->
<?php
  return;
} ?>

<?php if (have_comments() && comments_open()) { ?>
  <div id="comments">
    	<div>
    		<div class="prk_titlify_father">
	    		<h3 class="small header_font bd_headings_text_shadow zero_color">
	                <?php printf(_n(($prk_translations['comments_one_response']), '%1$s '.($prk_translations['comments_oneplus_response']), get_comments_number()), number_format_i18n(get_comments_number())); ?>
	        	</h3>
        	</div>
        </div>
    <ol class="commentlist">
      <?php wp_list_comments(array('callback' => 'samba_comment')); ?>
    </ol>

    <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) { // are there comments to navigate through ?>
      <nav id="comments-nav" class="pager">
        <div class="previous"><?php previous_comments_link(__('&larr; Older comments', 'samba_lang')); ?></div>
        <div class="next"><?php next_comments_link(__('Newer comments &rarr;', 'samba_lang')); ?></div>
      </nav>

    <?php } // check for comment navigation ?>

  </div><!-- /#comments -->
  <div class="clearfix"></div>
<?php } ?>

<?php 
	if (0) 
	{
		comment_form();
	}
	if (comments_open()) { 
	?>
  		<section id="respond">
        	<div class="prk_titlify_father">
	    		<h3 class="small header_font bd_headings_text_shadow zero_color">
                    <?php comment_form_title(($prk_translations['comments_leave_reply']), ($prk_translations['comments_leave_reply'].' to %s')); ?>
            	</h3>
            </div>
            <p class="cancel-comment-reply not_zero_color"><?php cancel_comment_reply_link(('Click here to cancel reply')); ?></p>
            <?php 
				if (get_option('comment_registration') && !is_user_logged_in()) 
				{ 
					?>
              		<p><?php printf(('You must be <a href="%s">logged in</a> to post a comment.'), wp_login_url(get_permalink())); ?></p>
            		<?php 
				} 
				else 
				{ 
					?>
              		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform" name="comment_form">
						<?php 
							if (is_user_logged_in()) 
							{ 
								?>
								<p><?php printf(('Logged in as <a href="%s/wp-admin/profile.php" class="not_zero_color">%s</a>.'), get_option('siteurl'), $user_identity); ?> 
									<a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php ('Log out of this account'); ?>" class="not_zero_color">
										<?php _e('Log out &raquo;', 'samba_lang'); ?>
									</a>
								</p>
								<?php 
							} 
							else 
							{ 
								?>
                                <div class="row">
                                <div class="four columns">
                                    <input type="text" class="text pirenko_highlighted" name="author" id="author" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> 
                                    placeholder="<?php echo($prk_translations['comments_author_text']); if ($req) echo($prk_translations['required_text']); ?>" />
							  	</div>
                                <div class="four columns">
                                    <input type="email" class="text pirenko_highlighted" name="email" id="email" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> 
                                    placeholder="<?php echo($prk_translations['comments_email_text']); if ($req) echo($prk_translations['required_text']); ?>" />		
                                </div>
                                
                                <div class="four columns">
                                    <input type="url" class="text pirenko_highlighted" name="url" id="url" size="22" tabindex="3" 
                                    placeholder="<?php echo($prk_translations['comments_url_text']); ?>" />
                                </div>
                                </div>
								<?php 
							} 
						?>
                        <textarea name="comment" id="comment" class="input-xlarge pirenko_highlighted" tabindex="4"
                        placeholder="<?php echo($prk_translations['comments_comment_text']); ?>"></textarea>
                        <div id="comment_form_messages" class="cf zero_color special_italic"><p class="comment_error"><?php echo($prk_translations['contact_error_email_text']); ?></p></div>
                        <div class="clearfix"> </div>
                        <div id="submit_comment_div" class='theme_button'>
                        	<a href="#"><?php echo($prk_translations['comments_submit']); ?></a>
                      	</div>
                        <div class="clearfix"></div>
                        <?php comment_id_fields(); ?>
                        <?php do_action('comment_form', $post->ID); ?>
              		</form>
            		<?php 
				} 
			?>
  		</section><!-- /#respond -->
        <div class="clearfix"></div>
		<?php 
	} 
?>
<script type="text/javascript">
jQuery(document).ready(function()
{
	var wordpress_directory = '<?php echo get_option('siteurl'); ?>';
	var empty_text_error = '<?php echo($prk_translations['empty_text_error']); ?>';
	var invalid_email_error = '<?php echo($prk_translations['invalid_email_error']); ?>';
	var wait_message = '<?php echo($prk_translations['contact_wait_text']); ?>';
	var comment_ok_message = '<?php echo($prk_translations['comment_ok_message']); ?>';
	var already_submitted_comment=false;
	jQuery('#commentform textarea, #author, #email').focus(function () 
	{
		jQuery("#comment_form_messages").hide("slow");
	});
	jQuery('#submit_comment_div a').click(function(e) 
	{
		empty_error = '<p class="comment_error">' + empty_text_error + '</p>';
        email_error = '<p class="comment_error">' + invalid_email_error + '</p>';
		e.preventDefault();
		error = false;
        emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;	
		if (already_submitted_comment==false)
		{
			jQuery("#comment_form_messages .comment_error").remove();
			//DATA VALIDATION
			jQuery('#commentform textarea, #author, #email').each(function()
			{
				
				value = jQuery(this).val();
				theID = jQuery(this).attr('id');
			
				if(value == '' && error==false)
				{
					jQuery('#comment_form_messages').html('');
					jQuery('#comment_form_messages').append(empty_error);
					error = true;
				}
				if(theID == 'email' && value != '' && !emailReg.test(value) && error==false)
				{
					jQuery('#comment_form_messages').html('');
					jQuery('#comment_form_messages').append('<p class="comment_error">'+email_error+'</p>');
					error = true;
				}
				
			});
			//SEND COMMENT IF THERE ARE NO ERRORS
			if(error == false)
			{
				jQuery('#comment_form_messages').html('');
				jQuery('#comment_form_messages').append('<p class="comment_error">'+wait_message+'</p>');
				jQuery("#comment_form_messages").css({'display':'inline-block'});
				//POST COMMENT
				jQuery.ajax({  
				type: "POST",  
				url: wordpress_directory+"/wp-comments-post.php",  
				data: jQuery("#commentform").serialize(),  
				success: function(resp)
				{
					jQuery('#comment_form_messages').html('');
					jQuery('#comment_form_messages').append('<p class="comment_error">'+comment_ok_message+'</p>');
					jQuery("#comment_form_messages").css({'display':'inline-block'});
					already_submitted_comment=true;
				},  
				error: function(e)
				{  
					jQuery('#comment_form_messages').html('');
					jQuery('#comment_form_messages').append('<p class="comment_error">Comment error. Please try again!</p>');
					jQuery("#comment_form_messages").css({'display':'inline-block'});
				}
				});
			}
			else
			{
				jQuery("#comment_form_messages").css({'display':'inline-block'});
				
			}
		}
		else
		{
				
		}
	});
});
	
</script>