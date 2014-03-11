

	<?php
	
		//// CUSTOM FIELDS
		$custom_fields = json_decode(htmlspecialchars_decode(get_post_meta(get_the_ID(), '_sf_custom_fields', true)));
		
		///// IF WE HAVE CUSTOM FIELD
		if(is_object($custom_fields)) :
	
	?>
    
    	<ul class="spot-custom-fields">
        
        	<?php foreach($custom_fields as $_field) : ?>
            
            	<li><strong><?php echo $_field->label ?>:</strong> <?php
				
					//// REPLACES LINKS
					$text = preg_replace('#(script|about|applet|activex|chrome):#is', "\\1:", $_field->value);
					
					$ret = ' ' . $text;
					$ret = preg_replace("#(^|[\n ])([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", "\\1<a href=\"\\2\" target=\"_blank\" rel=\"nofollow\">\\2</a>", $ret);
					$ret = preg_replace("#(^|[\n ])((www|ftp)\.[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", "\\1<a href=\"http://\\2\" target=\"_blank\" rel=\"nofollow\">\\2</a>", $ret);
					$ret = preg_replace("#(^|[\n ])([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i", "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $ret);
					$ret = substr($ret, 1);
					echo $ret;
					
				
				?></li>
            
            <?php endforeach; ?>
        
        </ul>
        <!-- .spot-custom-fields -->
    
    <?php endif; ?>