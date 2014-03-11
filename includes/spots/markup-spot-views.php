<?php 

	//// LETS FIRST GET ALL THE SPOTS BY THIS USER
	$args = array(
	
		'post_type' => 'spot',
		'posts_per_page' => -1,
		'author' => $current_user->ID,
		'post_status' => array('publish'),
	
	);
	
	$tQ2 = new WP_Query($args);
	
	if($tQ2->have_posts()) :
	
	 ?><h3><?php _e('Recent Page Views:', 'btoa'); ?></h3>

<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="<?php echo get_template_directory_uri() ?>/js/excanvas.min.js"></script><![endif]-->

<?php

	$spots_array = array();

	//// LETS GO THROUGH OUR POSTS AND SET UP THE GRAPH DATA
	while($tQ2->have_posts()) { $tQ2->the_post();
		
		///// LETS GET OUR PAGE VIEWS
		$page_views = get_post_meta(get_the_ID(), '_sf_view_count_today', true);
		$today = mktime(0, 0, 0, date('n', time()), date('j', time()), date('Y', time()));
		
		//// CREATES THIS SPOTS ARRAY
		$spots_array[get_the_id()] = array();
		
		//// LETS GET ALL PAGE VIEWS FOR THE PAST 7 DAYS
		for($i = 7; $i > 0; $i--) {
			
			//// LETS ADD THIS DAY AND VALUE TO THE ARRAY - MAKES SURE WE DISPLAY TODAY AS WELL
			$this_day = ($today + 86400) - (86400 * $i);
			
			///// ADDS THE AMOUNT OF VIEW FOR THIS DAY
			if(isset($page_views[$this_day])) { $views = count($page_views[$this_day]); }
			else { $views = 0; }
			
			//// ADDS TODAY TO THE ARRAY
			$spots_array[get_the_id()][] = array(
			
				'day' => ($this_day*1000),
				'views' => $views,
				//'views' => rand(0, 100),
			
			);
			
		}
		
	} wp_reset_postdata();

?>

