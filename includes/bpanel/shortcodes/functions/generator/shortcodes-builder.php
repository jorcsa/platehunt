

<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/includes/bpanel/shortcodes/css/generator.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/icons.css" media="screen" />
<script src="<?php echo get_template_directory_uri(); ?>/includes/bpanel/shortcodes/js/generator.js" type="text/javascript" charset="utf-8"></script>


<div class="shortcode-builder-wrapper">

    <div class="shortcode-section">
    
        <div class="shortcode-label">Type:</div>
        <!-- /.shortcode-label/ -->
    
        <div class="shortcode-field">
        
        	<select id="shortcode-type" class="widefat" onChange="jQuery(this).bPanelShortcodeType();">
            
            	<option>Select a Type</option>
            	<?php $i = 1; foreach($shortcodes as $type) {
					
					echo '<option value="shortcode-section-'.$i.'">'.$type['title'].'</option>';
					
				$i++; }?>
            
            </select>
            
        </div>
        <!-- /.shortcode-label/ -->
    
    </div>
    <!-- /shortcode-section/ -->
    
    
    
    <?php
	
		//// OUR SHORTCODES DEPENDING ON TYPE
		$i = 1;
		foreach($shortcodes as $type) :
	
	?>
        <div class="shortcode-section shortcode-shortcode" id="shortcode-section-<?php echo $i; ?>">
        <div class="shortcode-section-wrapper">
        
            <div class="shortcode-label">Shortcode:</div>
            <!-- /.shortcode-label/ -->
        
            <div class="shortcode-field">
            
                <select id="shortcode-shortcode" class="widefat" onChange="jQuery(this).bPanelShortcodeShortcode();">
                
                    <option>Select a Shortcode</option>
                    <?php $iShort = 1;foreach($type['shortcodes'] as $shortcode) : ?>
                    
                    
                    	<option value="shortcode-section-<?php echo $i; ?>-<?php echo $iShort; ?>"><?php echo $shortcode['title']; ?></option>
                    
                    
                    <?php $iShort++; endforeach; ?>
                
                </select>
                
            </div>
            <!-- /.shortcode-label/ -->
        
        </div>
        </div>
        <!-- /shortcode-section/ -->
        
	<?php $i++; endforeach; ?>
    
    
    
    <?php
	
		//// OUR SPECIFIC SHORTCODE
		$i = 1;
		foreach($shortcodes as $type) :
		
		$iShort = 1;
		foreach($type['shortcodes'] as $shortcode) :
	
	?>
        <div class="shortcode-section shortcode-shortcode-specific shortcodename-<?php echo $shortcode['name']; ?> shortcodetype-<?php echo $shortcode['type']; ?>" id="shortcode-section-<?php echo $i; ?>-<?php echo $iShort; ?>">
        
            <div class="shortcode-label">Fields:</div>
            <!-- /.shortcode-label/ -->
        
            <div class="shortcode-fields">
            
            	<?php
				
					//// LETS LOOP OUR FIELDS
					foreach($shortcode['fields'] as $field) :
				
				?>
            
            	<?php
				
					////////////////////////////////////////
					// TEXT FIEL
					if($field['type'] == 'text') :
				
				?>
                
                    <div class="shortcode-fields-field shortcode-field-text">
                    
                        <div class="shortcode-field-title"><?php echo $field['title']; ?></div>
                        
                        <div class="shortcode-field-input"><input type="text" value="" class="widefat" /></div>
                        
                        <div class="shortcode-field-desc"><?php echo $field['desc']; ?></div>
                        <span class="hidden shortcode-name"><?php echo $field['name']; ?></span>
                        <?php if(isset($field['image'])) : if($field['image']) { echo '<span class="hidden shortcode-image">true</span>'; } endif; ?>
                        
                    <div class="clear"></div>
                    </div>
                    <!-- /shortcode-field-text/ -->
                    
                <?php
				
					////////////////////////////////////////
					// SELECT FIELD
					elseif($field['type'] == 'icons') :
				
				?>
                
                    <div class="shortcode-fields-field shortcode-field-icons">
                    
                        <div class="shortcode-field-title"><?php echo $field['title']; ?></div>
                        
                        <input type="hidden" value="" class="widefat" />
                        
                        <script type="text/javascript">
						
						jQuery(document).ready(function() {
						
							jQuery('.theicons li').click(function() {
								
								jQuery(this).siblings('.selected').removeClass('selected');
								
								var selectedItem = jQuery(this).children('i').attr('class').replace('icon-', '');
								jQuery(this).addClass('selected').parent().parent().siblings('input').val(selectedItem);
								
							});
							
						});
						
						</script>
                        
                        <div class="shortcode-field-input" style="float: none; width: 100%;"><ul class="theicons">
                        
                        	<?php foreach($field['options'] as $opt) : ?>
                        
                        	<li><i class="icon-<?php echo $opt; ?>"></i></li>
                            
                            <?php endforeach; ?>
                        
                        </ul></div>
                        <span class="hidden shortcode-name"><?php echo $field['name']; ?></span>
                        
                    <div class="clear"></div>
                    </div>
                    <!-- /shortcode-field-text/ -->
                    
                <?php
				
					////////////////////////////////////////
					// SELECT FIELD
					elseif($field['type'] == 'select') :
				
				?>
                
                    <div class="shortcode-fields-field shortcode-field-select">
                    
                        <div class="shortcode-field-title"><?php echo $field['title']; ?></div>
                        
                        <div class="shortcode-field-input"><select class="widefat">
                        
                        	<?php foreach($field['options'] as $opt) { echo '<option>'.$opt.'</option>'; } ?>
                        
                        </select></div>
                        
                        <div class="shortcode-field-desc"><?php echo $field['desc']; ?></div>
                        <span class="hidden shortcode-name"><?php echo $field['name']; ?></span>
                        
                    <div class="clear"></div>
                    </div>
                    <!-- /shortcode-field-text/ -->
                    
                <?php
				
					////////////////////////////////////////
					// SELECT FIELD
					elseif($field['type'] == 'categories') :
				
				?>
                
                    <div class="shortcode-fields-field shortcode-field-select">
                    
                        <div class="shortcode-field-title"><?php echo $field['title']; ?></div>
                        
                        <div class="shortcode-field-input"><select class="widefat">
                        
                        	<option value="all">All Categories</option>
                            
                            <?php $terms = get_categories(); ?>
                        
                        	<?php foreach($terms as $term) { echo '<option value="'.$term->term_id.'">'.$term->name.'</option>'; } ?>
                        
                        </select></div>
                        
                        <div class="shortcode-field-desc"><?php echo $field['desc']; ?></div>
                        <span class="hidden shortcode-name"><?php echo $field['name']; ?></span>
                        
                    <div class="clear"></div>
                    </div>
                    <!-- /shortcode-field-text/ -->
                    
                <?php
				
					////////////////////////////////////////
					// SELECT FIELD
					elseif($field['type'] == 'portfolio_cats') :
				
				?>
                
                    <div class="shortcode-fields-field shortcode-field-select">
                    
                        <div class="shortcode-field-title"><?php echo $field['title']; ?></div>
                        
                        <div class="shortcode-field-input"><select class="widefat">
                        
                        	<option value="all">All Categories</option>
                            
                            <?php $terms = get_terms('portfolio_cats'); ?>
                        
                        	<?php foreach($terms as $term) { echo '<option value="'.$term->term_id.'">'.$term->name.'</option>'; } ?>
                        
                        </select></div>
                        
                        <div class="shortcode-field-desc"><?php echo $field['desc']; ?></div>
                        <span class="hidden shortcode-name"><?php echo $field['name']; ?></span>
                        
                    <div class="clear"></div>
                    </div>
                    <!-- /shortcode-field-text/ -->
                    
                <?php
				
					////////////////////////////////////////
					// SELECT FIELD
					elseif($field['type'] == 'taxonomy') :
				
				?>
                
                    <div class="shortcode-fields-field shortcode-field-select">
                    
                        <div class="shortcode-field-title"><?php echo $field['title']; ?></div>
                        
                        <div class="shortcode-field-input"><select class="widefat">
                        
                        	<option value="all">All</option>
                            
                            <?php $terms = get_terms($field['taxonomy']); ?>
                        
                        	<?php foreach($terms as $term) { echo '<option value="'.$term->term_id.'">'.$term->name.'</option>'; } ?>
                        
                        </select></div>
                        
                        <div class="shortcode-field-desc"><?php echo $field['desc']; ?></div>
                        <span class="hidden shortcode-name"><?php echo $field['name']; ?></span>
                        
                    <div class="clear"></div>
                    </div>
                    <!-- /shortcode-field-text/ -->
                    
                <?php
				
					////////////////////////////////////////
					// SELECT FIELD
					elseif($field['type'] == 'textarea') :
				
				?>
                
                    <div class="shortcode-fields-field shortcode-field-textarea">
                    
                        <div class="shortcode-field-title"><?php echo $field['title']; ?></div>
                        
                        <div class="shortcode-field-input"><textarea class="widefat" style="background: #ffffff;" rows="4" cols=""></textarea></div>
                        
                        <div class="shortcode-field-desc"><?php echo $field['desc']; ?></div>
                        <span class="hidden shortcode-name"><?php echo $field['name']; ?></span>
                        
                    <div class="clear"></div>
                    </div>
                    <!-- /shortcode-field-text/ -->
                    
                <?php
				
					////////////////////////////////////////
					// SELECT FIELD
					elseif($field['type'] == 'check') :
				
				?>
                
                    <div class="shortcode-fields-field shortcode-field-check">
                    
                        <div class="shortcode-field-title"><?php echo $field['title']; ?></div>
                        
                        <div class="shortcode-field-input"><input type="checkbox" /></div>
                        
                        <div class="shortcode-field-desc"><?php echo $field['desc']; ?></div>
                        <span class="hidden shortcode-name"><?php echo $field['name']; ?></span>
                        <span class="hidden shortcode-value"><?php echo $field['value']; ?></span>
                        
                    <div class="clear"></div>
                    </div>
                    <!-- /shortcode-field-text/ -->
                    
                <?php
				
					////////////////////////////////////////
					// HIDDEN FIELD
					elseif($field['type'] == 'hidden') :
				
				?>
                
                    <div class="shortcode-fields-field shortcode-field-hidden hidden">
                    
                        <div class="shortcode-field-title"><?php echo $field['title']; ?></div>
                        
                        <div class="shortcode-field-input"><input type="text" value="<?php echo $field['value']; ?>" class="widefat" /></div>
                        
                        <div class="shortcode-field-desc"><?php echo $field['desc']; ?></div>
                        <span class="hidden shortcode-name"><?php echo $field['name']; ?></span>
                        
                    <div class="clear"></div>
                    </div>
                    <!-- /shortcode-field-text/ -->
                    
                <?php
				
					////////////////////////////////////////
					// HIDDEN FIELD
					elseif($field['type'] == 'info') :
				
				?>
                
                    <div class="shortcode-fields-field shortcode-field-info">
                    
                        <div class="shortcode-field-info"><?php echo $field['desc']; ?></div>
                        
                    <div class="clear"></div>
                    </div>
                    <!-- /shortcode-field-text/ -->
                    
                <?php endif; ?>
                
                <?php endforeach; ?>
                
            </div>
            <!-- /.shortcode-label/ -->
        
        </div>
        <!-- /shortcode-section/ -->
        
	<?php $iShort++; endforeach; $i++; endforeach; ?>

    <div class="shortcode-section" id="shortcodes-insert">
    
        <div class="shortcode-label"></div>
        <!-- /.shortcode-label/ -->
    
        <div class="shortcode-field">
        
        	<input type="button" value="Insert Shortcode" class="button-primary" onClick='jQuery(this).bpanelGeneratorInsertShortcode();' />
            
        </div>
        <!-- /.shortcode-label/ -->
    
    </div>
    <!-- /shortcode-section/ -->
  
</div>
<div style="clear: both;"></div> 
<!-- /shortcode-builder-wrapper/ -->