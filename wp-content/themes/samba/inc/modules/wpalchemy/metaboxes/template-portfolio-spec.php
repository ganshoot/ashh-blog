<?php

$custom_metabox_temp_port = $simple_mb_temp_port = new WPAlchemy_MetaBox(array
(
	'id' => '_custom_meta_portfolio_template',
	'title' => 'Samba Portfolio Template Custom Options',
	'template' => get_template_directory() . '/inc/modules/wpalchemy/metaboxes/template-portfolio-meta.php',
	'include_template' => array('template_portfolio.php','template_portfolio_gallery.php','template_portfolio_masonry.php','template_portfolio_titled.php','template_portfolio_var-grid.php') // use an array for multiple items
));
/* eof */