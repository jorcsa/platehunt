<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
	
    <!-- HEAD BEGINS -->
    <head>
    	
        <!-- CHARSET -->
		<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>" />
        <meta name="viewport" content="width=device-width, user-scalable=no" />
        
        <?php if(ddp('favicon') != '') : ?><link rel="icon" type="image/png" href="<?php echo ddp('favicon'); ?>"><?php endif; ?>
    	
        <!-- PAGE TITLE -->
    	<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'btoa' ), max( $paged, $page ) );

	?></title>
        
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
        
        <!-- WP_HEAD STARTS -->
        <?php
		
			//// OUR WP HEADER — SCRIPTS AND JS FILES IN HERE
			wp_head();
			
		?>
    
    </head>
    <!-- HEAD ENDS -->
	
	<?php
	
		//// RESOLVES RTL
		$body_class = '';
		if(ddp('spotfinder_rtl') == 'on') { $body_class = 'rtl'; }
	
	?>
    
	<body <?php body_class($body_class); ?>>
        
    
        <?php
        
            //////////////////////////////////////////////////////
            //// THIS IS OUR MAIN HEADER - LOGO 
            //////////////////////////////////////////////////////
            
                get_template_part('includes/header/header', 'mobile');
            
            //////////////////////////////////////////////////////
        
        ?>
        
    
        <?php
        
            //////////////////////////////////////////////////////
            //// THIS IS OUR MAIN HEADER - LOGO 
            //////////////////////////////////////////////////////
            
                get_template_part('includes/header/header');
            
            //////////////////////////////////////////////////////
        
        ?>
    