<?php

	//// CLASS FOR OUR TOOLTIPS
	class SF_Tooltip {
		
		public $steps = array();
		
		//// CONSTRUCTS OUR CLASS
		public function __construct() {
			
			//// STARTS BY ADDING A NEW OBJECT THAT'S OUR FIELDS
			if(isset($steps)) { $this->steps = $steps; }
			
		}
		
		//// METHOD FOR ADDING A NEW STEP INTO OUR STEPS ARRAY
		public function add_step($field_id, $step_title, $step_description, $container = null, $align = null) {
			
			/// ADDS IT INTO OUR ARRAY
			$_step = new stdClass;
			$_step->field_id = $field_id;
			$_step->step_title = $step_title;
			$_step->step_description = $step_description;
			$_step->container = $container;
			$_step->align = $align;
			
			$this->steps[] = $_step;
			
		}
		
		public function generate_steps($cookie = '_sf_tooltips') {
			
			//echo '<pre>'; print_r($this->steps); exit;
			
			//// LETS START BY SETTING OUR JAVASCRIPT VARIABLES ?>
            
            
            <script type="text/javascript">
			
				jQuery(document).ready(function() {
					
					/// OUR TOOLTIP ARRAY
					_sf_tooltips = new Array();
					
					<?php foreach($this->steps as $_step) :
					
						  if($_step->container == NULL) { $container = $_step->field_id; }
						  else { $container = $_step->container; }
						  
						  if($_step->align == NULL) { $align = 'left'; }
						  else { $align = $_step->align; }
					?>
					
						var _step_<?php echo $_step->field_id ?> = {
							
							title:				<?php echo json_encode($_step->step_title); ?>,
							description:		<?php echo json_encode($_step->step_description); ?>,
							container:			<?php echo json_encode($container); ?>,
							align:				<?php echo json_encode($align); ?>,
							
						}
						
						_sf_tooltips.push(_step_<?php echo $_step->field_id ?>);
					
					<?php endforeach; ?>
					
					//// CALLS OUR FUNCTION TO DISPLAY THE TOOLTIPS
					jQuery('body')._sf_tooltips(_sf_tooltips, <?php echo json_encode(__('Next', 'btoa')) ?>, <?php echo json_encode(__('Skip Intro', 'btoa')) ?>, <?php echo json_encode(__('Previous', 'btoa')) ?>, '<?php echo $cookie ?>');
					
				});
			
			</script>
          
			
		<?php }
		
	}

?>