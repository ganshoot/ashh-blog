<?php
	//EDIT THE THEME NAME HERE IF NEEDED
	define('PRK_THEME_NAME', 'Samba');
	//NO MORE EDITING PLEASE
	// returns WordPress subdirectory if applicable
		function wp_base_dir() {
		  preg_match('!(https?://[^/|"]+)([^"]+)?!', site_url(), $matches);
		  if (count($matches) === 3) {
			return end($matches);
		  } else {
			return '';
		  }
		}
		
		// opposite of built in WP functions for trailing slashes
		function leadingslashit($string) {
		  return '/' . unleadingslashit($string);
		}
		
		function unleadingslashit($string) {
		  return ltrim($string, '/');
		}
		
		function add_filters($tags, $function) {
		  foreach($tags as $tag) {
			add_filter($tag, $function);
		  }
		}
	
	// Set the content width based on the theme's design and stylesheet
	if (!isset($content_width)) { $content_width = 1920; }
	
	define('POST_EXCERPT_LENGTH',       40);
	define('SIDEBAR_CLASSES',           'columns');	
	define('WP_BASE',                   wp_base_dir());
	define('THEME_NAME',                wp_get_theme());
	define('RELATIVE_PLUGIN_PATH',      str_replace(site_url() . '/', '', plugins_url()));
	define('FULL_RELATIVE_PLUGIN_PATH', WP_BASE . '/' . RELATIVE_PLUGIN_PATH);
	define('RELATIVE_CONTENT_PATH',     str_replace(site_url() . '/', '', content_url()));
	define('THEME_PATH',                RELATIVE_CONTENT_PATH . '/themes/' . THEME_NAME);
	define('PRK_BACKEND_THEME_NAME',		'samba');
	
	$remote_version_url=ABSPATH . 'wp-content/plugins/color-manager-samba/style_header.php';
	define('INJECT_STYLE',				@fopen($remote_version_url, "r"));

	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if (is_plugin_active('samba_framework/samba_framework.php')) 
	{
    	define('PRK_SAMBA_ON',"true");
    }
    else
    {
    	define('PRK_SAMBA_ON',"false");
	}
    if (is_plugin_active('woocommerce/woocommerce.php')) 
    {
    	define('PRK_WOO',"true");
    }
    else
    {
    	define('PRK_WOO',"false");
	}
	if (is_plugin_active('js_composer-samba/js_composer-samba.php')) 
	{
    	define('PRK_COMPOSER',"true");
    }
    else
    {
    	define('PRK_COMPOSER',"false");
	}
	if (is_plugin_active('revslider/revslider.php')) 
	{
    	define('PRK_RVSLIDER',"true");
    }
    else
    {
    	define('PRK_RVSLIDER',"false");
	}