<script type="text/javascript">

	jQuery(document).ready(function() {
		
		///// LETS CREATE OUR DATA ARRAY
		var datasets = {
			
			<?php foreach($spots_array as $post_id => $day) : ?>
			
				'<?php echo get_the_title($post_id); ?>': {
			
					label: '<?php echo get_the_title($post_id); ?>',
					data: [
					
					<?php foreach($day as $_day) : ?>
					
						[<?php echo $_day['day'] ?>, <?php echo $_day['views'] ?>], 
					
					<?php endforeach; ?>
				
				]},
			
			<?php endforeach; ?>
		
		}; //// ENDS OUR DATA
			
		data = [];
		dataLabels = {};
		
		jQuery.each(datasets, function(key, obj) {
			
			dataLabels[key] = obj;
			
		});
		
		jQuery.each(datasets, function(i, obj) {
			
			data.push(obj);
			
		});

		var stack = 0,
			bars = false,
			lines = true,
			steps = false;
		
		
		//// OUROPTION
		jQuery('#page-views').generatePlot(data);
		
		
		//// BINDS OUR HOVER
		bindPlot();
		
		//// IF THE USER CLICKS A LABEL
		jQuery('#page-view-labels li').click(function() {
			
			//// IF WE HAVE CLICKED TOGGLE ALL
			if(jQuery(this).attr('title') == '_sf_toggle_all') {
				
				var size = 0;
				jQuery.each(dataLabels, function() { size++; });
				
				var totals = jQuery('#page-view-labels li').length - 1;
				
				//// IF THE ARRAY IS EMPTY
				if(size < totals) {
					
					//// TOGGLE ALL ON
					jQuery.each(datasets, function(key, obj) {
						
						dataLabels[key] = obj;
						
					});
					
					
				} else {
					
					//// TOGGLE ALL OFF
					dataLabels = {}
					
				}
				
			} else {
			
				//// LETS GET THE CLICKED LABEL
				var clicked_label = jQuery(this).text();
				
				//// IF THIS IS NOT IN OUR DATA LABEL
				if(clicked_label in dataLabels) { delete dataLabels[clicked_label]; }
				else { dataLabels[clicked_label] = true; }
				
			}
				
			data = [];
			
			//// GENERATES OUR DATA ARRAY
			jQuery.each(datasets, function(key, obj) {
				
				//// GETS THE COLOR
				var labelItem = jQuery('#page-view-labels ul li[title="'+key+'"]');
				var _color = labelItem.find('input[name="color"]').val();
				
				//// IF THIS DATA SET IS IN THE OBJECT
				if(key in dataLabels) {
					
					/// SETS COLOR
					obj['color'] = _color;
					
					data.push(obj);
					
				}
				
			});
			
			//// GOES THROUGH OUR LABELS AND SEE WHICH ONES ARE SET
			jQuery('#page-view-labels ul li').each(function() {
				
				var _label = jQuery(this).find('span span').text();
				
				//// IF ITS IN OUR DATA LABELS
				if(_label in dataLabels) { jQuery(this).css({ opacity: 1 }); }
				else { jQuery(this).css({ opacity: .5 }); }
				
			});
			
			jQuery('#page-view-labels ul li[title="_sf_toggle_all"]').css({ opacity: 1 });
			
			//// REDRAWS THE GRAPH
			jQuery('#page-views').generatePlot(data);
			
			//// UNBINDS HOVER
			jQuery("#page-views").unbind("plothover");
			
			//// BINDS IT AGAIN
			bindPlot();
			
		});
		
		//// WHEN WE START RESIZING
		jQuery(window).resize(function() {
			
			if(typeof redrawInt != 'undefined') { clearTimeout(redrawInt); }
			
			jQuery('#page-views').css({ opacity: 0 });
			
			//// START OUR INTERVAL SO WE CAN REDRAW IT
			redrawInt = setTimeout(function() {
				
				jQuery('#page-views').generatePlot(data);
				
				jQuery('#page-views').css({ opacity: 1 });
				
			}, 100);
			
		});
		
	});
	
	function bindPlot() {
		
		jQuery("#page-views").bind("plothover", function (event, pos, item) {
			
			//// IF WE ARE HOVERING A POINT
			if(item) {
				
				var dataIndex = item.dataIndex;
				var spot_name = item.series.label;
				var thisData = '';
				
				jQuery.each(item.series.data, function(i, obj) {
					
					//// IF ITS WHAT WERE LOOKING FOR
					if(dataIndex == i) { thisData = obj; return false; }
					
				});
				
				var theDay = new Date(thisData[0]);
				
				//// TITLE
				var markup = '<span><big>'+spot_name+'</big></span>';
				
				//// PAge Views
				markup += '<span><strong><?php _e('Unique Views', 'btoa'); ?>:</strong> '+thisData[1]+'</span>';
				
				//// DATE
				//markup += '<span><strong><?php _e('Date', 'btoa'); ?>:</strong> '+theDay.getDate()+'/'+theDay.getMonth()+'</span>';
				
				//// ADDS OUR TOOLTIP
				if(jQuery('#spot-views-tooltip').length == 0) {
					jQuery('body').append('<div id="spot-views-tooltip"><div><span class="arrow"></span><span class="content"></span></div></div>');				
				}
				
				var tCont = jQuery('#spot-views-tooltip');
				
				//// SETS OFFSET
				var tX = item.pageX;
				var tY = item.pageY;
				tCont.css({ left: tX+'px', top: tY+'px' });
				
				//// APPENDS THE NEW MARKUP
				jQuery('#spot-views-tooltip .content').html(markup);
				
				jQuery('#spot-views-tooltip').show();
				
			} else {
				
				jQuery('#spot-views-tooltip').hide();
				
			}
			
		});
		
	}

</script>

<div id="page-view-labels"><ul><li title="_sf_toggle_all"><strong><?php _e('Toggle All', 'btoa'); ?></strong></li></ul><div class="clear"></div></div>
<!-- #page-views-labels -->

<div id="page-views"></div>
<!-- #page-views -->


<div class="clear"></div>
                    <div class="divider-top" style="margin: 0px 0 60px;"></div>
<div class="clear"></div>

<?php endif; ?>