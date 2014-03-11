<?php
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
//
//// ULTRASHARP THEME — INCLUDES/BACKEND/PHP/AJAX-SEARCH.PHP
//
//// RETURNS OUR AJAX SEARCH
//
//// REQUIRED FOR VERSION: 1.0
//
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////

	//sleep(1);

	//// IGNORE NON POST REQUESTS
	if(!$_POST) { exit('Nothing to see here. Please go back.'); }
	
	//// LOADS OUR WP-LOAD
	include('../../../../../../wp-load.php');
	
	//// OUR ERROR VARIABLE IS CURRENT EMPTY
	$return['error'] = false;
	$searchString = $_POST['postSearchString'];
	
	
	////////////////////////////////////////////////////////////
	//// NOW WE"RE GONNA START LOOPING STUFF
	////////////////////////////////////////////////////////////
	
	//// MAKES SURE TO START OUR OUTPUT TO RETURN LATER
	$output = '';
	$resultsCount = 0;
	
	
	////////////////////////////////////////////////////////////
	//// LET'S START WITH OUR PAGES	
	
	//// IF USER HAS ENABLED IF
	if(ddp('top_bar_search_ajax_pages') == 'on') {
	
		$args = array(
		
			'post_type' => 'page',
			'posts_per_page' => ddp('top_bar_search_ajax_pages_count'),
			's' => $searchString,
		
		);
		
		//// WP QUERY OBJECT
		$searchPagesQuery = new WP_Query($args);
		
		//// LOOPS OUR FOUND PAGES
		if($searchPagesQuery->have_posts()) {
			
			//// INCREASES COUNT
			$resultsCount++;
		
			////LET'S START OUR OUTPUT
			$output .= '<div class="search-results search-results-pages"><ul>';
			
			$pageI = 1;
			while($searchPagesQuery->have_posts()) { $searchPagesQuery->the_post();
			
				/// STARTS OUR PAGE LI'S
				if($pageI % 2 == 0) {
					
					$output .= '<li class="altbg"><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
					
				} else {
					
					$output .= '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
				
				}
				
				$pageI++;
		
			}
			
			//// CLOSES OUR PAGES SECTION
			$output .= '</ul></div>';
		
		}
	
	}
	
	
	////////////////////////////////////////////////////////////
	//// LET'S START WITH OUR POSTS
	
	//// IF USER HAS ENABLED IF
	if(ddp('top_bar_search_ajax_posts') == 'on') {
		
		$args = array(
		
			'post_type' => 'post',
			'posts_per_page' => ddp('top_bar_search_ajax_posts_count'),
			's' => $searchString,
		
		);
		
		//// WP QUERY OBJECT
		$searchPostsQuery = new WP_Query($args);
		
		//// LOOPS OUR FOUND PAGES
		if($searchPostsQuery->have_posts()) {
			
			//// INCREASES COUNT
			$resultsCount++;
		
			////LET'S START OUR OUTPUT
			$output .= '<div class="search-results search-results-posts"><span class="search-section-header">'.ddp('top_bar_search_ajax_posts_title').'</span><ul>';
			
			while($searchPostsQuery->have_posts()) { $searchPostsQuery->the_post();
			
				/// STARTS OUR PAGE LI'S
				$post_image = ddGetFeaturedImage(get_the_ID());
				$output .= '<li><a href="'.get_permalink().'">
								
									<div class="search-post-image"><img src="'.ddTimthumb($post_image[0], 35, 35).'" alt="'.get_the_title().'" /></div>
									
									<div class="search-post-content"><span class="title">'.substr(get_the_title(), 0, 18).'...</span><span class="info">'.get_the_time(get_option('date_format')).' -  '.get_comments_number(get_the_ID()).' '.__('Comment', 'ultrasharp');
									
									if(get_comments_number(get_the_ID()) != 1) { $output .= 's'; }
									
									$output .= '</span></div>
									
									<div class="clear"></div>
									<!-- /clear/ -->
								
							</a></li>';
		
			}
			
			//// CLOSES OUR PAGES SECTION
			$output .= '</ul></div>';
		
		}
	
	}
	
	
	////////////////////////////////////////////////////////////
	//// LET'S START WITH OUR PORTFOLIO POSTS
	
	//// IF USER HAS ENABLED IF
	if(ddp('top_bar_search_ajax_portfolio') == 'on') {
		
		$args = array(
		
			'post_type' => 'portfolio_posts',
			'posts_per_page' => ddp('top_bar_search_ajax_portfolio_count'),
			's' => $searchString,
		
		);
		
		//// WP QUERY OBJECT
		$searchPortfolioQuery = new WP_Query($args);
		
		//// LOOPS OUR FOUND PAGES
		if($searchPortfolioQuery->have_posts()) {
			
			//// INCREASES COUNT
			$resultsCount++;
		
			////LET'S START OUR OUTPUT
			$output .= '<div class="search-results search-results-portfolio"><span class="search-section-header">'.ddp('top_bar_search_ajax_portfolio_title').'</span><ul>';
			
			$iPort = 1;
			while($searchPortfolioQuery->have_posts()) { $searchPortfolioQuery->the_post();
			
				/// STARTS OUR PAGE LI'S
				$post_image = ddGetFeaturedImage(get_the_ID());
				if($iPort%3==0) { $output .= '<li class="last"><a href="'.get_permalink().'"><img src="'.ddTimthumb($post_image[0], 45, 45).'" alt="'.get_the_title().'" /></a></li>'; }
				else { $output .= '<li><a href="'.get_permalink().'"><img src="'.ddTimthumb($post_image[0], 45, 45).'" alt="'.get_the_title().'" /></a></li>'; }
		
			}
			
			//// CLOSES OUR PAGES SECTION
			$output .= '</ul></div>';
		
		}
		
	}
	
	$return['output'] = $output;
	$return['count'] = $resultsCount;
	
	//// RETURNS THE FORM
	echo json_encode($return);
	

?>